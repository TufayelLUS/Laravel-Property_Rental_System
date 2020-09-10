@extends('layouts.user')

@section('page_title')
Properties Listing
@endsection

@section('extra_headers')
<style type="text/css">
    input
    {
        padding: 5px;
        display: inline-block;
    }
    select
    {
        padding: 8px;
        display: inline-block;
    }
    @media only screen and (max-width: 1170px)
	{
	    input, select
	    {
	        display: block;
	        width: 100%;
	    }
	}
</style>
<!-- Modal -->
<div class="modal fade" id="property_del_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Confirmation before deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="confirm_delete" class="modal-body font-weight-bold">
        Are you sure to delete this property?
      </div>
      <div class="modal-footer">
      	<button id="delete_id" class="btn btn-danger">Confirm</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
@endsection

@section('page_body')
<div class="container my-4">
	@if(explode('/', url()->current())[count(explode('/', url()->current()))-1] == "my_properties")
	<h1>Properties I Own</h1>
	@else
	<h1>Properties Posted In This Site</h1>
	@endif
	<div class="text-center mb-3">
		<form>
			Filter: <select name="type" id="filter" class="mb-2">
				<option value="">None</option>
				<option value="Flat / Appartment">Flat / Appartment</option>
				<option value="House">House</option>
				<option value="Bungalaw">Bungalaw</option>
				<option value="Office Space">Office Space</option>
				<option value="Store Space / Commercial Space">Store Space / Commercial Space</option>
				<option value="Land">Land</option>
			</select>
			<select class="mb-2" name="applicant_type">
            	<option value="Anyone">Anyone</option>
				<option value="Small Family Only">Small Family Only</option>
				<option value="Family Only">Family Only</option>
				<option value="Family/Job Holders">Family/Job Holders</option>
				<option value="Job Holders Only">Job Holders Only</option>
				<option value="Bachelors Only">Bachelors Only</option>
            </select>
		<button type="submit" class="btn btn-success">Apply</button>
		</form>
	</div>
	@if(count($listings) == 0)
	<div class="text-left font-weight-normal alert alert-primary">No property listed for showing.</div>
	@endif
	@foreach($listings as $listing)
	<div class="row m-0 mb-3 bg-light p-3 border">
		<div class="col-lg-4 col-xl-4 col-sm-12">
			<img width="100%" class="mh-100" src="{{ url('uploads/' . explode('*' ,$listing->photo)[0]) }}">
		</div>
		<div class="col-lg-8 col-xl-8 col-sm-12 text-left">
			<h4>@if($listing->is_booked == 1 && $listing->booking_expires > round(microtime(1)))
				<span class="badge badge-warning">Being Booked</span>
				@endif
				@if($listing->is_booked == 2)
				<span class="badge badge-success">Booked</span>
				@endif
				@if($listing->is_booked != 2)
				<a style="color: blue" href="{{ url('property/' . $listing->id) }}">{{ $listing->title }}</a>
				@else
				{{ $listing->title }}
				@endif
			</h4>
			<div class="font-weight-normal">
				<div class="border p-3">
					<p style="font-size: 15px; color: black" class="h6 font-weight-normal"><strong>Owner:</strong> <i><a href="{{url('/')}}/user_profile/{{$listing->user_id}}" class="text-primary">{{ App\User::find($listing->user_id)->name }}</a></i></p>
					@if($listing->cat != "Store Space / Commercial Space" && $listing->cat != "Office Space")
					<p style="font-size: 15px; color: black" class="h6 font-weight-normal"><strong>Who Can Apply:</strong> <i>{{ $listing->applicant_type }}</i></p>
					@endif
					<p style="font-size: 15px; color: black" class="h6 font-weight-normal"><strong>Listed Under:</strong> <i>{{ $listing->cat }}</i></p>
					<strong>Location:</strong> {{ $listing->property_location }}
					<hr class="m-1">
					<div class="row m-0">
						<div class="col m-0 border-right">
							<strong>Price:</strong> {{ $listing->property_price }}<br>
							@if($listing->cat == "Store Space / Commercial Space")
							<strong>Room Area:</strong> {{ $listing->rooms }} sqft
							@else
							<strong>Rooms:</strong> {{ $listing->rooms }}
							@endif
						</div>
						<div class="col m-0">
							@if($listing->cat != "Store Space / Commercial Space" && $listing->cat != "Office Space")
							<strong>Gas:</strong> {{ $listing->gas }}<br>
							@endif
							<strong>Electricity:</strong> {{ $listing->electricity }}
						</div>
					</div>
				</div>
				@if($listing->user_id == Auth::user()->id)
				<div class="float-right mt-2">
					@if($listing->is_booked == 2)
					<button class="btn btn-sm btn-primary" onclick="location.href='{{ url('edit_post/' . $listing->id . '/repost') }}'">Repost</button>
					@else
					<button class="btn btn-sm btn-primary" onclick="location.href='{{ url('edit_post/' . $listing->id) }}'">Edit</button>
					@endif
					 <button onclick="triggerConfirm({{$listing->id}})" class="btn btn-sm btn-danger">Delete</button>
				</div>
				@endif
			</div>
		</div>
	</div>
	@endforeach
	<div><a href="{{ $listings->url(0) }}&type={{$type}}&applicant_type={{$app_type}}" class="btn btn-sm"><i class="fa fa-fast-backward"></i></a>
	@if(!$listings->onFirstPage())
		<a class="btn btn-sm" style="color: black" href="{{ $listings->previousPageUrl() }}&type={{$type}}&applicant_type={{$app_type}}">{{ $listings->currentPage()-1 }}</a>
	@endif
	<span class="h4">{{ $listings->currentPage() }}</span>
	@if($listings->hasMorePages())
		<a class="btn btn-sm" style="color: black" href="{{ $listings->nextPageUrl() }}&type={{$type}}&applicant_type={{$app_type}}">{{ $listings->currentPage()+1 }}</a>
	@endif
	<a href="?page={{ $listings->lastPage() }}&type={{$type}}&applicant_type={{$app_type}}" class="btn btn-sm"><i class="fa fa-fast-forward"></i></a></div>
</div>
<script type="text/javascript">
	function triggerConfirm(id)
	{
		$('#delete_id').attr('onclick',"location.href='{{url('/')}}/delete_property/" + id +"'");
		$('#property_del_modal').modal('show');
	}
	$(document).ready(function(){
		$('option[value="{{$type}}"]').prop('selected', 'selected');
		$('option[value="{{$app_type}}"]').prop('selected', 'selected');
	});
</script>
@endsection