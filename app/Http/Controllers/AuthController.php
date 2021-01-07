<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthorizationService;
use App\Services\TokenService;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private $authorizationService;
    private $tokenService;

    public function __construct(
        AuthorizationService $authorizationService,
        TokenService $tokenService
    ) {
        $this->authorizationService = $authorizationService;
        $this->tokenService = $tokenService;
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if ($this->authorizationService->authorize($request->login, $request->password)) {
            return response()->json([
                'status' => 'success',
                'token' =>  $this->tokenService->getToken($request->login, Str::getPrefix($request->login))
            ]);
        }

        return response()->failure(Response::HTTP_UNAUTHORIZED);
    }
}
