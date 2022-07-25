@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
{{-- @if (count($posts)) --}}

@forelse ($posts as $key => $post)
{{-- <div> {{ $key }} . {{ $post['title'] }}</div> --}}
{{-- @break($key == 2) --}}
{{-- @continue($key = 1) --}}

@if ($loop->even)
    <div>{{ $key }} . {{ $post['title'] }}</div>
@else 
    <div style="color: red">{{ $key }} . {{ $post['title'] }}</div>
@endif

@empty
No posts found!

@endforelse

{{-- @else
No posts found! --}}
{{-- @endif --}}

@endsection