@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? $user->image->url() : '' }}" alt="" class="img-thumbnail avatar">
                <div class="card mt-4">
                    <div class="card">
                        <h6>Upload a different photo</h6>
                        <input class="form-control-file" type="file" name="avatar">
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="form-group">
                    <label for="">Name:</label>
                    <input class="form-control" type="text" value="" name="name">
                </div>
                <x-errors>
                </x-errors>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Save Changes">
                </div>
            </div>
        </div>
    </form>
@endsection