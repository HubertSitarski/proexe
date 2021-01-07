<?php

namespace App\Providers;

use Symfony\Component\HttpFoundation\Response as ResponseCode;
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

        Response::macro('failure', function (string $code = ResponseCode::HTTP_INTERNAL_SERVER_ERROR) {
            return Response::json(
                ['status' => 'failure'],
                $code
            );
        });
    }
}
