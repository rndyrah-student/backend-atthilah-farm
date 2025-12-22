<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanPesananRequest;
use App\Http\Resources\PesananResource;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\DetailPesanan;
use Illuminate\Http\JsonResponse;
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

    public function store(SimpanPesananRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Pastikan user login
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        DB::beginTransaction();
        try {
            // Buat pesanan utama
            $pesanan = Pesanan::create([
                'pelanggan_id' => $user->id,
                'nama_pelanggan' => $data['nama_pelanggan'],
                'email_pelanggan' => $data['email_pelanggan'],
                'no_telepon_pelanggan' => $data['no_telepon_pelanggan'],
                'alamat_pengiriman' => $data['alamat_pengiriman'],
                'catatan' => $data['catatan'] ?? null, // ✅ nullable
                'tanggal_pesanan' => now(), // gunakan waktu saat ini
                'status' => 'Menunggu Konfirmasi',
            ]);

            // Proses setiap item dalam pesanan
            foreach ($data['produk'] as $item) {
                $produk = Produk::where('produk_id', $item['produk_id'])->first();

                if (!$produk) {
                    throw new \Exception("Produk dengan ID {$item['produk_id']} tidak ditemukan.");
                }

                if ($produk->stok < $item['jumlah']) {
                    throw new \Exception("Stok {$produk->nama_produk} tidak mencukupi.");
                }

                // Kurangi stok
                $produk->decrement('stok', $item['jumlah']);

                // Hitung subtotal
                $subtotal = $produk->harga * $item['jumlah'];

                // Simpan detail pesanan
                $pesanan->detail_pesanan()->create([
                    'produk_id' => $produk->produk_id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $produk->harga,
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Pesanan berhasil dibuat',
                'pesanan_id' => $pesanan->pesanan_id // sesuai nama kolom PK
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
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