<div class="container">
    <div class="row">
        <div class="col-sm-3 profile-sidebar">
            <div class="card">
                <img class="card-img-top" src="{{ $ig_attrs['profile_picture'] }}" alt="">
                <div class="card-block">
                    <h6 class="card-title">{{ $ig_attrs['username'] }}</h6>
                    @if (isset($ig_attrs['bio']))
                        <p class="card-text">{{ $ig_attrs['bio'] }}</p>
                    @endif
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ $ig_attrs['full_name'] }}</li>
                    @if (isset($ig_attrs['website']))
                        <li class="list-group-item">
                            <small>
                            <a class="bio-link" href="{{ $ig_attrs['website'] }}">
                                {{ $ig_attrs['website'] }}
                            </a>
                            </small>
                        </li>
                    @endif
                </ul>
            </div>
            <hr>
            <h5>Albums</h5>
            @if (!count($albums))
                <div class="alert alert-warning" role="alert">
                    <strong>🙊 G'ahead</strong> upload an album.
                </div>
            @else
                <ul class="list-group">
                @foreach ($albums as $album)
                    <li class="list-group-item justify-content-between">
                        <!-- TODO get this strtolower out of template -->
                        <a href="{{$ig_username}}/{{strtolower($album->display_name)}}">
                            {{ $album->display_name }}
                        </a>
                        <span class="badge badge-default badge-pill">{{ count($album->images) }}</span>
                    </li>
                @endforeach
                </ul>
            @endif
        </div>
        @include ('partials.album-search')
    <div>
</div>