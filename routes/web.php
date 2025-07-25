<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [UploadController::class, 'index'])->name('index');
Route::post('/upload', [UploadController::class, 'store'])->name('upload');

Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
