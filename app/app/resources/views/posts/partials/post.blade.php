{{-- @if ($loop->even) --}}

    <h3>
        @if($post->trashed())
            <del>
        @endif
        <a class="{{ $post->trashed() ? 'text-muted' : '' }}" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post['title'] }}</a>
        @if($post->trashed())
            </del>
        @endif
    </h3>
{{-- @else 
    <div style="color: red">{{ $key }} . {{ $post['title'] }}</div>
@endif --}}
{{-- <p class="text-muted">
    added {{ $post->created_at->diffForHumans() }}
    by {{ $post->user->name }}
</p> --}}

<x-updated :date="$post->created_at" :name="$post->user->name" :userId="$post->user->id">
    Added
</x-updated>

<x-tags :tags="$post->tags">
    
</x-tags>
@if ($post->comments_count)
    <p>{{ $post->comments_count }} comments</p>
@else
    No comments yet!
@endif

<div class="d-flex mb-3">
    @auth
        @can('update', $post)
            <a class="btn btn-success text-light" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
        @endcan
    @endauth
    @auth
        @if(!$post->trashed())
            @can('delete', $post)
                <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-info text-light" type="submit">Delete!</button>
                </form>
            @endcan
        @else
            <form action="{{ route('posts.restore', ['post' => $post->id]) }}" method="POST">
                @csrf
                @method('POST')
                <button class="btn btn-info text-light" type="submit">Restore!</button>
            </form>
        @endif
    @endauth


</div>

@cannot('delete', $post)
    <p>You can't delete this post</p>
@endcannot