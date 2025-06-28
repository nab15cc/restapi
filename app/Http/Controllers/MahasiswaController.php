<?php

namespace App\Http\Controllers;

use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::all();

        // ✅ Bungkus dengan 'data' agar DataTables bisa baca
        return response()->json([
            'data' => MahasiswaResource::collection($mahasiswas)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:10|unique:mahasiswas',
            'nama' => 'required|string|max:255',
            'jk' => 'required|string|max:1',
            'tgl_lahir' => 'required|date',
            'jurusan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255'
        ]);

        $mahasiswa = Mahasiswa::create($request->all());

        return (new MahasiswaResource($mahasiswa))->additional([
            'success' => true,
            'message' => 'Mahasiswa created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return response()->json($mahasiswa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nim' => 'required|string|max:10|unique:mahasiswas,nim,' . $id . ',nim',
            'nama' => 'required|string|max:255',
            'jk' => 'required|string|max:1',
            'tgl_lahir' => 'required|date',
            'jurusan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255'
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->all());

        return (new MahasiswaResource($mahasiswa))->additional([
            'success' => true,
            'message' => 'Mahasiswa updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return (new MahasiswaResource($mahasiswa))->additional([
            'success' => true,
            'message' => 'Mahasiswa deleted successfully'
        ]);
    }
}
