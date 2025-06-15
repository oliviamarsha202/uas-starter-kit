<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk Info Box
        $jumlah_berita = Berita::count();
        $jumlah_kategori = Kategori::count();
        $jumlah_penulis = User::where('role', 'wartawan')->count();
        $jumlah_admin = User::whereIn('role', ['admin', 'editor'])->count();

        // Data untuk Grafik: Jumlah berita per kategori
        $berita_per_kategori = Kategori::withCount('berita')
                                        ->get();
        
        // Format data untuk Chart.js
        $labels = $berita_per_kategori->pluck('nama_kategori');
        $data = $berita_per_kategori->pluck('berita_count');

        return view('dashboard', compact(
            'jumlah_berita', 
            'jumlah_kategori', 
            'jumlah_penulis',
            'jumlah_admin',
            'labels',
            'data'
        ));
    }
}