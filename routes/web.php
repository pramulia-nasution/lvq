<?php

use App\Http\Controllers\DatasetController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TestingController;
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


Route::get('/',[HomepageController::class,'index'])->name('home');
Route::get('list-data',[DatasetController::class,'index'])->name('dataset.index');
Route::delete('truncate',[DatasetController::class,'truncate'])->name('truncate');
Route::post('import',[DatasetController::class,'import'])->name('import');

Route::get('training',[TrainingController::class,'index'])->name('data.training');
Route::post('calculate-lvq1',[TrainingController::class,'calculateLVQ1'])->name('lvq1');
Route::post('calculate-lvq2',[TrainingController::class,'calculateLVQ2'])->name('lvq2');
Route::post('calculate-lvq3',[TrainingController::class,'calculateLVQ3'])->name('lvq3');

Route::get('testing',[TestingController::class,'index'])->name('data.testing');
Route::post('import_testing',[TestingController::class,'import'])->name('import.testing');
Route::delete('truncate_testing',[TestingController::class,'truncate'])->name('truncate.testing');
Route::post('store_testing',[TestingController::class,'store'])->name('store.testing');
Route::post('generate_testing',[TestingController::class,'generate'])->name('generate.testing');

Route::get('/test',[DatasetController::class,'test']);
