@forelse($comments as $comment)
      <p class="text-muted">
        {{$comment->content}}
      </p>
    
    @update(['date' => $comment->created_at, 'name' => $comment->user->firstname, 'userId' => $comment->user->id])
    @endupdate
@empty
      <p>No Comments Yet!</p>
@endforelse