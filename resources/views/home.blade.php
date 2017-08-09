@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <p>You are logged in!</p>
                    @if ($errors->connect_ig->first('ig_id'))
                    <p class="text-danger">{{ $errors->connect_ig->first('ig_id') }}</p>
                    @endif
                    @if (!empty($ig_attrs))
                        <table>
                            <tr>
                                <td>
                                    {{ $ig_attrs['username'] }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ $ig_attrs['full_name'] }}
                                </td>
                            </tr>
                            @if (isset($ig_attrs['bio']))
                            <tr>
                                <td>
                                    {{ $ig_attrs['bio'] }}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td>
                                    <img src="{{ $ig_attrs['profile_picture'] }}" alt="">
                                </td>
                            </tr>
                            @if (isset($ig_attrs['website']))
                            <tr>
                                <td>
                                    {{ $ig_attrs['website'] }}
                                </td>
                            </tr>
                            @endif
                        </table>
                    @else
                        <p>
                            <a href="/auth/instagram">connect your ig account</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
