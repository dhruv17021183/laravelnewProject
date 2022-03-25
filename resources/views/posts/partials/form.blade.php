<div class="container">
    <div class="form-group">
        <label>Title</label>
        <input id="title" type="text" class="form-control" name="title" value="{{old('title',optional($post ?? null)->title)}}"></div>
    <!-- @error('title')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror -->
    <div class="form-group">
        <label>Content</label>
        <textarea class="form-control" id="content" name="content">{{old('content',optional($post ?? null)->content)}}</textarea></div>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>