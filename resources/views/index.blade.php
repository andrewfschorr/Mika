@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">
                Welcome!
            </div>
            <div class="card-block">
                <h4 class="card-title">Please Login or Register</h4>
                <p class="card-text">Login or register to make your first hashtagged album.</p>
                <a href="/login" class="btn btn-primary">Login</a>
                <a href="/register" class="btn btn-primary">Register</a>
            </div>
        </div>
    </div>
@endsection
