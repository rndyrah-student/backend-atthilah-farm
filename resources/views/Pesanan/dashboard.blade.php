@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-start mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Pesanan #{{ $pesanan->id }}</h2>
        <a href="{{ route('pesanan.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
    
    <!-- Info Umum -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <p class="text-sm text-gray-500">Status</p>
            <p class="font-semibold">
                @if($pesanan->status === 'Menunggu Konfirmasi')
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Menunggu Konfirmasi</span>
                @elseif($pesanan->status === 'Dikonfirmasi')
                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Dikonfirmasi</span>
                @elseif($pesanan->status === 'Selesai')
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Selesai</span>
                @else
                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Ditolak</span>
                @endif
            </p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Tanggal Pesanan</p>
            <p class="font-semibold">{{ $pesanan->created_at->format('d M Y H:i') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Nama Pelanggan</p>
            <p class="font-semibold">{{ $pesanan->nama_pelanggan }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Email</p>
            <p>{{ $pesanan->email_pelanggan ?: '-' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">No. Telepon</p>
            <p>{{ $pesanan->no_telepon_pelanggan ?: '-' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Harga</p>
            <p class="font-bold text-green-600">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Alamat -->
    <div class="mb-6">
        <p class="text-sm text-gray-500 mb-1">Alamat Pengiriman</p>
        <p class="font-semibold">{{ $pesanan->alamat_pengiriman }}</p>
    </div>

    <!-- Produk -->
    <div class="mb-6">
        <p class="text-sm text-gray-500 mb-3">Detail Produk</p>
        <div class="border rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Produk</th>
                        <th class="px-4 py-2 text-center">Jumlah</th>
                        <th class="px-4 py-2 text-right">Harga</th>
                        <th class="px-4 py-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($pesanan->detail_pesanan as $detail)
                    <tr>
                        <td class="px-4 py-3">{{ $detail->produk->nama_produk }}</td>
                        <td class="px-4 py-3 text-center">{{ $detail->jumlah }}</td>
                        <td class="px-4 py-3 text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right">Total:</td>
                        <td class="px-4 py-3 text-right text-green-600 text-lg">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Catatan -->
    @if($pesanan->catatan)
    <div class="mb-6">
        <p class="text-sm text-gray-500 mb-1">Catatan</p>
        <p class="text-gray-700">{{ $pesanan->catatan }}</p>
    </div>
    @endif

    <!-- Update Status -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-3">Update Status</h3>
        <form method="POST" action="{{ route('pesanan.status', $pesanan->id) }}">
            @csrf
            @method('PATCH')
            <div class="flex items-end gap-3">
                <div class="flex-1">
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="Menunggu Konfirmasi" {{ $pesanan->status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="Dikonfirmasi" {{ $pesanan->status == 'Dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                        <option value="Ditolak" {{ $pesanan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg">
                    Update Status
                </button>
            </div>
        </form>
    </div>

    <!-- Aksi -->
    <div class="flex space-x-3 pt-4 border-t">
        <a href="{{ route('pesanan.edit', $pesanan->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
            <i class="fas fa-edit mr-2"></i> Edit
        </a>
        <form method="POST" action="{{ route('pesanan.destroy', $pesanan->id) }}" onsubmit="return confirm('Hapus pesanan ini? Data tidak bisa dikembalikan.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">
                <i class="fas fa-trash mr-2"></i> Hapus
            </button>
        </form>
    </div>
</div>
@endsection