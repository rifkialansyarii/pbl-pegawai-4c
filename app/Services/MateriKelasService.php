<?php

namespace App\Services;

use App\Models\Dosen;
use App\Models\MateriKelas;
use App\Models\PesertaKelasMk;
use Illuminate\Support\Facades\Storage;

class MateriKelasService
{
    private function getDosen($userId)
    {
        return Dosen::where('id_user', $userId)->firstOrFail();
    }

    private function validateKelasOwnership($dosen, $idKelas, $idMk)
{
    $kelasDimiliki = PesertaKelasMk::where('id_kelas', (string) $idKelas)
        ->where('id_mk', (string) $idMk)
        ->where('id_pegawai', (int) $dosen->id_pegawai)
        ->exists();

    if (!$kelasDimiliki) {
        abort(403, 'Anda tidak memiliki akses ke kelas dan mata kuliah ini');
    }
}

    public function getAll($userId)
    {
        $dosen = $this->getDosen($userId);

        return MateriKelas::where('id_dosen', $dosen->id_dosen)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getById($userId, $id)
    {
        $dosen = $this->getDosen($userId);

        return MateriKelas::where('id_dosen', $dosen->id_dosen)
            ->where('id_materi', $id)
            ->firstOrFail();
    }

    public function create($userId, $data, $file = null)
    {
        $dosen = $this->getDosen($userId);

        $this->validateKelasOwnership($dosen, $data['id_kelas'], $data['id_mk']);

        if ($file) {
            $data['file_path'] = $file->store('materi', 'public');
        }

        $data['id_dosen'] = $dosen->id_dosen;

        return MateriKelas::create($data);
    }

    public function update($userId, $id, $data, $file = null)
    {
        $dosen = $this->getDosen($userId);

        $materi = $this->getById($userId, $id);

        if (isset($data['id_kelas']) || isset($data['id_mk'])) {
            $idKelas = $data['id_kelas'] ?? $materi->id_kelas; 
            $idMk = $data['id_mk'] ?? $materi->id_mk;
        
            $this->validateKelasOwnership($dosen, $idKelas, $idMk);
        }

        if ($file) {
            if ($materi->file_path) {
                Storage::disk('public')->delete($materi->file_path);
            }

            $data['file_path'] = $file->store('materi', 'public');
        }

        $materi->update($data);

        return $materi;
    }

    public function delete($userId, $id)
    {
        $materi = $this->getById($userId, $id);

        if ($materi->file_path) {
            Storage::disk('public')->delete($materi->file_path);
        }

        $materi->delete();

        return ['message' => 'Materi berhasil dihapus'];
    }
}