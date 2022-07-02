<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserCollection;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Authenticate\AuthenticateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('user')->middleware('auth:sanctum')->group( function () {
        
    /**
     * Rota responsável pelo login do usuário
     */
    Route::post('login', [AuthenticateController::class, 'login'])->name('api.login')->withoutMiddleware('auth:sanctum');
    
    /**
     * Rota responsável por deslogar o usuário
     */
    Route::post('logout', [AuthenticateController::class, 'logout'])->name('api.logout');
    
    /**
     * Rota responsável pela troca de senha do usuário
     */
    Route::post('changepassword', [AuthenticateController::class, 'changePassword'])->name('api.changepassword');

    /**
     * Rota responsável pela atualização do usuário
     */
    Route::post('update/{id}', [UserController::class, 'update'])->name('api.user.update');
    
    Route::get('acesso', function (){
        return 'acesso';
    })->name('api.acesso');
});


Route::get('todos',  function () {
    return new UserCollection(User::all());
});