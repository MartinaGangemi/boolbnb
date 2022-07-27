<?php

namespace App\Providers;

use Braintree\Gateway;
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
        $this->app->singleton(Gateway::class,function($app){
            return new Gateway(
                [
                    'environment' => 'sandbox',
                    'merchantId' => '7brbgm2gqbtsgdft',
                    'publicKey' => '3th5nnkm8t4jjzd5',
                    'privateKey' => 'b3d50965038a23950a123cab8053a64b'
                ]
            );
        });
    }
}
