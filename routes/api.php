<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\KategoriProdukController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\DetailPesananController;
use App\Http\Controllers\Api\FakturController;
use App\Http\Controllers\Api\InformasiPeternakanController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\PelangganController;

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

    // 🔹 Pemesanan (pelanggan bisa buat pesanan)
    Route::apiResource('pesanan', PesananController::class);
    Route::apiResource('detail-pesanan', DetailPesananController::class);
});

// 🔐 Forgot & Reset Password
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

// 🔹 Produk
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk/{id}', [ProdukController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/produk', [ProdukController::class, 'store']);
    Route::put('/produk/{id}', [ProdukController::class, 'update']);
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);
});

// 🔹 Kategori Produk
//     Publik: hanya baca
Route::get('kategori-produk', [KategoriProdukController::class, 'index']);
Route::get('kategori-produk/{id}', [KategoriProdukController::class, 'show']);

// 🔒 Admin: tulis & ubah
Route::middleware('auth:sanctum')->group(function () {
    Route::post('kategori-produk', [KategoriProdukController::class, 'store']);
    Route::put('kategori-produk/{id}', [KategoriProdukController::class, 'update']);
    Route::delete('kategori-produk/{id}', [KategoriProdukController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('cart', CartController::class)->except(['create', 'edit', 'show']);
});

Route::middleware('auth:sanctum')->get('/debug-user', function (Request $request) {
    return response()->json([
        'user_id' => $request->user()->id,
        'email' => $request->user()->email,
        'role' => $request->user()->role,
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('pesanan', PesananController::class);
    
    // HANYA route untuk menambah detail ke pesanan tertentu
    Route::post('pesanan/{pesanan_id}/detail-pesanan', [DetailPesananController::class, 'store']);
    
    // Opsional: lihat semua detail dari satu pesanan
    Route::get('pesanan/{pesanan_id}/detail-pesanan', [DetailPesananController::class, 'index']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pelanggan', [PelangganController::class, 'index']);
});

// 🔹 Faktur
Route::apiResource('faktur', FakturController::class);

// 🔹 Informasi Peternakan (Hanya 1 record)
Route::get('informasi-peternakan', [InformasiPeternakanController::class, 'show']);
Route::put('informasi-peternakan', [InformasiPeternakanController::class, 'update']);
Route::post('informasi-peternakan', [InformasiPeternakanController::class, 'store']);