<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/books", [BookController::class, "index"])->name("books.index");
Route::post("/books/guardar", [BookController::class, "store"])->name("books.store");
Route::delete("/books/eliminar/{id}", [BookController::class, "destroy"])->name("books.eliminar");
Route::get("/books/editar/{id}", [BookController::class, "edit"])->name("books.editar");
Route::post("/books/actualizar/{id}", [BookController::class, "update"])->name("books.update");

Route::get("/authors", [AuthorController::class, "index"])->name("authors.index");
Route::post("/authors/guardar", [AuthorController::class, "store"])->name("authors.store");
