<?php

use App\Http\Controllers\Admin\ArsipSuratKeluarController;
use App\Http\Controllers\Admin\ArsipSuratMasukController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\LaporanSuratKeluarController;
use App\Http\Controllers\Admin\LaporanSuratMasukController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TemplateSuratController;
use App\Http\Controllers\Admin\TransaksiSuratKeluarController;
use App\Http\Controllers\Admin\TransaksiSuratMasukController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth','role:Admin')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');

        // Jabatan
        Route::resource('jabatan',JabatanController::class)->except('show');

        // Jenis Surat
        Route::resource('jenis-surat',JenisSuratController::class)->except('show');

        // Template Surat
        Route::resource('template-surat',TemplateSuratController::class)->except('show','edit','update');
        Route::get('template-surat/{id}/download',[TemplateSuratController::class,'download'])->name('template-surat.download');

        // Users
        Route::resource('users',UsersController::class)->except('show');
        Route::post('users/{id}/edit-password',[UsersController::class,'edit_password'])->name('users.edit-password');
        Route::get('users/trash',[UsersController::class,'trash'])->name('users.trash');
        Route::delete('users/{id}/destroy-permanent',[UsersController::class,'destroy_permanent'])->name('users.destroy-permanent');
        Route::get('users/{id}/restore',[UsersController::class,'restore'])->name('users.restore');

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
            Route::resource('surat-masuk',TransaksiSuratMasukController::class)->except('show');
            Route::get('surat-masuk/{id}/draft',[TransaksiSuratMasukController::class,'draft'])->name('surat-masuk.draft');
            Route::get('surat-masuk/{id}/detail',[TransaksiSuratMasukController::class,'detail'])->name('surat-masuk.detail');
            Route::post('surat-masuk/{id}/lampiran',[TransaksiSuratMasukController::class,'store_lampiran'])->name('surat-masuk.lampiran.store');
            Route::delete('surat-masuk/{id}/lampiran',[TransaksiSuratMasukController::class,'destroy_lampiran'])->name('surat-masuk.lampiran.destroy');
            Route::get('surat-masuk/{id}/download-lampiran',[TransaksiSuratMasukController::class,'download_lampiran'])->name('surat-masuk.lampiran.download');
            Route::post('surat-masuk/{id}/submit',[TransaksiSuratMasukController::class,'submit'])->name('surat-masuk.submit');

            // Surat Keluar
            Route::resource('surat-keluar',TransaksiSuratKeluarController::class)->except('show');
            Route::get('surat-keluar/{id}/draft',[TransaksiSuratKeluarController::class,'draft'])->name('surat-keluar.draft');
            Route::get('surat-keluar/{id}/detail',[TransaksiSuratKeluarController::class,'detail'])->name('surat-keluar.detail');
            Route::post('surat-keluar/{id}/lampiran',[TransaksiSuratKeluarController::class,'store_lampiran'])->name('surat-keluar.lampiran.store');
            Route::delete('surat-keluar/{id}/lampiran',[TransaksiSuratKeluarController::class,'destroy_lampiran'])->name('surat-keluar.lampiran.destroy');
            Route::get('surat-keluar/{id}/download-lampiran',[TransaksiSuratKeluarController::class,'download_lampiran'])->name('surat-keluar.lampiran.download');
            Route::post('surat-keluar/{id}/submit',[TransaksiSuratKeluarController::class,'submit'])->name('surat-keluar.submit');

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

        // Laporan
        Route::prefix('laporan')->name('laporan.')->group(function () {
            // Surat Masuk
            Route::get('surat-masuk',[LaporanSuratMasukController::class,'index'])->name('surat-masuk.index');

            // Surat Keluar
            Route::get('surat-keluar',[LaporanSuratKeluarController::class,'index'])->name('surat-keluar.index');
        });
    });
});
