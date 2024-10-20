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

        $buku = Buku::create( $request->all());


        return response() ->json([
            'message' => 'Buku berhasil ditambah',
            'data' => $buku], 201);
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
