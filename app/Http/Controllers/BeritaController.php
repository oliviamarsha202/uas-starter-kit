<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori; // Pastikan Kategori di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    // ... method index() ...
    public function index()
    {
        $berita = Berita::with(['user', 'kategori'])->latest()->paginate(10);
        return view('berita.index', compact('berita'));
    }

    /**
     * =======================================================
     * INI ADALAH METHOD YANG KITA PERBAIKI
     * =======================================================
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        // Ambil semua data dari model Kategori
        $kategori = Kategori::all();

        // Kirim data tersebut ke view menggunakan 'compact'
        return view('berita.create', compact('kategori'));
    }

    // ... method store(), edit(), update(), destroy(), approve() ...
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $path = $request->file('gambar')->store('public/berita');
        Berita::create([
            'judul' => $request->judul, 'konten' => $request->konten, 'kategori_id' => $request->kategori_id,
            'user_id' => Auth::id(), 'gambar' => $path, 'status' => 'draft'
        ]);
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dibuat dan menunggu approval.');
    }

    public function show(Berita $berita)
    {
        return view('berita.show', compact('berita'));
    }

    public function edit(Berita $berita)
    {
        $kategori = Kategori::all();
        return view('berita.edit', ['post' => $berita, 'kategori' => $kategori]);
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255', 'konten' => 'required|string', 'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $path = $berita->gambar;
        if ($request->hasFile('gambar')) {
            if ($berita->gambar) { Storage::delete($berita->gambar); }
            $path = $request->file('gambar')->store('public/berita');
        }
        $berita->update([
            'judul' => $request->judul, 'konten' => $request->konten, 'kategori_id' => $request->kategori_id, 'gambar' => $path,
        ]);
        return redirect()->route('berita.index')->with('success', 'Berita berhasil diupdate.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) { Storage::delete($berita->gambar); }
        $berita->delete();
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function approve(Berita $berita)
    {
        $berita->update(['status' => 'published']);
        return redirect()->route('berita.index')->with('success', 'Berita berhasil di-publish.');
    }
}