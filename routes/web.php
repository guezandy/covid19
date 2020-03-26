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
// Results page and landing page
Route::get('/', 'ViewController@index')->name('welcome');

// Trigger things
Route::get('/start', 'ViewController@start')->name('start');
Route::post('/single_message', 'ViewController@singleMessage')->name('single_message');
Route::post('/csv_file', 'ViewController@csvFile')->name('csv_file');
Route::post('/download_response', 'ViewController@downloadResponsesCsv')->name('download_response');

// Twilio response handler
Route::any('/response', 'ViewController@response')->name('response');


Route::get('clearclearclear', 'ViewController@clear')->name('clear');