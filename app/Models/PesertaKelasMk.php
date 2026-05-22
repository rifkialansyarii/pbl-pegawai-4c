<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaKelasMk extends Model
{
    protected $connection = 'pegawai';
    protected $table = 'peserta_kelas_mk';
    protected $primaryKey = 'id_peserta_kelas_mk';

    protected $fillable = [
        'id_kelas',
        'id_mk',
        'id_pegawai',
        'no_urut',
        'nim',
        'nama',
    ];
}