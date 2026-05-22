<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\MateriKelasService;
use Illuminate\Http\Request;

class MateriKelasController extends Controller
{
    public function index(Request $request, MateriKelasService $service)
    {
        return response()->json([
            'data' => $service->getAll($request->user()->id)
        ]);
    }

    public function show($id, Request $request, MateriKelasService $service)
    {
        return response()->json([
            'data' => $service->getById($request->user()->id, $id)
        ]);
    }

    public function store(Request $request, MateriKelasService $service)
    {
        $request->validate([
            'id_kelas' => 'required|string|max:20',
            'id_mk' => 'required|string|max:20',
            'id_kelas_session' => 'nullable|integer',
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|max:5120',
        ]);

        $materi = $service->create(
            $request->user()->id,
            $request->only([
                'id_kelas',
                'id_mk',
                'id_kelas_session',
                'judul',
                'deskripsi'
            ]),
            $request->file('file')
        );

        return response()->json([
            'message' => 'Materi berhasil ditambahkan',
            'data' => $materi
        ], 201);
    }

    public function update($id, Request $request, MateriKelasService $service)
    {
        $request->validate([
            'id_kelas' => 'sometimes|string|max:20',
            'id_mk' => 'sometimes|string|max:20',
            'id_kelas_session' => 'nullable|integer',
            'judul' => 'sometimes|string|max:150',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|max:5120',
        ]);

        $materi = $service->update(
            $request->user()->id,
            $id,
            $request->only([
                'id_kelas',
                'id_mk',
                'id_kelas_session',
                'judul',
                'deskripsi'
            ]),
            $request->file('file')
        );

        return response()->json([
            'message' => 'Materi berhasil diperbarui',
            'data' => $materi
        ]);
    }

    public function destroy($id, Request $request, MateriKelasService $service)
    {
        return response()->json(
            $service->delete($request->user()->id, $id)
        );
    }
}