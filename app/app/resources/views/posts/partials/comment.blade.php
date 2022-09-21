<div class="mb-2 mt-2">
    @auth 
        <form action="{{ route('posts.comments.store', ['post' => $post->id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea class="form-control" id="content" name="content"></textarea>
                <input type="hidden" name="blog_post_id" value="{{ $post->id }}">
                <button type="submit" class="btn btn-info btn-block">Send</button>
            </div>
        </form>
        <x-errors>
        </x-errors>
    @else
        <a href="{{ route('login')}}">Sign in</a> to post comments!
    @endauth
</div>

