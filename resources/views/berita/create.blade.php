@extends('layouts.admin')

@section('title', 'Tambah Berita Baru')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Berita</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="judul">Judul Berita</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" placeholder="Masukkan Judul Berita" value="{{ old('judul') }}">
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="kategori_id">Kategori</label>
                <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="konten">Konten</label>
                <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten" rows="5" placeholder="Masukkan Konten Berita">{{ old('konten') }}</textarea>
                @error('konten')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Unggulan</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror" id="gambar" name="gambar">
                        <label class="custom-file-label" for="gambar">Pilih file</label>
                    </div>
                </div>
                 @error('gambar')
                    <div class="text-danger mt-1" style="font-size: 80%;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan sebagai Draft</button>
            <a href="{{ route('berita.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection