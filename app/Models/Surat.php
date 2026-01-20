<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pemohon',
        'nik',
        'no_hp',
        'jenis_surat',
        'keterangan',
        'status',
        'tanggal_selesai',
        'file_surat',
        'lampiran'
    ];

    protected $casts = [
        'tanggal_selesai' => 'date',
        'lampiran' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
