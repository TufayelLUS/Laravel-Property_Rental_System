<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\AppConfig;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\MailerConfig;
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'] . '/final_year/public_html/mail/src/Configuration.php';

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function randKey()
    {
        //random key for user
        $length = 15;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        //end random key
        return $randomString;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_user = Auth::user();
        if ($current_user->id == 1) {
            return redirect('admin_home');
        }
        else{
            if (Auth::user()->is_email_verified == "False") {
                // recreate a key for that user
                $current_user->key = self::randKey();
                $current_user->save();
                return self::sendVerificationEmail();
            }
            else{
                return view('dashboard');
            }
        }
    }

    public function sendVerificationEmail()
    {
        $user_mail = Auth::user()->email;
        $user_name = Auth::user()->name;
        $activation_url = url('activate_account') . "/" . Auth::user()->id . "/" . Auth::user()->key;
        $app_name = AppConfig::first()->app_title;
        $msg = <<<HERE
        <html><body><div style="background-color:#d9d9d9;color:#4a4848;padding:30px;font-size:30px;text-align:center">
        $app_name
        </div>
        <div style="padding:30px;">
        <b>Hi $user_name,</b><br>
        You are receiving this email because recently you have created an account in our site. To confirm your email account association with our website, please click below to activate your account and you can login.<br><br><br>
        <div style="text-align:center">
        <a style="padding:10px;background-color:blue;color:white;border-radius:10px;margin:20px;text-decoration:none" href="$activation_url">Activate Account</a></div><br>
        If you are not the person who did this, you can simply ignore this message.<br>
        Regards,<br>
        $app_name
        <br>
        <br>
        If there is trouble clicking the button, you can copy paste this link in your browser $activation_url
        </div>
        <div style="background-color:#d9d9d9;color:#4a4848;padding:50px;font-size:30px;text-align:center">
        &copy; 2020 $app_name. All rights reserved.
        </div></body></html>
HERE;
        $headers = 'From: Account Activation for ' . $app_name . ' <noreply@prsystem.tech> ' . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        
        try{
            //mail($user_mail, "Confirm account activation", $msg, $headers);
            $smtpConfig = new MailerConfig();
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = $smtpConfig->SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpConfig->SMTP_USERNAME;
            $mail->Password = $smtpConfig->SMTP_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = $smtpConfig->SMTP_PORT;
            $mail->setFrom('noreply@prsystem.tech', 'Confirm account activation');
            $mail->addAddress($user_mail);
            $mail->Subject = "Confirm account activation";
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
        return view("confirm_email");
    }
}
