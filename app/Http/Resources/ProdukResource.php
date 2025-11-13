<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProdukResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->produk_id,
            'nama_produk' => $this->nama_produk,
            'berat' => $this->berat,
            'harga' => $this->harga,
            'deskripsi' => $this->deskripsi,
            'foto_url' => $this->foto_url ? asset('storage/' . $this->foto_url) : null,
            'stok' => $this->stok,
            'kategori' => new KategoriProdukResource($this->kategori),
            'dibuat_oleh' => $this->createdBy ? $this->createdBy->username : null,
            'dibuat_pada' => $this->created_at,
            'diperbarui_pada' => $this->updated_at,
        ];
    }
}