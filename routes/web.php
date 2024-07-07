<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;

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

//Login dan Logout Admin, Dosen dan Mahasiswa
Route::get('/', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'AuthLogin'])->name('login');
Route::get('logout', [AuthController::class, 'logout']);

//Reset Password Admin, Dosen dan Mahasiswa
Route::get('forgot-password', [AuthController::class, 'forgotpassword']);
Route::post('forgot-password', [AuthController::class, 'PostForgotPassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'PostReset']);

//Excel dan Pdf Admin
Route::get('admin/generate/excel', [AdminController::class, 'generateExcel'])->name('admin.generate.excel');
Route::get('admin/generate/pdf', [AdminController::class, 'generatePDF'])->name('admin.generate.pdf');

//Excel dan Pdf Fakultas
Route::get('/fakultas/generate/pdf', [FakultasController::class, 'generatePdf'])->name('fakultas.generate.pdf');
Route::get('/fakultas/generate/excel', [FakultasController::class, 'generateExcel'])->name('fakultas.generate.excel');

//Excel dan Pdf Prodi
Route::get('/prodi/generate/pdf', [ProdiController::class, 'generatePdf'])->name('prodi.generate.pdf');
Route::get('/prodi/generate/excel', [ProdiController::class, 'generateExcel'])->name('prodi.generate.excel');

//Tampilan Dashboard ketika sudah login untuk Admin
Route::group(['middleware' => ['auth:web']], function (){

//Route dengan Controller Admin
Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('admin/admin', [AdminController::class, 'index'])->name('admin.admin.list');
Route::get('admin/admin/form_create', [AdminController::class, 'form_create'])->name('admin.admin.form_create');
Route::post('admin/admin/proses_create', [AdminController::class, 'proses_create'])->name('admin.admin.proses_create');
Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit']);
Route::post('admin/admin/edit/{id}', [AdminController::class, 'update']);
Route::get('admin/admin/delete/{id}', [AdminController::class, 'delete']);
Route::get('admin/admin/preview/{id}', [AdminController::class, 'preview']);
Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');

//Route dengan Controller Kelas
Route::get('admin/kelas', [KelasController::class, 'index'])->name('admin.kelas.list');
Route::get('admin/kelas/form_create', [KelasController::class, 'form_create'])->name('admin.kelas.form_create');
Route::post('admin/kelas/proses_create', [KelasController::class, 'proses_create'])->name('admin.kelas.proses_create');

//Route dengan Controller Fakultas
Route::get('admin/fakultas', [FakultasController::class, 'index'])->name('admin.fakultas.list');
Route::get('admin/fakultas/form_create', [FakultasController::class, 'form_create'])->name('admin.fakultas.form_create');
Route::post('admin/fakultas/proses_create', [FakultasController::class, 'proses_create'])->name('admin.fakultas.proses_create');
Route::get('admin/fakultas/{fakultas_id}/edit', [FakultasController::class, 'edit'])->name('admin.fakultas.edit');
Route::put('admin/fakultas/{fakultas_id}/update', [FakultasController::class, 'update'])->name('admin.fakultas.update');
Route::post('admin/fakultas/soft-delete/{fakultas_id}', [FakultasController::class, 'softDeleteFakultas'])->name('admin.fakultas.softDeleteFakultas');

//Route dengan Controller Prodi
Route::get('admin/prodi', [ProdiController::class, 'index'])->name('admin.prodi.list');
Route::get('admin/prodi/form_create', [ProdiController::class, 'form_create'])->name('admin.prodi.form_create');
Route::post('admin/prodi/proses_create', [ProdiController::class, 'proses_create'])->name('admin.prodi.proses_create');
Route::get('admin/prodi/{prodi_id}/edit', [ProdiController::class, 'edit'])->name('admin.prodi.edit');
Route::put('admin/prodi/{prodi_id}/update', [ProdiController::class, 'update'])->name('admin.prodi.update');
Route::post('admin/prodi/soft-delete/{prodi_id}', [ProdiController::class, 'softDeleteProdi'])->name('admin.prodi.softDeleteProdi');

//Route dengan Controller Dosen
Route::get('admin/dosen', [DosenController::class, 'index'])->name('admin.dosen.list');
Route::get('admin/dosen/form_create', [DosenController::class, 'form_create'])->name('admin.dosen.form_create');
Route::post('admin/dosen/proses_create', [DosenController::class, 'proses_create'])->name('admin.dosen.proses_create');
Route::get('admin/dosen/edit/{dosen_id}', [DosenController::class, 'edit'])->name('admin.dosen.edit');
Route::put('admin/dosen/{dosen_id}/update', [DosenController::class, 'update'])->name('admin.dosen.update');
Route::get('/dosen/search', [DosenController::class, 'search'])->name('dosen.search');
Route::post('admin/dosen/soft-delete/{dosen_id}', [DosenController::class, 'softDeleteDosen'])->name('admin.dosen.softDeleteDosen');

//Route dengan Controller Mahasiswa
Route::get('admin/mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa.list');
Route::get('admin/mahasiswa/form_create', [MahasiswaController::class, 'form_create'])->name('admin.mahasiswa.form_create');
Route::post('admin/mahasiswa/proses_create', [MahasiswaController::class, 'proses_create'])->name('admin.mahasiswa.proses_create');
Route::get('admin/mahasiswa/edit/{mahasiswa_id}', [MahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
Route::put('admin/mahasiswa/{mahasiswa_id}/update', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
Route::get('/mahasiswa/search', [MahasiswaController::class, 'search'])->name('mahasiswa.search');
Route::post('admin/mahasiswa/soft-delete/{mahasiswa_id}', [MahasiswaController::class, 'softDeleteMahasiswa'])->name('admin.mahasiswa.softDeleteMahasiswa');

//Route dengan Controller WhatsApp
Route::get('admin/whatsapp', [WhatsAppController::class, 'index'])->name('admin.whatsapp.index');
Route::post('send-whatsapp-message', [WhatsAppController::class, 'sendWhatsAppMessage'])->name('send-whatsapp-message');

});

//Tampilan Dashboard ketika sudah login sebagai Dosen
Route::group(['middleware' => ['auth:dosen']], function (){

    Route::get('dosen/dashboard', [DashboardController::class, 'dashboard']);

});

//Tampilan Dashboard ketika sudah login sebagai Mahasiswa
Route::group(['middleware' => ['auth:mahasiswa']], function (){

    Route::get('mahasiswa/dashboard', [DashboardController::class, 'dashboard']);

});
