<?php

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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

    // $request->validate([
    //     'image.[]' => ['image'],
    // ]);

    // $request->validate([
        // 驗證 postman 的 key 為 image[] 時， 是不是 array 格式
        // 'image' => ['array'],
        // 驗證 postman 的 key 在 image[] 時，value (array element)是不是 image 格式 (驗證 array 的 element 是不是 image 格式
        // 'image.*' => ['image'],
    // ]);

    
    // image 為 value 的儲存方式 
    // $image = $request->file('image')->store('users');
    
    // image 為 array 的儲存方式
    // $images = $request->file('image');
    // $msg = [];
    // foreach($images as $image){
    //     $path = $image->store('users');
    //     // 每次儲存的檔名存入 $msg[] 
    //     $msg[] = $path;
    // };
    // return $msg;

    // 一對一 User and Image
    // $user = \App\Models\User::find(1);
    // $user->image()->create([
    //     'url' => $request->file('image')->store('users'),
    // ]); 
    // return $user->image;

    // 一對多 Book and Image
    $pics = $request->file('image');

    $book = \App\Models\Book::find(1);
    foreach($pics as $image){
        $book->images()->create([
            'url' => $image->store('books'),
        ]);
    };
    // Model Book 有 一對多 morphMany 的`images()` 方法
    // 透過 morphMany, Eloquent 自動生成一動態關聯屬性 `images`
    // return $book->images->take(-2);
    // ORM 的方式取得最新兩筆 image 資訊
    return $book->images()->latest()->take(2)->get();
});
