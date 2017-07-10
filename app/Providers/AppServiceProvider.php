<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //验证分类不能为空
        Validator::extend('category', function($attribute, $value, $parameters, $validator) {
            if ($value!=0){
                return true;
            }else{
                return false;
            }
        });
        //自定义汉字验证
        Validator::extend('chinese', function($attribute, $value, $parameters, $validator) {
            if(preg_match("/^[\x{4e00}-\x{9fa5}]/u", $value)){
                return true;
            }
            return false;
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
