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
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
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
                            @if ($item->status == 'published')
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{-- ============================================= --}}
                            {{-- KODE DEBUGGING - HAPUS SETELAH SELESAI --}}
                            {{-- ============================================= --}}
                            <div style="border: 1px dashed red; padding: 5px; margin-bottom: 10px; text-align: left;">
                                <p class="mb-0"><strong>Role saat ini:</strong> {{ Auth::user()->role }}</p>
                                <p class="mb-0"><strong>Apakah Editor?</strong> 
                                    @can('is-editor') 
                                        <span class="badge badge-success">YA</span>
                                    @else
                                        <span class="badge badge-danger">TIDAK</span>
                                    @endcan
                                </p>
                                <p class="mb-0"><strong>Status Berita:</strong> {{ $item->status }}</p>
                            </div>
                            <hr>
                            {{-- ============================================= --}}
                            {{-- Kode Asli --}}
                            {{-- ============================================= --}}

                            @can('is-editor')
                                @if($item->status == 'draft')
                                    <form action="{{ route('berita.approve', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                @endif
                            @endcan

                            @if(Gate::allows('is-admin') || Gate::allows('is-editor'))
                                <a href="{{ route('berita.edit', $item->id) }}" class="btn btn-info btn-sm">Edit</a>
                                
                                <form action="{{ route('berita.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            @endif
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