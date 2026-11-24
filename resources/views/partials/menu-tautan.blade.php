@php
    $kelasTautan = !empty($mobile)
        ? 'rounded-xl px-3 py-2.5 hover:bg-brand-50 hover:text-brand-800'
        : 'hover:text-brand-700';
    $kelasMasuk = !empty($mobile)
        ? 'rounded-xl px-3 py-2.5 text-center hover:bg-brand-50'
        : 'rounded-full px-4 py-2 hover:bg-brand-50';
@endphp

<a href="{{ route('beranda') }}" class="{{ $kelasTautan }} {{ request()->routeIs('beranda') ? 'text-brand-700' : '' }}">Beranda</a>
<a href="{{ route('beranda') }}#cari-kos" class="{{ $kelasTautan }}">Cari Kos</a>
<a href="{{ route('beranda') }}#tentang" class="{{ $kelasTautan }}">Tentang</a>

@auth
    @if (auth()->user()->isPemilik())
        <a href="{{ route('pemilik.dashboard') }}" class="{{ $kelasTautan }} {{ request()->routeIs('pemilik.*') ? 'text-brand-700' : '' }}">Dashboard</a>
    @elseif (auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}" class="{{ $kelasTautan }} {{ request()->routeIs('admin.*') ? 'text-brand-700' : '' }}">Dashboard</a>
    @endif
    <a href="{{ route('profil.edit') }}" class="{{ $kelasTautan }} {{ request()->routeIs('profil.*') ? 'text-brand-700' : '' }}">Profil</a>

    <span class="{{ !empty($mobile) ? 'flex items-center gap-2 px-3 py-2 text-slate-500' : 'flex items-center gap-2 text-slate-500' }}">
        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-brand-700 text-xs font-bold text-white" aria-hidden="true">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
        {{ auth()->user()->name }}
    </span>

    <form action="{{ route('logout') }}" method="POST" class="{{ !empty($mobile) ? '' : 'inline' }}">
        @csrf
        <button class="{{ !empty($mobile) ? 'w-full rounded-xl bg-red-50 px-3 py-2.5 text-left text-red-600' : 'rounded-full bg-red-50 px-4 py-2 text-red-600 hover:bg-red-100' }}">
            Logout
        </button>
    </form>
@else
    <a href="{{ route('login') }}" class="{{ $kelasMasuk }} {{ request()->routeIs('login') ? 'text-brand-700' : '' }}">Masuk</a>
    <a href="{{ route('register') }}" class="{{ !empty($mobile) ? 'rounded-xl bg-brand-700 px-3 py-2.5 text-center text-white' : 'rounded-full bg-brand-700 px-4 py-2 text-white hover:bg-brand-800' }}">
        Daftar
    </a>
@endauth
