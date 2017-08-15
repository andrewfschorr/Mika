<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class IgProxyController extends Controller
{
    public function index($term)
    {
        \Log::info($term);
        $client = new Client();
        $res = $client->request('GET', 'https://api.instagram.com/v1/tags/5dmarkii/media/recent?access_token=3749600.deea625.bc441d664eb4494db80375dec79a72c5');
        return $res->getBody();
     }
}
