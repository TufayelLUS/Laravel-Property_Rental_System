@extends('layouts.user')

@section('page_title')
My Booking List
@endsection

@section('page_body')
<div class="container text-left font-weight-normal">
	<h1 class="my-3 text-center">Your Booking List</h1>
	@if(!count($listings))
	<div class="alert alert-primary">
	There's nothing to show. When you will book a property, it will show on here. 
	</div>
	@endif
	@foreach($listings as $listing)
	<div class="border bg-light p-3 mt-2" onclick="location.href='{{url('property')}}/{{$listing->id}}'" onmouseenter="this.style.cursor = 'pointer'">
		<b>Property:</b> {{$listing->title}} 
		@if($listing->is_booked == 2)
		<span class="text-success">(Booking Confirmed!)</span>
		@else
		<br>
		<b>Booking Ends:</b>@if ($listing->expiry_unit == -1)
		<span class="text-danger">Not Defined, Hurry Up</span><br>
		@else
		{{date_create_from_format( 'U.u', number_format($listing->booking_expires, 6, '.', ''))->setTimezone((new \DateTimeZone('Asia/Dhaka')))->format('d-m-Y h:i:s A')}} (GMT+6)<br>
		@php
		$date1 = new DateTime(date_create_from_format( 'U.u', number_format(microtime(1), 6, '.', ''))->setTimezone((new \DateTimeZone('Asia/Dhaka')))->format('d-m-Y h:i:s A'));
		$date3 = new DateTime(date_create_from_format( 'U.u', number_format($listing->booking_expires, 6, '.', ''))->setTimezone((new \DateTimeZone('Asia/Dhaka')))->format('d-m-Y h:i:s A'));
		$date2 = $date3->diff($date1);
		@endphp
		@endif
		<b>Time left:</b> @if ($listing->expiry_unit == -1)
		<span class="text-danger">Not Defined, Hurry Up</span>
		@else
		<span class="text-danger">{{$date2->d}} days {{$date2->h}} hours {{$date2->i}} minutes {{$date2->s}} seconds</span>
		@endif
		@endif
	</div>
	@endforeach
</div>
<div><a href="{{ $listings->url(0) }}" class="btn btn-sm"><i class="fa fa-fast-backward"></i></a>
	@if(!$listings->onFirstPage())
		<a class="btn btn-sm" style="color: black" href="{{ $listings->previousPageUrl() }}">{{ $listings->currentPage()-1 }}</a>
	@endif
	<span class="h4">{{ $listings->currentPage() }}</span>
	@if($listings->hasMorePages())
		<a class="btn btn-sm" style="color: black" href="{{ $listings->nextPageUrl() }}">{{ $listings->currentPage()+1 }}</a>
	@endif
	<a href="?page={{ $listings->lastPage() }}" class="btn btn-sm"><i class="fa fa-fast-forward"></i></a></div>
@endsection