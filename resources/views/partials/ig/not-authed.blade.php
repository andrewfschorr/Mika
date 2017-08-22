<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">Welcome!</div>
            <div class="card-block">
                <h4 class="card-title">Go ahead and connect your Instagram.</h4>
                <p class="card-text">You won't really be able to do anything cool untill you do...</p>
                @if ($errors->connect_ig->first('ig_id'))
                <p class="text-danger">{{ $errors->connect_ig->first('ig_id') }}</p>
                @endif
                <a href="/auth/instagram" class="btn btn-primary">Connect Your Instagram</a>
            </div>
        </div>
    </div>
</div>