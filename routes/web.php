<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResponseController;
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

//buat landing page sama form
Route::get('/', [ReportController::class, 'index'])->name('home');
Route::post('/store', [ReportController::class, 'store'])->name('store');

//buat halaman login
Route::get('/login', [ReportController::class, 'login'])->name('login');
Route::post('auth', [ReportController::class, 'auth'])->name('auth');

//untuk petugas 
Route::middleware(['isLogin', 'CekRole:petugas'])->group(function(){
    Route::get ('/data/petugas', [ReportController::class, 'petugas'])->name('petugas');
    Route::get('/response/edit/{report_id}', [ResponseController::class, 'edit'])->name('response.edit');
    Route::patch('/response/update/{report_id}', [ResponseController::class, 'update'])->name('response.update');

});

//yang bisa diakses admin sama petugas
Route::middleware(['isLogin', 'CekRole:admin,petugas'])->group(function(){
    Route::get('/logout', [ReportController::class, 'logout'])->name('logout');
});

//buat ke halaman data setelah login
Route::middleware(['isLogin', 'CekRole:admin'])->group(function(){
    Route::get ('/data', [ReportController::class, 'data'])->name('data');
    Route::delete('/delete/{id}', [ReportController::class, 'destroy'])->name('delete');
});

Route::get ('/error', [ReportController::class, 'error'])->name('error');

//buat proses pdf, yg export itu semua data, yg created per baris
Route::get('/export/pdf', [ReportController::class, 'exportPDF'])->name('export.pdf');
Route::get('/created/pdf/{id}', [ReportController::class, 'createdPDF'])->name('created.pdf');

//buat proses excel, yg export itu semua data, yg created per baris
Route::get('/export/excel', [ReportController::class, 'exportExcel'])->name('export.excel');


