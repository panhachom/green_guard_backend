<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\BlogApiCrudController;
use App\Http\Controllers\FavoriteApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/blogs', [BlogApiCrudController::class, 'index']);
Route::get('/blogs/show/{id}', [BlogApiCrudController::class, 'show']);
Route::post('/blogs/{blog}/favorite', [FavoriteApiController::class, 'favorite']);
Route::post('login', [AuthApiController::class, 'login']);
Route::post('register', [AuthApiController::class, 'register']);
