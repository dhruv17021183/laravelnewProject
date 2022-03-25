@extends('layout')

@section('title',$post->title)
@section('content')
<div class="row">
  <div class="col-8">
    <h1>{{$post->title}}</h1>
    <p>{{$post->content}}</p>
    <p>Added{{$post->created_at->diffForHumans()}}</p>

    @if(now()->diffInMinutes($post->created_at) < 5) <span class="badge badge-success">
      New !</span>
      @endif
      <h4>Comments</h4>

      @forelse($post->comments as $comment)
      <p class="text-muted">
        {{$comment->content}},Added {{$comment->created_at->diffForHumans()}}
      </p>
      @empty
      <p>No Comments Yet!</p>
      @endforelse
  </div>
</div>
@endsection