@extends('layouts.app')

@section('content')

    <div class="form-login box-white">
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <h1><b style="color: #5ebea9; margin-right: 2px">LOGIN</b> FORM</h1>
            <div class="form-group">
                <label class="control-label">E-Mail Address</label>
                <input type="email" class="form-control" name="email" placeholder="Your Email" required autofocus>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label class="control-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Your Password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label class="label-check">
                    <input type="checkbox" class="cuz-cb">
                    <span class="label-text"></span>Remember Me?
                </label>
            </div>

            <button type="submit" class="btn btn-block btn-success">LOGIN</button>
                
        </form>
    </div>

@endsection
