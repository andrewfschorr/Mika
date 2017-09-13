import React from 'react';
import ReactDOM from 'react-dom';
import dataBootstrap from './components/data-bootstrap';
import Sortable from 'react-sortablejs';

class SearchMore extends React.Component {
    constructor(props) {
        super(props);
    }

    searchMore() {
        this.props.searchMore();
    }

    togglePhotoSelection(id) {
        this.props.togglePhotoSelection(id);
    }

    render() {
        let searchResults;
        if (!this.props.hasSearched) {
            searchResults = <div className="col-12">
                <button onClick={() => {this.searchMore()}} className="btn btn-primary">search for more <strong>#{this.props.name}</strong> tagged photos</button>
            </div>
        } else if (!this.props.searchMorePhotos.length) {
            searchResults = <div className="col">
                <h3>Oops sorry, no results found</h3>
            </div>
        } else {
            searchResults = this.props.searchMorePhotos.map((img, idx) => {
                const id = img.id;
                const src = img.images.standard_resolution.url;
                return (
                    <div className="col-sm-3 photo-grid-item returned-photo" key={id}>
                        <figure className="photo-item" onClick={() => {this.togglePhotoSelection(id)}}>
                            {img.isSelected ? <span className="glyphicon glyphicon-ok rounded-circle" aria-hidden="true"></span>
                                : null}
                            <img src={src} alt=""/>
                        </figure>
                        <figcaption className="caption">{img.caption.text} <a target="_blank" href={img.link}>{img.user.username}</a></figcaption>
                    </div>
                );
            });
        }

        return (
            <div className="row search-more-photos">
                <div className="col-12">
                    <hr/>
                </div>
                {searchResults}
            </div>
        );
    }
}

class SelectedPhotos extends React.Component {
    constructor(props) {
        super(props);
    }

    togglePhotoSelection(id) {
        this.props.togglePhotoSelection(id);
    }

    saveAlbum() {
        this.props.saveAlbum();
    }

    render() {
        let albumPhotos,
            albumUrl;
        if (!this.props.photos.length) {
            albumPhotos = <h3 className="col">Oh noe! Empty album 😰.</h3>;
        } else {
            albumUrl = `/album/${this.props.username}/${this.props.name}`;
            albumPhotos = this.props.photos.map((img, idx) => {
                const {id, url, link, caption, takenBy} = img;
                return (
                    <div className="col-sm-3 photo-grid-item edit-album-item" key={id}>
                        <figure className="photo-item">
                            <span className="glyphicon glyphicon-remove rounded-circle" aria-hidden="true" onClick={() => {this.togglePhotoSelection(id)}}></span>
                            <img src={url} alt=""/>
                        </figure>
                        <figcaption className="caption">{caption} <a target="_blank" href={link}>{takenBy}</a></figcaption>
                    </div>
                );
            });
        }

        return (
            <div className="row selected-photos">
                <h3 className="col-12">
                    #<strong>{this.props.name}</strong> Album
                </h3>
                <h6 className="col-12">
                    <a target="_blank" href={albumUrl}>http://pixeltagged.com/album/{this.props.username}/{this.props.name}</a>
                </h6>
                <Sortable
                    ref={(c) => {
                        if (c) {
                            c.sortable.el.classList.add('d-flex');
                        }
                    }}
                    options={{
                        animation: 200,
                    }}
                >
                {albumPhotos}
                </Sortable>
                {this.props.photos.length ?
                    <div className="col">
                        <button onClick={() => this.saveAlbum()} className="btn btn-success">Save Album</button>
                    </div>
                : null}
            </div>
        );
    }
}

class EditAlbum extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            selectedPhotos: props.photos,
            searchTerm: props.name,
            searchMorePhotos: [],
            hasSearched: false,
            username: props.username,
        };
        this.selectedPhotosMap = {};
        _.each(this.state.selectedPhotos, (img) => {
            this.selectedPhotosMap[img.id] = true;
        });
    }

    togglePhotoSelection(id) {
        let updatedSelectedPhotos;
        // remove photo
        if (this.selectedPhotosMap[id] !== undefined) {
            // remove photo from selected photos
            _.remove(this.state.selectedPhotos, (photo) => {
                return photo.id === id;
            });
            updatedSelectedPhotos = this.state.selectedPhotos;
            // remove isSelected = true attribute
            _.each(this.state.searchMorePhotos, (photo, idx) => {
                if (photo.id === id) {
                    delete photo.isSelected;
                    return false;
                }
            });
            delete this.selectedPhotosMap[id];
        // add photo
        } else {
            // add to selectedImgs
            const addedPhoto = _.find(this.state.searchMorePhotos, (img) => {
                return img.id === id;
            });

            updatedSelectedPhotos = this.state.selectedPhotos.concat({
                id: addedPhoto.id,
                url: addedPhoto.images.standard_resolution.url,
                link: addedPhoto.link,
                caption: addedPhoto.caption.text,
                takenBy: addedPhoto.user.username
            });

            _.each(this.state.searchMorePhotos, (photo, idx) => {
                if (photo.id === id) {
                    photo.isSelected = true;
                    return false;
                }
            });
            this.selectedPhotosMap[id] = true;
        }

        this.setState({
            selectedPhotos: updatedSelectedPhotos,
            searchMorePhotos: this.state.searchMorePhotos
        });
    }

    searchMore() {
        axios.get(`/search-term/${this.state.searchTerm}`).then(response => {
            this.setState({
                hasSearched: true,
                searchMorePhotos: response.data.data.map((img) => {
                    if (this.selectedPhotosMap[img.id] !== undefined) {
                        img.isSelected = true;
                    }
                    return img;
                }),
            });
        }).catch(e => {
            throw new Error(e);
        });
    }

    saveAlbum() {
        axios.post('/updateAlbum', {
            imgs: this.state.selectedPhotos,
            name: this.state.searchTerm,
        }).then((resp) => {
            window.location.reload();
        }).catch((err) => {
            this.setState({
                errors: err.response.data.error_msg,
            });
        });
    }

    render() {
        return (
            <div className="edit-photos">
                <SelectedPhotos
                    photos={this.state.selectedPhotos}
                    name={this.state.searchTerm}
                    togglePhotoSelection={this.togglePhotoSelection.bind(this)}
                    hasSearched={this.state.hasSearched}
                    saveAlbum={this.saveAlbum.bind(this)}
                    username={this.state.username}
                />
                <SearchMore
                    name={this.state.searchTerm}
                    searchMore={this.searchMore.bind(this)}
                    hasSearched={this.state.hasSearched}
                    searchMorePhotos={this.state.searchMorePhotos}
                    selectedPhotos={this.state.selectedPhotos}
                    togglePhotoSelection={this.togglePhotoSelection.bind(this)}
                />
            </div>
        );
    }
}

const editAlbumEl = document.getElementsByClassName('edit-album')[0];
const data = dataBootstrap.get('edit');

if (data.albumPhotos && editAlbumEl) {
    ReactDOM.render(
        <EditAlbum
            photos={data.albumPhotos.images}
            name={data.albumPhotos.display_name}
            username={data.igUserName}
        />,
        editAlbumEl
    );
}