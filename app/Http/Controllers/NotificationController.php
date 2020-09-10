<?php

namespace App\Http\Controllers;

use Request;
use App\Notification;
use Auth;
use App\User;
use App\AppConfig;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\MailerConfig;
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/Configuration.php';

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$notifications = Notification::where('user_id','=',Auth::user()->id)->orderByDesc('id')->paginate(10);
        $unread_count = Notification::where('user_id','=',Auth::user()->id)->where('is_read','=',0)->count();
        foreach ($notifications as $notification) {
            $notification->is_read = 1;
            $notification->save();
        }
		return view("notifications", ["notifications" => $notifications, 'unread_count' => $unread_count]);
    }

    public function announceOnMail()
    {
        $app_name = AppConfig::first()->app_title;
        $request = Request::instance();
        $msg_body = $request->post('msg_body');
        $headline = $request->post('msg_subject');
        $msg_body = nl2br($msg_body);
        $msg = <<<HERE
        <html><body><div style="background-color:#d9d9d9;color:#4a4848;padding:30px;font-size:30px;text-align:center">
        $app_name
        </div>
        <div style="padding:30px;">
        $msg_body
        </div>
        <div style="background-color:#d9d9d9;color:#4a4848;padding:50px;font-size:30px;text-align:center">
        &copy; 2020 $app_name. All rights reserved.
        </div></body></html>
HERE;

        $all_users = User::where('is_email_verified','=','True')->get();
        $errors = array();
        $successful = 0;
        foreach ($all_users as $user) {
            $user_mail = $user->email;
            if (preg_match("[localhost.tld]", $user_mail) == 1) {
                continue;
            }
            try{
                //mail($user_mail, "Announcement", $msg, $headers);
                $smtpConfig = new MailerConfig();
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = $smtpConfig->SMTP_HOST;
                $mail->SMTPAuth = true;
                $mail->Username = $smtpConfig->SMTP_USERNAME;
                $mail->Password = $smtpConfig->SMTP_PASSWORD;
                $mail->SMTPSecure = 'tls';
                $mail->Port = $smtpConfig->SMTP_PORT;
                $mail->setFrom('news@prsystem.tech', 'Team PRSystemDotTech');
                $mail->addAddress($user_mail);
                $mail->Subject = $headline;
                $mail->isHTML(true);
                $mail->Body = $msg;
                if(!$mail->send()){
                    array_push($errors, $mail->ErrorInfo);
                    //return 'Mailer Error: ' . $mail->ErrorInfo . "<br>Email: " . $user_mail;
                    //echo 'Message could not be sent.';
                    //echo 'Mailer Error: ' . $mail->ErrorInfo;
                }else{
                    $successful++;
                    //echo 'Message has been sent';
                }
            }
            catch(\Exception $e)
            {
                array_push($errors, $e);
            }
        }
        if (empty($errors)) {
            return redirect('send_announcement')->with('success', 'All email announcement sent successfully. (' . $successful .'/' . count($all_users) . ') success.');
        }
        else
        {
            return redirect('send_announcement')->with('failure', 'There was some error sending announcement email. (' . $successful .'/' . count($all_users) . ') success.');
        }
    }

    public function checkNotificationAPI()
    {
        if (Auth::check()) {
            $response = array();
            $response["status"] = "success";
            $response["data"] = array();
            $has_unread_notifications = Notification::where('user_id', '=', Auth::user()->id)->where('is_read', '=', 0)->count();
            if ($has_unread_notifications > 0) {
                $response["data"]["refresh"] = "true";
                $response["data"]["count"] = $has_unread_notifications;
            }
            else
            {
                $response["data"]["refresh"] = "false";
            }
            return json_encode($response);
        }
        else
        {
            $response = array();
            $response["status"] = "failure";
            $response["reason"] = "unauthorized user";
            return json_encode($response);
        }
    }
}
