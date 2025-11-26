<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\KategoriProdukController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\DetailPesananController;
use App\Http\Controllers\Api\FakturController;
use App\Http\Controllers\Api\InformasiPeternakanController;
use App\Http\Controllers\Api\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
// 🔐 Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// 🔐 Protected routes (butuh token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    // 🔹 (hanya admin)
    //Route::get('admin/stats', [AdminController::class, 'getStats'])->middleware('auth:sanctum');
    Route::get('users', [AdminController::class, 'getUsers']);
    Route::apiResource('produk', ProdukController::class);

    // 🔹 Pemesanan (pelanggan bisa buat pesanan)
    Route::apiResource('pesanan', PesananController::class);
    Route::apiResource('detail-pesanan', DetailPesananController::class);
});

// 🔐 Forgot & Reset Password
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

// 🔹 Produk
Route::apiResource('produk', ProdukController::class)->middleware('auth:sanctum');

// 🔹 Kategori Produk
Route::apiResource('kategori-produk', KategoriProdukController::class);

// 🔹 Pesanan
Route::apiResource('pesanan', PesananController::class);

// 🔹 Detail Pesanan
Route::apiResource('detail-pesanan', DetailPesananController::class);

// 🔹 Faktur
Route::apiResource('faktur', FakturController::class);

// 🔹 Informasi Peternakan (Hanya 1 record)
Route::get('informasi-peternakan', [InformasiPeternakanController::class, 'show']);
Route::put('informasi-peternakan', [InformasiPeternakanController::class, 'update']);
Route::post('informasi-peternakan', [InformasiPeternakanController::class, 'store']);