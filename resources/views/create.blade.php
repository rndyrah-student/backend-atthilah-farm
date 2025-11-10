@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Tambah Produk Baru</h1>

    <form action="{{ route('produk.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat->kategori_id }}">{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
            @error('kategori_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            @error('nama_produk')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="berat" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
            <input type="number" step="0.01" name="berat" id="berat" value="{{ old('berat') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('berat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
            <input type="number" step="0.01" name="harga" id="harga" value="{{ old('harga') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            @error('harga')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="foto_url" class="block text-sm font-medium text-gray-700">URL Foto</label>
            <input type="url" name="foto_url" id="foto_url" value="{{ old('foto_url') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('foto_url')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
            <input type="number" name="stok" id="stok" value="{{ old('stok') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            @error('stok')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('produk.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection