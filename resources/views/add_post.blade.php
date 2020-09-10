@extends('layouts.user')

@section('page_title')
Add A New Post
@endsection

@section('page_body')
<div class="container my-4">
	<h1 class="mb-5">Add a new Property to Listing</h1>
	<form class="text-left font-weight-normal border" style="padding: 20px;" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
		<p class="text-left text-primary"><strong><i class="fa fa-caret-right"></i> Property Summary</strong></p>
		Property Name <i data-toggle="tooltip" data-placement="top" title="Your House/Property Name" class="fas fa-info-circle text-info"></i>
		<input class="form-control mb-3 mt-1" type="text" name="title" placeholder="Property Name* (ex. Shaheen Villa for rent)" minlength="10" required>
		Property Type <i data-toggle="tooltip" data-placement="top" title="Category in which it falls into" class="fas fa-info-circle text-info"></i>
		<select name="cat" class="form-control mb-3 mt-1" required>
			<option value="Flat / Appartment">Flat / Appartment</option>
			<option value="House">House</option>
			<option value="Bungalaw">Bungalaw</option>
			<option value="Office Space">Office Space</option>
			<option value="Store Space / Commercial Space">Store Space / Commercial Space</option>
		</select>
		Rent <i data-toggle="tooltip" data-placement="top" title="Monthly rent in BDT your customer has to pay" class="fas fa-info-circle text-info"></i>
		<input type="number" min="0" class="form-control mb-3 mt-1" name="property_price" placeholder="Property Rent/Month*" required>
		<span id="availability_label">Property Availability <i data-toggle="tooltip" data-placement="top" title="Who are allowed to apply for" class="fas fa-info-circle text-info"></i></span>
		<select class="form-control mb-3 mt-1" name="applicant_type">
			<option value="Anyone">Anyone</option>
			<option value="Small Family Only">Small Family Only</option>
			<option value="Family Only">Family Only</option>
			<option value="Family/Job Holders">Family/Job Holders</option>
			<option value="Job Holders Only">Job Holders Only</option>
			<option value="Bachelors Only">Bachelors Only</option>
		</select>
		<span id="rooms_label">
		Rooms</span> <span id="rooms_tooltip_normal"><i data-toggle="tooltip" data-placement="top" title="Number of rooms available" class="fas fa-info-circle text-info"></i></span>
		<span id="rooms_tooltip_commerce" style="display: none;"><i id="rooms_tooltip" data-toggle="tooltip" data-placement="top" title="Area covered by room in sqft" class="fas fa-info-circle text-info"></i></span>
		<input min="0" type="number" class="form-control mb-3 mt-1" placeholder="Rooms" name="rooms" required>
		<span id="bedrooms_label">Bedrooms <i data-toggle="tooltip" data-placement="top" title="Number of available bedrooms" class="fas fa-info-circle text-info"></i></span>
		<input min="0" type="number" class="form-control mb-3 mt-1" placeholder="Bedrooms" name="bedrooms">
		<span id="bathroom_block">
		Bathrooms <i data-toggle="tooltip" data-placement="top" title="Total bathrooms available" class="fas fa-info-circle text-info"></i>
		<input min="0" type="number" class="form-control mb-3 mt-1" placeholder="Bathrooms" name="bathrooms">
		Attached Bathrooms <i data-toggle="tooltip" data-placement="top" title="Number of attached bathrooms" class="fas fa-info-circle text-info"></i>
		<input min="0" type="number" class="form-control mb-3 mt-1" placeholder="Attached Bathrooms" name="attached_bathrooms">
		Common Bathrooms <i data-toggle="tooltip" data-placement="top" title="Number of common bathrooms" class="fas fa-info-circle text-info"></i>
		<input min="0" type="number" class="form-control mb-3" placeholder="Common Bathrooms" name="common_bathrooms">
		</span>
		<span id="kitchens_label">Kitchens <i data-toggle="tooltip" data-placement="top" title="Number of available kitchens" class="fas fa-info-circle text-info"></i></span>
		<input min="0" type="number" class="form-control mb-3 mt-1" placeholder="Kitchens" name="kitchens">
		<span id="balcony_label">
		Balcony <i data-toggle="tooltip" data-placement="top" title="Number of available balcony" class="fas fa-info-circle text-info"></i>
		<input min="0" type="number" class="form-control mb-3 mt-1" placeholder="Balcony" name="balcony">
		</span>
		<p class="text-left text-primary"><strong><i class="fa fa-caret-right"></i> Offer Timeout Setting</strong></p>
		<div class="text-left">
			<span class="form-inline">
				Booking Request Timeout &nbsp;<i data-toggle="tooltip" data-placement="top" title="How long to engage your property for a customer booking" class="fas fa-info-circle text-info"></i> 
				<select class="form-control ml-2" name="expiry_unit">
					<option value="1">1 Hour</option>
					<option value="2">2 Hours</option>
					<option value="3">3 Hours</option>
					<option value="4">6 Hours</option>
					<option value="5">24 Hours</option>
					<option value="6">No Timeout</option>
				</select>
			</span>
		</div>
		<p class="text-left text-primary"><strong><i class="fa fa-caret-right"></i> Other Options</strong></p>
		<div class="text-left">
			<span class="form-inline mt-2" id="gas_block">
				<input type="checkbox" class="mr-1" name="gas"> Gas &nbsp;<i data-toggle="tooltip" data-placement="top" title="Tick mark if customer has to pay bills" class="fas fa-info-circle text-info"></i>
				<select class="form-control ml-2" name="gas_type" disabled>
					<option value="Regular">Regular</option>
					<option value="Cylinder">Cylinder</option>
				</select>
			</span>
			<span class="form-inline mt-2" id="electricity_block">
				<input type="checkbox" class="mr-1" name="electricity"> Electricity &nbsp;<i data-toggle="tooltip" data-placement="top" title="Tick mark if customer has to pay bills" class="fas fa-info-circle text-info"></i>
				<select class="form-control ml-2" name="electricity_type" disabled>
					<option value="Prepaid">Prepaid</option>
					<option value="Postpaid">Postpaid</option>
					</select>
			</span>
			<span class="form-inline mt-2" id="advance_block">
				<input type="checkbox" class="mr-1" name="advance"> Advance Payment &nbsp;<i data-toggle="tooltip" data-placement="top" title="Tick mark if customer has to pay advance rent" class="fas fa-info-circle text-info"></i>
				<input min="0" type="number" class="form-control ml-2" name="advance_amount" placeholder="Amount Payable" disabled>
			</span>
			<span id="furniture_block"><input type="checkbox" class="" name="furniture"> Furnitures Included <i data-toggle="tooltip" data-placement="top" title="Tick mark if furniture is available" class="fas fa-info-circle text-info"></i><br></span>
			<span id="parking_block"><input type="checkbox" class="" name="parking"> Parking Lot <i data-toggle="tooltip" data-placement="top" title="Tick mark if parking lot is available" class="fas fa-info-circle text-info"></i><br></span>
			<span id="swimming_block"><input type="checkbox" class="" name="swimming"> Swimming Space <i data-toggle="tooltip" data-placement="top" title="Tick mark if swimming space is available" class="fas fa-info-circle text-info"></i><br></span>
			<span id="playground_block"><input type="checkbox" class="" name="playground"> Playground <i data-toggle="tooltip" data-placement="top" title="Tick mark if playground is available" class="fas fa-info-circle text-info"></i></span>
		</div>
		<p class="text-left mt-2 text-primary"><strong><i class="fa fa-caret-right"></i> Contact Options</strong> <i data-toggle="tooltip" data-placement="top" title="How customers can contact you" class="fas fa-info-circle text-info"></i></p>
		<div class="text-left">
			<input type="checkbox" class="" name="phone_shared"> Via Phone<br>
			<input type="checkbox" class="" name="" checked disabled> Via Email <span class="font-weight-normal">(we will use this by default)</span><br>
		</div>
		<p class="text-left text-primary"><strong><i class="fa fa-caret-right"></i> Property Images</strong> <i data-toggle="tooltip" data-placement="top" title="Some images of how your property looks like" class="fas fa-info-circle text-info"></i></p>
		<input class="form-control mb-3" type="file" name="photo[]" multiple required>
		<p class="text-left text-primary"><strong><i class="fa fa-caret-right"></i> Property Address</strong> <i data-toggle="tooltip" data-placement="top" title="Full address of your property location" class="fas fa-info-circle text-info"></i></p>
		<textarea name="property_location" minlength="10" class="form-control mb-3" placeholder="Property Location* (e.g. House 46/C, Road No. 2, Rajpara R/A, Tilagor, Sylhet)" rows="3" required></textarea>
		<p class="text-left text-primary"><strong><i class="fa fa-caret-right"></i> Property Details/Sidenotes</strong> <i data-toggle="tooltip" data-placement="top" title="Write anything if you have some rules or other information to share related to property" class="fas fa-info-circle text-info"></i></p>
		<textarea minlength="5" class="form-control mb-3" placeholder="Property Details*" rows="10" name="desc" required></textarea>
		<div class="text-center">
			<button type="submit" class="btn btn-success mb-5">Submit</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});
	$('input[name="gas"]').on('change', function() {
		if ($('input[name="gas"]').is(':checked')) {
			//alert("yes");
			$('select[name="gas_type"]').prop('disabled', false);
		}
		else
		{
			//alert("no");
			$('select[name="gas_type"]').prop('disabled', true);
		}
	});
	$('input[name="electricity"]').on('change', function() {
		if ($('input[name="electricity"]').is(':checked')) {
			//alert("yes");
			$('select[name="electricity_type"]').prop('disabled', false);
		}
		else
		{
			//alert("no");
			$('select[name="electricity_type"]').prop('disabled', true);
		}
	});
	$('input[name="advance"]').on('change', function() {
		if ($('input[name="advance"]').is(':checked')) {
			//alert("yes");
			$('input[name="advance_amount"]').prop('disabled', false);
		}
		else
		{
			//alert("no");
			$('input[name="advance_amount"]').prop('disabled', true);
		}
	});
	$("select[name='cat']").on('change', function () {
		var cat_name = $("select[name='cat']").val();
		if (cat_name == "Office Space") {
			$('input[name="bedrooms"]').css('display', 'none');
			$('input[name="kitchens"]').css('display', 'none');
			$('#bedrooms_label').css('display', 'none');
			$('select[name="applicant_type"]').css('display', 'none');
			$('#availability_label').css('display', 'none');
			$('#kitchens_label').css('display', 'none');
			$('#gas_block').css('display', 'none');
			$('#furniture_block').css('display', 'none');
			$('#bathroom_block').css('display', '');
			$('#balcony_label').css('display', '');
			$('#swimming_block').css('display', '');
			$('#parking_block').css('display', '');
			$('#playground_block').css('display', '');
			$('#rooms_label').html("Rooms");
			$('#rooms_tooltip_commerce').hide();
			$('#rooms_tooltip_normal').show();
			$('input[name="rooms"]').attr('placeholder', "Rooms");
		}
		else if(cat_name == "Store Space / Commercial Space")
		{
			$('input[name="bedrooms"]').css('display', 'none');
			$('input[name="kitchens"]').css('display', 'none');
			$('#bedrooms_label').css('display', 'none');
			$('select[name="applicant_type"]').css('display', 'none');
			$('#availability_label').css('display', 'none');
			$('#kitchens_label').css('display', 'none');
			$('#gas_block').css('display', 'none');
			$('#furniture_block').css('display', 'none');
			$('#bathroom_block').css('display', 'none');
			$('#balcony_label').css('display', 'none');
			$('#swimming_block').css('display', 'none');
			$('#parking_block').css('display', 'none');
			$('#playground_block').css('display', 'none');
			$('#rooms_label').html("Room area in square feet");
			$('#rooms_tooltip_commerce').show();
			$('#rooms_tooltip_normal').hide();
			$('input[name="rooms"]').attr('placeholder', "Room area in sqft");
		}
		else
		{
			$('input[name="bedrooms"]').css('display', '');
			$('input[name="kitchens"]').css('display', '');
			$('#gas_block').css('display', '');
			$('#bedrooms_label').css('display', '');
			$('#kitchens_label').css('display', '');
			$('select[name="applicant_type"]').css('display', '');
			$('#availability_label').css('display', '');
			$('#furniture_block').css('display', '');
			$('#bathroom_block').css('display', '');
			$('#balcony_label').css('display', '');
			$('#swimming_block').css('display', '');
			$('#parking_block').css('display', '');
			$('#playground_block').css('display', '');
			$('#rooms_label').html("Rooms");
			$('#rooms_tooltip_commerce').hide();
			$('#rooms_tooltip_normal').show();
			$('input[name="rooms"]').attr('placeholder', "Rooms");
		}
	});
</script>
@endsection