@extends('layouts.admin')

@section('page_title')
Send Announcement To All Users
@endsection

@section('page_body')
<div class="container m-0">
	<div class="border my-3">
		<div class="border m-2">
			<div class="h1">Send an Annoucement to all users</div>
		</div>
		<form class="p-3 border m-2" method="POST">
			{{csrf_field()}}
			Annoucement Subject
			<input placeholder="Your announcement subject goes here" type="text" class="form-control my-3" name="msg_subject">
			Announcement Body
			<textarea rows="10" name="msg_body" class="form-control my-3" placeholder="Your announcement goes here" minlength="10" required></textarea>
			<button type="submit" class="btn btn-success">Send Announcement</button>
		</form>
	</div>
</div>
@endsection