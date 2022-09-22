@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-8">
{{-- @if ($post['is_new'])
<div>A new blog post! Using if</div>
@elseif(!$post['is_new'])
<div>Blog post id old! using elseif / else</div>
@endif

@unless ($post['is_new'])
<div>It is an old post ... using unless</div>
@endunless --}}

        <h1>
            {{ $post->title }}
            <x-badge type='danger' show="{{ now()->diffInMinutes($post->created_at) < 20 }}">
                New!
            </x-badge>
        </h1>
        <p>{{ $post->content }}</p>
        {{-- <img width="400" heigh="400" src="http://127.0.0.1/storage/{{ $post->image->path }}" alt=""> --}}
        {{-- <img width="400" heigh="400" src="{{ asset($post->image->path) }}" alt=""> --}}
        {{-- <img width="400" heigh="400" src="{{ Storage::url($post->image->path) }}" alt=""> --}}
        <img width="400" heigh="400" src="{{ $post->image->url() }}" alt="">
        {{-- <p>Added {{ $post->created_at->diffForHumans() }}</p> --}}
        <x-updated :date="$post->created_at" :name="$post->user->name">
            Added
        </x-updated>
        <x-updated :date="$post->updated_at">
            Updated
        </x-updated>

        <x-tags :tags="$post->tags">

        </x-tags>
        
        <P>Currently read by {{ $counter }}</P>
        <hr>
        <h4>Comments</h4>
        @include('posts.partials.comment')
        @forelse ($post->comments as $comment)
            <p>
                {{ $comment->content }}
            </p>
            {{-- <p class="text-muted">
                added {{ $comment->created_at->diffForHumans() }}
            </p> --}}
            <x-updated :date="$comment->created_at" :name="$comment->user->name">
                Added
            </x-updated>
        @empty
            <p>No comments yet!</p>
        @endforelse
{{-- @isset($post['has_comments'])
<div>The post has some comments ... using isset</div>
@endisset --}}
    </div>
    <div class="col-4">
        @include('posts._activity')
    </div>
</div>
@endsection