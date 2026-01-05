<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = ['judul','deskripsi','tanggal','foto'];
    /**
     * Cast attributes to native types.
     * Ensure `tanggal` is always a Carbon date instance.
     */
    protected $casts = [
        'tanggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
