@extends('layouts.user')

@section('page_title')
{{ $listing->title }} - For Rent
@endsection

@section('page_body')
<div class="container my-4">
	<div class="h1">
		{{ $listing->title }} at monthly {{ $listing->property_price }} BDT
	</div>
	<div class="h5 font-weight-normal text-left p-2 border bg-light">
		<b>Category:</b> {{ $listing->cat }}
		<br>
		<b>Owner:</b> {{ App\User::find($listing->user_id)->name }}
		<br>
		<b>Property Location:</b> {{ $listing->property_location }}<br>
		@if($listing->cat != "Store Space / Commercial Space")
		<span id="available_for"><b>Available For:</b> {{ $listing->applicant_type }}</span>
		@endif
	</div>
	<div class="row m-0 border pt-4">
		<div class="col-lg-9 col-xl-9 col-sm-12">
			<div class="container text-left">
				<!-- carousel start -->
				<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
				  <div class="carousel-inner">
				  	@php
				  	$i = 0;
				  	@endphp
				  	@foreach(explode("*", $listing->photo) as $img)
				  	@if($i == 0)
				    <div class="carousel-item active">
				    @php
				    $i = 1;
				    @endphp
				    @else
				    <div class="carousel-item">
				    @endif
				      <img style="max-width: 740px; max-height: 410px; cursor: zoom-in;" class="d-block w-100" onclick="showFullSize('{{ url('uploads/' . $img) }}')" src="{{ url('uploads/' . $img) }}" alt="Property Image">
				    </div>
				    @endforeach
				  </div>
				  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
				    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
				    <span class="carousel-control-next-icon" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>
				<!-- carousel end -->
				<br>
				<div class="border p-2 bg-light rounded">
					<h3><b>Property Summary</b></h3>
					<div class="row m-0">
						<div class="col-lg-6 col-xl-6 col-sm-12">
							<p>
								<ul class="font-weight-normal">
									@if($listing->cat == "Store Space / Commercial Space")
									<li><b>Room Area: </b>{{ $listing->rooms }} sqft</li>
									@else
									<li><b>Rooms: </b>{{ $listing->rooms }}</li>
									@endif
									@if($listing->cat != "Store Space / Commercial Space")
									<ul id="bedroom_container">
										<li><b>Bedrooms: </b>{{ $listing->bedrooms }}</li>
									</ul>
									@endif
									@if($listing->cat != "Store Space / Commercial Space")
									<li><b>Bathrooms: </b>{{ $listing->bathrooms }}</li>
									<ul>
										<li><b>Attached: </b>{{ $listing->attached_bathrooms }}</li>
										<li><b>Common: </b>{{ $listing->common_bathrooms }}</li>
									</ul>
									<li id="kitchen_container"><b>Kitchens: </b>{{ $listing->kitchens }}</li>
									<li><b>Balcony: </b>{{ $listing->balcony }}</li>
									@endif
								</ul>
							</p>
						</div>
						<div class="col-lg-6 col-xl-6 col-sm-12">
							<p>
								<ul class="font-weight-normal">
									@if($listing->cat != "Store Space / Commercial Space")
									<li id="gas_container"><b>Gas: </b>{{ $listing->gas }}</li>
									@endif
									<li><b>Electricity: </b>{{ $listing->electricity }}</li>
									<li><b>Advance Payment: </b>{{ $listing->advance }}</li>
									@if($listing->cat != "Store Space / Commercial Space")
									<li id="furniture_container"><b>Furniture availablity: </b>{{ $listing->furniture }}</li>
									<li><b>Swimming Pool: </b>{{ $listing->swimming }}</li>
									<li><b>Parking Lot: </b>{{ $listing->parking }}</li>
									<li><b>Playground: </b>{{ $listing->playground }}</li>
									@endif
								</ul>
							</p>
						</div>
					</div>
				</div>
				<div class="border p-2 my-4 bg-light rounded">
					<h3><b>Description</b></h3>
					<p style="color: black;font-size: 18px">{!! nl2br(e($listing->description)) !!}</p>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-xl-3 col-sm-12">
			<div class="mb-4">
				@if(($listing->booked_by == Auth::user()->id && $listing->phone_shared == "on") || ($listing->phone_shared == "on" && $listing->is_booked == 0 && Auth::user()->id != $listing->user_id))
				<button class="btn btn-primary w-75 mb-3"  data-toggle="modal" data-target="#exampleModalCenter">Call</button><br>
				@else
				<button class="btn btn-primary w-75 mb-3"  data-toggle="modal" data-target="#exampleModalCenter" disabled>Call</button><br>
				@endif
				@if($listing->booked_by == Auth::user()->id || ($listing->is_booked == 0 && Auth::user()->id != $listing->user_id))
				<button onclick="location.href='mailto:{{ App\User::find($listing->user_id)->email }}'" class="btn btn-warning w-75 mb-3">Send Email</button>
				@else
				<button class="btn btn-warning w-75 mb-3" disabled>Send Email</button>
				@endif
				@if($listing->is_booked == 0 && Auth::check() && Auth::user()->id != $listing->user_id)
				<button onclick="triggerConfirmation({{$listing->id}})" class="btn btn-success w-75">Book This Property</button>
				@else
				<button class="btn btn-success w-75" disabled>Book This Property</button>
				@endif
				@if($listing->is_booked == 1 && $listing->booked_by != Auth::user()->id)
				@if($listing->expiry_unit == -1)
				<div class="text-danger mt-2">
					This property is under booking process. Check back later for availability.
				</div>
				@else
				<div class="text-danger mt-2">
					This property is under booking process.<br/>Check availability again after {{date_create_from_format( 'U.u', number_format($listing->booking_expires, 6, '.', ''))->setTimezone((new \DateTimeZone('Asia/Dhaka')))->format('d-m-Y h:i:s A')}} (GMT+6)
				</div>
				<div>
					@php
					$date1 = new DateTime(date_create_from_format( 'U.u', number_format(microtime(1), 6, '.', ''))->setTimezone((new \DateTimeZone('Asia/Dhaka')))->format('d-m-Y h:i:s A'));
					$date2 = $date1->diff(new DateTime(date_create_from_format( 'U.u', number_format($listing->booking_expires, 6, '.', ''))->setTimezone((new \DateTimeZone('Asia/Dhaka')))->format('d-m-Y h:i:s A')));
					@endphp
					<span class="text-danger">{{$date2->d}} days {{$date2->h}} hours {{$date2->i}} minutes {{$date2->s}} seconds remaining</span>
				</div>
				@endif
				@elseif($listing->is_booked == 1)
				@if($listing->expiry_unit == -1)
				<div class="text-danger mt-2">
					Please confirm your booking with owner as soon as possible, otherwise your booking may be cancelled.
				</div>
				@else
				<div class="text-danger mt-2">
					Please confirm your booking with owner within {{date_create_from_format( 'U.u', number_format($listing->booking_expires, 6, '.', ''))->setTimezone((new \DateTimeZone('Asia/Dhaka')))->format('d-m-Y h:i:s A')}} (GMT+6)
				</div>
				<div>
					@php
					$date1 = new DateTime(date_create_from_format( 'U.u', number_format(microtime(1), 6, '.', ''))->setTimezone((new \DateTimeZone('Asia/Dhaka')))->format('d-m-Y h:i:s A'));
					$date2 = $date1->diff(new DateTime(date_create_from_format( 'U.u', number_format($listing->booking_expires, 6, '.', ''))->setTimezone((new \DateTimeZone('Asia/Dhaka')))->format('d-m-Y h:i:s A')));
					@endphp
					<span class="text-danger">{{$date2->d}} days {{$date2->h}} hours {{$date2->i}} minutes {{$date2->s}} seconds remaining</span>
				</div>
				@endif
				@endif
			</div>
		</div>
	</div>
	<div class="border mt-2 bg-light">
		<div class="container mt-5" >
			<h3 class="text-primary">Have any question?</h3>
			<h4 class="text-left">Ask something</h4>
			<p>
				<form method="POST">
					{{ csrf_field() }}
					<textarea placeholder=".........." class="form-control" name="comment_body" required></textarea>
					<button style="text-align: right;" class="btn btn-primary mt-3" type="submit">Comment</button>
				</form>
			</p>
		</div>
		<div class="container mt-5">
			<h4 class="text-left">Comments</h4>
			@if(!count($comments))
			<div class="alert alert-info mb-3 font-weight-normal text-left">
				Be the first to comment here.
			</div>
			@endif
			@foreach($comments as $comment)
			<div style="background-color: #dcf3fa" id="comment{{$comment->id}}" class="container border mb-3">
				<h6 class="text-left mt-2" style="color: #525354"><a class="text-primary" href="{{url('/')}}/user_profile/{{$comment->user_id}}">{{ App\User::find($comment->user_id)->name }}</a> said,</h6>
				<p class="text-left" style="font-size: 15px">Time : {{ $comment->created_at }}</p>
				<p class="text-left pl-3" style="color: #525354;font-size: 18px"><div class="alert alert-warning p-3 mb-2 font-weight-normal text-left"><sup id="sups_start{{$comment->id}}"><i class="fas fa-quote-left" style="font-size: 6px"></i></sup> 
					<span id="main_comment_body{{$comment->id}}">{{ $comment->comment_body }}</span>
					<sup id="sups_end{{$comment->id}}"><i class="fas fa-quote-right" style="font-size: 6px"></i></sup></div>
					@if($comment->user_id == Auth::user()->id || Auth::user()->id == 1)
					<div id="action_comment{{$comment->id}}" class="text-right">
						<button onclick="editComment({{$comment->id}})" class="btn btn-sm btn-primary">Edit</button> <button onclick="location.href='{{url('/')}}/delete_comment/{{$comment->id}}'" class="btn btn-sm btn-danger">Delete</button>
					</div>
					@elseif($listing->user_id == Auth::user()->id)
					<div id="action_comment{{$comment->id}}" class="text-right">
						<button onclick="location.href='{{url('/')}}/delete_comment/{{$comment->id}}'" class="btn btn-sm btn-danger">Delete</button>
					</div>
					@endif
				</p>
			</div>
			@endforeach
		</div>
	</div>
</div>
<script type="text/javascript">
	function showFullSize(url)
	{
		$('#imgPlaceholder').attr('src', url);
		$('#img_url').attr('href', url);
		$('#imageFullscreen').modal('show');

	}
	function triggerConfirmation(id)
	{
		$('#confirm_id').attr('onclick','location.href="{{url('/')}}/confirm_booking/' + id + '"');
		$('#confirmBookModal').modal('show');
	}
	obj = {};
	function editComment(comment_id)
	{
		var old_comment = $('#main_comment_body' + comment_id).html();
		obj[0] = old_comment;
		$('#action_comment' + comment_id).hide();
		$('#sups_start' + comment_id).hide();
		$('#sups_end' + comment_id).hide();
		$('#main_comment_body'+comment_id).html("<form method='POST' action='{{url('/')}}/edit_comment/" + comment_id +"''><input type='hidden' name='_token' value='{{csrf_token()}}'><textarea  rows='2' class='form-control mb-2' name='comment_body'>" + old_comment + "</textarea><div class='text-right'><button type='submit' class='btn btn-sm btn-primary'>Update Comment</button> <button onclick='revertChanges("+ comment_id + ");return false;' class='btn btn-sm btn-secondary'>Cancel</button></div></form>");
	}

	function revertChanges(comment_id)
	{
		$('#action_comment' + comment_id).show();
		$('#sups_start' + comment_id).show();
		$('#sups_end' + comment_id).show();
		$('#main_comment_body' + comment_id).html(obj[0]);
	}

	@if ($listing->cat == "Office Space")
	$(document).ready(function(){
		$('#available_for').css('display', 'none');
		$('#bedroom_container').css('display', 'none');
		$('#kitchen_container').css('display', 'none');
		$('#gas_container').css('display', 'none');
		$('#furniture_container').css('display', 'none');
	});
	@endif
</script>
@endsection

@section('extra_headers')
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Contact Owner via phone</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body font-weight-bold">
      	@if($listing->phone_shared == "on")
        Contact Number: {{ App\User::find($listing->user_id)->phone }}
        @else
        Contact Number: Not shared by owner
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div class="modal fade" id="confirmBookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Booking Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body font-weight-bold">
      	<div class="alert alert-info text-left">
      		<h5 class="text-center font-weight-bold">Please Note</h5>
      	You are about to book this property. When booked, this property will be unavailable for others and you will have a fixed amount of time to talk/contact with owner depending on owner's preferences for property posted. If you do not contact or the owner denies, this property will become available for others again. Are you sure to book this property?
      	</div>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-success" id="confirm_id">Confirm</button>
        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div class="modal fade" id="imageFullscreen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog mw-100 m-0">
    <div class="modal-content m-2">
      <div class="modal-header">
      	<i class="fas fa-external-link-alt"></i>&nbsp; <a id="img_url" target="_blank" class="text-primary" style="font-size: 20px" href="">Open in new tab</a> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
      	<img src="" width="100%" height="100%" id="imgPlaceholder">
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
@endsection