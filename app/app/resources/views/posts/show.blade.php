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
    @if ($post->image)
    <div style="background-image: url(' {{ $post->image->url() }}'); min-heigth: 500px; color: white; text-align: center; background-attachment: fixed;">
        <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
    @else
        <h1>
    @endif
            {{ $post->title }}
            <x-badge type='danger' show="{{ now()->diffInMinutes($post->created_at) < 20 }}">
                New!
            </x-badge>
        </h1>
    @if ($post->image)
        </h1>
    </div>
    @else
        </h1>
    @endif
        
        <p>{{ $post->content }}</p>
        {{-- <img width="400" heigh="400" src="http://127.0.0.1/storage/{{ $post->image->path }}" alt=""> --}}
        {{-- <img width="400" heigh="400" src="{{ asset($post->image->path) }}" alt=""> --}}
        {{-- <img width="400" heigh="400" src="{{ Storage::url($post->image->path) }}" alt=""> --}}
        {{-- <p>Added {{ $post->created_at->diffForHumans() }}</p> --}}
        <x-updated :date="$post->created_at" :name="$post->user->name">
            Added
        </x-updated>
        <x-updated :date="$post->updated_at">
            Updated
        </x-updated>

        <x-tags :tags="$post->tags">

        </x-tags>
        
        <P>{{ trans_choice('messages.people.reading', $counter) }}</P>
        <hr>
        <h4>Comments</h4>
        <x-commentForm :route="route('posts.comments.store', ['post' => $post->id])">
        </x-commentForm>

        <x-commentList :comments="$post->comments">
        </x-commentList>
{{-- @isset($post['has_comments'])
<div>The post has some comments ... using isset</div>
@endisset --}}
    </div>
    <div class="col-4">
        @include('posts._activity')
    </div>
</div>
@endsection