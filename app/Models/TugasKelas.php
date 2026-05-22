<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasKelas extends Model
{
    protected $connection = 'pegawai';

    protected $table = 'tugas_kelas';

    protected $primaryKey = 'id_tugas';

    protected $fillable = [
        'id_dosen',
        'id_kelas',
        'id_mk',
        'judul',
        'deskripsi',
        'deadline',
        'file_path',
    ];
}