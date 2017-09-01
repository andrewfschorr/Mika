@extends('layouts.app')
@section('content')
@if ($is_ig_authed)
    @include ('partials.ig.authed')
<!-- Not Authed :/ -->
@else
    @include ('partials.ig.not-authed')
@endif
@endsection
