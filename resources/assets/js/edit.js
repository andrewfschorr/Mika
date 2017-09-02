import React from 'react';
import ReactDOM from 'react-dom';
import dataBootstrap from './components/data-bootstrap';

const editAlbumEl = document.getElementsByClassName('edit-album')[0];
const data = dataBootstrap.get('edit');

console.log(data.album_photos);
console.log(editAlbumEl);