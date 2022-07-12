<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LoanedBookController;
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

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/signup', [AuthController::class, 'signup'])->middleware('admin');

    Route::post('/authors', [AuthorController::class, 'store']);
    Route::get('/authors/{author}', [AuthorController::class, 'show']);
    Route::get('/authors', [AuthorController::class, 'index']);
    Route::patch('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'delete']);

    Route::post('/authors/{author}/books', [BookController::class, 'store']);
    Route::get('/books/{book}', [BookController::class, 'show']);
    Route::get('/books', [BookController::class, 'index']);
    Route::patch('/authors/{author}/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'destroy']);
    Route::post('/books/{book}/categories/{category}', [BookController::class, 'toggleCategory']);

    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::patch('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    Route::post('/categories', [CategoryController::class, 'store']);

    Route::get('/clients/{client}', [ClientController::class, 'show']);
    Route::get('/clients', [ClientController::class, 'index']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::patch('/clients/{client}', [ClientController::class, 'update']);
    Route::delete('/clients/{client}', [ClientController::class, 'destroy']);

    Route::post('/books/{book}/clients/{client}/loan', [LoanedBookController::class, 'store']);
    Route::post('/loans/{loanedbook}/return', [LoanedBookController::class, 'destroy']);
    Route::get('/loans/{loanedbook}', [LoanedBookController::class, 'show']);
    Route::get('/loans', [LoanedBookController::class, 'index']);
});

Route::post('/login', [AuthController::class, 'login'])->middleware('guest');