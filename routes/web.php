<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SfpController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\BKeluarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatchcordController;

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

Route::get('/logan/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/logan/login', [AuthController::class, 'authenticating']);

Route::middleware('auth')->group(function () {
    Route::middleware('must-admin')->group(function () {
        Route::get('/logan/input-data/arsip', [ArsipController::class, 'index']);
        Route::post('/logan/input-data/arsip', [ArsipController::class, 'store']);

        Route::get('/logan/list-data/arsip', [ArsipController::class, 'show']);
        Route::get('/logan/list-data/arsip-edit/{id}', [ArsipController::class, 'edit']);
        Route::put('/logan/list-data/arsip-edit/{id}', [ArsipController::class, 'update']);
        Route::delete('/logan/list-data/arsip-delete/{id}', [ArsipController::class, 'delete']);
        Route::delete('/logan/list-data/arsip-delete-permanent/{id}', [ArsipController::class, 'permanentDelete']);
        Route::get('/logan/list-data/arsip-restore/{id}', [ArsipController::class, 'restore']);
        Route::get('/logan/trash/arsip-deleted-list', [ArsipController::class, 'deletedArsip']);

        Route::get('/logan/list-data/arsip/jsonArsip', [ArsipController::class, 'jsonArsip']);
        Route::get('/logan/list-data/arsip/jsonArsipDeleted', [ArsipController::class, 'jsonArsipDeleted']);

        Route::get('/logan/manajemen-akun', [AuthController::class, 'manajemenAkun']);
        Route::post('/logan/manajemen-akun/akun-buat', [AuthController::class, 'buatAkun']);
        Route::put('/logan/manajemen-akun/akun-edit', [AuthController::class, 'updateAkun']);
        Route::delete('/logan/manajemen-akun/akun-delete/{id}', [AuthController::class, 'deleteAkun']);
        Route::get('/logan/manajemen-akun/jsonAkun', [AuthController::class, 'jsonAkun']);
    });

    Route::get('/logan/logout', [AuthController::class, 'logout']);

    Route::get('/logan/', [DashboardController::class, 'index']);

    Route::get('/logan/input-data/sfp-masuk', [SfpController::class, 'index']);
    Route::post('/logan/input-data/sfp', [SfpController::class, 'store']);

    Route::get('/logan/input-data/patchcord-masuk', [PatchcordController::class, 'index']);
    Route::post('/logan/input-data/patchcord', [PatchcordController::class, 'store']);

    Route::get('/logan/input-data/modul-masuk', [ModulController::class, 'index']);
    Route::post('/logan/input-data/modul', [ModulController::class, 'store']);

    Route::get('/logan/input-data/barang-keluar', [BKeluarController::class, 'show']);
    Route::get('/logan/input-data/barang-keluar/jsonBKeluar', [BKeluarController::class, 'jsonBKeluar']);
    Route::post('/logan/input-data/bkeluar', [BKeluarController::class, 'store']);
    Route::post('/logan/input-data/bkeluar-tambah', [BKeluarController::class, 'tambah']);
    Route::get('/logan/input-data/bkeluar-edit/{id}', [BKeluarController::class, 'edit']);
    Route::put('/logan/input-data/bkeluar-edit/{id}', [BKeluarController::class, 'update']);
    Route::get('/logan/input-data/bkeluar-detail-barang/{id}', [BKeluarController::class, 'detailBarang']);
    Route::delete('/logan/input-data/bkeluar-delete/{id}', [BKeluarController::class, 'delete']);

    Route::get('/logan/input-data/pilih-barang', [BKeluarController::class, 'pilihBarang'])->middleware('sudah-input-barang');
    Route::get('/logan/input-data/selesai-pilih', [BKeluarController::class, 'selesaiPilih']);
    Route::put('/logan/input-data/ambil-barang', [BKeluarController::class, 'ambilBarang']);
    Route::put('/logan/input-data/bkeluar-hapus-barang', [BKeluarController::class, 'hapusBarang']);
    Route::get('/logan/input-data/bkeluar-cetakpdf/{id}', [BKeluarController::class, 'cetakPdf']);

    Route::get('/logan/list-data/sfp-masuk', [SfpController::class, 'showMasuk']);
    Route::get('/logan/list-data/sfp-edit/{id}', [SfpController::class, 'edit']);
    Route::put('/logan/list-data/sfp-edit/{id}', [SfpController::class, 'update']);
    Route::delete('/logan/list-data/sfp-delete/{id}', [SfpController::class, 'delete']);
    Route::delete('/logan/list-data/sfp-delete-permanent/{id}', [SfpController::class, 'permanentDelete']);
    Route::get('/logan/list-data/sfp-restore/{id}', [SfpController::class, 'restore']);
    Route::get('/logan/trash/masuk/sfp-deleted-list', [SfpController::class, 'deletedSfp']);
    Route::get('/logan/trash/keluar/sfp-keluar-deleted-list', [SfpController::class, 'deletedSfpKeluar']);

    Route::get('/logan/list-data/patchcord-masuk', [PatchcordController::class, 'showMasuk']);
    Route::get('/logan/list-data/patchcord-edit/{id}', [PatchcordController::class, 'edit']);
    Route::put('/logan/list-data/patchcord-edit/{id}', [PatchcordController::class, 'update']);
    Route::delete('/logan/list-data/patchcord-delete/{id}', [PatchcordController::class, 'delete']);
    Route::delete('/logan/list-data/patchcord-delete-permanent/{id}', [PatchcordController::class, 'permanentDelete']);
    Route::get('/logan/list-data/patchcord-restore/{id}', [PatchcordController::class, 'restore']);
    Route::get('/logan/trash/masuk/patchcord-deleted-list', [PatchcordController::class, 'deletedPatchcord']);
    Route::get('/logan/trash/keluar/patchcord-keluar-deleted-list', [PatchcordController::class, 'deletedPatchcordKeluar']);    

    Route::get('/logan/list-data/modul-masuk', [ModulController::class, 'showMasuk']);
    Route::get('/logan/list-data/modul-edit/{id}', [ModulController::class, 'edit']);
    Route::put('/logan/list-data/modul-edit/{id}', [ModulController::class, 'update']);
    Route::delete('/logan/list-data/modul-delete/{id}', [ModulController::class, 'delete']);
    Route::delete('/logan/list-data/modul-delete-permanent/{id}', [ModulController::class, 'permanentDelete']);
    Route::get('/logan/list-data/modul-restore/{id}', [ModulController::class, 'restore']);
    Route::get('/logan/trash/masuk/modul-deleted-list', [ModulController::class, 'deletedModul']);
    Route::get('/logan/trash/keluar/modul-keluar-deleted-list', [ModulController::class, 'deletedModulKeluar']);

    Route::get('/logan/list-data/sfp-keluar', [SfpController::class, 'showKeluar']);
    Route::get('/logan/list-data/patchcord-keluar', [PatchcordController::class, 'showKeluar']);
    Route::get('/logan/list-data/modul-keluar', [ModulController::class, 'showKeluar']);

    Route::get('/logan/list-data/sfp-masuk/jsonSfpMasuk', [SfpController::class, 'jsonSfpMasuk']);
    Route::get('/logan/list-data/sfp-masuk/jsonSfpMasukDeleted', [SfpController::class, 'jsonSfpMasukDeleted']);
    Route::get('/logan/list-data/sfp-keluar/jsonSfpKeluar', [SfpController::class, 'jsonSfpKeluar']);
    Route::get('/logan/list-data/sfp-keluar/jsonSfpKeluarDeleted', [SfpController::class, 'jsonSfpKeluarDeleted']);

    Route::get('/logan/list-data/patchcord-masuk/jsonPatchcordMasuk', [PatchcordController::class, 'jsonPatchcordMasuk']);
    Route::get('/logan/list-data/patchcord-masuk/jsonPatchcordMasukDeleted', [PatchcordController::class, 'jsonPatchcordMasukDeleted']);
    Route::get('/logan/list-data/patchcord-keluar/jsonPatchcordKeluar', [PatchcordController::class, 'jsonPatchcordKeluar']);
    Route::get('/logan/list-data/patchcord-keluar/jsonPatchcordKeluarDeleted', [PatchcordController::class, 'jsonPatchcordKeluarDeleted']);

    Route::get('/logan/list-data/modul-masuk/jsonModulMasuk', [ModulController::class, 'jsonModulMasuk']);
    Route::get('/logan/list-data/modul-masuk/jsonModulMasukDeleted', [ModulController::class, 'jsonModulMasukDeleted']);
    Route::get('/logan/list-data/modul-keluar/jsonModulKeluar', [ModulController::class, 'jsonModulKeluar']);
    Route::get('/logan/list-data/modul-keluar/jsonModulKeluarDeleted', [ModulController::class, 'jsonModulKeluarDeleted']);

    Route::get('/logan/input-data/pilih-barang/jsonSfpMasuk', [BKeluarController::class, 'jsonSfpMasuk']);
    Route::get('/logan/input-data/pilih-barang/jsonPatchcordMasuk', [BKeluarController::class, 'jsonPatchcordMasuk']);
    Route::get('/logan/input-data/pilih-barang/jsonModulMasuk', [BKeluarController::class, 'jsonModulMasuk']);

    Route::get('/logan/input-data/detail-barang/jsonSfpHapus', [BKeluarController::class, 'jsonSfpHapus']);
    Route::get('/logan/input-data/detail-barang/jsonPatchcordHapus', [BKeluarController::class, 'jsonPatchcordHapus']);
    Route::get('/logan/input-data/detail-barang/jsonModulHapus', [BKeluarController::class, 'jsonModulHapus']);
});
