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
        return (
            <div className="row">
                <div className="col">
                    <h3>Search for a new album tag: <small>#{this.props.searchTerm}</small></h3>
                    <form>
                        <div className="form-group">
                            <input onChange={(e) => this.handleSearchChange(e)} id="album-tag" type="text" className="form-control" placeholder="Enter a tag" />
                        </div>
                        <button type="submit" onClick={(e) => this.handleSearchTerm(e)} className="btn btn-default">Search</button>
                    </form>
                </div>
            </div>
        );
    }
}

class ReturnedPhotos extends React.Component {

    shouldComponentUpdate(nextProps, nextState) {
        return nextProps.photoResponse !== this.props.photoResponse;
    }

    render() {
        let photos;
        if (!this.props.photoResponse.length) {
            photos = <h3 className="col">Oops, sorry, nothing here</h3>;
        } else {
            photos = this.props.photoResponse.map((img, idx) => {
                const id = img.id;
                const src = img.images.standard_resolution.url;
                return (
                    <div className="col-sm-3" key={id}>
                    <figure onClick={() => {this.togglePhotoSelection(id)}}>
                            <img src={src} alt=""/>
                        </figure>
                    </div>
                );

            });
        }
        return (
            <div className="row photo-results">
                {photos}
            </div>
        );
    }
}

class SelectedPhotos extends React.Component {
    render() {
        return (
            <div className="row">
                <p>hellp</p>
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
            hasSearched: false,
        };
    }

    handleSearchChange(searchVal) {
        searchVal = searchVal.replace(/-|\ |#|\./g, '');
        this.setState({
            searchTerm: searchVal,
        });
    }

    handleSearchTerm() {
        axios.get(`/search-term/${this.state.searchTerm}`).then(response => {
            this.setState({
                responseImgs: response.data.data,
            })
        }).catch(e => {
            throw new Error(e);
        })
    }

    render() {
        return (
            <div>
                <TagSearch
                    handleSearchChange={this.handleSearchChange.bind(this)}
                    handleSearchTerm={this.handleSearchTerm.bind(this)}
                    searchTerm={this.state.searchTerm}
                />
                <ReturnedPhotos
                    photoResponse={this.state.responseImgs}
                />
                {/* <SelectedPhotos /> */}
            </div>
        );
    }
}

ReactDOM.render(
  <CreateAlbum/>,
  document.getElementsByClassName('app-root')[0]
);