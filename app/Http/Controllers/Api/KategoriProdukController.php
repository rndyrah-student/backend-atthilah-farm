<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanKategoriRequest;
use App\Http\Resources\KategoriProdukResource;
use App\Models\KategoriProduk;

class KategoriProdukController extends Controller
{
    public function index()
    {
        $kategori = KategoriProduk::all();
        return response()->json(KategoriProdukResource::collection($kategori));
    }

    public function show($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        return response()->json(new KategoriProdukResource($kategori));
    }

    public function store(SimpanKategoriRequest $request)
    {
        $kategori = KategoriProduk::create($request->validated());
        return response()->json(new KategoriProdukResource($kategori), 201);
    }

    public function update(SimpanKategoriRequest $request, $id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        $kategori->update($request->validated());
        return response()->json(new KategoriProdukResource($kategori));
    }

    public function destroy($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        $kategori->delete();
        return response()->json(['message' => 'Kategori produk berhasil dihapus']);
    }
}