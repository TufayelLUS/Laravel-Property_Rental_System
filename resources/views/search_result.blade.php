@extends(Auth::check() ? 'layouts.user' : 'layouts.common')

@section('page_title')
Search Results
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
    @media only screen and (max-width: 1195px)
    {
        input, select
        {
            display: block;
            width: 100%;
        }
    }
</style>
@endsection

@section('page_body')
<div class="container mt-3">
	<div style="background-color: #e1eaf7">
		<div class="h1 mb-4 text-center">Looking for something?</div>
		<div class="mb-3 p-1 text-center">
	        <form action="search_result" class="mx-3">
	            <input type="text" name="area" class="mb-2 ml-1" placeholder="Enter Area">
	            <input min="0" type="number" name="min_price" class="mb-2 ml-1" placeholder="Enter Min Price">
	            <input min="0" type="number" name="max_price" class="mb-2 ml-1" placeholder="Enter Max Price">
	            <select class="mb-2 ml-1" name="applicant_type">
	            	<option value="Anyone">Anyone</option>
					<option value="Small Family Only">Small Family Only</option>
					<option value="Family Only">Family Only</option>
					<option value="Family/Job Holders">Family/Job Holders</option>
					<option value="Job Holders Only">Job Holders Only</option>
					<option value="Bachelors Only">Bachelors Only</option>
	            </select>
	            <select class="mb-2 ml-1" name="prop_type"><option value="Flat / Appartment">Flat / Appartment</option>
	            <option value="House">House</option>
	            <option value="Bungalaw">Bungalaw</option>
	            <option value="Office Space">Office Space</option>
	            <option value="Store Space / Commercial Space">Store Space / Commercial Space</option></select>
	            {{csrf_field()}}<br>
	            <button type="submit" class="btn btn-secondary py-2 px-5 mb-2 ml-1">Search</button>
	        </form>
	    </div>
	</div>
    <div style="background-color: #e1eaf7" class="p-2 mb-3">
		<h3 class="text-primary pt-4 text-center">Search Results</h3>
		<div class="text-left ml-3 mb-3 font-weight-normal"><i class="fa fa-caret-right"></i><i>You are searching <u>{{ $prop_type == "" ? "" : $prop_type }}</u> for <u>{{ $app_type == "" ? "" : $app_type }}</u> in <u>{{ $area == "" ? "Any Location" : $area }}</u> with price range of <u>({{ $min_price == "" ? "0" : $min_price }} - {{ $max_price == "" ? "Infinity" : $max_price }})</u></i><br></div>
		@if(count($results) == 0)
		<br><b>Sorry, currently there are no such property listed with your search criteria. Try changing search parameters and search again.</b><br><br>
		@endif
		@foreach($results as $result)
		<div class="row m-0 mb-3 bg-light p-3 border">
			<div class="col-lg-4 col-xl-4 col-sm-12">
				<img width="100%" class="mh-100" src="{{ url('uploads/' . explode('*' ,$result->photo)[0]) }}">
			</div>
			<div class="col-lg-8 col-xl-8 col-sm-12 text-left">
				<h3>@if($result->is_booked == 1 && $result->booking_expires > round(microtime(1)))
				<span class="badge badge-warning">Being Booked</span> 
				@endif
				@if($result->is_booked == 2)
				<span class="badge badge-success">Booked</span>
				@endif
				@if($result->is_booked != 2)
				<a style="color: blue" href="{{ url('property/' . $result->id) }}">{{ $result->title }}</a>
				@else
				{{ $result->title }}
				@endif</h3>
				<div class="font-weight-normal">
					<div class="border p-3">
						<p style="font-size: 15px; color: black" class="h6 font-weight-normal"><strong>Owner:</strong> <i>{{ App\User::find($result->user_id)->name }}</i></p>
					@if($result->cat != "Store Space / Commercial Space" && $result->cat != "Office Space")
					<p style="font-size: 15px; color: black" class="h6 font-weight-normal"><strong>Who Can Apply:</strong> <i>{{ $result->applicant_type }}</i></p>
					@endif
					<p style="font-size: 15px; color: black" class="h6 font-weight-normal"><strong>Listed Under:</strong> <i>{{ $result->cat }}</i></p>
						<strong>Location:</strong> <span class="{{Auth::check() ? '' : 'text-danger'}}">{{ Auth::check() ? $result->property_location : "Login to view" }}</span>
						<hr class="m-1">
						<div class="row m-0">
							<div class="col m-0 border-right">
								<strong>Price:</strong> {{ $result->property_price }}<br>
								@if($result->cat == "Store Space / Commercial Space")
							<strong>Room Area:</strong> {{ $result->rooms }} sqft
							@else
							<strong>Rooms:</strong> {{ $result->rooms }}
							@endif
							</div>
							<div class="col m-0">
								@if($result->cat != "Store Space / Commercial Space" && $result->cat != "Office Space")
								<strong>Gas:</strong> {{ $result->gas }}<br>
								@endif
								<strong>Electricity:</strong> {{ $result->electricity }}
							</div>
						</div>
					</div>
					@if(Auth::check() && $result->user_id == Auth::user()->id)
					<div class="float-right mt-2">
						<button class="btn btn-sm btn-primary" onclick="location.href='{{ url('edit_post/' . $result->id) }}'">Edit</button> <button class="btn btn-sm btn-danger">Delete</button>
					</div>
					@endif
				</div>
			</div>
		</div>
		@endforeach
		<div class="text-center"><a href="{{ $results->url(0) }}&area={{$area}}&min_price={{$min_price}}&max_price={{$max_price}}&applicant_type={{$app_type}}&prop_type={{$prop_type}}" class="btn btn-sm"><i class="fa fa-fast-backward"></i></a>
		@if(!$results->onFirstPage())
			<a class="btn btn-sm" style="color: black" href="{{ $results->previousPageUrl() }}&area={{$area}}&min_price={{$min_price}}&max_price={{$max_price}}&applicant_type={{$app_type}}&prop_type={{$prop_type}}">{{ $results->currentPage()-1 }}</a>
		@endif
		<span class="h4">{{ $results->currentPage() }}</span>
		@if($results->hasMorePages())
			<a class="btn btn-sm" style="color: black" href="{{ $results->nextPageUrl() }}&area={{$area}}&min_price={{$min_price}}&max_price={{$max_price}}&applicant_type={{$app_type}}&prop_type={{$prop_type}}">{{ $results->currentPage()+1 }}</a>
		@endif
		<a href="?page={{ $results->lastPage() }}&area={{$area}}&min_price={{$min_price}}&max_price={{$max_price}}&applicant_type={{$app_type}}&prop_type={{$prop_type}}" class="btn btn-sm"><i class="fa fa-fast-forward"></i></a></div>
	</div>
</div>
@endsection