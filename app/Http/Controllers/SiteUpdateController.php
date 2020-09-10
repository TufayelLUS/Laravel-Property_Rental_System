<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use App\AppConfig;

class SiteUpdateController extends Controller
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
        $current_user = Auth::user();
        if ($current_user->id == 1) {
            $request = Request::instance();
            $tmp_site_name = $request->post()['page_title'];
            $tmp_fb_url = $request->post()['fb_url'];
            $tmp_twitter_url = $request->post()['twitter_url'];
            $tmp_linkedin_url = $request->post()['linkedin_url'];
            $config = AppConfig::all();
            $config[0]->app_title = $tmp_site_name;
            $config[0]->fb_url = $tmp_fb_url;
            $config[0]->twitter_url = $tmp_twitter_url;
            $config[0]->linkedin_url = $tmp_linkedin_url;
            $config[0]->save();
            return redirect('admin_home')->with('success', "Website Details Updated");
        }
        else{
            return view('dashboard');
        }
    }
}
