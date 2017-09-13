@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="album-name">{{$album_name}}</h1>
            <h2 class="ig-name">
                <a target="_blank" href="http://instagram.com/{{$user_name}}">{{'@' . $user_name}}</a>
            </h2>
        </div>
    </div>
</div>
<div class="container-fluid photos">
    <div class="row">
        @foreach($images as $image)
        <div class="album-item col-sm-3">
            <figure class="fig">
                <a target="_blank" href="{{$image['link']}}">
                    <img src="{{$image['url']}}" />
                </a>
            </figure>
            <figcaption class="caption">
                {{$image['caption']}}
                <a target="_blank" href="{{$image['link']}}">{{$image['takenBy']}}</a>
            </figcaption>
        </div>
        @endforeach
    </div>
</div>
@endsection

