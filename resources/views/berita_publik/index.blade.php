<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Berita - {{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100">
        {{-- Navbar Sederhana --}}
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            {{-- Logo atau Nama Situs --}}
                            <a href="{{ route('home') }}" class="font-bold text-xl">Starter Kit</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Login</a>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Konten Utama --}}
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Berita Terbaru</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($berita as $item)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                        <a href="{{ route('berita.publik.show', $item->id) }}">
<img class="w-full h-48 object-cover" src="{{ Storage::url(str_replace('public/', '', $item->gambar)) }}" alt="{{ $item->judul }}">
                        </a>
                        <div class="p-6">
                            <span class="text-sm text-gray-500 font-semibold">{{ $item->kategori->nama_kategori }}</span>
                            <h2 class="mt-2 mb-2 font-bold text-2xl text-gray-800 leading-tight">
                                <a href="{{ route('berita.publik.show', $item->id) }}" class="hover:text-indigo-600">{{ Str::limit($item->judul, 50) }}</a>
                            </h2>
                            <p class="text-sm text-gray-600">
                                Oleh {{ $item->user->name }} • {{ $item->created_at->format('d F Y') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 col-span-3 text-xl py-12">Belum ada berita yang dipublikasikan.</p>
                @endforelse
            </div>
            
            <div class="mt-8">
                {{ $berita->links() }}
            </div>
        </div>
    </body>
</html>