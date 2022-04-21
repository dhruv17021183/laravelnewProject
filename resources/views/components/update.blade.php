<p class="text-muted">
    {{ empty(trim($slot)) ? 'Added ' : $slot }} {{ $date->diffForHumans() }}
    @if(isset($firstname))
       @if(isset($userId))
         by <a href="{{ route('users.show',['user' => $userId])}}">{{ $firstname }} ok</a>
        @else
        by {{ $firstname }}
        @endif
    @endif
</p>