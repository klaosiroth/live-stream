<?php

use App\Http\Controllers\Api\ApiScheduleController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => '/match'], function () {
    Route::get('/', [ApiScheduleController::class, 'allMatch']);
    ROute::get('/{id}', [ApiScheduleController::class, 'getMatch']);
});
