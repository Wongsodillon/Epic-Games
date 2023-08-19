<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [GameController::class, "guestPage"])->name("main");
Route::match(["post", "get"], "/login", [UserController::class, "login"])->name("login");
Route::get("/loginpage", [UserController::class, "loginPage"])->name("loginpage")->middleware("guest");
Route::post("/register", [UserController::class, "register"])->name("register");
Route::get("/registerpage", [UserController::class, "registerPage"])->name("registerpage")->middleware("guest");

Route::get("/home", [GameController::class, "userPage"])->name("home")->middleware("auth");
Route::get("/wishlistpage", [GameController::class, "wishlistPage"])->name("wishlistpage")->middleware("auth");
Route::get("/librarypage", [GameController::class, "libraryPage"])->name("librarypage")->middleware("auth");
Route::get("/gamedetails/{id}", [GameController::class, "gameDetails"])->name("gamedetails")->middleware("auth");
Route::get("/search", [GameController::class, "search"])->name("search");
Route::get("/browse", [GameController::class, "browse"])->name("browse");
Route::get("/addtowishlist/{id}", [GameController::class, "addToWishlist"])->name("addtowishlist")->middleware("auth");
Route::get("/removefromwishlist/{id}", [GameController::class, "removeFromWishlist"])->name("removefromwishlist")->middleware("auth");
Route::get("/checkoutpage/{id}", [GameController::class, "checkoutPage"])->name("checkoutpage")->middleware("auth");
Route::post("/addtolibrary/{id}", [GameController::class, "addToLibrary"])->name("addtolibrary")->middleware("auth");

Route::middleware(["admin"])->prefix("admin")->group(function() {
    Route::get("/games", [AdminController::class, "adminPage"])->name("adminpage");
    Route::get("/search", [AdminController::class, "adminSearch"])->name("adminsearch");
    Route::get("/addgamepage", [AdminController::class, "addGamePage"])->name("addgamepage");
    Route::post("/addgame", [AdminController::class, "addGame"])->name("addgame");
    Route::delete("/deletegame/{id}", [AdminController::class, "deleteGame"])->name("deletegame");
    Route::get("/updategame/{id}", [AdminController::class, "updateGamePage"])->name("updategamepage");
    Route::patch("/update/{id}", [AdminController::class, "updateGame"])->name("updategame");
});
