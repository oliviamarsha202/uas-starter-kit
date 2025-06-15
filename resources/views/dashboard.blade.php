@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
{{-- Bagian Info Box --}}
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $jumlah_berita }}</h3>
                <p>Total Berita</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-paper"></i>
            </div>
            <a href="{{ route('berita.index') }}" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $jumlah_kategori }}</h3>
                <p>Total Kategori</p>
            </div>
            <div class="icon">
                <i class="ion ion-pricetags"></i>
            </div>
            <a href="{{ route('kategori.index') }}" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $jumlah_penulis }}</h3>
                <p>Jumlah Penulis</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-stalker"></i>
            </div>
            <a href="#" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $jumlah_admin }}</h3>
                <p>Jumlah Admin & Editor</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="#" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

{{-- Bagian Grafik --}}
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Distribusi Berita per Kategori</h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="beritaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk Chart.js --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Ambil data dari PHP (Blade)
    const labels = {!! json_encode($labels) !!};
    const data = {!! json_encode($data) !!};
    
    const ctx = document.getElementById('beritaChart').getContext('2d');
    const beritaChart = new Chart(ctx, {
        type: 'bar', // Tipe grafik: bar, line, pie, dll.
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Berita',
                data: data,
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection