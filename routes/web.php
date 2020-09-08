<?php

use Illuminate\Support\Facades\Route;

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
//wszystkie ścieżki w aplikacji do których dodałem middleware
//wszystkie tabele do projektu zostały dodane do bazy za pomocą laravela
Route::get('/', function () {
    return view('welcome');
});
Route::get('download_books', 'BooksController@index')->middleware('guardian');
Route::get('download_categories', 'CategoriesController@index')->middleware('guardian');
Route::post('update_book', 'BooksController@update')->middleware('guardian');
Route::post('insert_book', 'BooksController@create')->middleware('guardian');
Route::post('delete_book', 'BooksController@destroy')->middleware('guardian');
