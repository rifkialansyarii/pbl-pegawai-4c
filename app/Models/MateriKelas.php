<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriKelas extends Model
{
    protected $connection = 'pegawai';

    protected $table = 'materi_kelas';

    protected $primaryKey = 'id_materi';

    protected $fillable = [
        'id_dosen',
        'id_kelas',
        'id_mk',
        'id_kelas_session',
        'judul',
        'deskripsi',
        'file_path',
    ];
}