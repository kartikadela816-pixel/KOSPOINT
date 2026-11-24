@if (session('sukses'))
    <div class="mb-4 flex items-start gap-3 rounded-xl border border-brand-200 bg-brand-50 px-4 py-3 text-sm text-brand-900" role="status">
        <span class="font-bold" aria-hidden="true">&#10003;</span>
        <p>{{ session('sukses') }}</p>
    </div>
@endif

@if (session('galat'))
    <div class="mb-4 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
        <span class="font-bold" aria-hidden="true">!</span>
        <p>{{ session('galat') }}</p>
    </div>
@endif

@if ($errors->any() && ! $errors->hasBag('password'))
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
        Data belum bisa disimpan. Periksa kolom yang ditandai merah.
    </div>
@endif
