@extends('layouts.common')

@section('page_title')
Reset Password - {{ $app_name }}
@endsection

@section('extra_headers')
<style type="text/css">
    html, body
    {
        background-image: url('../images/login_background.jpg');
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
                <div style="border-top-right-radius: 10px; border-top-left-radius: 10px;" class="panel-heading bg-warning text-black font-weight-normal p-2 h1 text-center">Reset Password</div>

                <div class="panel-body py-5 px-2">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="pb-3 text-center">
                            Enter your E-Mail Address to get password reset link
                        </div>
                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
                        
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
