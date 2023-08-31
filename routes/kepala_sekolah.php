<?php

use App\Http\Controllers\KepalaSekolah\ArsipSuratKeluarController;
use App\Http\Controllers\KepalaSekolah\ArsipSuratMasukController;
use App\Http\Controllers\KepalaSekolah\DashboardController;
use App\Http\Controllers\KepalaSekolah\ProfileController;
use App\Http\Controllers\KepalaSekolah\TransaksiSuratKeluarController;
use App\Http\Controllers\KepalaSekolah\TransaksiSuratMasukController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth','role:Kepala Sekolah')->group(function () {
    Route::prefix('kepala-sekolah')->name('kepala-sekolah.')->group(function () {

        Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');

        // Profile
        Route::get('profile',[ProfileController::class,'index'])->name('profile.index');
        Route::get('profile/edit',[ProfileController::class,'edit'])->name('profile.edit');
        Route::put('profile',[ProfileController::class,'update'])->name('profile.update');
        Route::post('profile/upload-ktp',[ProfileController::class,'upload_ktp'])->name('profile.upload_ktp');
        Route::post('profile/edit-ktp',[ProfileController::class,'edit_ktp'])->name('profile.edit_ktp');
        Route::get('profile/destroy-ktp',[ProfileController::class,'destroy_ktp'])->name('profile.destroy_ktp');
        Route::post('profile/upload-photo',[ProfileController::class,'upload_photo'])->name('profile.upload_photo');
        Route::delete('profile/destroy-photo',[ProfileController::class,'destroy_photo'])->name('profile.destroy_photo');
        Route::post('profile/edit-photo',[ProfileController::class,'edit_photo'])->name('profile.edit_photo');
        Route::post('profile/edit-password',[ProfileController::class,'edit_password'])->name('profile.edit_password');

        // Transaksi
        Route::prefix('transaksi')->name('transaksi.')->group(function () {

            // Surat Masuk
            Route::get('surat-masuk',[TransaksiSuratMasukController::class,'index'])->name('surat-masuk.index');
            Route::get('surat-masuk/{id}/detail',[TransaksiSuratMasukController::class,'detail'])->name('surat-masuk.detail');
            Route::get('surat-masuk/{id}/download-lampiran',[TransaksiSuratMasukController::class,'download_lampiran'])->name('surat-masuk.lampiran.download');

            // Surat Keluar
            Route::get('surat-keluar',[TransaksiSuratKeluarController::class,'index'])->name('surat-keluar.index');
            Route::get('surat-keluar/{id}/detail',[TransaksiSuratKeluarController::class,'detail'])->name('surat-keluar.detail');
            Route::get('surat-keluar/{id}/download-lampiran',[TransaksiSuratKeluarController::class,'download_lampiran'])->name('surat-keluar.lampiran.download');
        });

        // Arsip
        Route::prefix('arsip')->name('arsip.')->group(function () {
            // Surat Masuk
            Route::get('surat-masuk',[ArsipSuratMasukController::class,'index'])->name('surat-masuk.index');
            Route::get('surat-masuk/{id}/detail',[ArsipSuratMasukController::class,'detail'])->name('surat-masuk.detail');
            Route::get('surat-masuk/{id}/download-lampiran',[ArsipSuratMasukController::class,'download_lampiran'])->name('surat-masuk.lampiran.download');

            // Surat Keluar
            Route::get('surat-keluar',[ArsipSuratKeluarController::class,'index'])->name('surat-keluar.index');
            Route::get('surat-keluar/{id}/detail',[ArsipSuratKeluarController::class,'detail'])->name('surat-keluar.detail');
            Route::get('surat-keluar/{id}/download-lampiran',[ArsipSuratKeluarController::class,'download_lampiran'])->name('surat-keluar.lampiran.download');
        });
    });
});
