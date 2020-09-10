@extends('layouts.user')

@section('page_title')
User Dashboard
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
@endsection

@section('page_body')
<div class="container my-4">
    @if(App\Listing::where('user_id', '=', Auth::user()->id)->where('is_booked','=','1')->where('booking_expires', '>', round(microtime(1)))->count() > 0)
    <div class="text-left alert alert-info"><i class="fas fa-exclamation-triangle"></i> You have a pending booking request, <a class="text-primary font-weight-bolder" href="{{url('booking_requests')}}">please check by clicking here</a> and take action.</div>
    @endif
    <div class="border p-2">
    <i class="h1 fa fa-search"></i>
    <div class="h1 mb-4">Looking for something?</div>
    <div class="">
        <form action="search_result" class="mx-3">
            <input type="text" name="area" class="mb-2 ml-1" placeholder="Enter Area">
            <input type="number" min="0" name="min_price" class="mb-2 ml-1" placeholder="Enter Min Price">
            <input type="number" min="0" name="max_price" class="mb-2 ml-1" placeholder="Enter Max Price">
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
    <div class="border mt-2 p-4">
    <i class="h1 fas fa-chart-line"></i>
    <div class="h3">Your Website Activity Stats</div>
    <div class="row m-0">
        <div class="col-lg-6 col-sm-12">
            <div class="card mt-4">
                <div class="card-body text-center">
                    <i class="fa fa-user h1"></i><br>
                    <p style="color: black">{{ App\Listing::where("user_id", Auth::user()->id)->count() }} Total Posts</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card mt-4">
                <div class="card-body text-center">
                    <i class="fa fa-user h1"></i><br>
                    <p style="color: black">{{ App\Comment::where('user_id', Auth::user()->id)->count() }} Total Comments</p>
                </div>
            </div>
        </div>
    </div>
    </div>
    
</div>
@endsection
