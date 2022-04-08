@extends('layout')


@section('content')
<div class="row">
  <div class="col-8">
    @foreach($posts as $key=>$post)
    @include('posts.partials.post',[])

    @endforeach
  </div>
  
  <div class="col-4">
    <div class="conainer">
      <div class="row">
        <div class="card" style="width: 100%;">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <h6 class="card-subtitle mb-2 text-muted">Some quick example text to build on the card title and make.</h6>
          </div>
          <ul class="list-group list-group-flush">
            @foreach($mostCommented as $post)
            <li class="list-group-item">
              <a href="{{ route('posts.show',['post'=>$post->id])}}">
                {{$post->title}}
              </a>
            </li>
            @endforeach
          </ul>
        </div>
      </div>

      <div class="row mt-4">
        <div class="card" style="width: 100%;">
          <div class="card-body">
            <h5 class="card-title">Most Active</h5>
            <h6 class="card-subtitle mb-2 text-muted">Users With Most Post Written</h6>
          </div>
          <ul class="list-group list-group-flush">
            @foreach($mostActive as $user)
            <li class="list-group-item">
              {{ $user->firstname}}
            </li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="row mt-4">
        <div class="card" style="width: 100%;">
          <div class="card-body">
            <h5 class="card-title">Most Active LastMonth</h5>
            <h6 class="card-subtitle mb-2 text-muted">Users With Most Post Written LastMonth</h6>
          </div>
          <ul class="list-group list-group-flush">
          {{-- @foreach($mostActiveLastMonth as $user)
            <li class="list-group-item">
              {{ $user->firstname}}
            </li>
            @endforeach
          --}}
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection