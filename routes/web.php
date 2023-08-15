<?php

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
    });
    Route::get('/logan/input-data/sfp-masuk', [SfpController::class, 'index']);
    Route::post('/logan/input-data/sfp', [SfpController::class, 'store']);

    Route::get('/logan/input-data/patchcord-masuk', [PatchcordController::class, 'index']);
    Route::post('/logan/input-data/patchcord', [PatchcordController::class, 'store']);

    Route::get('/logan/input-data/modul-masuk', [ModulController::class, 'index']);
    Route::post('/logan/input-data/modul', [ModulController::class, 'store']);

    Route::get('/logan/list-data/sfp-masuk', [SfpController::class, 'showMasuk']);
    Route::get('/logan/list-data/sfp-edit/{id}', [SfpController::class, 'edit']);
    Route::put('/logan/list-data/sfp-edit/{id}', [SfpController::class, 'update']);
    Route::delete('/logan/list-data/sfp-delete/{id}', [SfpController::class, 'delete']);
    Route::delete('/logan/list-data/sfp-delete-permanent/{id}', [SfpController::class, 'permanentDelete']);
    Route::get('/logan/list-data/sfp-restore/{id}', [SfpController::class, 'restore']);
    Route::get('/logan/trash/masuk/sfp-deleted-list', [SfpController::class, 'deletedSfp']);

    Route::get('/logan/list-data/patchcord-masuk', [PatchcordController::class, 'showMasuk']);
    Route::get('/logan/list-data/patchcord-edit/{id}', [PatchcordController::class, 'edit']);
    Route::put('/logan/list-data/patchcord-edit/{id}', [PatchcordController::class, 'update']);
    Route::delete('/logan/list-data/patchcord-delete/{id}', [PatchcordController::class, 'delete']);
    Route::delete('/logan/list-data/patchcord-delete-permanent/{id}', [PatchcordController::class, 'permanentDelete']);
    Route::get('/logan/list-data/patchcord-restore/{id}', [PatchcordController::class, 'restore']);
    Route::get('/logan/trash/masuk/patchcord-deleted-list', [PatchcordController::class, 'deletedPatchcord']);

    Route::get('/logan/list-data/modul-masuk', [ModulController::class, 'showMasuk']);
    Route::get('/logan/list-data/modul-edit/{id}', [ModulController::class, 'edit']);
    Route::put('/logan/list-data/modul-edit/{id}', [ModulController::class, 'update']);
    Route::delete('/logan/list-data/modul-delete/{id}', [ModulController::class, 'delete']);
    Route::delete('/logan/list-data/modul-delete-permanent/{id}', [ModulController::class, 'permanentDelete']);
    Route::get('/logan/list-data/modul-restore/{id}', [ModulController::class, 'restore']);
    Route::get('/logan/trash/masuk/modul-deleted-list', [ModulController::class, 'deletedModul']);

    Route::get('/logan/list-data/sfp-masuk/jsonSfpMasuk', [SfpController::class, 'jsonSfpMasuk']);
    Route::get('/logan/list-data/sfp-masuk/jsonSfpMasukDeleted', [SfpController::class, 'jsonSfpMasukDeleted']);

    Route::get('/logan/list-data/patchcord-masuk/jsonPatchcordMasuk', [PatchcordController::class, 'jsonPatchcordMasuk']);
    Route::get('/logan/list-data/patchcord-masuk/jsonPatchcordMasukDeleted', [PatchcordController::class, 'jsonPatchcordMasukDeleted']);

    Route::get('/logan/list-data/modul-masuk/jsonModulMasuk', [ModulController::class, 'jsonModulMasuk']);
    Route::get('/logan/list-data/modul-masuk/jsonModulMasukDeleted', [ModulController::class, 'jsonModulMasukDeleted']);
});
