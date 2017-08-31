@extends('layouts.app')

@section('content')
<div class="container-fluid login">
        <div class="row justify-content-center">
            <div class="col-6">
                <h3 class="">Register</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-6">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="control-label">Name</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                            <br>
                            <div class="alert alert-danger">
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            </div>
                            @endif
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label">E-Mail Address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                        <br>
                        <div class="alert alert-danger">
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="control-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                        <br>
                        <div class="alert alert-danger">
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="control-label">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
