@forelse($comments as $comment)
      <p class="text-muted">
        {{$comment->content}},Added {{$comment->created_at->diffForHumans()}}
      </p>
      @empty
      <p>No Comments Yet!</p>
@endforelse