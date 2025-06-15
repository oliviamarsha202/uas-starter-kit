<x-guest-layout>
    <div class="container mx-auto px-4 py-8">
        <article class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $berita->judul }}</h1>
            <p class="text-gray-500 mb-4">
                Kategori: <span class="font-semibold">{{ $berita->kategori->nama_kategori }}</span> | 
                Oleh: <span class="font-semibold">{{ $berita->user->name }}</span> | 
                Dipublikasikan pada: <span class="font-semibold">{{ $berita->created_at->format('d F Y') }}</span>
            </p>
            
<img class="w-full h-96 object-cover rounded-lg mb-8" src="{{ Storage::url(str_replace('public/', '', $berita->gambar)) }}" alt="{{ $berita->judul }}">
            
            <div class="prose max-w-none text-gray-800">
                {!! nl2br(e($berita->konten)) !!}
            </div>

            <div class="mt-8">
                <a href="{{ route('berita.publik.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">← Kembali ke Daftar Berita</a>
            </div>
        </article>
    </div>
</x-guest-layout>