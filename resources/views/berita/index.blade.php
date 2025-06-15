@extends('layouts.admin')

@section('title', 'Manajemen Berita')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Berita</h3>
        <div class="card-tools">
            <a href="{{ route('berita.create') }}" class="btn btn-primary btn-sm">Tambah Berita</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th style="width: 200px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($berita as $item)
                    <tr>
                        <td>{{ $loop->iteration + $berita->firstItem() - 1 }}</td>
                        <td>
                            <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}" width="100">
                        </td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->kategori->nama_kategori }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>
                            {{-- BAGIAN INI MENAMPILKAN LABEL STATUS --}}
                            @if ($item->status == 'published')
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{-- BAGIAN INI MENAMPILKAN TOMBOL APPROVE SECARA KONDISIONAL --}}
                            @if (Auth::user()->role == 'editor' && $item->status == 'draft')
                                <form action="{{ route('berita.approve', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                            @endif

                            <a href="{{ route('berita.edit', $item->id) }}" class="btn btn-info btn-sm">Edit</a>
                            
                            <form action="{{ route('berita.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada berita.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $berita->links() }}
    </div>
</div>
@endsection