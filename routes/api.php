<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Auth\LoginController;

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
Route::get('/doctor/{id}', [DoctorController::class, 'show']);
Route::get('profile', [DoctorController::class, 'show'])->middleware('auth');
Route::post('/login',[AuthController::class],'login')->middleware('auth');

Route::prefix('doctor')->group(function () {
    Route::get('', [DoctorController::class, 'index']);
    Route::get('create', [DoctorController::class, 'create']);
    Route::post('store', [DoctorController::class, 'store']);
    Route::get('edit/{id}', [DoctorController::class, 'edit']);
    Route::post('update/{id}', [DoctorController::class, 'update']);
    Route::delete('delete/{id}', [DoctorController::class, 'destroy']);
    // Todo: differences between these ways and which one has better performance.
    //Route::post('ajax/fetchSubjects', [TeacherController::class, 'fetchSubjects'])->name('ajax.fetchSubjects');
    Route::get('ajax/fetchSubjects/{id}', [DoctorController::class, 'getSubjects']);
});
Route::prefix('student')->group(function () {
    Route::get('', [StudentController::class, 'index']);
    Route::get('create', [StudentController::class, 'create']);
    Route::post('store', [StudentController::class, 'store']);
    Route::get('edit/{id}', [StudentController::class, 'edit']);
    Route::post('update/{id}', [StudentController::class, 'update']);
    Route::delete('delete/{id}', [StudentController::class, 'destroy']);
});
Route::prefix('subject')->group(function () {
    Route::get('', [SubjectController::class, 'index']);
    Route::get('create', [SubjectController::class, 'create']);
    Route::post('store', [SubjectController::class, 'store']);
    Route::get('edit/{id}', [SubjectController::class, 'edit']);
    Route::post('update/{id}', [SubjectController::class, 'update']);
    Route::delete('delete/{id}', [SubjectController::class, 'destroy']);
});
Route::prefix('manager')->group(function () {
    Route::get('', [UserController::class, 'index']);
    Route::get('create', [UserController::class, 'create']);
    Route::post('store', [UserController::class, 'store']);
    Route::get('edit/{id}', [UserController::class, 'edit']);
    Route::post('update/{id}', [UserController::class, 'update']);
    Route::delete('delete/{id}', [UserController::class, 'destroy']);
});
Route::get('/generate/broad-question','GenerateController@generateBroadQuestion');
Route::post('/generate/broad-question','GenerateController@generateBroadQuestionPost');











































Route::get('/flights', function () {
    // Only authenticated users may access this route...
})->middleware('auth');



Route::get('/flights', function () {
    // Only authenticated users may access this route...
})->middleware('auth:admin');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\RegisterController@register');
Route::post('login', 'Api\RegisterController@login');

Route::middleware('auth:api')->group( function(){

    Route::get('/product','Api\productController@index');
    Route::post('/product/store','Api\productController@store');
    Route::get('/product/show/{id}','Api\productController@show');
    Route::put('/product/update/{id}','Api\productController@update');
    Route::delete('/product/destroy/{id}','Api\productController@destroy');
    Route::delete('/product/destroyMyAccount/{id}','Api\productController@destroyMyAccount');


    Route::post('/product/storeOfComment/{id}','Api\productController@storeOfComment');

    Route::get('/product/user/{id}','Api\productController@userProduct');
    Route::get('/product/sorted/{attribute}','Api\productController@sortedProduct');

    Route::post('/product/searchByName','Api\productController@searchByName');
    Route::post('/product/searchByCategory','Api\productController@searchByCategory');
    Route::post('/product/searchByExpirationDate','Api\productController@searchByExpirationDate');

    // Route::get('product/islikedbyme/{id}', 'Api\productController@isLikedByMe');
    // Route::post('product/like', 'Api\productController@like');
    Route::post('product/storeOfLikes/{id}', 'Api\productController@storeOfLikes');

    //  Route::resource('product', 'Api\productController');
}) ;
//any route within the group must be logged in

