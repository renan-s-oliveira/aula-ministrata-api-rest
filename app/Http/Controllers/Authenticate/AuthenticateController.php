<?php

namespace App\Http\Controllers\Authenticate;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\User\AuthenticateService;
use App\Http\Requests\Authenticate\AuthenticateRequest;

class AuthenticateController extends Controller
{    
    /**
     * Controller responsavel pelo login
     *
     * @param AuthenticateRequest $request
     *
     * @return void
     */
    public function login(AuthenticateRequest $request)
    {
        $login = AuthenticateService::login($request);
        return new UserResource($login);
    }

    /**
     * Controller responsavel por deslogar o usuário
     *
     * @param AuthenticateRequest $request
     *
     * @return void
     */
    public function logout()
    {
        $login = AuthenticateService::logout();
        return response()->json($login);
    }

    /**
     * Controller responsavel por trocar a senha do usuário
     *
     * @param AuthenticateRequest $request
     *
     * @return void
     */
    public function changePassword()
    {
        
    }
}
