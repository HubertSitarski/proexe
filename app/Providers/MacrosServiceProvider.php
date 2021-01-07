<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class MacrosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Str::macro('getPrefix', function (string $string) {
            return strstr($string, '_', true);
        });

        Response::macro('failure', function (string $code) {
            return Response::json(
                ['status' => 'failure'],
                $code
            );
        });
    }
}
