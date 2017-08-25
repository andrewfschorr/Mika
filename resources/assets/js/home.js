import React from 'react';
import ReactDOM from 'react-dom';

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
    render() {
        if (!this.props.hasSearched || !this.props.photoResponse.length) return null;

        let selectedImgs;
        if (!this.props.selectedImgs.length) {
            selectedImgs = <h3 className="col">Oh noe! Empty album 😰.</h3>;
        } else {
            selectedImgs = this.props.selectedImgs.map((img, idx) => {
                const id = img.id;
                const src = img.images.standard_resolution.url;
                return (
                    <div className="col-sm-3" key={id}>
                    <figure className="photo-grid" onClick={() => {this.togglePhotoSelection(id)}}>
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
            </div>
        );
    }
}

class ReturnedPhotos extends React.Component {

    shouldComponentUpdate(nextProps, nextState) {
        return nextProps.photoResponse !== this.props.photoResponse;
    }

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
                    <div className="col-sm-3" key={id}>
                    <figure className="photo-grid" onClick={() => {this.togglePhotoSelection(id)}}>
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
            hasSearched: false,
        };

        this.selectedImgsMap = {};

        this.originalState = _.clone(this.state);
    }

    handleSearchChange(searchVal) {
        searchVal = searchVal.replace(/-|\ |#|\./g, '');
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
            })
        }).catch(e => {
            throw new Error(e);
        })
    }

    togglePhotoSelection(id) {
        let addedPhoto,
            newImagesState;

        if (this.selectedImgsMap[id] === undefined) {
            addedPhoto = _.find(this.state.responseImgs, (img) => {
                return img.id === id;
            });
            this.selectedImgsMap[id] = true;
            newImagesState = this.state.selectedImgs.concat(addedPhoto);
        } else {
            addedPhoto = _.findIndex(this.state.selectedImgs, (img) => {
                return img.id === id;
            });
            this.state.selectedImgs.splice(addedPhoto, 1);
            newImagesState = this.state.selectedImgs;
            delete this.selectedImgsMap[id];
        }

        this.setState({
            selectedImgs: newImagesState,
        });
    }

    reset() {
        this.setState(this.originalState);
    }

    render() {
        return (
            <div>
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

ReactDOM.render(
  <CreateAlbum/>,
  document.getElementsByClassName('app-root')[0]
);