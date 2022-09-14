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
        <div class="container">
            <div class="row">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Most Commented</h5>
                        <h6 class="card-subtitle mb-2 text-muted">What people are currently talking about</h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostCommented as $post)
                            <li class="list-group-item">
                                <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                    {{ $post->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row mt-4">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">Most Active</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            User with most posts written
                        </h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostActive as $user)
                            <li class="list-group-item">
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection