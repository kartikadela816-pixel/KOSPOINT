<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'KosPoint')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-emerald-50">

<nav class="bg-emerald-600 text-white p-4">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
        <a href="{{ route('beranda') }}" class="font-bold text-xl">KosPoint</a>

        <div class="flex gap-4 items-center">
            <a href="{{ route('beranda') }}">Beranda</a>
            @auth
                @if(auth()->user()->isPemilik())
                    <a href="{{ route('pemilik.booking.index') }}">Booking Masuk</a>
                @else
                    <a href="{{ route('booking.index') }}">Booking Saya</a>
                @endif
                <a href="{{ route('rental.index') }}">Sewa</a>
                <span>{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="bg-red-500 px-3 py-1 rounded">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto p-6">
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            @foreach($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    @yield('content')
</main>

</body>
</html>