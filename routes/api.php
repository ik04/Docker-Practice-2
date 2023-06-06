<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// http://localhost:8000/api/ (root route)
// test the Api on Postman, Please Put the Accept: application/json header
Route::get("/healthcheck",[UserController::class,"index"]);
// Register , login 


Route::post("/signup",[UserController::class,"register"]);
Route::post("/login",[UserController::class,"login"]);
Route::post("/register-admin",[UserController::class,"registerAdmin"]); // to showcase the delete route, a simple admin creation route


// Authenticated Routes (Requires login token in Authorization header)
// list , Delete , Info , get by hour
Route::group(['middleware'=>['auth:sanctum']],function(){
    
Route::get("users",[UserController::class,"listUsers"]); // lists all
Route::get("users/{hours}",[UserController::class,"createdByHour"]); // to get users created in the last specified hours
Route::get("user/{id}",[UserController::class,"searchUser"]); // Search user by id

Route::post("logout",[UserController::class,"logout"]);// a logged in user can logout
Route::delete("user/{id}",[UserController::class,"deleteUser"]); // an admin can delete other users, a normal user can only delete their own acc
});