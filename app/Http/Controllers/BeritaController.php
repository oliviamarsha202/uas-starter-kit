<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * =======================================================
     * METHOD UNTUK MANAJEMEN BERITA (MEMERLUKAN LOGIN)
     * =======================================================
     */

    /**
     * Menampilkan daftar semua berita di halaman manajemen.
     */
    public function index()
    {
        $berita = Berita::with(['user', 'kategori'])->latest()->paginate(10);
        return view('berita.index', compact('berita'));
    }

    /**
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('berita.create', compact('kategori'));
    }

    /**
     * Menyimpan berita baru ke dalam database.
     */
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

    /**
     * Menampilkan detail satu berita (biasanya tidak digunakan di backend, tapi ada untuk kelengkapan).
     */
    public function show(Berita $berita)
    {
        // Anda bisa arahkan ke halaman edit atau halaman publik
        return redirect()->route('berita.edit', $berita->id);
    }

    /**
     * Menampilkan form untuk mengedit berita.
     */
    public function edit(Berita $post) // Menggunakan $post agar konsisten dengan view
    {
        $kategori = Kategori::all();
        return view('berita.edit', ['post' => $post, 'kategori' => $kategori]);
    }

    /**
     * Mengupdate data berita di database.
     */
    public function update(Request $request, Berita $post) // Menggunakan $post agar konsisten
    {
        $request->validate([
            'judul' => 'required|string|max:255', 'konten' => 'required|string', 'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $path = $post->gambar;
        if ($request->hasFile('gambar')) {
            if ($post->gambar) { Storage::delete($post->gambar); }
            $path = $request->file('gambar')->store('public/berita');
        }
        $post->update([
            'judul' => $request->judul, 'konten' => $request->konten, 'kategori_id' => $request->kategori_id, 'gambar' => $path,
        ]);
        return redirect()->route('berita.index')->with('success', 'Berita berhasil diupdate.');
    }

    /**
     * Menghapus berita dari database.
     */
    public function destroy(Berita $post) // Menggunakan $post agar konsisten
    {
        if ($post->gambar) { Storage::delete($post->gambar); }
        $post->delete();
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Menyetujui (approve) sebuah berita.
     */
    public function approve(Berita $berita)
    {
        $berita->update(['status' => 'published']);
        return redirect()->route('berita.index')->with('success', 'Berita berhasil di-publish.');
    }


    /**
     * =======================================================
     * METHOD BARU UNTUK HALAMAN PUBLIK (BISA DIAKSES SEMUA ORANG)
     * =======================================================
     */

    /**
     * Menampilkan daftar berita yang sudah di-publish untuk publik.
     */
    public function indexPublik()
    {
        $berita = Berita::where('status', 'published') // Hanya ambil yang sudah publish
                         ->with(['user', 'kategori']) // Eager loading untuk efisiensi
                         ->latest()
                         ->paginate(9); // Tampilkan 9 berita per halaman
        
        return view('berita_publik.index', compact('berita'));
    }

    /**
     * Menampilkan detail satu berita untuk publik.
     */
    public function showPublik(Berita $berita)
    {
        // Pastikan berita yang diakses sudah di-publish, jika belum, tampilkan error 404
        if ($berita->status !== 'published') {
            abort(404);
        }
        
        return view('berita_publik.show', compact('berita'));
    }
}