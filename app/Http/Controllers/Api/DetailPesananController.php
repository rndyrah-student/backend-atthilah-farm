<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanDetailPesananRequest;
use App\Http\Resources\DetailPesananResource;
use App\Models\DetailPesanan;

class DetailPesananController extends Controller
{
    public function index()
    {
        $detail_pesanan = DetailPesanan::with(['pesanan', 'produk'])->get();
        return response()->json(DetailPesananResource::collection($detail_pesanan));
    }

    public function show($id)
    {
        $detail_pesanan = DetailPesanan::with(['pesanan', 'produk'])->findOrFail($id);
        return response()->json(new DetailPesananResource($detail_pesanan));
    }

    public function store(SimpanDetailPesananRequest $request)
    {
        $data = $request->validated();
        $detail_pesanan = DetailPesanan::create($data);
        return response()->json(new DetailPesananResource($detail_pesanan), 201);
    }

    public function update(SimpanDetailPesananRequest $request, $id)
    {
        $detail_pesanan = DetailPesanan::findOrFail($id);
        $detail_pesanan->update($request->validated());
        return response()->json(new DetailPesananResource($detail_pesanan));
    }

    public function destroy($id)
    {
        $detail_pesanan = DetailPesanan::findOrFail($id);
        $detail_pesanan->delete();
        return response()->json(['message' => 'Detail pesanan berhasil dihapus']);
    }
}