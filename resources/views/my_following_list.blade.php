@extends('layouts.user')

@section('page_title')
People I am following
@endsection

@section('page_body')
<div class="container my-3 font-weight-normal">
	<h1>My subscription list</h1>
	<table class="table table-bordered table-striped" style="overflow-x: auto;" width="100%">
		<tr>
			<th width="70%">User Name</th>
			<th width="30%">Action</th>
		</tr>
		@foreach($users as $user)
		<tr>
			<td class="text-left">{{App\User::find($user->user_id)->name}}</td>
			<td><button onclick="location.href='{{url('/')}}/user_profile/{{$user->user_id}}'" class="btn btn-sm btn-info">View Profile</button></td>
		</tr>
		@endforeach
	</table>
	@if(count($users) == 0)
	<div class="alert alert-info mb-0 text-left font-weight-normal">You haven't followed anyone yet. Once you follow someone, it will be shown here.</div>
	@endif
	<div><a href="{{ $users->url(0) }}" class="btn btn-sm"><i class="fa fa-fast-backward"></i></a>
	@if(!$users->onFirstPage())
		<a class="btn btn-sm" style="color: black" href="{{ $users->previousPageUrl() }}">{{ $users->currentPage()-1 }}</a>
	@endif
	<span class="h4">{{ $users->currentPage() }}</span>
	@if($users->hasMorePages())
		<a class="btn btn-sm" style="color: black" href="{{ $users->nextPageUrl() }}">{{ $users->currentPage()+1 }}</a>
	@endif
	<a href="?page={{ $users->lastPage() }}" class="btn btn-sm"><i class="fa fa-fast-forward"></i></a></div>
</div>
@endsection