<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function index(Request $request)
{
    $query = Tugas::query();

    if ($request->has('namaTugas')) {
        $query->where('namaTugas', 'like', '%' . $request->namaTugas . '%');
    }

    return $query->get();
}

    public function store(Request $request)
    {
        $request->validate([
            'namaTugas' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsiTugas' => 'required|date',
        ]);

        $path = $request->file('gambar')->store('tugas', 'public');
        $email = $request->header("Authorization");

        $tugas = Tugas::create([
            'email' => '$email',
            'namaTugas' => $request->namaTugas,
            'gambar' => $path,
            'deskripsiTugas' => $request->deskripsiTugas,
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Data berhasil masuk."
        ]);
    }

    public function show($id)
    {
        return Tugas::findOrFail($id);
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        Storage::disk('public')->delete($tugas->gambar);
        $tugas->delete();

        return response()->json(null, 204);
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'namaTugas' => 'sometimes|required|string|max:255',
        'gambar' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        'deskripsiTugas' => 'sometimes|required|date',
    ]);

    $tugas = Tugas::findOrFail($id);

    if ($request->hasFile('gambar')) {
        Storage::disk('public')->delete($tugas->gambar);
        $path = $request->file('gambar')->store('tugas', 'public');
        $tugas->gambar = $path;
    }

    if ($request->has('namaTugas')) {
        $tugas->namaTugas = $request->namaTugas;
    }

    if ($request->has('deskripsiTugas')) {
        $tugas->deskripsiTugas = $request->deskripsiTugas;
    }

    $tugas->save();

    return response()->json($tugas);
}
}
