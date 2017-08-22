<div class="container">
    <div class="row">
        <div class="col-sm-3 profile-sidebar">
            <div class="card">
                <img class="card-img-top" src="{{ $ig_attrs['profile_picture'] }}" alt="">
                <div class="card-block">
                    <h6 class="card-title">{{ $ig_attrs['username'] }}</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ $ig_attrs['full_name'] }}</li>
                    @if (isset($ig_attrs['bio']))
                        <li class="list-group-item">{{ $ig_attrs['bio'] }}</li>
                    @endif
                    @if (isset($ig_attrs['website']))
                        <li class="list-group-item">
                            <small>
                            <a href="{{ $ig_attrs['website'] }}">
                                {{ $ig_attrs['website'] }}
                            </a>
                            </small>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="col">
            @include ('partials.album-search')
        </div>
    <div>
</div>