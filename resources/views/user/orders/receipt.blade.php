<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $order->order_number }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace, 'Lucida Console', Monaco;
            background-color: #f1f5f9;
            color: #000;
            font-size: 12px;
            line-height: 1.35;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 10px;
            min-height: 100vh;
        }
        .action-bar {
            width: 100%;
            max-width: 340px;
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        .btn {
            flex: 1;
            padding: 10px 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-print {
            background-color: #dc2626;
            color: #fff;
            box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.3);
        }
        .btn-print:hover {
            background-color: #b91c1c;
        }
        .btn-back {
            background-color: #e2e8f0;
            color: #334155;
        }
        .btn-back:hover {
            background-color: #cbd5e1;
        }
        .receipt-card {
            background-color: #fff;
            width: 100%;
            max-width: 320px;
            padding: 20px 15px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            position: relative;
        }
        /* Jagged bottom edge decoration for receipt */
        .receipt-card::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 0;
            right: 0;
            height: 8px;
            background: radial-gradient(circle, transparent, transparent 50%, #fff 50%, #fff 100%);
            background-size: 12px 12px;
            background-repeat: repeat-x;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .fw-bold { font-weight: bold; }
        .brand-title {
            font-size: 16px;
            font-weight: 900;
            letter-spacing: 1px;
            margin-bottom: 2px;
            text-transform: uppercase;
        }
        .brand-subtitle {
            font-size: 10px;
            color: #475569;
            margin-bottom: 6px;
        }
        .divider-double {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            height: 3px;
            margin: 8px 0;
        }
        .divider-single {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 11px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0;
            font-size: 11px;
        }
        .items-table th {
            padding: 4px 0;
            border-bottom: 1px dashed #000;
            font-weight: bold;
        }
        .items-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .item-name {
            font-weight: bold;
        }
        .item-calc {
            font-size: 10px;
            color: #334155;
        }
        .total-section {
            margin-top: 4px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 11px;
        }
        .total-grand {
            font-size: 13px;
            font-weight: 900;
            margin: 6px 0;
        }
        .badge-lunas {
            display: inline-block;
            border: 2px solid #000;
            padding: 2px 10px;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 2px;
            margin: 8px 0;
            text-transform: uppercase;
        }
        .footer-note {
            font-size: 10px;
            color: #334155;
            margin-top: 8px;
            line-height: 1.4;
        }
        .qr-code-box {
            margin: 10px auto;
            text-align: center;
        }
        .qr-code-box img {
            width: 90px;
            height: 90px;
            display: block;
            margin: 0 auto;
        }

        /* PRINT STYLES FOR 58mm PRINTERS */
        @media print {
            body {
                background: #fff;
                padding: 0;
                margin: 0;
                display: block;
            }
            .action-bar {
                display: none !important;
            }
            .receipt-card {
                max-width: 100% !important;
                width: 58mm !important;
                box-shadow: none !important;
                padding: 5px 0 !important;
                margin: 0 !important;
            }
            .receipt-card::after {
                display: none !important;
            }
            @page {
                size: 58mm auto;
                margin: 2mm 1mm;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Aksi di Layar Komputer/HP (Sembunyi saat dicetak) -->
    <div class="action-bar">
        <button onclick="window.print()" class="btn btn-print">
            <i class="fa-solid fa-print"></i> Cetak Struk
        </button>
        <button onclick="window.close(); if(history.length > 1) { history.back(); }" class="btn btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </button>
    </div>

    {{-- ========================================================================= --}}
    {{-- [FITUR 1] LEMBAR CETAK STRUK KASIR TERMAL 58MM (POS THERMAL RECEIPT)       --}}
    {{-- ========================================================================= --}}
    <!-- Lembar Struk Kasir Termal 58mm -->
    <div class="receipt-card">
        
        <!-- HEADER KEDAI -->
        <div class="text-center">
            <div class="brand-title">KEDAI MARJUKI'S</div>
            <div class="brand-subtitle">
                Spesial Nasi Goreng, Bakmi &amp; Aneka Kuliner<br>
                Jl. Candisari No. 08, Semarang<br>
                Telp/WA: 0882-0051-16301
            </div>
        </div>

        <div class="divider-double"></div>

        <!-- INFO TRANSAKSI -->
        <div class="info-row">
            <span>No. Nota</span>
            <span class="fw-bold">{{ $order->order_number }}</span>
        </div>
        <div class="info-row">
            <span>Tanggal</span>
            <span>{{ $order->created_at->format('d/m/Y H:i') }} WIB</span>
        </div>
        <div class="info-row">
            <span>Pelanggan</span>
            <span class="fw-bold">{{ $order->customer_name }}</span>
        </div>
        <div class="info-row">
            <span>Layanan</span>
            <span class="fw-bold">{{ $order->customer_address }}</span>
        </div>
        @if ($order->notes)
            <div class="info-row">
                <span>Catatan</span>
                <span style="max-width: 160px; text-align: right;">{{ $order->notes }}</span>
            </div>
        @endif

        <div class="divider-single"></div>

        <!-- DAFTAR ITEM PESANAN -->
        <table class="items-table">
            <thead>
                <tr>
                    <th class="text-left">MENU</th>
                    <th class="text-center">QTY</th>
                    <th class="text-right">HARGA</th>
                    <th class="text-right">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td colspan="4" class="item-name">{{ $item->product_name }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-center">{{ $item->quantity }}x</td>
                        <td class="text-right item-calc">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right fw-bold">{{ $item->formatted_subtotal }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider-single"></div>

        <!-- TOTAL HARGA & STATUS PEMBAYARAN -->
        <div class="total-section">
            <div class="total-row">
                <span>Subtotal Items</span>
                <span>{{ $order->formatted_total_price }}</span>
            </div>
            <div class="total-row total-grand">
                <span>TOTAL AKHIR</span>
                <span>{{ $order->formatted_total_price }}</span>
            </div>
            <div class="total-row">
                <span>Metode Bayar</span>
                <span class="fw-bold">{{ strtoupper($order->payment_method) }}</span>
            </div>
            <div class="total-row">
                <span>Status Bayar</span>
                <span class="fw-bold">
                    @if ($order->payment_status === 'paid')
                        LUNAS
                    @else
                        {{ strtoupper($order->payment_status) }}
                    @endif
                </span>
            </div>
        </div>

        <div class="text-center">
            @if ($order->payment_status === 'paid')
                <div class="badge-lunas">*** LUNAS ***</div>
            @else
                <div class="badge-lunas" style="border-style: dashed;">PENDING</div>
            @endif
        </div>

        <!-- QR CODE NOTA UNTUK VERIFIKASI CEPAT -->
        <div class="qr-code-box">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&margin=0&data={{ urlencode($order->order_number) }}" alt="QR Nota">
            <div style="font-size: 9px; margin-top: 3px;">Kode Nota: {{ $order->order_number }}</div>
        </div>

        <div class="divider-double"></div>

        <!-- FOOTER & UCAPAN TERIMA KASIH -->
        <div class="text-center footer-note">
            <div class="fw-bold">MATUR NUWUN SAMPUN RAWUH!</div>
            <div>Nikmati hidangan lezat khas Kedai Marjuki'S.</div>
            <div style="margin-top: 4px; font-size: 9px;">-- Simpan struk ini sebagai bukti transaksi yang sah --</div>
        </div>
    </div>

    <script>
        // Auto print jika dibuka dengan parameter ?autoprint=1
        if (window.location.search.includes('autoprint=1')) {
            window.addEventListener('load', function() {
                setTimeout(function() {
                    window.print();
                }, 300);
            });
        }
    </script>
</body>
</html>
