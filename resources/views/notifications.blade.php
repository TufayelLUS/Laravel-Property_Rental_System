@extends('layouts.user')

@section('page_title')
All Notifications
@endsection

@section('page_body')
<div class="container text-left font-weight-normal">
	<h1 class="text-center mt-3">Your Notifications</h1>
	@if(count($notifications) == 0)
	<div class="alert alert-primary">
		No notifications to show.
	</div>
	@endif
	@foreach($notifications as $notification)
	@if($unread_count > 0)
	<div>
		<blockquote onclick="location.href='{{$notification->page_url}}'" onmouseenter="this.style.boxShadow='0px 0px 5px -1px black';this.style.cursor='pointer'" onmouseleave="this.style.boxShadow=''" class="blockquote border p-3" style="background-color: #00cccc; border-radius: 10px;">
		{{$notification->msg_body}}<br>
		<sub>›› {{$notification->created_at}}</sub>
		</blockquote>
		@php
		$unread_count--;
		@endphp
	</div>
	@else
	<div>
		<blockquote onclick="location.href='{{$notification->page_url}}'" onmouseenter="this.style.boxShadow='0px 0px 5px -1px black';this.style.cursor='pointer'" onmouseleave="this.style.boxShadow=''" class="blockquote border p-3" style="background-color: #dcf3fa; border-radius: 10px">
		{{$notification->msg_body}}<br>
		<sub>›› {{$notification->created_at}}</sub>
		</blockquote>
	</div>
	@endif
	@endforeach
</div>
<div><a href="{{ $notifications->url(0) }}" class="btn btn-sm"><i class="fa fa-fast-backward"></i></a>
	@if(!$notifications->onFirstPage())
		<a class="btn btn-sm" style="color: black" href="{{ $notifications->previousPageUrl() }}">{{ $notifications->currentPage()-1 }}</a>
	@endif
	<span class="h4">{{ $notifications->currentPage() }}</span>
	@if($notifications->hasMorePages())
		<a class="btn btn-sm" style="color: black" href="{{ $notifications->nextPageUrl() }}">{{ $notifications->currentPage()+1 }}</a>
	@endif
	<a href="?page={{ $notifications->lastPage() }}" class="btn btn-sm"><i class="fa fa-fast-forward"></i></a></div>
@endsection