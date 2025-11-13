<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\KategoriProdukController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\DetailPesananController;
use App\Http\Controllers\Api\FakturController;
use App\Http\Controllers\Api\InformasiPeternakanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 🔹 Produk
Route::apiResource('produk', ProdukController::class);

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
