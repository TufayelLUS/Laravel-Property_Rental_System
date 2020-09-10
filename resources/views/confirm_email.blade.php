@extends('layouts.common')

@if(Auth::user()->is_email_verified == "False")
@section('page_title')
Account Unverified!
@endsection

@section('page_body')
<div style="min-height: 100%" class="text-center my-5">
	<i class="h1 text-warning fas fa-exclamation-triangle"></i>
	<h1 class="mb-3">Hi {{ Auth::user()->name }}!</h1>
	<p class="font-weight-normal container">Thanks for being a part of our website. We have sent you an account verification link to your email. <b>Please confirm your email to access the website functionalities</b>. Once confirmed, you can use our website normally. Thank you.</p>
	<p class="font-weight-normal container">No emails received? Check in SPAM folder or <b><a class="text-success h4" href="confirm_email">Click Here to Send Verification Email Again</a></b></p>
</div>
@endsection
@else
<script type="text/javascript">
	location.href = 'dashboard';
</script>
<noscript>Please go back to <a href="{{url('/')}}">home page</a></noscript>
@endif