@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
{{-- @if (count($posts)) --}}
<div class="row">
    <div class="col-8">

    @each('posts.partials.post', $posts, 'post')
    {{-- @forelse ($posts as $key => $post)
    {{-- <div> {{ $key }} . {{ $post['title'] }}</div> --}}
    {{-- @break($key == 2) --}}
    {{-- @continue($key = 1) --}}
        {{-- @include('posts.partials.post', []) --}}

    {{-- @empty
    No posts found! --}}

    {{-- @endforelse --}} 

    {{-- @else
    No posts found! --}}
    {{-- @endif --}}
    </div>
    <div class="col-4">
        @include('posts._activity')
    </div>
</div>

@endsection