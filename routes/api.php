<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
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


Route::group(['prefix'=>'admin'],function (){

    Route::post('/login',[AdminController::class,'login']);
    Route::post('/register',[AdminController::class,'register']);
    Route::group(['middleware'=>['recaptcha.verify']],function (){
        Route::post('/user-register',[UserController::class,'store']);
    });
    Route::group(['middleware'=>['jwt.verify:admins']],function (){
        Route::post('/logout',[AdminController::class,'logout']);
        Route::apiResource('/user',UserController::class);
        Route::post('/filterUserData',[UserController::class,"filterUserData"]);
        Route::post('/averageUserRegisterPerDate',[UserController::class,"averageUserRegisterPerDate"]);
        Route::get('/getTotalUserCount',[UserController::class,"getTotalUserCount"]);
    });
});
