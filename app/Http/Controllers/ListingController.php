<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Http\Request as FileRequest;
use App\Listing;
use App\Follower;
use App\Notification;
use App\AppConfig;
use App\User;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\MailerConfig;
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/Configuration.php';

class ListingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public static $items_per_page = 10;
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function httpGet()
    {
        if (Auth::user()->is_email_verified == "False") {
            return view("confirm_email");
        }
        return view('add_post');
    }

    public function notifyFollowers()
    {
        $followers = Follower::where('user_id','=',Auth::user()->id)->get();
        foreach ($followers as $follower) {
            $followerAccount = User::where('id','=',$follower->follower_id)->first();
            $user_mail = $followerAccount->email;
            $notification = new Notification;
            $notification->user_id = $follower->follower_id;
            $notification->msg_body = Auth::user()->name . " has posted a new property recently.";
            $notification->page_url = url('/') . "/user_profile/" . $followerAccount->id;
            $notification->save();
            $app_name = AppConfig::first()->app_title;
            $msg = <<<HERE
            <html><body><div style="background-color:#d9d9d9;color:#4a4848;padding:30px;font-size:30px;text-align:center">
            $app_name
            </div>
            <div style="padding:30px;">
            $notification->msg_body
            <br>
            Login in your account to view notification about this email.
            <br>
            </div>
            <div style="background-color:#d9d9d9;color:#4a4848;padding:50px;font-size:30px;text-align:center">
            &copy; 2020 $app_name. All rights reserved.
            </div></body></html>
HERE;
            $headers = 'From: New Property Listing Update ' . $app_name . ' <noreply@prsystem.tech> ' . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            
            try{
                //mail($user_mail, "New Property Listing Update", $msg, $headers);
                $smtpConfig = new MailerConfig();
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = $smtpConfig->SMTP_HOST;
                $mail->SMTPAuth = true;
                $mail->Username = $smtpConfig->SMTP_USERNAME;
                $mail->Password = $smtpConfig->SMTP_PASSWORD;
                $mail->SMTPSecure = 'tls';
                $mail->Port = $smtpConfig->SMTP_PORT;
                $mail->setFrom('noreply@prsystem.tech', 'New Property Listing Update');
                $mail->addAddress($user_mail);
                $mail->Subject = "New Property Listing Update";
                $mail->isHTML(true);
                $mail->Body = $msg;
                if(!$mail->send()){
                    //echo 'Message could not be sent.';
                    //echo 'Mailer Error: ' . $mail->ErrorInfo;
                }else{
                    //echo 'Message has been sent';
                }
            }
            catch(\Exception $e)
            {
                echo $e;
            }
        }
    }

    public function index()
    {
        if (Auth::user()->is_email_verified == "False") {
            return view("confirm_email");
        }
        else
        {
            $request = Request::instance();
            $title = $request->post('title');
            $cat = $request->post('cat');
            $property_price = $request->post('property_price');
            $applicant_type = $request->post('applicant_type');
            $rooms = $request->post('rooms');
            $bedrooms = $request->post('bedrooms');
            $bathrooms = $request->post('bathrooms');
            $attached_bathrooms = $request->post('attached_bathrooms');
            $common_bathrooms = $request->post('common_bathrooms');
            $kitchens = $request->post('kitchens');
            $balcony = $request->post('balcony');
            $gas = $request->post('gas');
            if ($gas == "on") {
                $gas = $request->post('gas_type');
            }
            else
            {
                $gas = "Handled by property owner";
            }
            $electricity = $request->post('electricity');
            if ($electricity == "on") {
                $electricity = $request->post('electricity_type');
            }
            else
            {
                $electricity = "Handled by property owner";
            }
            $advance = $request->post('advance');
            if ($advance == "on") {
                $advance = $request->post('advance_amount');
            }
            else
            {
                $advance = "Not Required";
            }
            $furniture = $request->post('furniture') == "on" ? "Included" : "Excluded";
            $swimming = $request->post('swimming') == "on" ? "Included" : "Excluded";
            $parking = $request->post('parking') == "on" ? "Included" : "Excluded";
            $playground = $request->post('playground') == "on" ? "Included" : "Excluded";
            $imgs = $request->file('photo');
            $property_location = $request->post('property_location');
            $desc = $request->post('desc');
            $expiry_values = [1=>3600,2=>7200,3=>10800,4=>21600,5=>86400, 6=>-1];
            $expiry_unit = $expiry_values[$request->post('expiry_unit')];
            $new_data = new Listing;
            $new_data->title = $title;
            $new_data->user_id = Auth::user()->id;
            $new_data->cat = $cat;
            $new_data->property_price = $property_price;
            $new_data->applicant_type = $applicant_type;
            $new_data->rooms = $rooms;
            $new_data->bedrooms = $bedrooms;
            $new_data->bathrooms = $bathrooms;
            $new_data->attached_bathrooms = $attached_bathrooms;
            $new_data->common_bathrooms = $common_bathrooms;
            $new_data->kitchens = $kitchens;
            $new_data->balcony = $balcony;
            $new_data->gas = $gas;
            $new_data->electricity = $electricity;
            $new_data->advance = $advance;
            $new_data->furniture = $furniture;
            $new_data->swimming = $swimming;
            $new_data->parking = $parking;
            $new_data->playground = $playground;
            $sep = '';
            $allowed_ext = ['jpg', 'png', 'gif'];
            foreach ($imgs as $img) {
                $ext = $img->getClientOriginalExtension();
                
                $file_ok = 0;
                foreach ($allowed_ext as $key => $value) {
                    if ($value == $ext) {
                        $file_ok = 1;
                    }
                }
                if ($file_ok == 0) {
                    return redirect("add_post")->with("failure", "File extension must be jpg, gif or png");
                }
                else{
                    Storage::disk('public')->put($img->getFileName() . "." . $ext, File::get($img));
                    $new_data->photo .= $sep . $img->getFileName() . "." . $ext;
                    $sep = '*';
                }
            }
            $new_data->description = $desc;
            $new_data->phone_shared = $request->post('phone_shared') == "on" ? "on" : "off";
            $new_data->property_location = $property_location;
            $new_data->expiry_unit = $expiry_unit;
            $new_data->save();
            self::notifyFollowers();
            return redirect("add_post")->with("success", "Your listing has been saved!");
        }
    }

    public function display($id)
    {
        $listing = Listing::where('id', $id)->firstOrFail();
        return view('edit_post', ['listing' => $listing]);
    }

    public function update(FileRequest $req, $id)
    {
        $request = Request::instance();
        $title = $request->post('title');
        $cat = $request->post('cat');
        $property_price = $request->post('property_price');
        $applicant_type = $request->post('applicant_type');
        $rooms = $request->post('rooms');
        $bedrooms = $request->post('bedrooms');
        $bathrooms = $request->post('bathrooms');
        $attached_bathrooms = $request->post('attached_bathrooms');
        $common_bathrooms = $request->post('common_bathrooms');
        $kitchens = $request->post('kitchens');
        $balcony = $request->post('balcony');
        $gas = $request->post('gas');
        if ($gas == "on") {
            $gas = $request->post('gas_type');
        }
        else
        {
            $gas = "Handled by property owner";
        }
        $electricity = $request->post('electricity');
        if ($electricity == "on") {
            $electricity = $request->post('electricity_type');
        }
        else
        {
            $electricity = "Handled by property owner";
        }
        $advance = $request->post('advance');
        if ($advance == "on") {
            $advance = $request->post('advance_amount');
        }
        else
        {
            $advance = "Not Required";
        }
        $furniture = $request->post('furniture') == "on" ? "Included" : "Excluded";
        $swimming = $request->post('swimming') == "on" ? "Included" : "Excluded";
        $parking = $request->post('parking') == "on" ? "Included" : "Excluded";
        $playground = $request->post('playground') == "on" ? "Included" : "Excluded";
        $property_location = $request->post('property_location');
        $desc = $request->post('desc');
        $expiry_values = [1=>3600,2=>7200,3=>10800,4=>21600,5=>86400, 6=>-1];
        $expiry_unit = $expiry_values[$request->post('expiry_unit')];
        $phone_shared = $request->post('phone_shared');
        $listing = Listing::find($id);
        $listing->title = $title;
        $listing->user_id = Auth::user()->id;
        $listing->cat = $cat;
        $listing->property_price = $property_price;
        $listing->rooms = $rooms;
        $listing->applicant_type = $applicant_type;
        $listing->bedrooms = $bedrooms;
        $listing->bathrooms = $bathrooms;
        $listing->attached_bathrooms = $attached_bathrooms;
        $listing->common_bathrooms = $common_bathrooms;
        $listing->kitchens = $kitchens;
        $listing->balcony = $balcony;
        $listing->gas = $gas;
        $listing->electricity = $electricity;
        $listing->advance = $advance;
        $listing->furniture = $furniture;
        $listing->swimming = $swimming;
        $listing->parking = $parking;
        $listing->playground = $playground;
        $sep = '';
        $allowed_ext = ['jpg', 'png', 'gif'];
        if(!empty($req->file('photo')))
        {
            $listing->photo = '';
            $imgs = $req->file('photo');
            foreach ($imgs as $img) {
                $ext = $img->getClientOriginalExtension();
                $file_ok = 0;
                foreach ($allowed_ext as $key => $value) {
                    if ($value == $ext) {
                        $file_ok = 1;
                    }
                }
                if ($file_ok == 0) {
                    return redirect("edit_post/" . $id)->with("failure", "File extension must be jpg, gif or png");
                }
                else{
                    Storage::disk('public')->put($img->getFileName() . "." . $ext, File::get($img));
                    $listing->photo .= $sep . $img->getFileName() . "." . $ext;
                    $sep = '*';
                }
            }
        }
        $listing->description = $desc;
        $listing->phone_shared = $phone_shared == "on" ? "on" : "off";
        $listing->property_location = $property_location;
        $listing->expiry_unit = $expiry_unit;
        $listing->save();
        return redirect("property/" . $id)->with('success', "Property Details Updated");
    }

    public function repost(FileRequest $req, $id)
    {
        $request = Request::instance();
        $title = $request->post('title');
        $cat = $request->post('cat');
        $property_price = $request->post('property_price');
        $applicant_type = $request->post('applicant_type');
        $rooms = $request->post('rooms');
        $bedrooms = $request->post('bedrooms');
        $bathrooms = $request->post('bathrooms');
        $attached_bathrooms = $request->post('attached_bathrooms');
        $common_bathrooms = $request->post('common_bathrooms');
        $kitchens = $request->post('kitchens');
        $balcony = $request->post('balcony');
        $gas = $request->post('gas');
        if ($gas == "on") {
            $gas = $request->post('gas_type');
        }
        else
        {
            $gas = "Handled by property owner";
        }
        $electricity = $request->post('electricity');
        if ($electricity == "on") {
            $electricity = $request->post('electricity_type');
        }
        else
        {
            $electricity = "Handled by property owner";
        }
        $advance = $request->post('advance');
        if ($advance == "on") {
            $advance = $request->post('advance_amount');
        }
        else
        {
            $advance = "Not Required";
        }
        $furniture = $request->post('furniture') == "on" ? "Included" : "Excluded";
        $swimming = $request->post('swimming') == "on" ? "Included" : "Excluded";
        $parking = $request->post('parking') == "on" ? "Included" : "Excluded";
        $playground = $request->post('playground') == "on" ? "Included" : "Excluded";
        $property_location = $request->post('property_location');
        $desc = $request->post('desc');
        $expiry_values = [1=>3600,2=>7200,3=>10800,4=>21600,5=>86400, 6=>-1];
        $expiry_unit = $expiry_values[$request->post('expiry_unit')];
        $phone_shared = $request->post('phone_shared');
        $listing = new Listing;
        $oldListing = Listing::find($id);
        $listing->title = $title;
        $listing->user_id = Auth::user()->id;
        $listing->cat = $cat;
        $listing->property_price = $property_price;
        $listing->rooms = $rooms;
        $listing->applicant_type = $applicant_type;
        $listing->bedrooms = $bedrooms;
        $listing->bathrooms = $bathrooms;
        $listing->attached_bathrooms = $attached_bathrooms;
        $listing->common_bathrooms = $common_bathrooms;
        $listing->kitchens = $kitchens;
        $listing->balcony = $balcony;
        $listing->gas = $gas;
        $listing->electricity = $electricity;
        $listing->advance = $advance;
        $listing->furniture = $furniture;
        $listing->swimming = $swimming;
        $listing->parking = $parking;
        $listing->playground = $playground;
        $sep = '';
        $allowed_ext = ['jpg', 'png', 'gif'];
        if(!empty($req->file('photo')))
        {
            $listing->photo = '';
            $imgs = $req->file('photo');
            foreach ($imgs as $img) {
                $ext = $img->getClientOriginalExtension();
                $file_ok = 0;
                foreach ($allowed_ext as $key => $value) {
                    if ($value == $ext) {
                        $file_ok = 1;
                    }
                }
                if ($file_ok == 0) {
                    return redirect("edit_post/" . $id)->with("failure", "File extension must be jpg, gif or png");
                }
                else{
                    Storage::disk('public')->put($img->getFileName() . "." . $ext, File::get($img));
                    $listing->photo .= $sep . $img->getFileName() . "." . $ext;
                    $sep = '*';
                }
            }
        }
        else
        {
            $listing->photo = $oldListing->photo;
        }
        $listing->description = $desc;
        $listing->phone_shared = $phone_shared == "on" ? "on" : "off";
        $listing->property_location = $property_location;
        $listing->expiry_unit = $expiry_unit;
        $listing->save();
        $oldListing->delete();
        self::notifyFollowers();
        return redirect("my_properties")->with('success', "Property Reposted Successfully");
    }

    public function viewPostsAsAdmin()
    {
        $listings = Listing::paginate(self::$items_per_page);
        return view("all_posts", ['listings' => $listings]);
    }

    public function bookingRecords()
    {
        $listings = Listing::where('is_booked', '!=', 0)->paginate(self::$items_per_page);
        return view("all_booking", ['listings' => $listings]);
    }
}
