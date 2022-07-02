<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\ConnectionException;
use App\Exceptions\Handler as ExceptionsHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CustomHandler extends ExceptionsHandler
{
    /**
    * Se precisar adicionar mensagens personalizadas pode adicionar a Exception como chave,
    * depois o código de erro seguido da mensagem personalizada
    */
    private $exceptions = [
        AuthenticationException::class => [
            'code' => JsonResponse::HTTP_UNAUTHORIZED,
            'message' => 'Você precisa estar logado para acessar esta funcionalidade.'
        ],
        UnauthorizedException::class => [
            'code' => JsonResponse::HTTP_UNAUTHORIZED,
            'message' => 'Usuário sem permissão.'
        ],
        ConnectionException::class => [
            'code' => JsonResponse::HTTP_GATEWAY_TIMEOUT,
            'message' => 'Desculpe, não foi possível atender sua solicitação. Tente novamente mais tarde.'
        ],
    ];

    public function render($request, Throwable $e)
    {

        if (isset($e)) {
            
            if($response = self::verifyException($e, $this->exceptions)) {
                return $response;
            }

            $statusCode = $e instanceof HttpException ? $e->getStatusCode() : JsonResponse::HTTP_INTERNAL_SERVER_ERROR;

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $statusCode);
        }

        return parent::render($request, $e);
    }

    public static function verifyException($e, $exceptions = [])
    {
        foreach ($exceptions as $className => $exception) {
            if ($e instanceof $className) {
                return response()->json([
                    'status' => false,
                    'message' => $exception['message'],
                ], $exception['code']);
            }
        }
        return false;
    }

}