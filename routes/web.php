<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

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

Route::view('/', 'chart')->name('chart');
// Route::get('/pdf/{year}', [PdfController::class, 'showPdf']);
// Route::get('/generate-pdf/{year}', [PdfController::class, 'generatePdf']);
Route::get('/download-pdf/{year}', [PdfController::class, 'downloadPdf'])->name('download.pdf');
