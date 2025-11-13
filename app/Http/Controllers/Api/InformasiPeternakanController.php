<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanInformasiPeternakanRequest;
use App\Http\Resources\InformasiPeternakanResource;
use App\Models\InformasiPeternakan;

class InformasiPeternakanController extends Controller
{
    public function show()
    {
        $info = InformasiPeternakan::first(); // karena cuma 1 record
        if (!$info) {
            return response()->json(['message' => 'Informasi peternakan belum diatur'], 404);
        }
        return response()->json(new InformasiPeternakanResource($info));
    }

    public function store(SimpanInformasiPeternakanRequest $request)
    {
        $info = InformasiPeternakan::create($request->validated());
        return response()->json(new InformasiPeternakanResource($info), 201);
    }

    public function update(SimpanInformasiPeternakanRequest $request)
    {
        $info = InformasiPeternakan::first();
        if (!$info) {
            return response()->json(['message' => 'Informasi peternakan belum ditemukan'], 404);
        }
        $info->update($request->validated());
        return response()->json(new InformasiPeternakanResource($info));
    }
}