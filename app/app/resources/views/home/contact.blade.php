@extends('layouts.app')

@section('title', 'Contact Page')
@section('content')

<h1>Contact Page</h1>
@can('home.secret')
    <p>
        <a href="{{ route('home.secret') }}">
            Special contact details
        </a>
    </p>
@endcan
@endsection