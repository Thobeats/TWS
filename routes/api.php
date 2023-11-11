<?php

use App\Models\FilePond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;


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

Route::post('/saveImage/{folder}', [FilePond::class, 'saveImage']);
Route::post('/saveSlide', [FilePond::class, 'saveSlide']);
Route::delete('/deleteImage/{folder}', [FilePond::class, 'deleteImage']);

Route::post('/saveDoc/{folder}', [FilePond::class, 'saveDoc']);
Route::delete('/deleteDoc/{folder}', [FilePond::class, 'deleteDoc']);

Route::get('/getCategory/{id}', [VendorController::class, 'getCategory']);

Route::get('/notifyAdmin', [VendorController::class, 'notAdmin']);
