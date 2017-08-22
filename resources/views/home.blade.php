@extends('layouts.app')
@section('content')
<!-- AUTHED for ig! -->
@if (!empty($ig_attrs))
    @include ('partials.ig.authed')
<!-- Not Authed :/ -->
@else
    @include ('partials.ig.not-authed')
@endif
@endsection
