<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','nama_pelapor','nik','no_hp','judul','isi','lampiran','status'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
