<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanPesananRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

public function rules()
{
    return [
        'nama_pelanggan' => 'required|string|max:255',
        'email_pelanggan' => 'required|email|max:255',
        'no_telepon_pelanggan' => 'required|string|max:20',
        'alamat_pengiriman' => 'required|string|max:500',
        'catatan' => 'nullable|string|max:500',
        'produk' => 'required|array|min:1',
        'produk.*.produk_id' => 'required|exists:produk,produk_id',
        'produk.*.jumlah' => 'required|integer|min:1',
    ];
}


    public function messages()
    {
        return [
            'nama_pelanggan.required' => 'Nama pelanggan harus diisi.',
            'email_pelanggan.required' => 'Email pelanggan harus diisi.',
            'no_telepon_pelanggan.required' => 'No telepon pelanggan harus diisi.',
            'alamat_pengiriman.required' => 'Alamat pengiriman harus diisi.',
        ];
    }
}