@extends('layouts.app')

@section('title', 'Login')

@section('content')

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label for="">E-mail</label>
        <input name="email" value="{{ old('email') }}" type="text"
            class="form-control{{ $errors->has('email') ? ' is-invalid' : ''}}" required>

        @if ($errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">
        <label for="">Password</label>
        <input name="password" value="" type="password"
            class="form-control{{ $errors->has('password') ? ' is-invalid' : ''}}" required>
        @if ($errors->has('password'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">
        <div class="form-check">
            <input name="remember" type="checkbox" class="form-check-input"
            value="{{ old('remeber') ? 'checked' : '' }}">
            <label class="form-check-label" for="remeber">
                Remember Me
            </label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-block">
        Login
    </button>
</form>
@endsection