{{-- @if ($loop->even) --}}
    <div>{{ $key }} . {{ $post['title'] }}</div>
{{-- @else 
    <div style="color: red">{{ $key }} . {{ $post['title'] }}</div>
@endif --}}
<div>
    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete!</button>
    </form>
</div>