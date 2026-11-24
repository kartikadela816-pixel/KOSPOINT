{{-- Variabel: $pengguna, $batal, $baru (true saat tambah) --}}
@php $diriSendiri = $pengguna->exists && $pengguna->id === auth()->id(); @endphp

<div class="space-y-4">
    <section class="kp-kartu p-5">
        <div class="grid gap-4 sm:grid-cols-2">
            <x-field name="name" label="Nama" required :value="$pengguna->name" />
            <x-field name="email" label="Email" type="email" required :value="$pengguna->email" />
            <x-field name="nomor_hp" label="Nomor HP" type="tel" :value="$pengguna->nomor_hp" />
            <x-select name="role" label="Role" required :options="['admin' => 'Admin', 'pemilik' => 'Pemilik Kos', 'pencari' => 'Pencari Kos']" :value="$pengguna->role"
                      :disabled="$diriSendiri" />
            <x-select name="status_akun" label="Status akun" required :options="['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif']" :value="$pengguna->status_akun"
                      :disabled="$diriSendiri" />
            @if ($diriSendiri)
                <p class="text-xs text-slate-500 sm:col-span-2">Role dan status akun Anda sendiri tidak bisa diubah.</p>
            @endif
        </div>
    </section>

    <section class="kp-kartu p-5">
        <h2 class="mb-1 font-bold text-slate-900">Password</h2>
        @unless ($baru)
            <p class="mb-4 text-sm text-slate-500">Kosongkan jika tidak ingin mengganti password.</p>
        @endunless
        <div class="grid gap-4 sm:grid-cols-2">
            <x-field name="password" label="Password" type="password" :required="$baru" autocomplete="new-password" hint="Minimal 6 karakter." />
            <x-field name="password_confirmation" label="Konfirmasi password" type="password" :required="$baru" autocomplete="new-password" />
        </div>
    </section>

    <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
        <a href="{{ $batal }}" class="kp-tombol-sekunder">Batal</a>
        <button class="kp-tombol">Simpan</button>
    </div>
</div>
