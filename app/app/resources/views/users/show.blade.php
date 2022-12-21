@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
    <div class="row">
        <div class="col-4">
            <img src="{{ $user->image ? $user->image->url() : '' }}" alt="" class="img-thumbnail avatar">
        </div>
        <div class="col-8">
            <h3>{{ $user->name }}</h3>

            <p>Currently viewed by {{ $counter }} other users</p>
            <x-commentForm :route="route('users.comments.store', ['user' => $user->id])">
            </x-commentForm>
        
            <x-commentList :comments="$user->commentsOn">
            </x-commentList>
        </div>
    </div>
    
@endsection