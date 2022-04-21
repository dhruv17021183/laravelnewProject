<style>
    body {
        font-family: Arial, Helvetica, sans-serif;

    }
</style>

<p>
    Hii {{ $comment->commentable->user->name }}

Someone has Commented on Your blog post
<a href="{{ route('posts.show',['post' => $comment->commentable->id]) }}">
    {{$comment->commentable->title}}
</a>

</p>

<hr />

<p>
    
    <a href="{{ route('users.show',['user' => $comment->user->id])}}">
        {{ $comment->user->firstname}}
    </a> Said:
</p>

<p>
    "{{ $comment->content }}"
</p>
