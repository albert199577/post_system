<p class="text-muted">
    {{ $slot ?? 'Added'}} {{ $date->diffForHumans() }}
    @if (isset($name))
        @if(isset($userId))
            by <a href="{{ route('users.show', ['user' => $userId]) }}">{{ $name }}</a>
        @else
            by {{ $name }}
        @endif
    @endif
</p>