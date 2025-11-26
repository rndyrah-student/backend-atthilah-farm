<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanPesananRequest;
use App\Http\Resources\PesananResource;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $pesanan = Pesanan::where('pelanggan_id', $user->id)
                         ->with(['detail_pesanan.produk', 'faktur'])
                         ->orderBy('tanggal_pesanan', 'desc')
                         ->get();
        
        return response()->json(PesananResource::collection($pesanan));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['detail_pesanan.produk', 'faktur'])
                         ->where('pesanan_id', $id)
                         ->firstOrFail();
        
        return response()->json(new PesananResource($pesanan));
    }

    public function store(SimpanPesananRequest $request)
    {
        $data = $request->validated();
        $data['pelanggan_id'] = $request->user()->id;
        $data['status'] = 'Menunggu';
        $data['tanggal_pesanan'] = now();

        $pesanan = Pesanan::create($data);

        return response()->json(new PesananResource($pesanan), 201);
    }

    public function update(SimpanPesananRequest $request, $id)
    {
        $pesanan = Pesanan::where('pesanan_id', $id)->firstOrFail();
        
        if ($request->user()->role !== 'admin' && $request->has('status')) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $pesanan->update($request->validated());

        return response()->json(new PesananResource($pesanan));
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::where('pesanan_id', $id)->firstOrFail();
        
        if ($pesanan->pelanggan_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $pesanan->delete();

        return response()->json(['message' => 'Pesanan berhasil dihapus']);
    }
}