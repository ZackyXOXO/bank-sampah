<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\TodoController;
use App\Http\Controllers\API\BankSampahController;


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

Route::controller(TodoController::class)->group(function () {
    Route::get('todos', 'index');
    Route::post('todo', 'store');
    Route::get('todo/{id}', 'show');
    Route::put('todo/{id}', 'update');
    Route::delete('todo/{id}', 'destroy');
}); 

Route::controller(BankSampahController::class)->group(function () {
    Route::get('bank', 'index');
    Route::post('bank', 'store_sampah');
    Route::get('bank/{id}', 'show');
    Route::put('bank/{id}', 'update');
    Route::delete('bank/{id}', 'delete');
}); 