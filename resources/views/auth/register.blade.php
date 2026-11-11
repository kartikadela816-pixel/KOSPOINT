@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Registrasi</h1>

    <form action="{{ route('register.store') }}" method="POST" class="space-y-3">
        @csrf

        <div>
            <label class="block mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border p-2 rounded">
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border p-2 rounded">
            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1">Nomor HP</label>
            <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}"
                   class="w-full border p-2 rounded">
            @error('nomor_hp')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1">Daftar Sebagai</label>
            <select name="role" class="w-full border p-2 rounded">
                <option value="pencari">Pencari Kos</option>
                <option value="pemilik">Pemilik Kos</option>
            </select>
            @error('role')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border p-2 rounded">
            @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full border p-2 rounded">
        </div>

        <button class="w-full bg-blue-600 text-white p-2 rounded">
            Daftar
        </button>
    </form>
</div>
@endsection