<?php

namespace App\Services;

use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;
use External\Foo\Auth\AuthWS;
use Illuminate\Support\Str;

class AuthorizationService
{
    public static $FOO = 'FOO';
    public static $BAR = 'BAR';
    public static $BAZ = 'BAZ';

    public function authorize(string $login, string $password): bool
    {
        switch (Str::getPrefix($login)) {
            case self::$FOO:
                (new AuthWS())->authenticate($login, $password);
                return true;
            case self::$BAR:
                return (new LoginService())->login($login, $password);
            case self::$BAZ:
                if ((new Authenticator())->auth($login, $password) instanceof Success) {
                    return true;
                }
                return false;
            default:
                return false;
        }
    }
}
