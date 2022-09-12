{{-- @if ($loop->even) --}}
    <h3><a class="text-secondary" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post['title'] }}</a></h3>
{{-- @else 
    <div style="color: red">{{ $key }} . {{ $post['title'] }}</div>
@endif --}}
<p class="text-muted">
    added {{ $post->created_at->diffForHumans() }}
    by {{ $post->user->name }}
</p>
@if ($post->comments_count)
    <p>{{ $post->comments_count }} comments</p>
@else
    No comments yet!
@endif

<div class="d-flex mb-3">
    @can('update', $post)
        <a class="btn btn-success text-light" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
    @endcan
    
    @can('delete', $post)
        <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-info text-light" type="submit">Delete!</button>
        </form>
    @endcan
</div>

@cannot('delete', $post)
    <p>You can't delete this post</p>
@endcannot