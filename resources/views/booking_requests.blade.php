@extends('layouts.user')

@section('page_title')
People who booked my properties
@endsection

@section('page_body')
<div class="container text-left">
	<h1 class="text-center mt-3">Booking Requests For Your Property</h1>
	<div class="alert alert-info"><i class="fas fa-info-circle"></i> Every booking request has a fixed lifetime based on your defined timeout setting, you can accept/deny it within that time. After the time has expired, your property will become available again for others to book. Until you take action, your property will remain onhold.</div>
	<hr>
	<table class="table table-bordered table-striped" width="100%">
		@if(count($listings) > 0)
		<tr class="text-center">
			<th width="50%">Property Name</th>
			<th width="30%">User Name</th>
			<th width="20%">Action</th>
		</tr>
		@else
		<div class="font-weight-normal alert alert-primary">Currently no one has booked your property. Once booked, it will appear here.</div>
		@endif
		<script type="text/javascript">
			var prop_name = [];
			var lodger_name = [];
			var phone = [];
			var email = [];
			var expires = [];
		</script>
		@foreach($listings as $listing)
		<tr>
			<td>{{$listing->title}} ({{$listing->property_price}} BDT)</td>
			<td>{{App\User::find($listing->booked_by)->name}}</td>
			<td class="text-center"><button class="btn btn-primary" onclick="triggerDialog({{$listing->id}})">View Details</button></td>
		</tr>
		<script type="text/javascript">
			prop_name[{{$listing->id}}] = "{{$listing->title}}";
			lodger_name[{{$listing->id}}] = "{{App\User::find($listing->booked_by)->name}}";
			phone[{{$listing->id}}] = "{{App\User::find($listing->booked_by)->phone}}";
			email[{{$listing->id}}] = "{{App\User::find($listing->booked_by)->email}}";
			expires[{{$listing->id}}] = "{{date_create_from_format( 'U.u', number_format($listing->booking_expires, 6, '.', ''))->setTimezone((new \DateTimeZone('Asia/Dhaka')))->format('d-m-Y h:i:s A')}}";
		</script>
		@endforeach
	</table>
	<div class="text-center"><a href="{{ $listings->url(0) }}" class="btn btn-sm"><i class="fa fa-fast-backward"></i></a>
	@if(!$listings->onFirstPage())
		<a class="btn btn-sm" style="color: black" href="{{ $listings->previousPageUrl() }}">{{ $listings->currentPage()-1 }}</a>
	@endif
	<span class="h4">{{ $listings->currentPage() }}</span>
	@if($listings->hasMorePages())
		<a class="btn btn-sm" style="color: black" href="{{ $listings->nextPageUrl() }}">{{ $listings->currentPage()+1 }}</a>
	@endif
	<a href="?page={{ $listings->lastPage() }}" class="btn btn-sm"><i class="fa fa-fast-forward"></i></a></div>
</div>
<script type="text/javascript">
	function triggerDialog(id)
	{
		$('#property_name').html(prop_name[id]);
		$('#lodger_un').html(lodger_name[id]);
		$('#lodger_ph').html(phone[id]);
		$('#lodger_em').html('<a class="text-primary" href="mailto:' + email[id] + '">' + email[id] + "</a>");
		$('#req_expires').html(expires[id]);
		$('#confirmBtn').attr('onclick', "location.href='confirm_customer/" + id + "'");
		$('#cancelBtn').attr('onclick', "location.href='cancel_customer/" + id + "'");
		$('#detailsDialog').modal('show');
	}

	function confirmBooking(id)
	{
		alert(id);
	}
</script>
@endsection
@section('extra_headers')
<!-- Modal -->
<div class="modal fade" id="detailsDialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Booking Request Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body font-weight-bold">
      	<table class="table table-bordered table-striped" width="100%">
      		<tr>
      			<th width="40%">Property Name: </th>
      			<td width="60%"><span id="property_name"></span></td>
      		</tr>
      		<tr>
      			<th>Customer Name: </th>
      			<td><span id="lodger_un"></span></td>
      		</tr>
      		<tr>
      			<th>Customer Phone Number: </th>
      			<td><span id="lodger_ph"></span></td>
      		</tr>
      		<tr>
      			<th>Customer Contact Email: </th>
      			<td><span id="lodger_em"></span></td>
      		</tr>
      		<tr>
      			<th>Request Expires On: </th>
      			<td><span id="req_expires"></span></td>
      		</tr>
      	</table>
      	<div class="text-center">
      		<div class="alert alert-primary">Please wait for Lodger to contact you or you can contact lodger to confirm the booking. Once accepted, your property will be archived. Once denied, your property will become available for others to book again.</div>
      		<button id="confirmBtn" class="btn btn-success mr-3">Accept</button><button id="cancelBtn" class="btn btn-danger">Deny</button>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
@endsection