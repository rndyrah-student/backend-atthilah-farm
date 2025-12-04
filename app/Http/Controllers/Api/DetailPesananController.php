<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanDetailPesananRequest;
use App\Http\Resources\DetailPesananResource;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DetailPesananController extends Controller
{
    public function index(Request $request)
    {
        // Ambil detail pesanan user yang login
        $detail_pesanan = DetailPesanan::whereHas('pesanan', function($q) use ($request) {
                                $q->where('pelanggan_id', $request->user()->id);
                            })
                            ->with(['pesanan', 'produk'])
                            ->get();
        
        return response()->json(DetailPesananResource::collection($detail_pesanan));
    }

    public function show($id)
    {
        $detail_pesanan = DetailPesanan::with(['pesanan', 'produk'])
                                      ->where('detail_id', $id)
                                      ->firstOrFail();
        
        return response()->json(new DetailPesananResource($detail_pesanan));
    }

    public function store(Request $request, $pesanan_id) // ← dapatkan dari URL
    {
        // ✅ Validasi HANYA field yang dikirim user
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|exists:produk,produk_id',
            'jumlah'    => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // ✅ Ambil harga_satuan dari database (bukan dari request)
        $produk = Produk::findOrFail($request->produk_id);
        $harga_satuan = $produk->harga; // atau $produk->harga, sesuaikan dengan field di modelmu

        // ✅ Gunakan $pesanan_id dari parameter URL
        // (opsional: verifikasi apakah pesanan ini milik user yang login)
        $pesanan = Pesanan::where('pesanan_id', $pesanan_id)
                        ->where('pelanggan_id', $request->user()->id)
                        ->firstOrFail();

        // Cek apakah item sudah ada → update jumlah
        $detail = DetailPesanan::where('pesanan_id', $pesanan_id)
                            ->where('produk_id', $request->produk_id)
                            ->first();

        if ($detail) {
            $detail->jumlah += $request->jumlah;
            $detail->save();
        } else {
            $subtotal = $request->jumlah * $harga_satuan;
            DetailPesanan::create([
                'pesanan_id'   => $pesanan_id,   // ← dari URL
                'produk_id'    => $request->produk_id,
                'jumlah'       => $request->jumlah,
                'harga_satuan' => $harga_satuan, // ← dari database
                'subtotal' => $subtotal,
            ]);
        }

        return response()->json(['message' => 'Item berhasil ditambahkan ke pesanan'], 201);
    }

    public function update(SimpanDetailPesananRequest $request, $id)
    {
        $detail_pesanan = DetailPesanan::where('detail_id', $id)->firstOrFail();
        
        // Hanya admin atau pembuat pesanan yang bisa edit
        if ($detail_pesanan->pesanan->pelanggan_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $data = $request->validated();
        $data['subtotal'] = $data['jumlah'] * $data['harga_satuan'];
        
        $detail_pesanan->update($data);

        return response()->json(new DetailPesananResource($detail_pesanan));
    }

    public function destroy($id)
    {
        $detail_pesanan = DetailPesanan::where('detail_id', $id)->firstOrFail();
        
        // Hanya admin atau pembuat pesanan yang bisa hapus
        if ($detail_pesanan->pesanan->pelanggan_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $pesanan_id = $detail_pesanan->pesanan_id;
        $detail_pesanan->delete();
    }
}