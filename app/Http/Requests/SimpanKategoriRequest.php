<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanKategoriRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        \Log::info('Request Validation Data:', $this->all());
        
        return [
            'nama_kategori' => 'required|string|max:255|unique:kategori_produk,nama_kategori',
            'deskripsi' => 'nullable|string'
        ];
    }
}