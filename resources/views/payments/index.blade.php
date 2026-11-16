
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Pembayaran - KosPoint</title>
</head>
<body style="font-family: Arial; background: #f5f6fa; padding: 30px;">

    <h2>Verifikasi Pembayaran</h2>
    <p>Daftar pembayaran yang dikirim oleh pencari kos.</p>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Pencari</th>
                <th>ID Sewa</th>
                <th>Jumlah Bayar</th>
                <th>Metode</th>
                <th>Tanggal Bayar</th>
                <th>Bukti</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $payment->pencari->name ?? '-' }}</td>
                    <td>{{ $payment->id_sewa }}</td>
                    <td>Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                    <td>{{ $payment->metode_pembayaran }}</td>
                    <td>{{ $payment->tanggal_bayar ?? '-' }}</td>

                    <td>
                        @if ($payment->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $payment->bukti_pembayaran) }}" target="_blank">
                                Lihat Bukti
                            </a>
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ ucfirst($payment->status_pembayaran) }}</td>

                    <td>
                        @if ($payment->status_pembayaran == 'menunggu')
                            <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit">Setujui</button>
                            </form>

                            <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit">Tolak</button>
                            </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center;">
                        Belum ada pembayaran yang masuk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>
    <a href="{{ route('admin.dashboard') }}">Kembali ke Dashboard</a>

</body>
</html>
