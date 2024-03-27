<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MemberController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('admin/login', 'login');
    Route::post('admin/register', 'register');
    Route::post('admin/logout', 'logout');
    Route::post('admin/refresh', 'refresh');
});

Route::controller(MemberController::class)->group(function () {
    Route::get('members' , 'index');
    Route::post('member' , 'store_member');
    Route::get('member/{id}', 'show');
    Route::put('member/{id}', 'update');
    Route::delete('member/{id}', 'delete');
});