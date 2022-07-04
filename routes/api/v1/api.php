<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\ContactUsController;
use App\Http\Controllers\api\v1\VirtualSurveyController;
use App\Http\Controllers\api\v1\FreeQuoteController;
use App\Http\Middleware\AppKey;

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


Route::prefix('/v1')->group(function () {


    Route::middleware([AppKey::class])->group(function () {

        // Contact Us Here....
        Route::post('contactus',  [ContactUsController::class, 'index']);


        // Virtual Survey Here....
        Route::post('survey',  [VirtualSurveyController::class, 'index']);


        // Free Quotes Here....
        Route::post('free-quote',  [FreeQuoteController::class, 'index']);
    });
});





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});