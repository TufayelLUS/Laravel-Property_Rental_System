@extends('layouts.admin')

@section('page_title')
Admin Dashboard
@endsection

@section('page_body')
<div class="mt-3">
<i>Welcome back {{ Auth::user()->name }}</i>! <br>You are now logged into administrator dashboard.
</div>
<div class="row m-0">
    <div class="col-xl-6 col-sm-12">
        <div class="card mt-3">
            <div class="card-title"><i class="fa fa-user h1 m-4"></i></div>
            <div class="card-body m-0">Total {{
                App\User::all()->count()
            }} Registered Users</div>
        </div>
    </div>
    <div class="col-xl-6 col-sm-12">
        <div class="card mt-3">
            <div class="card-title"><i class="fa fa-list h1 m-4"></i></div>
            <div class="card-body m-0">Total {{ App\Listing::all()->count() }} Active Listing</div>
        </div>
    </div>
</div>
<div class="row m-0">
    <div class="col-xl-6 col-sm-12">
        <div class="card mt-3">
            <div class="card-title"><i class="fas fa-project-diagram h1 m-4"></i></div>
            <div class="card-body m-0">Total {{App\Comment::all()->count()}} Comments
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-sm-12">
        <div class="card mt-3">
            <div class="card-title"><i class="fas fa-comments h1 m-4"></i></div>
            <div class="card-body m-0">Total {{App\Feedback::all()->count()}} Customer Feedback</div>
        </div>
    </div>
</div>
@endsection