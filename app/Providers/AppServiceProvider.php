<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\AppConfig;
use App\User;
use Auth;
use View;
use Artisan;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        if(Schema::hasTable('app_configs'))
        {
            // load web application name, global vars from database
            $AppModel = AppConfig::all();
            if($AppModel->count()){
                $app_name = $AppModel[0]->app_title;
                $fb_url = $AppModel[0]->fb_url;
                $twitter_url = $AppModel[0]->twitter_url;
                $linkedin_url = $AppModel[0]->linkedin_url;
                View::share('app_name', $app_name);
                View::share('fb_url', $fb_url);
                View::share('twitter_url', $twitter_url);
                View::share('linkedin_url', $linkedin_url);
            }
            else
            {
                $AppModel_t = new AppConfig;
                $AppModel_t->app_title = "Laravel Web Application by Tufayel, Musa & Arup";
                $app_name = $AppModel_t->app_title;
                $AppModel_t->save();
                $fb_url = $AppModel_t->fb_url;
                $twitter_url = $AppModel_t->twitter_url;
                $linkedin_url = $AppModel_t->linkedin_url;
                View::share('app_name', $app_name);
                View::share('fb_url', $fb_url);
                View::share('twitter_url', $twitter_url);
                View::share('linkedin_url', $linkedin_url);
                redirect('/');
            }
        }
        else
        {
            //force run migration again as it seems there is no migration ran for this.
            Artisan::call('migrate', array('--path' => 'app/migrations', '--force' => true));
            redirect('/');
        }
        //View::share('app_name', "testing");
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this -> app -> bind('path.public', function()
        {
                return base_path('public_html');
        });
    }
}
