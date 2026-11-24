@php
    $pengguna = auth()->user();
    $namaPeran = match ($pengguna->role) {
        'pemilik' => 'Pemilik Kos',
        'admin' => 'Admin',
        default => 'Pencari Kos',
    };
@endphp

<div class="mt-6 grid gap-4 sm:grid-cols-3">
    <div class="kp-kartu border-t-4 border-t-brand-700 p-5">
        <p class="text-sm text-slate-500">Nama</p>
        <p class="mt-1 break-words font-bold text-slate-900">{{ $pengguna->name }}</p>
    </div>
    <div class="kp-kartu border-t-4 border-t-brand-600 p-5">
        <p class="text-sm text-slate-500">Role kamu</p>
        <p class="mt-1 font-bold text-slate-900">{{ $pengguna->role }}</p>
        <p class="mt-1 text-sm text-brand-700">{{ $namaPeran }}</p>
    </div>
    <div class="kp-kartu border-t-4 border-t-brand-200 p-5">
        <p class="text-sm text-slate-500">Status akun</p>
        <p class="mt-1 font-bold capitalize text-slate-900">{{ $pengguna->status_akun ?: '-' }}</p>
    </div>
</div>

<div class="kp-kartu mt-4 p-5">
    <div class="flex items-center gap-3">
        <span class="kp-ikon h-10 w-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM4 20a8 8 0 0 1 16 0" />
            </svg>
        </span>
        <h2 class="font-bold text-slate-900">Data akun</h2>
    </div>
    <dl class="mt-4 grid gap-3 sm:grid-cols-2">
        <div class="rounded-xl bg-surface p-4">
            <dt class="text-sm text-slate-500">Email</dt>
            <dd class="mt-1 break-all font-semibold">{{ $pengguna->email }}</dd>
        </div>
        <div class="rounded-xl bg-surface p-4">
            <dt class="text-sm text-slate-500">Nomor HP</dt>
            <dd class="mt-1 font-semibold">{{ $pengguna->nomor_hp ?: '-' }}</dd>
        </div>
    </dl>
</div>
