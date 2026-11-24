<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembayaran - KosPoint</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
        }

        h2 {
            color: #263238;
        }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select, button {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            margin-top: 22px;
            background: #2563eb;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .error {
            color: red;
            font-size: 13px;
        }

        .kembali {
            display: inline-block;
            margin-top: 15px;
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Formulir Pembayaran</h2>
        <p>Silakan isi data pembayaran sewa kos Anda.</p>

        @if ($rentals->isEmpty())
    <div style="background: #fff3cd; color: #856404; padding: 12px; border-radius: 6px; margin-bottom: 15px;">
        Anda belum memiliki data sewa aktif. Silakan lakukan booking kos terlebih dahulu.
    </div>
@endif

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if ($rentals->isNotEmpty())
        <form action="{{ route('payments.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <label for="id_sewa">Pilih Data Sewa</label>
            <select name="id_sewa" id="id_sewa" required>
                <option value="">-- Pilih Sewa --</option>
                @foreach ($rentals as $rental)
                    <option value="{{ $rental->id }}"
                        {{ old('id_sewa') == $rental->id ? 'selected' : '' }}>
                        Sewa #{{ $rental->id }}
                        - Rp {{ number_format($rental->harga_per_bulan, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>

            <label for="jumlah_bayar">Jumlah Pembayaran (Rp)</label>
            <input type="number"
                   name="jumlah_bayar"
                   id="jumlah_bayar"
                   min="1"
                   step="1000"
                   value="{{ old('jumlah_bayar') }}"
                   required>

            <label for="metode_pembayaran">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" required>
                <option value="">-- Pilih Metode --</option>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="QRIS">QRIS</option>
            </select>

            <label for="bukti_pembayaran">Upload Bukti Transfer</label>
            <input type="file"
                   name="bukti_pembayaran"
                   id="bukti_pembayaran"
                   accept="image/jpeg,image/png,image/jpg"
                   required>

            <button type="submit">Kirim Pembayaran</button>
        </form>
        @endif

        <a href="{{ route('payments.index') }}" class="kembali">
            Kembali ke Daftar Pembayaran
        </a>
    </div>
</body>
</html>
