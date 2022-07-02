<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class AuthenticateService
{    
    /**
     * Service responsavel por login do usuário na API
     *
     * @return void
     */
    public static function login(Request $request)
    {
        $login = $request->all();
        $user = User::where('email', $login['email'])->first();

        if (! $user) {
            throw new HttpException(JsonResponse::HTTP_UNAUTHORIZED, 'Usuário não encontrado');
        }

        if(! Hash::check($login['password'], $user->password)) {
            throw new HttpException(JsonResponse::HTTP_UNAUTHORIZED, 'Senha incorreta');
        }

        $token = $user->createToken($user->email)->plainTextToken;
        $user->token = $token;

        return $user;
    }

    /**
     * Service responsavel por deslogar o usuário na API
     *
     * @return void
     */
    public static function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            'success' => true,
            'message' => 'usuário deslogado com sucesso'
        ];
    }
}
