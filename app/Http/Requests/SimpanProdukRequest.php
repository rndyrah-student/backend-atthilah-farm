<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanProdukRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        \Log::info('Request Validation Data:', $this->all());

        return [
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_produk,kategori_id',
            'berat' => 'nullable|numeric',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'foto_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'stok' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'nama_produk.required' => 'Nama produk harus diisi.',
            'kategori_id.required' => 'Kategori produk harus dipilih.',
            'harga.required' => 'Harga produk harus diisi.',
            'foto_url.image' => 'File harus berupa gambar.',
            'stok.required' => 'Stok produk harus diisi.',
            'created_by.exists' => 'User tidak ditemukan.'           
        ];
    }
}