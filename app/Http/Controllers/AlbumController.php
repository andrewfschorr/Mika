<?php

namespace App\Http\Controllers;

use App\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function __construct()
    {

    }

    public function viewAlbum($user, $album)
    {
        $album_name = sprintf('%1$s-%2$s', strtolower($user), strtolower($album));
        $album_entry = Album::where('album_name', $album_name)->first();
        $this->setContext('album');

        if ($album) {
            return view('album', [
                'images' => $album_entry->images,
                'album_name' => $album,
                'user_name' => $user,

            ]);
        } else {
            abort(404);
        }
    }
}
