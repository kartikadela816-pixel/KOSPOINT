@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Notifikasi</h1>
        <p class="text-gray-500 mt-1">Informasi terbaru mengenai aktivitas akunmu.</p>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($notifications as $notification)
        <div class="mb-4 rounded-xl border p-5 shadow-sm
            {{ $notification->dibaca ? 'bg-white border-gray-200' : 'bg-blue-50 border-blue-200' }}">

            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">

                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <h2 class="font-semibold text-gray-800">
                            {{ $notification->judul }}
                        </h2>

                        @if (!$notification->dibaca)
                            <span class="text-xs bg-blue-600 text-white px-2 py-1 rounded-full">
                                Baru
                            </span>
                        @endif
                    </div>

                    <p class="text-gray-600">
                        {{ $notification->pesan }}
                    </p>

                    <p class="text-xs text-gray-400 mt-3">
                        {{ $notification->created_at->format('d M Y, H:i') }}
                    </p>
                </div>

                @if (!$notification->dibaca)
                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                            class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            Tandai dibaca
                        </button>
                    </form>
                @else
                    <span class="text-sm text-green-600 font-medium">
                        Sudah dibaca
                    </span>
                @endif

            </div>
        </div>
    @empty
        <div class="text-center bg-white border border-gray-200 rounded-xl p-10">
            <div class="text-4xl mb-3">🔔</div>
            <h2 class="font-semibold text-gray-700">Belum ada notifikasi</h2>
            <p class="text-sm text-gray-500 mt-1">
                Notifikasi terbaru akan muncul di halaman ini.
            </p>
        </div>
    @endforelse

</div>
@endsection
