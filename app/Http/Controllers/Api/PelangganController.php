<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
    if (!$user || $user->role !== 'Admin') {
        return response()->json(['message' => 'Unauthorized'], 403);
    }
        $query = User::where('role', 'Pelanggan');

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_telepon', 'like', "%{$search}%");
            });
        }

        $pelanggan = $query->orderBy('created_at', 'desc')
                          ->paginate(15); // pagination opsional

        return response()->json($pelanggan);
    }
}