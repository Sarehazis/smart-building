<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryDeviceController;
use App\Http\Controllers\Api\DeviceController as ApiDeviceController;
use App\Http\Controllers\Api\GedungController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\JenisDeviceController as ApiJenisDeviceController;
use App\Http\Controllers\Api\LantaiController as ApiLantaiController;
use App\Http\Controllers\Api\PerusahaanController as ApiPerusahaanController;
use App\Http\Controllers\Api\RfidController as ApiRfidController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\RuanganController as ApiRuanganController;
use App\Http\Controllers\Api\SettingRolesController;
use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Yang belum login
Route::post('/login', [AuthController::class, 'login']);

// Get Status Lampu
Route::get('/status-lampu/{macAddress}', [ApiDeviceController::class, 'getStatusLampu']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/search-user', [AuthController::class, 'search']);
});


// Route Middleware Group
Route::group(['middleware' => 'auth:sanctum', 'isAdmin', 'prefix' => 'admin'], function () {
    Route::resource('roles', RolesController::class);
    // Route Setting Roles
    Route::resource('settings_roles', SettingRolesController::class);
    // Route Perusahaan 
    Route::resource('perusahaan', ApiPerusahaanController::class);
    // Route Jenis Device
    Route::resource('jenis_device', ApiJenisDeviceController::class);
    // Route Show URL Device
    Route::get('device/url/{id}', [ApiDeviceController::class, 'showUrl']);
    // Route Update device detail (nama_device, jenis_device_id,mac_address)
    Route::resource('device', ApiDeviceController::class);
    Route::post('device/{id}', [ApiDeviceController::class, 'update']);
    // Route Update device suhu, status, min_suhu dan max_suhu
    Route::post('device/{id}/suhu', [ApiDeviceController::class, 'updateSuhu']);
    Route::post('device/{id}/status', [ApiDeviceController::class, 'updateStatus']);
    Route::post('device/{id}/suhurange', [ApiDeviceController::class, 'updateSuhuRange']);

    // Route CategoryDeviceController 
    Route::resource('category_device', CategoryDeviceController::class);

    // Route Ruangan
    Route::resource('ruangan', ApiRuanganController::class);

    // Route Lantai
    Route::resource('lantai', ApiLantaiController::class);

    // Route Gedung
    Route::resource('gedung', GedungController::class);

    // Route rfID
    Route::resource('rfid', ApiRfidController::class);

    // Route CategoryDevice
    Route::resource('category_device', CategoryDeviceController::class);

    // Route History
    Route::resource('history', HistoryController::class);

    // Route Setting Ruangan Device 
    Route::resource('setting_ruangan_device', ApiDeviceController::class);
});

// Route Roles
