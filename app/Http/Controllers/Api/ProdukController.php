<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanProdukRequest;
use App\Http\Resources\ProdukResource;
use App\Models\Produk;

class ProdukController extends Controller
{
    // 🔹 Ambil semua produk
    public function index()
    {
        $produk = Produk::with('kategori')->get();
        return response()->json(ProdukResource::collection($produk));
    }

    // 🔹 Ambil satu produk berdasarkan ID
    public function show($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);
        return response()->json(new ProdukResource($produk));
    }

    // 🔹 Tambah produk baru
    public function store(SimpanProdukRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('foto_url')) {
            $path = $request->file('foto_url')->store('produk', 'public');
            $data['foto_url'] = $path;
        }

        $produk = Produk::create($data);

        return response()->json(new ProdukResource($produk), 201);
    }

    // 🔹 Update produk
    public function update(SimpanProdukRequest $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('foto_url')) {
            $path = $request->file('foto_url')->store('produk', 'public');
            $data['foto_url'] = $path;
        }

        $produk->update($data);

        return response()->json(new ProdukResource($produk));
    }

    // 🔹 Hapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}