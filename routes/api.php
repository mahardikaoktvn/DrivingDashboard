<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OmzetController;
use App\Http\Controllers\Api\PlayerController;
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

Route::get('/ytd-omzet', [OmzetController::class, 'ytd_omzet']);
Route::get('/ytd-omzet-zt', [OmzetController::class, 'ytd_omzet_zt']);
Route::get('/mtd-omzet', [OmzetController::class, 'mtd_omzet']);
Route::get('/mtd-omzet-zt', [OmzetController::class, 'mtd_omzet_zt']);
Route::get('/today-omzet', [OmzetController::class, 'tdy_omzet']);
Route::get('/today-omzet-zt', [OmzetController::class, 'tdy_omzet_zt']);
Route::get('/omzet-monthly-zt', [OmzetController::class, 'monthly_zt']);
Route::get('/omzet-monthly-zt1', [OmzetController::class, 'monthly_zt1']);
Route::get('/active-member', [OmzetController::class, 'active_member']);