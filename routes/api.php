<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
  ApiController,
    UserController
};
use App\Http\Middleware\User;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/Users', [UserController::class, 'index'])->name('show.users');
Route::get('/User/{id}', [UserController::class, 'testShow'])->name('show.user');
// Route::post('/payments/notification', [ApiController::class, 'notification']); 
