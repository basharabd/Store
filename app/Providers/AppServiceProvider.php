<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
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

      


            //remove data array for response json in Api
      //  JsonResource::withoutWrapping();
      
        validator::extend('filter', function($attribute , $value , $params){
            return ! in_array(strtolower($value) , $params);
        } , 'The Value Is Not Allowed');

      Paginator::useBootstrapFive();
      //  Paginator::defaultView('pagination.custom');
    }
}