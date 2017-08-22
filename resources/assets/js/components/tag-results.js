import React from 'react';

export default class TagResults extends React.Component {
    togglePhotoSelection(id) {
        console.log(id);
    }
    render() {
        const tagImgs = this.props.responseImgs.map((img, idx)=> {
            const id = img.id;
            const src = img.images.standard_resolution.url;
            return (
                <div key={id} className="col-4">
                    <figure onClick={() => {this.togglePhotoSelection(id)}}>
                        <img src={src} alt=""/>
                    </figure>
                </div>
            )

        });
        // This sucks, I'm aware
        // https://stackoverflow.com/questions/16377972/how-to-align-left-last-row-line-in-multiple-line-flexbox
        return (
            <div className="results">
                {tagImgs}
            </div>
        )
    }
}
