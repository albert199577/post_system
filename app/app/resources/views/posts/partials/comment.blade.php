<form action="{{ route('comment.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="content">Content</label>
        <textarea class="form-control" id="content" name="content">{{ old('content', optional($comment ?? null)->content) }}</textarea>
        <input type="hidden" name="blog_post_id" value="{{ $post->id }}">
        <button type="submit" class="btn btn-info">Send comment!</button>
    </div>
</form>
