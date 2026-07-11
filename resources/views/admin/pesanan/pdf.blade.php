<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #BA-{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333333;
            font-size: 13px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 10px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #E5E5E5;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .logo {
            height: 50px;
            vertical-align: middle;
        }
        .brand-name {
            font-size: 20px;
            font-weight: bold;
            color: #2D2D2D;
            vertical-align: middle;
            margin-left: 10px;
        }
        .brand-accent {
            color: #B08D57;
        }
        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            color: #2D2D2D;
            text-align: right;
            margin: 0;
        }
        .invoice-details {
            text-align: right;
            color: #5F5F5F;
            font-size: 12px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-header {
            font-weight: bold;
            font-size: 14px;
            color: #2D2D2D;
            border-bottom: 1px solid #E5E5E5;
            padding-bottom: 5px;
            margin-bottom: 8px;
        }
        .info-text {
            color: #5F5F5F;
            line-height: 1.6;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #F8F9FA;
            color: #2D2D2D;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #E5E5E5;
            font-size: 12px;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #E5E5E5;
            vertical-align: top;
        }
        .items-table .text-right {
            text-align: right;
        }
        .catatan-box {
            background-color: #F8F9FA;
            border-left: 3px solid #B08D57;
            padding: 8px 12px;
            margin-top: 6px;
            font-size: 11px;
            color: #5f5f5f;
        }
        .catatan-title {
            font-weight: bold;
            margin-bottom: 2px;
        }
        .total-table {
            width: 100%;
            margin-top: 10px;
        }
        .total-label {
            font-weight: bold;
            font-size: 14px;
            color: #2D2D2D;
            text-align: right;
            padding-right: 15px;
        }
        .total-value {
            font-weight: bold;
            font-size: 16px;
            color: #B08D57;
            text-align: right;
            width: 150px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }
        .status-pending { background-color: #FFF3CD; color: #856404; }
        .status-diverifikasi { background-color: #D1ECF1; color: #0C5460; }
        .status-diproses { background-color: #CCE5FF; color: #004085; }
        .status-selesai { background-color: #D4EDDA; color: #155724; }
        .status-ditolak { background-color: #F8D7DA; color: #721C24; }

        .footer {
            margin-top: 50px;
            text-align: center;
            border-top: 1px solid #E5E5E5;
            padding-top: 15px;
            font-size: 11px;
            color: #8C8C8C;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td style="width: 50%;">
                    @php
                        $logoPath = public_path('images/logo.png');
                        $logoBase64 = '';
                        if (file_exists($logoPath)) {
                            $logoData = file_get_contents($logoPath);
                            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
                        }
                    @endphp
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" class="logo" alt="Logo" style="height: 40px; width: 40px;">
                    @endif
                    <span class="brand-name">BERKAH <span class="brand-accent">ALAM</span></span>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h2 class="invoice-title">INVOICE PESANAN</h2>
                    <div class="invoice-details">
                        <strong>Invoice No:</strong> #BA-{{ $order->id }}<br>
                        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($order->tanggal)->format('d F Y') }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- Info Section -->
        <table class="info-table">
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                    <div class="info-header">Ditujukan Kepada:</div>
                    <div class="info-text">
                        <strong>{{ $order->user->name }}</strong><br>
                        Email: {{ $order->user->email }}<br>
                        Telepon: {{ $order->user->phone ?: '-' }}
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div class="info-header">Detail Transaksi & Pengiriman:</div>
                    <div class="info-text">
                        <strong>Status Pesanan:</strong> 
                        <span class="status-badge status-{{ $order->status }}">{{ $order->status }}</span><br>
                        <strong>Status Pembayaran:</strong> 
                        @if($order->pembayaran)
                            {{ ucfirst($order->pembayaran->status) }}
                        @else
                            Belum Melakukan Pembayaran
                        @endif<br>
                        <strong>Alamat Pengiriman:</strong><br>
                        {{ $order->alamat ?: ($order->user->address ?: '-') }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 45%;">Nama Produk / Detail Kustom</th>
                    <th style="width: 20%; text-align: right;">Harga Satuan</th>
                    <th style="width: 15%; text-align: center;">Kuantitas</th>
                    <th style="width: 20%; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->detailPesanan as $detail)
                    <tr>
                        <td>
                            <strong>{{ $detail->produk->nama }}</strong>
                            @if($detail->catatan_ukiran)
                                <div class="catatan-box">
                                    <div class="catatan-title">Catatan Ukiran:</div>
                                    {!! nl2br(e($detail->catatan_ukiran)) !!}
                                </div>
                            @endif
                        </td>
                        <td class="text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td style="text-align: center;">{{ $detail->qty }} Pcs</td>
                        <td class="text-right">Rp {{ number_format($detail->harga * $detail->qty, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total Area -->
        <table class="total-table">
            <tr>
                <td style="width: 60%; vertical-align: top; color: #8c8c8c; font-size: 11px;">
                    * Terima kasih telah mempercayakan pembuatan nisan / prasasti Anda pada Berkah Alam.<br>
                    * Invoice ini adalah bukti transaksi yang sah.
                </td>
                <td style="width: 40%; vertical-align: top;">
                    <table style="width: 100%;">
                        <tr>
                            <td class="total-label">Total Tagihan:</td>
                            <td class="total-value">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} BERKAH ALAM. Jl. Raya Berkah Alam No. 88, Sentra Batu Alam, Indonesia.
        </div>
    </div>
</body>
</html>
