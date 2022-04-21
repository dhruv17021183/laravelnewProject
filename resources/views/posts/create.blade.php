@include('layout')

@section('content')


<form action= "{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('posts.partials.form')
    <button type="submit" class="btn btn-primary btn-block">Create</button>
</form>
