@extends('layouts.admin')

@section('page_title')
Booking Records
@endsection

@section('page_body')
<div class="container">
	<h1 class="py-2">Booking Activities</h1>
	<div style="overflow-x: auto;">
	<table class="table table-striped table-bordered" width="100%">
		<tr>
			<th>Renter</th>
			<th>Owner</th>
			<th>Link</th>
			<th>Status</th>
		</tr>
		@foreach($listings as $listing)
		<tr>
		    @if(App\User::where('id', '=', $listing->booked_by)->count())
			<td>{{App\User::find($listing->booked_by)->name}}</td>
			<td>{{App\User::find($listing->user_id)->name}}</td>
			<td><a target="_blank" class="text-primary" href="{{url('property/' . $listing->id)}}" >View</a></td>
			<td>@if($listing->is_booked == 1)
				Being Booked
				@elseif($listing->is_booked == 2)
				Booked
				@endif
			</td>
			@php
			continue
			@endphp
			@endif
		</tr>
		@endforeach
	</table>
	</div>
	@if(!count($listings))
	<div class="alert alert-info text-left">No ongoing booking at this moment.</div>
	@endif
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