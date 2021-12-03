<?php

use App\Http\Controllers\PageController;
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

Route::get('/', function () {
    return view('welcome');
});
//es lo mismo pero sirve mas que todo para paginas estaticas
// Route::view('vista', 'welcome', ['app' => '']);

Route::resource('pages', PageController::class); //7 rutas poisbles
