@extends('layouts.common')

@section('page_title')
{{$user->name}}'s Public Profile - {{$app_name}}
@endsection

@section('extra_headers')
<style type="text/css">
.profile-cover
{
    background-image: url("../images/cover-default.jpg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
<script type="text/javascript">
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});
</script>
@endsection

@section('page_body')
<div class="font-weight-normal">
	<div class="profile-cover p-5">
		
	</div>
	<div class="">
		<img class="rounded" src="{{url('/')}}/images/avatar-default.png" width="100px" height="100px" style="margin-left: 30px;margin-top: -60px;margin-right: 20px"> <div style="margin-left:140px;margin-top:-80px;color:white;margin-bottom:80px">{{$user->name}} @if($user->is_email_verified == "True")
			&nbsp;<i data-toggle="tooltip" data-placement="bottom" title="This user has verified email address" class="fas fa-check-circle text-info"></i>&nbsp; @if(Auth::check() && Auth::user()->id != $user->id)
			@if(App\Follower::where('user_id', '=', $user->id)->where('follower_id','=', Auth::user()->id)->count())
			<button onclick="location.href='{{url('/')}}/user_profile/{{$user->id}}/unfollow'" class="btn btn-sm btn-success p-1">Unfollow</button>
			@else
			<button onclick="location.href='{{url('/')}}/user_profile/{{$user->id}}/follow'" class="btn btn-sm btn-success p-1">Follow</button>
			@endif
			@endif
		@endif</div>
	</div>
	<div class="m-4 p-3 border">
		<b>Member Since:</b> {{$user->created_at}}<br>
		<b>Properties Posted:</b> {{App\Listing::where('user_id','=',$user->id)->count()}}<br>
		<b>Comments Posted:</b> {{App\Comment::where('user_id','=',$user->id)->count()}}<br>
	</div>
	<div class="mx-4 mb-4 p-3 border text-center" id="recent">
		<div class="p-3 mb-2 border">
			<b>Recent Published Properties</b>
		</div>
		<div class="px-2 pb-2 border">
			@foreach($listings as $listing)
			<div class="p-3 mt-2 border bg-light text-left">
				<b>Property Name:</b> {{$listing->title}} 
				@if($listing->is_booked == 1 && $listing->booking_expires > round(microtime(1)))
				<span class="badge badge-warning">Being Booked</span>
				@elseif($listing->is_booked == 2)
				<span class="badge badge-success">Already Booked</span>
				@else
				<a class="text-primary" target="_blank" href="{{url('/')}}/property/{{$listing->id}}">View</a>
				@endif
				<br>
				<b>Category:</b> {{$listing->cat}}<br>
				<b>Available For:</b> {{$listing->applicant_type}}
			</div>
			@endforeach
			@if(!count($listings))
			<div class="alert alert-info text-left m-0 p-3 mt-2">This user hasn't published any property yet.</div>
			@endif
		</div>
	</div>
</div>
@endsection