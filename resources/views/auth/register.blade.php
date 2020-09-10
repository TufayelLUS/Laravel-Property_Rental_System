@extends('layouts.common')

@section('page_title')
Register to {{ $app_name }}
@endsection

@section('extra_headers')
<style type="text/css">
    html, body
    {
        background-image: url('images/login_background.jpg');
        background-repeat: no-repeat;
    }
    .blurred
    {
        background-color: black;
        opacity: 0.6;
        filter: alpha(opacity=60);
        border-radius: 10px;
    }
    </style>
@endsection

@section('page_body')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default blurred text-white">
                <div style="border-top-right-radius: 10px; border-top-left-radius: 10px;" class="panel-heading bg-warning text-black font-weight-normal p-2 text-center h1">Create an Account</div>

                <div class="panel-body py-5 px-2">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-md-4 control-label">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" placeholder="+8801XXXXXXXXX" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    <br>
                                @endif
                                <span id="phoneInvalid" style="display: none" class="help-block text-danger">
                                        <strong>Please use correct phone number formatting!</strong>
                                    </span>
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
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button id="regBtn" type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('input[name="phone"]').keyup(function() {
        var phone = $('input[name="phone"]').val();
        if (phone === "") {
            $('#phoneInvalid').css('display','none');
            $('#regBtn').removeAttr('disabled');
            $('#phoneInvalid').fadeOut("slow");
        }
        var type1 = /^\+\d+$/.test(phone); //+880xxxxxxxxx
        var type2 = /^\d+$/.test(phone); //017xxxxxxxxx
        if (type1 === true || type2 === true)
        {
            // a perfect number format
            $('#phoneInvalid').css('display','none');
            $('#regBtn').removeAttr('disabled');
            $('#phoneInvalid').fadeOut("slow");
        }
        else
        {
            $('#phoneInvalid').css('display','block');
            $('#regBtn').attr('disabled','disabled');
            $('#phoneInvalid').fadeIn("slow");
        }
    });
</script>
@endsection
