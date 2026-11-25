{{-- Lambang KOSPOINT: pin lokasi berisi rumah kos. Variabel: $ukuran (kelas kotak), $ikon (kelas svg) --}}
<span class="flex shrink-0 items-center justify-center bg-brand-700 text-white shadow-sm {{ $ukuran ?? 'h-10 w-10 rounded-xl' }}">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="{{ $ikon ?? 'h-6 w-6' }}" aria-hidden="true">
        <path d="M12 21.5s7-6 7-11.5a7 7 0 1 0-14 0c0 5.5 7 11.5 7 11.5z" />
        <path d="M8.9 11 12 8.2l3.1 2.8M9.9 10.2V14h4.2v-3.8" />
    </svg>
</span>
