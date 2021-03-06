@extends('layouts.common')

@section('page_title')
Login to {{ $app_name }}
@endsection

@section('extra_headers')
<style type="text/css">
    html, body
    {
        background-image: url('images/login_background.jpg');
        background-position: center;
        background-repeat: no-repeat;
    }
    .blurred
    {
        background-color: black;
        opacity: 0.6;
        filter: alpha(opacity=60);
        border-radius: 10px;
    }
    #copyright
    {
        
        width: 100%;
        overflow: hidden;
    }
</style>
@endsection

@section('page_body')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default blurred text-white">
                <div style="border-top-right-radius: 10px; border-top-left-radius: 10px;" class="panel-heading bg-warning text-black font-weight-normal p-2 h1 text-center">Login</div>

                <div class="panel-body py-5 px-2">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-warning">
                                    Login
                                </button>

                                <a class="btn btn-link text-warning" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
