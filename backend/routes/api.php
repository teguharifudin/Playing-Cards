<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardDistributionController;

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

// Route::middleware('cors')->group(function () {
//     Route::options('{any}', function () {
//         return response('', 200)
//             ->header('Access-Control-Allow-Origin', '*')
//             ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS')
//             ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
//     })->where('any', '.*');
    
//     Route::post('/distribute', [CardDistributionController::class, 'distribute']);
// });

// Route::get('/', [CardDistributionController::class, 'index']);

Route::post('/distribute', [CardDistributionController::class, 'distribute']);

Route::get('/test', function() {
    return response()->json(['message' => 'API is working']);
});