<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan semua item di keranjang user yang login.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('produk')->get();
        return response()->json($cartItems);
    }

    /**
     * Tambah item ke keranjang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,produk_id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produkId = $request->produk_id;
        $jumlah = $request->jumlah;
        $userId = Auth::id();

        // Cek apakah produk sudah ada di keranjang
        $existing = Cart::where('user_id', $userId)
                        ->where('produk_id', $produkId)
                        ->first();

        if ($existing) {
            // Jika ada, tambah jumlahnya
            $existing->jumlah += $jumlah;
            $existing->save();
        } else {
            // Jika belum, buat baru
            Cart::create([
                'user_id' => $userId,
                'produk_id' => $produkId,
                'jumlah' => $jumlah,
            ]);
        }

        return response()->json(['message' => 'Produk ditambahkan ke keranjang'], 201);
    }

    /**
     * Update jumlah item di keranjang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        $cartItem->jumlah = $request->jumlah;
        $cartItem->save();

        return response()->json(['message' => 'Keranjang diperbarui']);
    }

    /**
     * Hapus item dari keranjang.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $cartItem = Cart::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        $cartItem->delete();

        return response()->json(['message' => 'Produk dihapus dari keranjang']);
    }
}