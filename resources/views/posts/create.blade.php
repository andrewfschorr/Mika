@extends ('layouts.main')

@section ('content')
<div class="col-sm-8 blog-main">
    <form method="POST" action="posts">
        <div class="form-group">
            <label for="exampleInputEmail1">Title</label>
            <input type="title" class="form-control" id="exampleInputEmail1" name="title">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Body</label>
            <textarea id="body" class="form-control" name="body"></textarea>
        </div>
        {{csrf_field()}}
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

@section ('footer')
<footer class="blog-footer">
    <p>Blog template built for <a href="https://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
    <p>
        <a href="#">Back to top</a>
    </p>
</footer>
@endsection