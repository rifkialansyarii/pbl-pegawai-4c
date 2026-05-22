<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;

class DosenController extends Controller
{
    public function index()
    {
        return response()->json(
            Dosen::with(['pegawai', 'user'])->get()
        );
    }

    public function show($id)
    {
        return response()->json(
            Dosen::with(['pegawai', 'user'])->findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $dosen = Dosen::create($request->all());

        return response()->json($dosen, 201);
    }

    public function update($id, Request $request)
    {
        $dosen = Dosen::findOrFail($id);

        $dosen->update($request->all());

        return response()->json($dosen);
    }

    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);

        $dosen->delete();

        return response()->json([
            'message' => 'Dosen deleted'
        ]);
    }
}