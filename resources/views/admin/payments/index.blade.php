
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pembayaran - KosPoint</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        h2 {
            color: #263238;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f0f3f5;
        }

        button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 3px;
        }

        .setujui {
            background: #16a34a;
            color: white;
        }

        .tolak {
            background: #dc2626;
            color: white;
        }

        .kosong {
            text-align: center;
            color: #777;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 12px;
            border-radius: 6px;
        }
    </style>
</head>

<body>
<div class="container">

    <h2>Verifikasi Pembayaran</h2>
    <p>Daftar pembayaran yang dikirim oleh pencari kos.</p>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <table>
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

                        <td>
                            Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                        </td>

                        <td>{{ $payment->metode_pembayaran }}</td>

                        <td>{{ $payment->tanggal_bayar ?? '-' }}</td>

                        <td>
                            @if ($payment->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $payment->bukti_pembayaran) }}"
                                   target="_blank">
                                    Lihat Bukti
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            {{ ucfirst($payment->status_pembayaran) }}
                        </td>

                        <td>
                            @if ($payment->status_pembayaran == 'menunggu')

                                <form action="{{ route('admin.payments.approve', $payment->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="setujui"
                                        onclick="return confirm('Setujui pembayaran ini?')">
                                        Setujui
                                    </button>
                                </form>

                                <form action="{{ route('admin.payments.reject', $payment->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="tolak"
                                        onclick="return confirm('Tolak pembayaran ini?')">
                                        Tolak
                                    </button>
                                </form>

                            @else
                                -
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="9" class="kosong">
                            Belum ada pembayaran yang masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <br>

    <a href="{{ route('admin.dashboard') }}">
        Kembali ke Dashboard
    </a>

</div>
</body>
</html>
