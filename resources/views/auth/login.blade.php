@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Login</h1>

    <form action="{{ route('login.store') }}" method="POST" class="space-y-3">
        @csrf

        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border p-2 rounded">
            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border p-2 rounded">
        </div>

        <button class="w-full bg-blue-600 text-white p-2 rounded">
            Masuk
        </button>
    </form>

    <p class="mt-4 text-sm">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-blue-600">Daftar di sini</a>
    </p>
</div>
@endsection