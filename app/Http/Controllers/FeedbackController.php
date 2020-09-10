<?php

namespace App\Http\Controllers;

use Request;
use App\Feedback;
use Auth;

class FeedbackController extends Controller
{
    //
    public function __construct()
    {
    	//
    }

    public function index()
    {
    	$request = Request::instance();
    	$name = $request->post("name");
    	$email = $request->post("email");
    	$subject = $request->post("subject");
    	$msg = $request->post("message");
    	$feedback = new Feedback;
    	$feedback->name = $name;
    	$feedback->email = $email;
    	$feedback->subject = $subject;
    	$feedback->message = $msg;
    	$feedback->save();
    	return redirect("/")->with("success", "Feedback sent to administrator");
    }

    public function viewFeedback()
    {
    	if (Auth::user()->id != 1) {
    		return redirect("/");
    	}
    	else{
    		$feedbacks = Feedback::paginate(10);
    		return view("customer_feedback", ["feedbacks"=>$feedbacks]);
    	}
    }

    public function deleteFeedback($id)
    {
        if (Auth::user()->id == 1) {
            $feedback = Feedback::findOrFail($id);
            $feedback->delete();
            return redirect("customer_feedback")->with("success", "Feedback deleted successfully!");
        }
        else
        {
            return redirect("dashboard")->with("failure", "You are not authorized to perform this operation!");
        }
    }
}
