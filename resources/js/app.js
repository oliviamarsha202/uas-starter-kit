import './bootstrap';

// Import Alpine.js (bawaan dari Breeze)
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// =======================================================
// INI ADALAH KODE YANG KITA TAMBAHKAN
// =======================================================
import bsCustomFileInput from 'bs-custom-file-input';

// Inisialisasi plugin setelah dokumen selesai dimuat
document.addEventListener('DOMContentLoaded', function () {
    bsCustomFileInput.init();
});
// =======================================================