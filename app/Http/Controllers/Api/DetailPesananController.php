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

    public function store(SimpanDetailPesananRequest $request)
    {
        $data = $request->validated();
        
        // Ambil harga produk untuk jaga-jaga
        $produk = Produk::findOrFail($data['produk_id']);
        $data['harga_satuan'] = $produk->harga;
        $data['subtotal'] = $data['jumlah'] * $data['harga_satuan'];

        $detail_pesanan = DetailPesanan::create($data);

        // Update total harga di pesanan
        $this->updateTotalHarga($data['pesanan_id']);

        return response()->json(new DetailPesananResource($detail_pesanan), 201);
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

        // Update total harga di pesanan
        $this->updateTotalHarga($detail_pesanan->pesanan_id);

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

        // Update total harga di pesanan
        $this->updateTotalHarga($pesanan_id);

        return response()->json(['message' => 'Detail pesanan berhasil dihapus']);
    }

    private function updateTotalHarga($pesanan_id)
    {
        $total = DetailPesanan::where('pesanan_id', $pesanan_id)
                             ->sum(DB::raw('jumlah * harga_satuan'));
        
        Pesanan::where('pesanan_id', $pesanan_id)->update(['total_harga' => $total]);
    }
}