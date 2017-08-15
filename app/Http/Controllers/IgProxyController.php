<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class IgProxyController extends Controller
{
    public function index($term)
    {
        $access_token = \Auth::user()->access_token;
        $client = new Client();
        $res = $client->request('GET', "https://api.instagram.com/v1/tags/$term/media/recent?access_token=$access_token");
        \Log::info("https://api.instagram.com/v1/tags/$term/media/recent?access_token=$access_token");
        return $res->getBody();
     }
}
