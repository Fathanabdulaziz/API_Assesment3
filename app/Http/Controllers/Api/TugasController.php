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
        $userId = $request->header('Authorization');

        if ($userId) {
            $data = Tugas::where('email', $userId)
                ->orWhereNull('email')
                ->get()
                ->map(function ($item) use ($userId) {
                    $item->mine = $item->email === $userId ? 1 : 0;
                    return $item;
                });
        } else {
            $data = Tugas::whereNull('email')
                ->get()
                ->map(function ($item) {
                    $item->mine = 0;
                    return $item;
                });
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaTugas' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsiTugas' => 'required|date',
        ]);

        $path = $request->file('image')->store('tugas', 'public');
        $email = $request->header("Authorization");

        $tugas = Tugas::create([
            'email' => $email,
            'namaTugas' => $request->namaTugas,
            'image' => $path,
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
        Storage::disk('public')->delete($tugas->image);
        $tugas->delete();

        return response()->json(null, 204);
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'namaTugas' => 'sometimes|required|string|max:255',
        'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        'deskripsiTugas' => 'sometimes|required|date',
    ]);

    $tugas = Tugas::findOrFail($id);

    if ($request->hasFile('image')) {
        Storage::disk('public')->delete($tugas->image);
        $path = $request->file('image')->store('tugas', 'public');
        $tugas->image = $path;
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
