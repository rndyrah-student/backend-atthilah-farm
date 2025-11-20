<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PesananResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->pesanan_id,
            'nomor_pesanan' => 'ORD-' . date('Y') . '-' . str_pad($this->pesanan_id, 3, '0', STR_PAD_LEFT),
            'pelanggan_id' => $this->pelanggan_id,
            'nama_pelanggan' => $this->nama_pelanggan,
            'email_pelanggan' => $this->email_pelanggan,
            'no_telepon_pelanggan' => $this->no_telepon_pelanggan,
            'alamat_pengiriman' => $this->alamat_pengiriman,
            'tanggal_pesanan' => $this->tanggal_pesanan,
            'total_harga' => $this->total_harga,
            'status' => $this->status,
            'catatan' => $this->catatan,
            'dibuat_pada' => $this->created_at,
            'diperbarui_pada' => $this->updated_at,
            'detail_pesanan' => DetailPesananResource::collection($this->whenLoaded('detail_pesanan')),
            'faktur' => $this->whenLoaded('faktur') ? new FakturResource($this->faktur) : null,
        ];
    }
}