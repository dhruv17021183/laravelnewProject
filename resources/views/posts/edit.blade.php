@include('layout')

@section('title','update post')

@section('content')


<form action= "{{route('posts.update',['post'=>$post->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('posts.partials.form')
    <div><input type="submit" value="update" class="btn btn-primary btn-block"></div>    
</form>