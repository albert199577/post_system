<div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" id ="title" type="text" name="title" value="{{ old('title', optional($post ?? null)->title) }}">
</div>
{{-- @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror --}}

<div class="form-group">
    <label for="content">Content</label>
    <textarea class="form-control" id="content" name="content">{{ old('content', optional($post ?? null)->title) }}</textarea>
</div>
<div class="form-group">
    <label for="content">Thumbnail</label>
    <input type="file" name="thumbnail" class="form-control-file">
</div>
<x-errors>

</x-errors>