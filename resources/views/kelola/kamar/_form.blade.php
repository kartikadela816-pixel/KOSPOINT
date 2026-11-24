{{-- Variabel: $kamar, $batal --}}
<div class="space-y-4">
    <section class="kp-kartu p-5">
        <div class="grid gap-4 sm:grid-cols-2">
            <x-field name="nomor_kamar" label="Nomor kamar" required :value="$kamar->nomor_kamar" placeholder="101" />
            <x-field name="nama_kamar" label="Nama / tipe kamar" :value="$kamar->nama_kamar" placeholder="Deluxe" />
            <x-field name="harga_per_bulan" label="Harga per bulan (Rp)" type="number" min="0" step="1000" required :value="$kamar->harga_per_bulan !== null ? (int) $kamar->harga_per_bulan : null" />
            <x-field name="uang_jaminan" label="Uang jaminan (Rp)" type="number" min="0" step="1000" :value="$kamar->uang_jaminan !== null ? (int) $kamar->uang_jaminan : 0" />
            <x-select name="jenis_kamar_mandi" label="Kamar mandi" required :options="['dalam' => 'Dalam', 'luar' => 'Luar']" :value="$kamar->jenis_kamar_mandi" />
            <x-select name="status_kamar" label="Status kamar" required
                      :options="['tersedia' => 'Tersedia', 'dipesan' => 'Dipesan', 'terisi' => 'Terisi', 'nonaktif' => 'Nonaktif']" :value="$kamar->status_kamar" />
            <x-textarea name="deskripsi" label="Deskripsi" :value="$kamar->deskripsi" class="sm:col-span-2" />
        </div>
    </section>

    <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
        <a href="{{ $batal }}" class="kp-tombol-sekunder">Batal</a>
        <button class="kp-tombol">Simpan</button>
    </div>
</div>
