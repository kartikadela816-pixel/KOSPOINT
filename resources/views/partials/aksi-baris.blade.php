{{-- Tombol aksi baris tabel/kartu. Variabel: $lihat (opsional), $ubah, $hapus, $konfirmasi --}}
<div class="flex flex-wrap items-center gap-2">
    @isset($lihat)
        <a href="{{ $lihat }}" class="kp-aksi bg-brand-700 text-white hover:bg-brand-800">Kelola</a>
    @endisset
    <a href="{{ $ubah }}" class="kp-aksi bg-surface text-brand-800 hover:bg-brand-100">Edit</a>
    <form action="{{ $hapus }}" method="POST" onsubmit="return confirm(@js($konfirmasi))">
        @csrf
        @method('DELETE')
        <button class="kp-aksi bg-red-50 text-red-600 hover:bg-red-100">Hapus</button>
    </form>
</div>
