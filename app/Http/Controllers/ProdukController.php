<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with(['kategori', 'createdBy'])->paginate(10);
        return view('index', compact('produk'));
    }

    public function create()
    {
        $kategori = KategoriProduk::all();
        return view('create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_produk,kategori_id',
            'nama_produk' => 'required|string|max:255',
            'berat' => 'nullable|numeric',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto_url' => 'nullable|url',
            'stok' => 'required|integer|min:0',
        ]);

        $produk = new Produk();
        $produk->kategori_id = $request->kategori_id;
        $produk->nama_produk = $request->nama_produk;
        $produk->berat = $request->berat;
        $produk->harga = $request->harga;
        $produk->deskripsi = $request->deskripsi;
        $produk->foto_url = $request->foto_url;
        $produk->stok = $request->stok;
        $produk->created_by = 1;
        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = KategoriProduk::all();
        return view('edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_produk,kategori_id',
            'nama_produk' => 'required|string|max:255',
            'berat' => 'nullable|numeric',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto_url' => 'nullable|url',
            'stok' => 'required|integer|min:0',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->kategori_id = $request->kategori_id;
        $produk->nama_produk = $request->nama_produk;
        $produk->berat = $request->berat;
        $produk->harga = $request->harga;
        $produk->deskripsi = $request->deskripsi;
        $produk->foto_url = $request->foto_url;
        $produk->stok = $request->stok;
        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('index')->with('success', 'Produk berhasil dihapus.');
    }
}