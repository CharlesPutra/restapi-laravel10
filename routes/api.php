<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//route register api
Route::post('/register', [AuthController::class, 'register']);
//route login api
Route::post('/login', [AuthController::class, 'login']);

//route halaman home atau halaman guest dan show data untuk halaman home atau guest
Route::get('/home', [HomeController::class, 'index']);
Route::get('/home/{id}', [HomeController::class, 'show']);


//route auth atau yang sudah login api
Route::middleware('auth:sanctum')->group(function () {
    //route product api
    Route::apiResource('/products', ProductController::class);
    //route logout api
    Route::post('/logout', [ AuthController::class, 'logout']);
});
