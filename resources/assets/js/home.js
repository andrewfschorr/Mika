import React from 'react';
import ReactDOM from 'react-dom';

class TagSearch extends React.Component {
    state = {
        tagSearchValue: ''
    }
    handleChange(e) {
        let searchVal = e.target.value.replace(/-|\ |#|\./g, '')
        this.setState({
            tagSearchValue: searchVal,
        })
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
                        <button type="submit" className="btn btn-default">Search</button>
                    </form>
                </div>
            </div>
        );
    }
}

ReactDOM.render(
  <TagSearch/>,
  document.getElementsByClassName('app-root')[0]
);