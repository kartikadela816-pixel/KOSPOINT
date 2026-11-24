<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'KOSPOINT')</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                },
                colors: {
                    // Palet KOSPOINT: dominan hijau dan putih.
                    brand: {
                        50: '#f3faf6',
                        100: '#e6f6ec',
                        200: '#bdf0d3',
                        600: '#178447',
                        700: '#0f6e39',
                        800: '#0c5730',
                        900: '#083421',
                    },
                    // Latar lembut untuk kolom isian dan kotak info.
                    surface: '#f1f3fd',
                    halaman: '#f8f9ff',
                },
            },
        },
    }
</script>
{{-- Kelas komponen yang dipakai berulang agar tampilan konsisten di semua halaman. --}}
<style type="text/tailwindcss">
    @layer components {
        .kp-kartu {
            @apply rounded-2xl border border-slate-200/70 bg-white shadow-sm;
        }
        .kp-label {
            @apply mb-1.5 block text-sm font-semibold text-slate-800;
        }
        .kp-input {
            @apply w-full rounded-xl border border-transparent bg-surface px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-600 focus:bg-white focus:ring-2 focus:ring-brand-100;
        }
        .kp-tombol {
            @apply inline-flex items-center justify-center gap-2 rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-600 focus-visible:ring-offset-2;
        }
        .kp-tombol-sekunder {
            @apply inline-flex items-center justify-center gap-2 rounded-xl bg-surface px-5 py-3 text-sm font-semibold text-brand-800 transition hover:bg-brand-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-600;
        }
        .kp-aksi {
            @apply inline-flex items-center justify-center rounded-lg px-3 py-1.5 text-xs font-semibold transition;
        }
        .kp-lencana {
            @apply inline-flex items-center gap-1.5 rounded-full bg-brand-100 px-3 py-1 text-xs font-bold text-brand-800;
        }
        .kp-ikon {
            @apply flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-700;
        }
    }
</style>
