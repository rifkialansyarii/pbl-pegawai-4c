<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $connection = 'pegawai';

    protected $table = 'dosen';

    protected $primaryKey = 'id_dosen';

    protected $fillable = [
        'id_pegawai',
        'id_user',
        'nama_dosen',
        'panggilan',
        'jk',
        'nidn',
        'nip_baru',
        'email',
        'alamat',
        'id_jurusan',
        'id_prodi',
        'status_aktif',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}