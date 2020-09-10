<?php

namespace App\Http\Controllers;

use Request;
use App\User;
use App\AppConfig;
use App\Listing;
use Auth;
use Hash;
use App\Follower;

class ProfileUpdateController extends Controller
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
        $request = Request::instance();
        $tmp_user_name = $request->post()['display_name'];
        $tmp_phone = $request->post()['phone'];
        $tmp_password = $request->post()['password'];
        $new_pass = $request->post()['update_password'];
        $new_pass1 = $request->post()['update_password1'];
        $user = User::find(Auth::user()->id);
        if (!empty($new_pass)) {
            if (strlen($new_pass) < 5) {
                return redirect('edit_profile')->with('failure', "Password length cannot be less than 5 characters.");
            }
            if ($new_pass != $new_pass1) {
                return redirect('edit_profile')->with('failure', "Password Confirmation mismatch, try again.");
            }
            if (Hash::check($tmp_password, $user->password)){
                $user->name = $tmp_user_name;
                $user->phone = $tmp_phone;
                $user->password = Hash::make($new_pass);
                $user->save();
                return redirect('edit_profile')->with('success', "Profile Updated Successfully.");
            }
            else
            {
                return redirect('edit_profile')->with('failure', "You are unauthorized to perform this operation. Retype your password correctly.");
            }
        }
        if (Hash::check($tmp_password, $user->password)){
            $user->name = $tmp_user_name;
            $user->phone = $tmp_phone;
            $user->save();
            return redirect('edit_profile')->with('success', "Profile Updated Successfully.");
        }
        else
        {
            return redirect('edit_profile')->with('failure', "You are unauthorized to perform this operation. Retype your password correctly.");
        }
    }

    public function activateAccount($id, $key)
    {
        if (User::where('key', $key)->firstOrFail()) {
            $user = User::find($id);
            if ($key == $user->key) {
                $user->is_email_verified = "True";
                $user->save();
                Auth::logout();
                return redirect("/login");
            }
        }

    }

    public function httpGet()
    {
        if (Auth::user()->is_email_verified == "False") {
            return view("confirm_email");
        }
        return view("edit_profile");
    }

    public function updateProfileAsAdmin()
    {
        if (Auth::user()->id == 1) {
            $request = Request::instance();
            $id = $request->post()['id'];
            $user = User::where("id", $id)->first();
            $user->name = $request->post()['name'];
            $user->email = $request->post()['email'];
            $user->phone = $request->post()['phone'];
            $user->is_email_verified = $request->post()['verified'];
            $user->save();
            return redirect("all_users")->with('success', "Account Information Updated Successfully");
        }
        else
        {
            return redirect('/');
        }
    }

    public function deleteUserAsAdmin($id)
    {
        if (Auth::user()->id == 1) {
            if (intval($id) == 1) {
                return redirect("all_users")->with("failure", "You cannot delete yourself!");
            }
            else
            {
                $user = User::where("id", $id);
                $user->delete();
                return redirect("all_users")->with("success", "User account deleted succesfully!");
            }
        }
        else
        {
            return redirect("/");
        }
    }

    public function publicView($id)
    {
        if ($id == 1) {
            return view("errors.404");
        }
        else
        {
            $user = User::findOrFail($id);
            $listings = Listing::where('user_id','=',$id)->take(5)->get();
            return view("public_profile", ['user'=>$user, 'listings'=>$listings]);
        }
    }

    public function followProfile($id)
    {
        if ($id == Auth::user()->id) {
            return redirect("user_profile/" . $id)->with('failure', "You cannot follow yourself!");
        }
        else
        {
            $exists = User::where('id', '=', $id);
            if ($exists->count() == 0)
            {
                return view("errors.404");
            }
            $following = Follower::where('follower_id', '=', Auth::user()->id)->where('user_id', '=', $id);
            if ($following->count()) {
                return redirect("user_profile/" . $id)->with('failure', "You are already following " . $exists->first()->name . ".");
            }
            $follow = new Follower;
            $follow->user_id = $id;
            $follow->follower_id = Auth::user()->id;
            $follow->save();
            return redirect("user_profile/" . $id)->with('success', "You are now following " . $exists->first()->name . ". When this person posts any property, you will be notified.");
        }
    }

    public function unfollowProfile($id)
    {
        $exists = User::where('id', '=', $id);
        if ($exists->count() == 0)
        {
            return view("errors.404");
        }
        $following = Follower::where('follower_id', '=', Auth::user()->id)->where('user_id', '=', $id);
        if($following->count())
        {
            $following->delete();
            return redirect("user_profile/" . $id)->with('success', "You have unfollowed " . $exists->first()->name . " successfully.");
        }
        else
        {
            return redirect("user_profile/" . $id)->with('failure', "You are not following " . $exists->first()->name . ".");
        }
    }

    public function displayFollowingList()
    {
        $users = Follower::where('follower_id', '=', Auth::user()->id)->paginate(10);
        return view("my_following_list", ['users'=>$users]);
    }
}
