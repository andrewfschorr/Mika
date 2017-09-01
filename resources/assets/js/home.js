import React from 'react';
import ReactDOM from 'react-dom';
import dataBootstrap from './components/data-bootstrap';

class Errors extends React.Component {
    constructor(props) {
        super(props)
    }
    render() {
        {return this.props.errors.length ? <div className="errors">
            {this.props.errors.map((error, idx) => {
                return <div className="alert alert-danger" role="alert" key={idx}>
                    {error}
                </div>
            })}
        </div>  : null}
    }
}

class TagSearch extends React.Component {
    constructor(props) {
        super(props);
    }

    handleSearchChange(e) {
        this.props.handleSearchChange(e.target.value);
    }

    handleSearchTerm(e) {
        e.preventDefault();
        this.props.handleSearchTerm();
    }

    render() {
        if (this.props.hasSearched) {
            return <div className="row col">
                <h3><strong>#{this.props.searchTerm}</strong></h3>
            </div>
        }
        return (
            <div className="row">
                <div className="col">
                    <h3>Search for a new album tag: <small>#{this.props.searchTerm}</small></h3>
                    <form>
                        <div className="form-group d-flex flex-row">
                            <input onChange={(e) => this.handleSearchChange(e)} id="album-tag" type="text" className="form-control" placeholder="Enter a tag" />
                            <button type="submit" onClick={(e) => this.handleSearchTerm(e)} className="btn btn-primary ml-3">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        );
    }
}

class SelectedPhotos extends React.Component {

    togglePhotoSelection(id) {
        this.props.togglePhotoSelection(id);
    }

    makeAlbum(id) {
        this.props.makeAlbum(id);
    }

    render() {
        if (!this.props.hasSearched || !this.props.photoResponse.length) return null;

        let selectedImgs,
            makeAlbumBtn = null;
        if (!this.props.selectedImgs.length) {
            selectedImgs = <h3 className="col">Oh noe! Empty album 😰.</h3>;
        } else {
            selectedImgs = this.props.selectedImgs.map((img, idx) => {
                const id = img.id;
                const src = img.images.standard_resolution.url;
                makeAlbumBtn = <h6 className="col-12"><button className="btn btn-success" onClick={() => {this.makeAlbum(id)}}>Make album!</button></h6>;
                return (
                    <div className="col-sm-3 photo-grid-item album-item" key={id}>
                        <figure className="photo-item">
                            <span className="glyphicon glyphicon-remove rounded-circle" aria-hidden="true" onClick={() => {this.togglePhotoSelection(id)}}></span>
                            <img src={src} alt=""/>
                        </figure>
                    </div>
                );
            });
        }

        return (
            <div className="row">
                <h6 className="col-12">
                    Currently selected photos:
                </h6>
                {selectedImgs}
                {makeAlbumBtn}
            </div>
        );
    }
}

class ReturnedPhotos extends React.Component {

    togglePhotoSelection(id) {
        this.props.togglePhotoSelection(id);
    }

    reset() {
        this.props.reset();
    }

    render() {
        let photos;
        if (!this.props.hasSearched) return null;
        if (!this.props.photoResponse.length) {
            photos = <div className="col">
                <h3>Oops sorry, no results found</h3>
            </div>
        } else {
            photos = this.props.photoResponse.map((img, idx) => {
                const id = img.id;
                const src = img.images.standard_resolution.url;
                return (
                    <div className="col-sm-3 photo-grid-item returned-photo" key={id}>
                        <figure className="photo-item" onClick={() => {this.togglePhotoSelection(id)}}>
                            {img.isSelected ? <span className="glyphicon glyphicon-ok rounded-circle" aria-hidden="true"></span>
                                : null}
                            <img src={src} alt=""/>
                        </figure>
                    </div>
                );
            });
        }
        return (
            <div className="row photo-results">
                <div className="col-12">
                    <hr/>
                </div>
                <h6 className="col-12"><strong>{this.props.searchTerm}</strong> tagged photos:</h6>
                 {photos}
                <div className="col-12">
                    <button className="btn btn-primary" onClick={() => this.reset()}>Search again</button>
                </div>
            </div>
        );
    }
}


class CreateAlbum extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            searchTerm: '',
            responseImgs: [],
            selectedImgs: [],
            errors: [],
            hasSearched: false,
        };

        this.selectedImgsMap = {};

        this.originalState = _.clone(this.state);
    }

    handleSearchChange(searchVal) {
        searchVal = searchVal.replace(/[^0-9a-z]/gi, '');
        this.setState({
            searchTerm: searchVal,
        });
    }

    handleSearchTerm() {
        if (!this.state.searchTerm) return;
        axios.get(`/search-term/${this.state.searchTerm}`).then(response => {
            this.setState({
                hasSearched: true,
                responseImgs: response.data.data,
            });
        }).catch(e => {
            throw new Error(e);
        });
    }

    makeAlbum(id) {
        if (!this.state.selectedImgs.length || !this.state.searchTerm) {
            return;
        }

        const selectedImgs = [];
        _.each(this.state.selectedImgs, (img) => {
            selectedImgs.push(img.images.standard_resolution.url);
        });

        axios.post('/createalbum', {
            imgs: selectedImgs,
            name: this.state.searchTerm,
        }).then((resp) => {
            console.log(resp);
        }).catch((err) => {
            this.setState({
                errors: err.response.data.error_msg,
            });
        });
    }

    togglePhotoSelection(id) {
        let toggledPhoto,
            newImagesState;

        // add/remove to the selectedImgs State
        if (this.selectedImgsMap[id] === undefined) {
            // add to selectedImgs
            toggledPhoto = _.find(this.state.responseImgs, (img) => {
                return img.id === id;
            });
            this.selectedImgsMap[id] = true;
            newImagesState = this.state.selectedImgs.concat(toggledPhoto);
            // add isSelected attribute
            toggledPhoto.isSelected = true;

        } else {
            // TODO - maybe better way than 0(2*n) with 2 loops(?)
            // remove from selectedImgs
            _.each(this.state.selectedImgs, (photo, idx) => {
                if (photo.id === id) {
                    this.state.selectedImgs.splice(idx, 1);
                    return false;
                }
            });
            newImagesState = this.state.selectedImgs;
            // remove the isSelected = true attribute
            delete this.selectedImgsMap[id];
            // remove from the selectedImgsMap
            _.each(this.state.responseImgs, (photo, idx) => {
                if (photo.id === id) {
                    delete photo.isSelected;
                    return false;
                }
            });
        }

        this.setState({
            selectedImgs: newImagesState,
            responseImgs: this.state.responseImgs,
        });
    }

    reset() {
        this.selectedImgsMap = {};
        this.setState(this.originalState);
    }

    render() {
        return (
            <div>
                <Errors
                    errors={this.state.errors}
                />
                <TagSearch
                    handleSearchChange={this.handleSearchChange.bind(this)}
                    handleSearchTerm={this.handleSearchTerm.bind(this)}
                    searchTerm={this.state.searchTerm}
                    hasSearched={this.state.hasSearched}
                />
                 <SelectedPhotos
                    hasSearched={this.state.hasSearched}
                    selectedImgs={this.state.selectedImgs}
                    photoResponse={this.state.responseImgs}
                    togglePhotoSelection={this.togglePhotoSelection.bind(this)}
                    makeAlbum={this.makeAlbum.bind(this)}
                 />
                <ReturnedPhotos
                    photoResponse={this.state.responseImgs}
                    hasSearched={this.state.hasSearched}
                    searchTerm={this.state.searchTerm}
                    togglePhotoSelection={this.togglePhotoSelection.bind(this)}
                    reset={this.reset.bind(this)}
                />
            </div>
        );
    }
}

// TODO there has to be a better way :/
if (dataBootstrap.get('home').igUsername) {
    ReactDOM.render(
        dataBootstrap.get('home').igUsername && <CreateAlbum/>,
        document.getElementsByClassName('app-root')[0]
    );
}


