<div class="nb-2 nt-2">
@auth

    <form action="{{ $route }}" method="POST">
        @csrf 
        <div class="form-group">
            <textarea type="text" name="content" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Add Comment</button>
    </form>
    @errors @enderrors
@else
    <a href="{{ route('login')}}">Sign-in</a> post Comments!
@endauth
</div>
<hr/>