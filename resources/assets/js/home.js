import React from 'react';
import ReactDOM from 'react-dom';

class TagSearch extends React.Component {
    state = {
        tagSearchValue: '',
        hasSearched: false,
        responseImgs: [],
    }

    handleChange(e) {
        let searchVal = e.target.value.replace(/-|\ |#|\./g, '')
        this.setState({
            tagSearchValue: searchVal,
        })
    }

    searchTag(e){
        e.preventDefault();
        axios.get(`/search-term/${this.state.tagSearchValue}`).then(response => {
            console.log(response.data.data);
            this.setState({
                responseImgs: response.data.data,
                hasSearched: true,
            })
        }).catch(e => {
            throw new Error(e);
        })
    }

    componentWillMount() {
        console.log(this)
    }

    render() {
        return (
            <div className="row">
                <div className="col-md-8 col-md-offset-2">
                <h3>Search for a new album tag: <small>{this.state.tagSearchValue}</small></h3>
                    <form>
                        <div className="form-group">
                            <label htmlFor="album-tag">Tag</label>
                            <input onChange={(e) => this.handleChange(e)} id="album-tag" type="text" className="form-control" placeholder="Enter a tag" />
                        </div>
                        <button type="submit" onClick={(e) => this.searchTag(e)} className="btn btn-default">Search</button>
                    </form>
                    {this.state.hasSearched && <SearchResults responseImgs={this.state.responseImgs} />}
                </div>
            </div>
        );
    }
}

class Child extends React.Component {
    render() {
        return (<p>woah</p>)
    }
}

class SearchResults extends React.Component {
    render() {
        console.log(this.props)
        return (
            <div>fuck me</div>
        )
    }
}

ReactDOM.render(
  <TagSearch/>,
  document.getElementsByClassName('app-root')[0]
);