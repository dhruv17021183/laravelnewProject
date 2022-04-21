@extends('layout')

@section('title',$post->title)
@section('content')
<div class="row">
  <div class="col-8">
    @if($post->image)
       <div style="background-image: url('{{ $post->image->url()}}'); min-height: 500px; color: white; text-align: center;">
         <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
    @else 
         <h1>
    @endif
        {{ $post->title}}

    <p>{{$post->content}}</p>
    {{-- <p>Added{{$post->created_at->diffForHumans()}}</p> --}}

      @badge(['show' => now()->diffInMinutes($post->created_at) < 10])
        Brand New post!
      @endbadge

      @if($post->image)
          </h1>
      </div>
      @else
         </h1>
      @endif

 

    @update(['date' => $post->created_at, 'name' => $post->user->firstname])
    @endupdate
    @update(['date' => $post->updated_at])
            Updated
    @endupdate
    @component('components.tags',['tags' => $post->tags])
    @endcomponent

    <p>Currently read by {{ $counter }} people</p>
   
      <h4>Comments</h4>

      @include('comments.form')

      @commentsList(['comments' => $post->comments])
        
      @endcommentsList
    
  </div>
</div>
@endsection