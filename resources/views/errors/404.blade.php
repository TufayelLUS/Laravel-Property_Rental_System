@extends('layouts.common')
@section('page_title')
Page Not Found! - {{ $app_name }}
@endsection

@section('extra_headers')
<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat:900" rel="stylesheet">

<link type="text/css" rel="stylesheet" href="https://colorlib.com/etc/404/colorlib-error-404-3/css/style.css" />
<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
@endsection

@section('page_body')
<div id="notfound">
<div class="notfound">
<div class="notfound-404">
<h3>Oops! Page not found</h3>
<h1><span>4</span><span>0</span><span>4</span></h1>
</div>
<h2>we are sorry, but the page you requested was not found</h2>
</div>
</div>
@endsection