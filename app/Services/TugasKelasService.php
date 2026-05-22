<?php

namespace App\Services;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\TugasKelas;
use App\Models\PesertaKelasMk;
use Illuminate\Support\Facades\Storage;

class TugasKelasService
{
    private function getDosen($userId)
    {
        return Dosen::where('id_user', $userId)->firstOrFail();
    }

    private function validateKelasOwnership($dosen, $idKelas, $idMk)
{
    $kelasDimiliki = PesertaKelasMk::where('id_kelas', $idKelas)
        ->where('id_mk', $idMk)
        ->where('id_pegawai', $dosen->id_pegawai)
        ->exists();

    if (!$kelasDimiliki) {
        abort(403, 'Anda tidak memiliki akses ke kelas dan mata kuliah ini');
    }
}

    public function getAll($userId)
    {
        $dosen = $this->getDosen($userId);

        return TugasKelas::where('id_dosen', $dosen->id_dosen)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getById($userId, $id)
    {
        $dosen = $this->getDosen($userId);

        return TugasKelas::where('id_dosen', $dosen->id_dosen)
            ->where('id_tugas', $id)
            ->firstOrFail();
    }

    public function create($userId, $data, $file = null)
    {
        $dosen = $this->getDosen($userId);

        $this->validateKelasOwnership($dosen, $data['id_kelas'], $data['id_mk']);

        if ($file) {
            $data['file_path'] = $file->store('tugas', 'public');
        }

        $data['id_dosen'] = $dosen->id_dosen;

        return TugasKelas::create($data);
    }

    public function update($userId, $id, $data, $file = null)
    {
        $dosen = $this->getDosen($userId);

        $tugas = $this->getById($userId, $id);

        if (isset($data['id_kelas']) || isset($data['id_mk'])) {
            $idKelas = $data['id_kelas'] ?? $tugas->id_kelas; 
            $idMk = $data['id_mk'] ?? $tugas->id_mk;
        
            $this->validateKelasOwnership($dosen, $idKelas, $idMk);
        }

        if ($file) {
            if ($tugas->file_path) {
                Storage::disk('public')->delete($tugas->file_path);
            }

            $data['file_path'] = $file->store('tugas', 'public');
        }

        $tugas->update($data);

        return $tugas;
    }

    public function delete($userId, $id)
    {
        $tugas = $this->getById($userId, $id);

        if ($tugas->file_path) {
            Storage::disk('public')->delete($tugas->file_path);
        }

        $tugas->delete();

        return ['message' => 'Tugas berhasil dihapus'];
    }
}