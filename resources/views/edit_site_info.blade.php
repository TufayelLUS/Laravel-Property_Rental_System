@extends('layouts.admin')

@section('page_title')
Update Website Details
@endsection

@section('page_body')
<div class="jumbotron text-left">
<div class="container" >
    <form method="POST" action="">
        {{ csrf_field() }}
        <label for="page_title">Website Name</label>
        <input id="page_title" type="text" class="form-control font-weight-bold mb-3" name="page_title" placeholder="Website Name (ex. My Property Rental System)" value="{{ $app_name }}" required>
        <label for="fb_url">Facebook Page URL</label>
        <input id="fb_url" type="text" class="form-control font-weight-bold mb-3" name="fb_url" placeholder="https://www.facebook.com/example" value="{{ $fb_url }}" required>
        <label for="twitter_url">Twitter Page URL</label>
        <input id="twitter_url" type="text" class="form-control font-weight-bold mb-3" name="twitter_url" placeholder="https://www.twitter.com/example" value="{{ $twitter_url }}" required>
        <label for="linkedin_url">LinkedIn Page URL</label>
        <input id="linkedin_url" type="text" class="form-control font-weight-bold mb-3" name="linkedin_url" placeholder="https://www.linkedin.com/example" value="{{ $linkedin_url }}" required>
        <button type="submit" class="btn btn-warning text-white float-right"> Update Details</button>
    </form>
</div>
</div>
@endsection