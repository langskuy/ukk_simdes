<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;

class KegiatanController extends Controller
{
    /**
     * Display a listing of kegiatan for public
     */
    public function index()
    {
        $kegiatans = Kegiatan::latest()->paginate(12);
        return view('kegiatan.index', compact('kegiatans'));
    }

    /**
     * Display the specified kegiatan
     */
    public function show(Kegiatan $kegiatan)
    {
        return view('kegiatan.show', compact('kegiatan'));
    }
}
