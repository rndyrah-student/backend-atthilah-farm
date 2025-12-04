<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanDetailPesananRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'produk_id' => 'required|exists:produk,produk_id',
            'jumlah' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'pesanan_id.exists' => 'Pesanan tidak ditemukan.',
            'produk_id.exists' => 'Produk tidak ditemukan.',
            'jumlah.min' => 'Jumlah minimal 1.',
        ];
    }
}