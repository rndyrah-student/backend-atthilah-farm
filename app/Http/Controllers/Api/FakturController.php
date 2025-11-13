<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpanFakturRequest;
use App\Http\Resources\FakturResource;
use App\Models\Faktur;

class FakturController extends Controller
{
    public function index()
    {
        $faktur = Faktur::with('pesanan')->get();
        return response()->json(FakturResource::collection($faktur));
    }

    public function show($id)
    {
        $faktur = Faktur::with('pesanan')->findOrFail($id);
        return response()->json(new FakturResource($faktur));
    }

    public function store(SimpanFakturRequest $request)
    {
        $data = $request->validated();
        $faktur = Faktur::create($data);
        return response()->json(new FakturResource($faktur), 201);
    }

    public function update(SimpanFakturRequest $request, $id)
    {
        $faktur = Faktur::findOrFail($id);
        $faktur->update($request->validated());
        return response()->json(new FakturResource($faktur));
    }

    public function destroy($id)
    {
        $faktur = Faktur::findOrFail($id);
        $faktur->delete();
        return response()->json(['message' => 'Faktur berhasil dihapus']);
    }
}