<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use App\Listing;
use App\Comment;
use App\Notification;
use App\User;
use App\AppConfig;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\MailerConfig;
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/Configuration.php';

class PropertyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public static $item_per_page = 10;

    public function __construct()
    {
        //

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendEmailNotification($receiver_id, $msg, $headline)
    {
        $app_name = AppConfig::first()->app_title;
        $user_mail = User::find($receiver_id)->email;
        $msg = <<<HERE
            <html><body><div style="background-color:#d9d9d9;color:#4a4848;padding:30px;font-size:30px;text-align:center">
            $app_name
            </div>
            <div style="padding:30px;">
            $msg
            <br>
            Login in your account to view notification about this email.
            <br>
            </div>
            <div style="background-color:#d9d9d9;color:#4a4848;padding:50px;font-size:30px;text-align:center">
            &copy; 2020 $app_name. All rights reserved.
            </div></body></html>
HERE;
        $headers = 'From: ' . $headline . ' ' . $app_name . ' <noreply@prsystem.tech> ' . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
            
        try{
            //mail($user_mail, $headline, $msg, $headers);
            $smtpConfig = new MailerConfig();
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = $smtpConfig->SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpConfig->SMTP_USERNAME;
            $mail->Password = $smtpConfig->SMTP_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = $smtpConfig->SMTP_PORT;
            $mail->setFrom('noreply@prsystem.tech', $headline);
            $mail->addAddress($user_mail);
            $mail->Subject = $headline;
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
            //
        }
    }

    public function singleUser()
    {
        $request = Request::instance();
        $type = "None";
        $app_type = "";
        $listings = Listing::where("user_id", Auth::user()->id);
        if ($request->get('type') && $request->get('type') != "None") {
            $type = $request->get('type');
            $listings = $listings->where('cat','=',$type);
        }
        if ($request->get('applicant_type') && $request->get('applicant_type') != "") {
            $app_type = $request->get('applicant_type');
            $listings = $listings->where('applicant_type','=',$app_type);
        }
        $listings = $listings->orderByDesc('id');
        $listings = $listings->paginate(self::$item_per_page);
        return view("show_properties", ['listings' => $listings, 'type'=>$type, 'app_type'=>$app_type]);
    }

    public function allUser()
    {
        $request = Request::instance();
        $type = "None";
        $app_type = "";
        $listings = Listing::where('id','>',0)->where('is_booked','=',0);
        if ($request->get('type') && $request->get('type') != "None") {
            $type = $request->get('type');
            $listings = $listings->where('cat','=',$type);
        }
        if ($request->get('applicant_type') && $request->get('applicant_type') != "") {
            $app_type = $request->get('applicant_type');
            $listings = $listings->where('applicant_type','=',$app_type);
        }
        $listings = $listings->orderByDesc('id');
        $listings = $listings->paginate(self::$item_per_page);
        return view("show_properties", ['listings' => $listings, 'type'=>$type, 'app_type'=>$app_type]);
    }

    public function viewDetails($id)
    {
        $listing = Listing::findOrFail($id);
        if($listing->is_booked == 1)
        {
            if ($listing->booking_expires <= round(microtime(1))) {
                $listing->is_booked = 0;
                $listing->booked_by = 0;
                $listing->booking_expires = 0;
                $listing->save();
            }
        }
        $comments = Comment::where('prop_id', $id)->get();
        return view("property_details", ['listing' => $listing, 'comments' => $comments]);
    }

    public function saveComment($prop_id)
    {
        $request = Request::instance();
        $user_id = Auth::user()->id;
        $comment_body = $request->post()['comment_body'];
        $owner_id = Listing::where('id','=',$prop_id)->first()->user_id;
        $new_comment = new Comment;
        $new_comment->prop_id = $prop_id;
        $new_comment->owner_id = $owner_id;
        $new_comment->user_id = $user_id;
        $new_comment->comment_body = $comment_body;
        $new_comment->save();
        if ($owner_id != Auth::user()->id) {
            $notification = new Notification;
            $notification->user_id = $owner_id;
            $notification->msg_body = "You have a new comment in one of your property";
            $notification->page_url = url("post_comments");
            $notification->save();
            self::sendEmailNotification($notification->user_id, $notification->msg_body, "New Comment In Property");
        }
        return redirect('property/' . $prop_id)->with('success', 'Your comment has been sent successfully!');
    }

    public function viewComment()
    {
        $comments = Comment::where('owner_id','=',Auth::user()->id)->where('user_id', '!=', Auth::user()->id)->orderByDesc('id')->paginate(self::$item_per_page);
        return view("post_comments", ['comments' => $comments]);
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $listingOwner = Listing::where('id','=',$comment->prop_id)->first()->user_id;
        if ($comment->user_id != Auth::user()->id && Auth::user()->id != 1 && Auth::user()->id != $listingOwner) {
            return redirect("property/" . $comment->prop_id)->with('failure', "You are not authorized to perform this action!");
        }
        else
        {
            $comment->delete();
            return redirect("property/" . $comment->prop_id)->with('success', "Your comment is deleted successfully!");
        }
    }

    public function updateComment($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id != Auth::user()->id && Auth::user()->id != 1) {
            return redirect("property/" . $comment->prop_id)->with('failure', "You are not authorized to perform this action!");
        }
        else
        {
            $request = Request::instance();
            $comment_body = $request->post('comment_body');
            $comment->comment_body = $comment_body;
            $comment->save();
            return redirect("property/" . $comment->prop_id)->with('success', "Your comment is updated successfully!");
        }
    }

    public function search()
    {
        $request = Request::instance();
        $area = $request->get('area');
        $min_price = $request->get('min_price') > 0 ? $request->get('min_price') : 0;
        $max_price = $request->get('max_price') > 0 ? $request->get('max_price') : 0;
        $app_type = $request->get('applicant_type');
        $prop_type = $request->get('prop_type');
        $results = Listing::where('cat', $prop_type)->where('applicant_type', '=', $app_type);
        if ($area != "") {
            $results = $results->where('property_location', 'like', "%" . $area . "%");
        }
        if ($min_price != "") {
            $results = $results->where('property_price', '>=', $min_price);
        }
        if ($max_price != "") {
            $results = $results->where('property_price', '<=', $max_price);
        }
        $results = $results->paginate(self::$item_per_page);
        return view('search_result', ['results' => $results,'area'=>$area, 'min_price'=>$min_price,'max_price'=>$max_price,'app_type'=>$app_type,'prop_type'=>$prop_type]);
    }

    public function confirmBooking($id)
    {
        $listing = Listing::find($id);
        if ($listing->user_id == Auth::user()->id) {
            return redirect("property/" . $id)->with("failure", "You cannot book your own property!");
        }
        $count_of_booking = Listing::where('booked_by','=', Auth::user()->id)->where('is_booked','=',1)->count();
        if ($count_of_booking == 3) {
            return redirect("property/" . $id)->with("failure", "You can have atmost 3 pending booking at a time. Please complete booking process for existing properties first to book more properties later.");
        }
        if ($listing->is_booked == 1 && $listing->booking_expires > round(microtime(1))) {
            return redirect("property/" . $id)->with("failure", "This property is already in booking process. You cannot book again until the time expires and the property becomes available again.");
        }
        $listing->is_booked = 1;
        $listing->booked_by = Auth::user()->id;
        $expiry_unit = $listing->expiry_unit;
        if ($expiry_unit == -1) {
            $expiry_unit = 31536000;
        }
        $listing->booking_expires = round(microtime(1))+$expiry_unit;
        $listing->save();
        $notification = new Notification;
        $notification->user_id = $listing->user_id;
        $notification->msg_body = "You have a new booking request for one of your property";
        $notification->page_url = url("booking_requests");
        $notification->save();
        self::sendEmailNotification($notification->user_id, $notification->msg_body, "New Booking Request on Property");
        $last_time = "as soon as possible";
        if ($listing->expiry_unit != -1) {
            if ($listing->expiry_unit == 3600) {
                $last_time = "in 1 hour";
            }
            elseif ($listing->expiry_unit == 7200) {
                $last_time = "in 2 hours";
            }
            elseif ($listing->expiry_unit == 10800) {
                $last_time = "in 3 hours";
            }
            elseif ($listing->expiry_unit == 21600) {
                $last_time = "in 6 hours";
            }
            elseif ($listing->expiry_unit == 86400) {
                $last_time = "in 24 hours";
            }
        }
        return redirect("property/" . $id)->with("success", "Your booking process has started. Kindly contact owner " . $last_time . ", otherwise your booking will be cancelled.");
    }

    public function myBooking()
    {
        $listings = Listing::where('booked_by', '=', Auth::user()->id)->orderBy('booking_expires')->paginate(self::$item_per_page);
        return view("my_booking", ['listings' => $listings]);
    }

    public function viewBooking()
    {
        $listings = Listing::where('user_id','=',Auth::user()->id)->where('is_booked','=','1')->where('booking_expires', '>', round(microtime(1)))->paginate(self::$item_per_page);
        return view("booking_requests", ["listings" => $listings]);
    }

    public function confirmCustomer($id)
    {
        $listing = Listing::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->get();
        $listing[0]->is_booked = 2;
        $listing[0]->booking_expires = 0;
        $listing[0]->save();
        $notification = new Notification;
        $notification->user_id = $listing[0]->booked_by;
        $notification->msg_body = "Congrats! Your booking request for " . $listing[0]->title . " has been confirmed by it's owner";
        $notification->page_url = url("property/".$listing[0]->id);
        $notification->save();
        self::sendEmailNotification($notification->user_id, $notification->msg_body, "Booking Confirmation");
        return redirect("booking_requests")->with("success", "Booking confirmed and property has been archived");
    }
    public function cancelCustomer($id)
    {
        $listing = Listing::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->get();
        $notification = new Notification;
        $notification->user_id = $listing[0]->booked_by;
        $notification->msg_body = "Your booking request for " . $listing[0]->title . " has been cancelled by it's owner";
        $notification->page_url = url("property/".$listing[0]->id);
        $notification->save();
        $listing[0]->is_booked = 0;
        $listing[0]->booked_by = 0;
        $listing[0]->booking_expires = 0;
        $listing[0]->save();
        self::sendEmailNotification($notification->user_id, $notification->msg_body, "Booking Cancellation Notification");
        return redirect("booking_requests")->with("success", "Booking cancelled and property has been reactivated");
    }

    public function deleteProperty($id)
    {
        $listing = Listing::where('id','=',$id)->get()[0];
        $old_owner = $listing->user_id;
        $old_name = $listing->title;
        if (Auth::user()->id == 1) {
            //
        }
        elseif ($listing->user_id != Auth::user()->id) {
            return redirect("dashboard")->with("failure", "You are not authorized to perform this operation");
        }
        $listing->delete();
        $comments = Comment::where('prop_id', '=', $id)->get();
        foreach ($comments as $comment) {
            $comment->delete();
        }
        if (Auth::user()->id == 1) {
            $notification = new Notification;
            $notification->user_id = $old_owner;
            $notification->msg_body = "Your property " . $old_name . " has been removed by administrator due to violating community rules.";
            $notification->page_url = "#";
            $notification->save();
            self::sendEmailNotification($notification->user_id, $notification->msg_body, "A property deleted due to TOS violation");
            return redirect("all_posts")->with("success", "Property deleted successfully");
        }
        return redirect("dashboard")->with("success", "Property deleted successfully");
    }
    
    public function bookingListAsAdmin()
    {
        $listings = Listing::where('booked_by', '!=', 0)->get();
        return view("all_booking");
    }

}
