@extends('layouts.app')
@section('content')
@if ($is_ig_authed)
    <div class="container">
        <div class="row">
            @include ('partials.profile-sidebar')
            @include ('partials.album-search')
        </div>
    </div>
@else
    @include ('partials.not-authed')
@endif
@endsection
