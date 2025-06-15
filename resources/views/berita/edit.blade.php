@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Edit Berita</h3>
    </div>
    
    {{-- Menggunakan variabel $post yang dikirim dari controller --}}
    <form action="{{ route('berita.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="judul">Judul Berita</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $post->judul) }}">
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="form-group">
                <label for="kategori_id">Kategori</label>
                <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ old('kategori_id', $post->kategori_id) == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="konten">Konten</label>
                <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten" rows="5">{{ old('konten', $post->konten) }}</textarea>
                @error('konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Unggulan</label>
                <div class="mb-2">
                    <img src="{{ Storage::url($post->gambar) }}" alt="Gambar saat ini" width="150">
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror" id="gambar" name="gambar">
                        <label class="custom-file-label" for="gambar">Pilih file baru...</label>
                    </div>
                </div>
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                @error('gambar') <div class="text-danger mt-1" style="font-size: 80%;">{{ $message }}</div> @enderror
            </div>
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update Berita</button>
            <a href="{{ route('berita.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection