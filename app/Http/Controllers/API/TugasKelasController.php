<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\TugasKelasService;
use Illuminate\Http\Request;

class TugasKelasController extends Controller
{
    public function index(Request $request, TugasKelasService $service)
    {
        return response()->json([
            'data' => $service->getAll($request->user()->id)
        ]);
    }

    public function show($id, Request $request, TugasKelasService $service)
    {
        return response()->json([
            'data' => $service->getById($request->user()->id, $id)
        ]);
    }

    public function store(Request $request, TugasKelasService $service)
    {
        $request->validate([
            'id_kelas' => 'required|string|max:20',
            'id_mk' => 'required|string|max:20',
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
            'file' => 'nullable|file|max:5120',
        ]);

        $tugas = $service->create(
            $request->user()->id,
            $request->only([
                'id_kelas',
                'id_mk',
                'judul',
                'deskripsi',
                'deadline'
            ]),
            $request->file('file')
        );

        return response()->json([
            'message' => 'Tugas berhasil ditambahkan',
            'data' => $tugas
        ], 201);
    }

    public function update($id, Request $request, TugasKelasService $service)
    {
        $request->validate([
            'id_kelas' => 'sometimes|string|max:20',
            'id_mk' => 'sometimes|string|max:20',
            'judul' => 'sometimes|string|max:150',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
            'file' => 'nullable|file|max:5120',
        ]);

        $tugas = $service->update(
            $request->user()->id,
            $id,
            $request->only([
                'id_kelas',
                'id_mk',
                'judul',
                'deskripsi',
                'deadline'
            ]),
            $request->file('file')
        );

        return response()->json([
            'message' => 'Tugas berhasil diperbarui',
            'data' => $tugas
        ]);
    }

    public function destroy($id, Request $request, TugasKelasService $service)
    {
        return response()->json(
            $service->delete($request->user()->id, $id)
        );
    }
}