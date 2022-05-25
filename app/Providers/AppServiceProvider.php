<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env('SETUP_MODE')==1){
            $siteSetting = SiteSetting::orderBy('id','ASC')->first();
            foreach($siteSetting->getAttributes() as $key => $value){
                Config::set('site.'.$key,$value);
            }
        }
    }
}