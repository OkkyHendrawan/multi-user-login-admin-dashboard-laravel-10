<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsAppController;

Route::get('admin/whatsapp', [WhatsAppController::class, 'index'])->name('admin.whatsapp.index');
Route::post('send-whatsapp-message', [WhatsAppController::class, 'sendWhatsAppMessage'])->name('send-whatsapp-message');
