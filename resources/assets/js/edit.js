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

    render() {
        let searchResults;
        if (!this.props.hasSearched) {
            searchResults = <div className="col-12">
                <button onClick={() => {this.searchMore()}} className="btn btn-primary">search for more {this.props.name} photos</button>
            </div>
        } else if (!this.props.searchMorePhotos.length) {
            searchResults = <div className="col">
                <h3>Oops sorry, no results found</h3>
            </div>
        } else {
            searchResults = this.props.searchMorePhotos.map((img, idx) => {
                // TODO do something better here
                // const isPhotoAlreadySelected = _.some(this.props.selectedPhotos, {id: img.id});
                // if (isPhotoAlreadySelected) {
                //     img.isSelected = true;
                // }
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

    render() {
        let albumPhotos;
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

        return (
            <div className="row selected-photos">
                <h3 className="col-12">
                    #<strong>{this.props.name}</strong> Album
                </h3>
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
        };
        this.selectedPhotosMap = {};
        _.each(this.state.selectedPhotos, (img) => {
            this.selectedPhotosMap[img.id] = true;
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

    render() {
        return (
            <div className="edit-photos">
                <SelectedPhotos
                    photos={this.props.photos}
                    name={this.props.name}
                />
                <SearchMore
                    searchMore={this.searchMore.bind(this)}
                    hasSearched={this.state.hasSearched}
                    searchMorePhotos={this.state.searchMorePhotos}
                    selectedPhotos={this.state.selectedPhotos}
                />
            </div>
        );
    }
}

const editAlbumEl = document.getElementsByClassName('edit-album')[0];
const data = dataBootstrap.get('edit');

if (data.album_photos && editAlbumEl) {
    ReactDOM.render(
        <EditAlbum
            photos={data.album_photos.images}
            name={data.album_photos.display_name}
        />,
        editAlbumEl
    );
}