<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanPesananRequest;
use App\Http\Resources\PesananResource;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['pelanggan', 'detail_pesanan.produk', 'faktur'])->get();
        return response()->json(PesananResource::collection($pesanan));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'detail_pesanan.produk', 'faktur'])->findOrFail($id);
        return response()->json(new PesananResource($pesanan));
    }

    public function store(SimpanPesananRequest $request)
    {
        $data = $request->validated();
        $pesanan = Pesanan::create($data);
        return response()->json(new PesananResource($pesanan), 201);
    }

    public function update(SimpanPesananRequest $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update($request->validated());
        return response()->json(new PesananResource($pesanan));
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();
        return response()->json(['message' => 'Pesanan berhasil dihapus']);
    }
}