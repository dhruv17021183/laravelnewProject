<h3><a href="{{route('posts.show',['post'=>$post->id])}}">{{$post->title}}</a></h3>
<p class="text-muted">
  Added {{ $post->created_at->diffForHumans()}}
  By {{$post->user->firstname}} {{$post->user->lastname}}
</p>
@if($post->comments_count)
<p>{{$post->comments_count}} comments</p>
@else
<p>No Comments</p>
@endif
@can('update',$post)
<div class="mb-3">
  <a href="{{route('posts.edit',['post'=>$post->id])}}" class="btn btn-primary">
    Edit
  </a>

@endcan

{{-- @cannot('delete',$post)
  <p>You Cant Delete This post!</p>
@endcannot --}}

@can('delete',$post)
<form class="d-inline" action="{{route('posts.destroy',['post'=>$post->id])}}" method="post">
  @csrf
  @method('DELETE')
  <input type="submit" value="Delete!" class="btn btn-primary">
</form>
</div>
@endcan
