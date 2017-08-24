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
            <ul class="list-group">
                <li class="list-group-item justify-content-between">
                    Cras justo odio
                    <span class="badge badge-default badge-pill">14</span>
                </li>
                <li class="list-group-item justify-content-between">
                    Dapibus ac facilisis in
                    <span class="badge badge-default badge-pill">2</span>
                </li>
                <li class="list-group-item justify-content-between">
                    Morbi leo risus
                    <span class="badge badge-default badge-pill">1</span>
                </li>
            </ul>
        </div>
        @include ('partials.album-search')
    <div>
</div>