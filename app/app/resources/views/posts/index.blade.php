@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
{{-- @if (count($posts)) --}}
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

@endsection