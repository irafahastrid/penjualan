<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BeliController;
use App\Http\Controllers\LoginController;
use Faker\Provider\Base;
use Illuminate\Auth\Events\Login;
use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/', function () {
    return view('welcome');
});


Route::prefix('/login')->group(function(){
    Route::get('/',[LoginController::class,'index'])->name('login');
    Route::post('/check',[LoginController::class,'check'])->name('login.check');
});
Route::get('/logout',[LoginController::class,'logout'])->name('logout');

Route::prefix('/barang')->middleware('checkLevel:barang')->group(function(){
    Route::get('/',[BarangController::class,'index'])->name('barang.index');
    Route::get('/data',[BarangController::class,'dataBarang'])->name('barang.data');
    Route::get('/tambah',[BarangController::class,'tambah'])->name('barang.tambah');
    Route::get('/edit/{id_barang}',[BarangController::class,'update'])->name('barang.edit');
    Route::post('/simpan',[BarangController::class,'simpan'])->name('barang.simpan');
    Route::post('/hapus',[BarangController::class,'delete'])->name('barang.hapus');
    Route::get('/list',[BarangController::class,'listBarang'])->name('barang.list');
});

//Prefic beli
Route::prefix('/beli')->middleware('checkLevel:beli')->group(function(){
    Route::get('/',[BeliController::class,'index'])->name('beli.index');
    Route::get('/data',[BeliController::class,'index'])->name('beli.data');
    Route::get('/tambah',[BeliController::class,'tambah'])->name('beli.tambah');
    Route::post('/simpan',[BeliController::class,'simpan'])->name('beli.simpan');
});
