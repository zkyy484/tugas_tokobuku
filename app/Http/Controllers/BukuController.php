<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        return Buku::all();
    }

    public function store(Request $request)
    {

        $request->validate([
            'judul' => 'required|string|min:1',
            'penulis' => 'required|string',
            'harga' => 'required|numeric|min:1000',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        if (empty($request->judul)) {
            return response()->json([
                'pesan' => 'Kolom tidak boleh kosong',
            ], 404);
        }

        if ($request->harga < 1000) {
            return response()->json([
                'pesan' => 'Harga tidak boleh kurang dari 1000',
            ], 404);
        }

        $buku = Buku::create( $request->all());


        return response() ->json([
            'message' => 'Buku berhasil ditambah',
            'data' => $buku], 201);
    }

    // mencari data sesuai dengan kategori idnya
    public function cari($idk) {
        $bukus = Buku::where('kategori_id', $idk)->get();

        if ($bukus->isEmpty()) {
            return response()->json([
                "pesan" => "tidak ditemukan kategori yang sesuai"
            ], 484);
        }

        return response()->json($bukus, 200);
    }

    public function show(string $id)
    {
        return Buku::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'nullable|string|min:1',
            'penulis' => 'nullable|string',
            'harga' => 'nullable|numeric|min:1000',
            'stok' => 'nullable|integer',
            'kategori_id' => 'nullable|exists:kategoris,id',
        ]);

        $buku = Buku::findOrFail($id);
        $buku ->update($request->all());

        return response()->json($buku, 200);
    }

    public function destroy(string $id)
    {
        Buku::findOrFail($id)->delete();
        return response()->json("Data berhasil dihapus", 201);
    }
}
