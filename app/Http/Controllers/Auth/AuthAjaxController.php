<?php

namespace App\Http\Controllers;

use Validator;
use App\Album;
use Illuminate\Http\Request;

class AuthAjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createAlbum(Request $request)
    {
        $user = \Auth::user();
        $images = [];
        foreach ($request->input('imgs') as $image) {
            if (strpos($image['url'], 'cdninstagram.com')) {
                $images[] = [
                    'url' => $image['url'],
                    'caption' => $image['caption'],
                    'link' => $image['link'],
                    'taken_by' => $image['takenBy'],
                ];
            }
        }

        $name = $request->input('name');
        $album_name = $user->getIg('username') . '-' . strtolower($name);
        $display_name = $name;

        $data = compact('images', 'album_name', 'display_name');

        $validator = Validator::make(
            $data,
            [
                'album_name' => 'required|unique:albums',
                'images' => 'present|array',
            ],
            [
                // because ajax, don't think these are in use
                'album_name.unique' => 'Sorry, can only have one album per hashtag.',
                'images' => 'Uh oh, Somethings up... Our engineers have been alerted :/',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error_msg' => $validator->errors()->all()
            ], 400);
        } else {
            try {
                $album = Album::create([
                    'album_name' => $data['album_name'],
                    'display_name' => $data['display_name'],
                    'images' => $data['images'],
                    'user_id' => $user->id,
                ]);
            } catch (\Illuminate\Database\QueryException $exception) {
                return response()->json([
                    'error_msg' => 'Uh oh, Somethings up... Our engineers have been alerted :/'
                ], 400);
            }

            $request->session()->flash('album_success', sprintf('Album <strong>%s</strong> was created! 🎉', $album->display_name));
            return response()->json([
                'success' => 'success',
                'lcAlbumName' => $album->lc_album_name,
                'igName' => $user->getIg('username'),
            ], 200);
        }
    }
}