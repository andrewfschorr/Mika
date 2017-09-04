<div class="col-sm-9">
    @if (session('album_success'))
    <div class="alert alert-success" role="alert">
        {!! session('album_success') !!}
    </div>
    @endif
    <div class="edit-album"></div>
</div>