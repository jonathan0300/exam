<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VirusController;
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
//Route::delete('/{virus}', [VirusController::class, 'destroy']);
Route::get('/', function()
{
    return view('index');
});
Route::resource('/virus', VirusController::class);
