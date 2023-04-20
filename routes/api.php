<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RegisterController;

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

Route::prefix('user')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth')->group(function () {
        Route::get('profile', function () {
            return auth()->user();
        });
        Route::get('logout', [AuthController::class, 'logout']);
        Route::apiResource('books', BookController::class)
        ->only('store', 'index', 'show', 'update', 'destroy');
    
    });
});
 
Route::post('photo', function (Request $request) {

    // postman 上傳的檔案中，找尋postman body>form-data key 為 image 的內容
    $image = $request->file('image');     
    // 拿到 client 端原始檔案的副檔名(getClientOriginalExtension())
    // 拿到 client 端原始檔案的完整檔名(getClientOriginalName())
    foreach($image as $photo){
        // dd($photo->getClientOriginalName());
        echo $photo->getClientOriginalName().PHP_EOL;

    }
    // dd($image[0]->getClientOriginalName());

    // return 'upload file';
});
