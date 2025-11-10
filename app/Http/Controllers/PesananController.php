<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\User;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar pesanan dengan pencarian dan statistik.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = Pesanan::with(['pelanggan', 'detail_pesanan.produk']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('alamat_pengiriman', 'like', "%{$search}%")
                  ->orWhere('pesanan_id', $search);
            });
        }

        $pesanan = $query->latest()->paginate(10);

        $stats = [
            'total' => Pesanan::count(),
            'menunggu' => Pesanan::where('status', 'Menunggu Konfirmasi')->count(),
            'dikonfirmasi' => Pesanan::where('status', 'Dikonfirmasi')->count(),
            'selesai' => Pesanan::where('status', 'Selesai')->count(),
        ];

        return view('pesanan.index', compact('pesanan', 'stats', 'search'));
    }

    /**
     * Menampilkan form tambah pesanan.
     */
    public function create()
    {
        $pelanggan = User::where('role', 'Pelanggan')->get();
        $produk = Produk::all();
        return view('pesanan.create', compact('pelanggan', 'produk'));
    }

    /**
     * Menyimpan pesanan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:user,user_id',
            'nama_pelanggan' => 'required|string',
            'alamat_pengiriman' => 'required|string',
            'produk_id' => 'required|array',
            'produk_id.*' => 'exists:produk,produk_id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
        ]);

        // Hitung total harga
        $total = 0;
        foreach ($request->produk_id as $index => $produk_id) {
            if (!$produk_id || !$request->jumlah[$index]) continue;
            $produk = Produk::find($produk_id);
            if (!$produk) continue;
            $total += $produk->harga * $request->jumlah[$index];
        }
        
        $pesanan = Pesanan::create([
            'pelanggan_id' => $request->pelanggan_id,
            'nama_pelanggan' => $request->nama_pelanggan,
            'email_pelanggan' => $request->email_pelanggan,
            'no_telepon_pelanggan' => $request->no_telepon_pelanggan,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'catatan' => $request->catatan,
            'total_harga' => $total,
            'status' => 'Menunggu Konfirmasi',
            'tanggal_pesanan' => now(),
        ]);

        // Simpan detail pesanan
        foreach ($request->produk_id as $index => $produk_id) {
            if (!$produk_id || !$request->jumlah[$index]) continue;
            $produk = Produk::find($produk_id);
            if (!$produk) continue;

            DetailPesanan::create([
                'pesanan_id' => $pesanan->pesanan_id,
                'produk_id' => $produk_id,
                'jumlah' => $request->jumlah[$index],
                'harga_satuan' => $produk->harga,
                'subtotal' => $produk->harga * $request->jumlah[$index],
            ]);
        }

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'detail_pesanan.produk'])->findOrFail($id);
        return view('pesanan.show', compact('pesanan'));
    }

    /**
     * Menampilkan form edit pesanan.
     */
    public function edit($id)
    {
        $pesanan = Pesanan::with('detail_pesanan')->findOrFail($id);
        $pelanggan = User::where('role', 'Pelanggan')->get();
        $produk = Produk::all();
        return view('pesanan.edit', compact('pesanan', 'pelanggan', 'produk'));
    }

    /**
     * Memperbarui pesanan.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:user,user_id',
            'nama_pelanggan' => 'required|string',
            'alamat_pengiriman' => 'required|string',
            'produk_id' => 'required|array',
            'produk_id.*' => 'exists:produk,produk_id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        // Hapus detail lama
        $pesanan->detail_pesanan()->delete();

        // Hitung ulang total
        $total = 0;
        foreach ($request->produk_id as $index => $produk_id) {
            if (!$produk_id || !$request->jumlah[$index]) continue;
            $produk = Produk::find($produk_id);
            if (!$produk) continue;
            $total += $produk->harga * $request->jumlah[$index];
        }

        $pesanan->update([
            'pelanggan_id' => $request->pelanggan_id,
            'nama_pelanggan' => $request->nama_pelanggan,
            'email_pelanggan' => $request->email_pelanggan,
            'no_telepon_pelanggan' => $request->no_telepon_pelanggan,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'catatan' => $request->catatan,
            'total_harga' => $total,
        ]);

        // Simpan detail baru
        foreach ($request->produk_id as $index => $produk_id) {
            if (!$produk_id || !$request->jumlah[$index]) continue;
            $produk = Produk::find($produk_id);
            if (!$produk) continue;

            DetailPesanan::create([
                'pesanan_id' => $pesanan->pesanan_id,
                'produk_id' => $produk_id,
                'jumlah' => $request->jumlah[$index],
                'harga_satuan' => $produk->harga,
                'subtotal' => $produk->harga * $request->jumlah[$index],
            ]);
        }

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diperbarui!');
    }

    /**
     * Menghapus pesanan.
     */
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->detail_pesanan()->delete();
        $pesanan->delete();

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    /**
     * Memperbarui status pesanan (via form di halaman detail).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Konfirmasi,Dikonfirmasi,Ditolak,Selesai'
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diubah!');
    }
}