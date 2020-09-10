<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	if (!Schema::hasTable('listings')) {
		Artisan::call('migrate:fresh', []);
		return redirect('/');
	}
	else{
		$flats = App\Listing::where("cat", "Flat / Appartment")->orderByDesc('id')->limit(3)->get();
		$houses = App\Listing::where("cat", "House")->orderByDesc('id')->limit(3)->get();
		$bungalaws = App\Listing::where("cat", "Bungalaw")->orderByDesc('id')->limit(3)->get();
		$office_spaces = App\Listing::where("cat", "Office Space")->orderByDesc('id')->limit(3)->get();
	    return view('welcome', ['flats' => $flats, 'houses' => $houses, 'bungalaws' => $bungalaws, 'office_spaces' => $office_spaces]);
	}
});


Route::get('activate_account/{id}/{key}', "ProfileUpdateController@activateAccount");

Route::get('admin_home', function () {
	return view('admin_home');
})->middleware('auth');

Route::get('edit_site_info', function () {
	return view('edit_site_info');
})->middleware('auth');

Route::post("edit_site_info", "SiteUpdateController@index")->middleware('auth');

Route::get("edit_profile", "ProfileUpdateController@httpGet")->middleware('auth');

Route::post("edit_profile", "ProfileUpdateController@index")->middleware('auth');

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('confirm_email', "HomeController@sendVerificationEmail");
Route::get('add_post', "ListingController@httpGet")->middleware('auth');
Route::post("add_post", "ListingController@index")->middleware('auth');
Route::get('edit_post/{id}', 'ListingController@display')->middleware('auth');
Route::post('edit_post/{id}', 'ListingController@update')->middleware('auth');
Route::get('edit_post/{id}/repost', 'ListingController@display')->middleware('auth');
Route::post('edit_post/{id}/repost', 'ListingController@repost')->middleware('auth');
Route::get("my_properties", "PropertyController@singleUser")->middleware('auth');
Route::get("all_properties", "PropertyController@allUser")->middleware('auth');
Route::get("property/{id}", "PropertyController@viewDetails")->middleware('auth');
Route::post('property/{prop_id}', 'PropertyController@saveComment')->middleware('auth');
Route::get('all_users', function() {
	$users = App\User::paginate(10);
	return view("all_users", ['users' => $users]);
})->middleware('auth');
Route::post("all_users", "ProfileUpdateController@updateProfileAsAdmin")->middleware('auth');
Route::post('delete_user/{id}', "ProfileUpdateController@deleteUserAsAdmin")->middleware('auth');
Route::get("post_comments", "PropertyController@viewComment")->middleware('auth');
Route::get("search_result", "PropertyController@search");
Route::get("confirm_booking/{id}", "PropertyController@confirmBooking")->middleware('auth');
Route::get('my_booking', "PropertyController@myBooking")->middleware('auth');
Route::get('booking_requests', "PropertyController@viewBooking")->middleware('auth');
Route::get("confirm_customer/{id}", "PropertyController@confirmCustomer")->middleware('auth');
Route::get("cancel_customer/{id}", "PropertyController@cancelCustomer")->middleware('auth');
Route::get('notifications', "NotificationController@index")->middleware('auth');
Route::get('delete_property/{id}', "PropertyController@deleteProperty")->middleware('auth');
Route::post("sendFeedback", "FeedbackController@index");
Route::get("customer_feedback", "FeedbackController@viewFeedback")->middleware("auth");
Route::get("customer_feedback/delete/{id}", "FeedbackController@deleteFeedback")->middleware('auth');
Route::get("all_posts", "ListingController@viewPostsAsAdmin")->middleware('auth');
Route::get("all_booking", "ListingController@bookingRecords")->middleware('auth');
Route::get('user_profile/{id}', "ProfileUpdateController@publicView");
Route::get('user_profile/{id}/follow', "ProfileUpdateController@followProfile")->middleware('auth');
Route::get('user_profile/{id}/unfollow', "ProfileUpdateController@unfollowProfile")->middleware('auth');
Route::get('send_announcement', function() {
	return view('send_announcement');
})->middleware('auth');
Route::post('send_announcement', "NotificationController@announceOnMail")->middleware('auth');
Route::get('my_following_list', "ProfileUpdateController@displayFollowingList")->middleware('auth');
Route::get('delete_comment/{id}', "PropertyController@deleteComment")->middleware('auth');
Route::post('edit_comment/{id}', "PropertyController@updateComment")->middleware('auth');
Route::get('api/notifications', "NotificationController@checkNotificationAPI");
Auth::routes();