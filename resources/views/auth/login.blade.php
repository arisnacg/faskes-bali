@extends('layouts.app')

@section('content')
<div class="form-login box-white">
    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <h1><b style="color: #5ebea9; margin-right: 2px">LOGIN</b> FORM</h1>
        <div class="form-group">
            <label for="email" class="control-label">E-Mail Address</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="error-control">
                    {{ $errors->first('email') }}
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="password" class="control-label">Password</label>
            <input id="password" type="password" class="form-control" name="password" required>
            @if ($errors->has('password'))
                <span class="error-control">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>

         <div class="form-group">
            <label class="label-check">
                <input type="checkbox" name="remember" class="cuz-cb" {{ old('remember') ? 'checked' : '' }}>
                <span class="label-text"></span>Remember Me?
            </label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-success">
                Login
            </button>
            <a class="btn btn-primary btn-block" href="/qrcode" style="margin-top: 5px">
                Qrcode Generator
            </a>
        </div>
    </form>
</div>
@endsection
