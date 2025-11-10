@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Daftar Produk</h1>
    <a href="{{ route('produk.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Produk</a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="min-w-full bg-white border border-gray-300 rounded-lg shadow">
    <thead>
        <tr class="bg-gray-100">
            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">ID</th>
            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Nama Produk</th>
            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Kategori</th>
            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Harga</th>
            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Stok</th>
            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Dibuat Oleh</th>
            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($produk as $item)
        <tr class="border-t">
            <td class="py-3 px-4">{{ $item->produk_id }}</td>
            <td class="py-3 px-4">{{ $item->nama_produk }}</td>
            <td class="py-3 px-4">{{ $item->kategori->nama_kategori ?? '-' }}</td>
            <td class="py-3 px-4">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
            <td class="py-3 px-4">{{ $item->stok }}</td>
            <td class="py-3 px-4">{{ $item->createdBy->nama_lengkap ?? '-' }}</td>
            <td class="py-3 px-4">
                <a href="{{ route('produk.edit', $item->produk_id) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                <form action="{{ route('produk.destroy', $item->produk_id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $produk->links() }}
</div>
@endsection