<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function () {
    return redirect()->route('mahasiswa.index');
});

Route::resource('mahasiswa', MahasiswaController::class);
Route::get('/mahasiswa-export-pdf', [MahasiswaController::class, 'exportPdf'])->name('mahasiswa.export.pdf');
Route::get('/mahasiswa-export-excel', [MahasiswaController::class, 'exportExcel'])->name('mahasiswa.export.excel');
