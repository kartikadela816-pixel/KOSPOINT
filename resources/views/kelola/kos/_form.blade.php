{{-- Variabel: $kos, $prefix, $daftarPemilik --}}
<div class="space-y-4">
    <section class="kp-kartu p-5">
        <h2 class="mb-4 font-bold text-slate-900">Informasi dasar</h2>
        <div class="grid gap-4 sm:grid-cols-2">
            @if ($prefix === 'admin')
                <x-select name="id_pemilik" label="Pemilik kos" required placeholder="Pilih pemilik"
                          :options="$daftarPemilik->pluck('name', 'id')->all()" :value="$kos->id_pemilik" class="sm:col-span-2" />
            @endif

            <x-field name="nama_kos" label="Nama kos" required :value="$kos->nama_kos" class="sm:col-span-2" />

            <fieldset class="sm:col-span-2">
                <legend class="kp-label">Jenis kos <span class="text-red-500">*</span></legend>
                <div class="grid grid-cols-3 gap-1 rounded-2xl bg-surface p-1">
                    @foreach (['putra' => 'Putra', 'putri' => 'Putri', 'campur' => 'Campur'] as $nilai => $teks)
                        <label class="cursor-pointer">
                            <input type="radio" name="jenis_kos" value="{{ $nilai }}" class="peer sr-only" @checked(old('jenis_kos', $kos->jenis_kos) === $nilai)>
                            <span class="flex items-center justify-center rounded-xl bg-white px-3 py-2.5 text-sm font-semibold text-slate-600 transition peer-checked:bg-brand-700 peer-checked:text-white peer-focus-visible:ring-2 peer-focus-visible:ring-brand-600">{{ $teks }}</span>
                        </label>
                    @endforeach
                </div>
                @error('jenis_kos')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </fieldset>

            <x-select name="status_kos" label="Status kos" required
                      :options="['draft' => 'Draft', 'aktif' => 'Aktif', 'nonaktif' => 'Nonaktif']" :value="$kos->status_kos"
                      class="sm:col-span-2" />

            <x-textarea name="deskripsi" label="Deskripsi" :value="$kos->deskripsi" class="sm:col-span-2" />
        </div>
    </section>

    <section class="kp-kartu p-5">
        <h2 class="mb-4 font-bold text-slate-900">Lokasi</h2>
        <div class="grid gap-4 sm:grid-cols-2">
            <x-textarea name="alamat" label="Alamat lengkap" required :value="$kos->alamat" rows="2" class="sm:col-span-2" />
            <x-field name="latitude" label="Latitude" type="number" step="any" :value="$kos->latitude" placeholder="-8.219232" />
            <x-field name="longitude" label="Longitude" type="number" step="any" :value="$kos->longitude" placeholder="114.369339" />
        </div>
    </section>

    <section class="kp-kartu p-5">
        <h2 class="mb-4 font-bold text-slate-900">Kontak dan aturan</h2>
        <div class="grid gap-4 sm:grid-cols-2">
            <x-field name="nomor_whatsapp" label="Nomor WhatsApp" type="tel" :value="$kos->nomor_whatsapp" />
            <x-field name="nomor_telepon" label="Nomor telepon" type="tel" :value="$kos->nomor_telepon" />
            <x-textarea name="aturan_kos" label="Aturan kos" :value="$kos->aturan_kos" rows="4" class="sm:col-span-2"
                        hint="Satu aturan per baris, misalnya jam malam atau aturan tamu." />
        </div>
    </section>

    <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
        <a href="{{ $batal }}" class="kp-tombol-sekunder">Batal</a>
        <button class="kp-tombol">Simpan</button>
    </div>
</div>
