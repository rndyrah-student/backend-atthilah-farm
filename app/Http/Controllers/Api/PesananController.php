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

        $query = Pesanan::with(['detail_pesanan.produk', 'faktur']);

        // Jika user adalah admin, tampilkan SEMUA pesanan
        if (strtolower($user->role) === 'admin') {
            // Tampilkan semua
        } else {
            // Jika customer, hanya tampilkan pesanan milik sendiri
            $query->where('pelanggan_id', $user->id);
        }

        $pesanan = $query->orderBy('tanggal_pesanan', 'desc')->get();
        
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
        $data['status'] = 'Menunggu Konfirmasi';
        $data['tanggal_pesanan'] = now();

        $pesanan = Pesanan::create($data);

        return response()->json(new PesananResource($pesanan), 201);
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::where('pesanan_id', $id)->firstOrFail();
        $user = $request->user();

        // Hanya admin yang boleh akses endpoint ini
        if ($user->role !== 'Admin') {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        // Validasi status
        $allowedStatuses = ['Menunggu Konfirmasi', 'Dikonfirmasi', 'Ditolak', 'Diproses', 'Selesai'];
        if ($request->has('status')) {
            if (!in_array($request->status, $allowedStatuses)) {
                return response()->json(['message' => 'Status tidak valid'], 422);
            }
            $pesanan->status = $request->status;
        }

        $pesanan->save();

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