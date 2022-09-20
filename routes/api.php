<?php
use App\Http\Controllers\UserAuthController;
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

//Public Routes
Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/forgot-password',[UserAuthController::class, 'forget_password']);
Route::post('/reset',[UserAuthController::class, 'reset']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [UserAuthController::class, 'logout']);
    Route::post('/change_password', [UserAuthController::class, 'change_password']); 

});
Route::get('/testing',function(){
    return("good job");
 });
