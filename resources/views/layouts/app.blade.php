<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KosPoint</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-blue-900 text-white p-4">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
        <a href="{{ route('beranda') }}" class="font-bold text-xl">KosPoint</a>

        <div class="flex gap-4">
            @auth
                <span>{{ auth()->user()->name }}</span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="bg-red-500 px-3 py-1 rounded">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Registrasi</a>
            @endauth
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto p-6">
    @yield('content')
</main>

</body>
</html>