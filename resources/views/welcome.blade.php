@extends('layouts.common')

@section('page_title')
{{ $app_name }}
@endsection

@section('extra_headers')
<style type="text/css">
.carousel-inner img {
    width: 100%;
    height: 600px;
}
.carousel-item img
{
	filter: brightness(0.5);
}
.justify
{
	text-align: justify;
}
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
#signupbtn
{
	animation: pulse 2s infinite;
}
@keyframes pulse {
	0% {
		/*transform: scale(0.95);*/
		box-shadow: 0 0 0 0 rgba(51, 217, 178, 0.7);
	}
	
	70% {
		/*transform: scale(1);*/
		box-shadow: 0 0 0 10px rgba(51, 217, 178, 0);
	}
	
	100% {
		/*transform: scale(0.95);*/
		box-shadow: 0 0 0 0 rgba(51, 217, 178, 0);
	}
}
@media only screen and (max-width: 600px) {
	.carousel-inner img {
	    width: 100%;
	    height: 300px;
	}
}
@media only screen and (max-width: 800px) {
	.carousel-inner img {
	    width: 100%;
	    height: 400px;
	}
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
@endsection

@section('page_body')
<div id="carousel_banner" class="carousel slide" data-ride="carousel">
  <ul class="carousel-indicators">
    <li data-target="#carousel_banner" data-slide-to="0" class="active"></li>
    <li data-target="#carousel_banner" data-slide-to="1"></li>
    <li data-target="#carousel_banner" data-slide-to="2"></li>
  </ul>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/banner1.jpg" alt="Banner 1" width="400" height="300">
      <div class="carousel-caption">
        <h3>Affordable Price</h3>
        <p>Here you will get properties at affordable prices</p>
      </div>   
    </div>
    <div class="carousel-item">
      <img src="images/banner2.jpg" alt="Banner 2">
      <div class="carousel-caption">
        <h3>Different Choices</h3>
        <p>You have the option to choose the best among all available properties</p>
      </div>   
    </div>
    <div class="carousel-item">
      <img src="images/banner3.jpg" alt="Banner 3" width="1100px" height="600px">
      <div class="carousel-caption">
        <h3>Fraud Safety</h3>
        <p>Stay safe while making deals</p>
      </div>   
    </div>
  </div>
  <a class="carousel-control-prev" href="#carousel_banner" data-slide="prev">
    <i class="fas fa-arrow-alt-circle-left text-info h1"></i>
  </a>
  <a class="carousel-control-next" href="#carousel_banner" data-slide="next">
    <i class="fas fa-arrow-alt-circle-right text-info h1"></i>
  </a>
</div>
<div class="bg-light p-3 font-weight-normal">
	<h1 id="about" class="text-center p-3 h1 justify-content-between"><i class="fas fa-comment-dots"></i><br>About this platform</h1>
	<p class="px-3 justify">
		"Renting, also known as hiring or letting, is an agreement where a payment is made for the temporary use of a good, service or property owned by another. A gross lease is when the tenant pays a flat rental amount and the landlord pays for all property charges regularly incurred by the ownership. An example of renting is equipment rental. Renting can be an example of the sharing economy." - Wikipedia<br>
		Why us? We are an effective marketplace where you will be able to get quality properties based on your taste and you can easily contact with property buyers or rent a property of your own. <br>
		Our platform contains lots of available features that can help you get your desired properties rented with fraud safety. Different contact options available which makes it easier for you to manage how you are contacted by others. We protect your data from outsiders by letting them see data only when they have an account.<br>
		Feeling interested? Why not join us today! We do not share your contact information or use it for marketing purposes. 
		<br><br>
		<div class="text-center">
			<button id="signupbtn" onclick="location.href='register'" class="btn btn-success text-white">Sign up for FREE</button>
		</div>
	</p>
</div>
<div class="text-center">
	<h1 class="py-3 mt-4"><i class="fas fa-search"></i><br>Looking for something?</h1>
    <div class="mb-5">
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
            {{csrf_field()}}
            <br>
            <button type="submit" class="btn btn-secondary py-2 px-5 mb-2 ml-1">Search</button>
        </form>
    </div>
</div>
<div class="py-3 border-bottom bg-light">
	<h1 class="text-center py-3"><i class="fas fa-list-alt"></i><br>Recent Flat/Appartment Listing</h1>
	<div class="container ">
		<div class="row py-3 justify-content-center">
			@foreach($flats as $flat)
			<div class="col-xl-4 col-lg-4 col-sm-12">
				<div class="card mb-3 bg-light" onmouseenter="this.style.boxShadow='0px 0px 5px -1px black'" onmouseleave="this.style.boxShadow=''">
					<div class="card-body">
						<div class="card-title">
							<span class="font-weight-bold">{{$flat->title}}</span> in <span class="font-weight-bold">{{ substr($flat->property_location, 0, 20)}} ...</span>
						</div>
						<hr>
						<img style="max-height: 300px; max-width: 500px" src="{{url('uploads/' . explode( '*', $flat->photo)[0])}}" class="card-img-top">
						<hr>
						<div class="card-text m-0">
							<div class="row m-0">
								<div class="col border-right">
									<ul class="p-0" style="list-style: none;">
										<li><span class="font-weight-bold">Rent:</span> {{$flat->property_price}}</li>
										<li><span class="font-weight-bold">Rooms:</span> {{$flat->rooms}}</li>
										<li><span class="font-weight-bold">Bathrooms:</span> {{$flat->bathrooms}}</li>
									</ul>
								</div>
								<div class="col">
									<ul class="p-0" style="list-style: none;">
										<li><span class="font-weight-bold">Gas:</span> {{$flat->gas}}</li>
										<li><span class="font-weight-bold">Electricity:</span> {{$flat->electricity}}</li>
									</ul>
								</div>
							</div>
							<button onclick="location.href='property/{{$flat->id}}'" class="btn btn-primary float-right">View Details</button>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		@if(count($flats) == 0)
		<div class="col">
			<p class="text-center">Currently there are no listing on this category</p>
		</div>
		@else
		<div class="py-3 text-center"><button onclick="location.href='all_properties'" class="btn btn-primary">See More</button></div>
		@endif
	</div>
</div>
<div class="py-3 border-bottom">
	<h1 class="text-center py-3"><i class="fas fa-list-alt"></i><br>Recent House Listing</h1>
	<div class="container ">
		<div class="row py-3 justify-content-center">
			@foreach($houses as $house)
			<div class="col-xl-4 col-lg-4 col-sm-12">
				<div class="card mb-3 bg-light" onmouseenter="this.style.boxShadow='0px 0px 5px -1px black'" onmouseleave="this.style.boxShadow=''">
					<div class="card-body">
						<div class="card-title">
							<span class="font-weight-bold">{{$house->title}}</span> in <span class="font-weight-bold">{{ substr($house->property_location,0, 20)}} ...</span>
						</div>
						<hr>
						<img style="max-height: 300px; max-width: 500px" src="{{url('uploads/' . explode( '*', $house->photo)[0])}}" class="card-img-top">
						<hr>
						<div class="card-text m-0">
							<div class="row m-0">
								<div class="col border-right">
									<ul class="p-0" style="list-style: none;">
										<li><span class="font-weight-bold">Rent:</span> {{$house->property_price}}</li>
										<li><span class="font-weight-bold">Rooms:</span> {{$house->rooms}}</li>
										<li><span class="font-weight-bold">Bathrooms:</span> {{$house->bathrooms}}</li>
									</ul>
								</div>
								<div class="col">
									<ul class="p-0" style="list-style: none;">
										<li><span class="font-weight-bold">Gas:</span> {{$house->gas}}</li>
										<li><span class="font-weight-bold">Electricity:</span> {{$house->electricity}}</li>
									</ul>
								</div>
							</div>
							<button onclick="location.href='property/{{$house->id}}'" class="btn btn-primary float-right">View Details</button>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		@if(count($houses) == 0)
		<div class="col">
			<p class="text-center">Currently there are no listing on this category</p>
		</div>
		@else
		<div class="py-3 text-center"><button onclick="location.href='all_properties'" class="btn btn-primary">See More</button></div>
		@endif
	</div>
</div>
<div class="py-3 border-bottom bg-light">
	<h1 class="text-center py-3"><i class="fas fa-list-alt"></i><br>Recent Bungalaw Listing</h1>
	<div class="container ">
		<div class="row py-3 justify-content-center">
			@foreach($bungalaws as $bungalaw)
			<div class="col-xl-4 col-lg-4 col-sm-12">
				<div class="card mb-3 bg-light" onmouseenter="this.style.boxShadow='0px 0px 5px -1px black'" onmouseleave="this.style.boxShadow=''">
					<div class="card-body">
						<div class="card-title">
							<span class="font-weight-bold">{{$bungalaw->title}}</span> in <span class="font-weight-bold">{{ substr($bungalaw->property_location,0,20)}} ...</span>
						</div>
						<hr>
						<img style="max-height: 300px; max-width: 500px" src="{{url('uploads/' . explode( '*', $bungalaw->photo)[0])}}" class="card-img-top">
						<hr>
						<div class="card-text m-0">
							<div class="row m-0">
								<div class="col border-right">
									<ul class="p-0" style="list-style: none;">
										<li><span class="font-weight-bold">Rent:</span> {{$bungalaw->property_price}}</li>
										<li><span class="font-weight-bold">Rooms:</span> {{$bungalaw->rooms}}</li>
										<li><span class="font-weight-bold">Bathrooms:</span> {{$bungalaw->bathrooms}}</li>
									</ul>
								</div>
								<div class="col">
									<ul class="p-0" style="list-style: none;">
										<li><span class="font-weight-bold">Gas:</span> {{$bungalaw->gas}}</li>
										<li><span class="font-weight-bold">Electricity:</span> {{$bungalaw->electricity}}</li>
									</ul>
								</div>
							</div>
							<button onclick="location.href='property/{{$bungalaw->id}}'" class="btn btn-primary float-right">View Details</button>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		@if(count($bungalaws) == 0)
		<div class="col">
			<p class="text-center">Currently there are no listing on this category</p>
		</div>
		@else
		<div class="py-3 text-center"><button onclick="location.href='all_properties'" class="btn btn-primary">See More</button></div>
		@endif
	</div>
</div>
<div class="py-3 border-bottom">
	<h1 class="text-center py-3"><i class="fas fa-list-alt"></i><br>Recent Office Space Listing</h1>
	<div class="container ">
		<div class="row py-3 justify-content-center">
			@foreach($office_spaces as $office_space)
			<div class="col-xl-4 col-lg-4 col-sm-12">
				<div class="card mb-3 bg-light" onmouseenter="this.style.boxShadow='0px 0px 5px -1px black'" onmouseleave="this.style.boxShadow=''">
					<div class="card-body">
						<div class="card-title">
							<span class="font-weight-bold">{{$office_space->title}}</span> in <span class="font-weight-bold">{{ substr($office_space->property_location,0,20)}} ...</span>
						</div>
						<hr>
						<img style="max-height: 300px; max-width: 500px" src="{{url('uploads/' . explode( '*', $office_space->photo)[0])}}" class="card-img-top">
						<hr>
						<div class="card-text m-0">
							<div class="row m-0">
								<div class="col border-right">
									<ul class="p-0" style="list-style: none;">
										<li><span class="font-weight-bold">Rent:</span> {{$office_space->property_price}}</li>
										<li><span class="font-weight-bold">Rooms:</span> {{$office_space->rooms}}</li>
										<li><span class="font-weight-bold">Bathrooms:</span> {{$office_space->bathrooms}}</li>
									</ul>
								</div>
								<div class="col">
									<ul class="p-0" style="list-style: none;">
										<li><span class="font-weight-bold">Electricity:</span> {{$office_space->electricity}}</li>
									</ul>
								</div>
							</div>
							<button onclick="location.href='property/{{$office_space->id}}'" class="btn btn-primary float-right">View Details</button>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		@if(count($office_spaces) == 0)
		<div class="col">
			<p class="text-center">Currently there are no listing on this category</p>
		</div>
		@else
		<div class="py-3 text-center"><button onclick="location.href='all_properties'" class="btn btn-primary">See More</button></div>
		@endif
	</div>
</div>
<div class="bg-secondary text-white p-3">
	<div class="row">
		<div class="col-xl-6 col-lg-6 col-sm-12 px-3 border-right">
			<h4 id="contact">Get In Touch</h4>
			<form action="sendFeedback" class="" method="POST">
				{{csrf_field()}}
				<input class="form-control my-2" placeholder="Your Name" type="text" name="name" required>
				<input class="form-control my-2" placeholder="Your Email" type="text" name="email" required>
				<input class="form-control my-2" placeholder="Subject" type="text" name="subject" required>
				<textarea name="message" rows="5" class="form-control my-2" placeholder="Your Message" required></textarea>
				<button class="btn btn-primary text-white float-right">Send Message</button>
			</form>
		</div>
		<div class="col-xl-6 col-lg-6 col-sm-12 px-3">
			<b>Office:</b>
			<ul style="list-style: none;">
				<li>Address
					<ul>
						<li>House 123</li>
						<li>Road 132</li>
						<li>Sylhet</li>
						<li>Bangladesh</li>
					</ul>
				</li>
				<li>Phone: +(123) 456 789 0</li>
				<li>Fax: 123 456789 456</li>
				<li>Email: dev@prsystem.tech</li>
			</ul>
		</div>
	</div>
</div>
@endsection