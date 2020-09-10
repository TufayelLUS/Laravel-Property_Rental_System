<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{
    //
    protected $fillable = ['app_title', 'app_slogan', 'fb_url', 'twitter_url', 'linkedin_url'];
}
