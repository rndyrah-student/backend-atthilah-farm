<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailPesananResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->detail_id,
            'pesanan_id' => $this->pesanan_id,
            'produk_id' => $this->produk_id,
            'nama_produk' => $this->produk ? $this->produk->nama_produk : null,
            'jumlah' => $this->jumlah,
            'harga_satuan' => $this->harga_satuan,
            'subtotal' => $this->subtotal,
            'dibuat_pada' => $this->created_at,
            'diperbarui_pada' => $this->updated_at,
            'produk' => $this->whenLoaded('produk') ? new ProdukResource($this->produk) : null,
        ];
    }
}