<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $sale->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .receipt-container {
            max-width: 300px;
            margin: 0 auto;
            background: white;
            padding: 20px 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px dashed #000;
            padding-bottom: 15px;
        }

        .cafe-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .cafe-info {
            font-size: 11px;
            line-height: 1.4;
        }

        .receipt-info {
            font-size: 11px;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .receipt-info div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .receipt-items {
            margin-bottom: 10px;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
        }

        .item {
            font-size: 11px;
            margin-bottom: 8px;
        }

        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .item-details {
            display: flex;
            justify-content: space-between;
            color: #333;
        }

        .receipt-summary {
            font-size: 12px;
            margin-bottom: 15px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .summary-row.total {
            font-weight: bold;
            font-size: 14px;
            padding-top: 8px;
            border-top: 2px solid #000;
            margin-top: 8px;
        }

        .receipt-footer {
            text-align: center;
            font-size: 11px;
            margin-top: 15px;
            border-top: 1px dashed #000;
            padding-top: 15px;
        }

        .footer-thanks {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .buttons {
            margin-top: 20px;
            text-align: center;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-family: Arial, sans-serif;
            text-decoration: none;
            display: inline-block;
        }

        .btn-print {
            background-color: #5d87ff;
            color: white;
        }

        .btn-back {
            background-color: #49beff;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .receipt-container {
                max-width: 80mm;
                box-shadow: none;
                padding: 10px;
            }

            .buttons {
                display: none;
            }
        }

        @page {
            size: 80mm auto;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="receipt-header">
            <div class="cafe-name">CR /</div>
            <div class="cafe-info">
                Jl. Kahuripan No.1, Klojen, Kec. Klojen, Kota Malang, Jawa Timur 65119
            </div>
        </div>

        <!-- Transaction Info -->
        <div class="receipt-info">
            <div>
                <span>No. Transaksi</span>
                <span>#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div>
                <span>Tanggal</span>
                <span>{{ $sale->sale_date->format('d/m/Y H:i') }}</span>
            </div>
            <div>
                <span>Kasir</span>
                <span>{{ Auth::user()->name }}</span>
            </div>
            <div>
                <span>Pelanggan</span>
                <span>{{ $sale->customer->customer_name }}</span>
            </div>
        </div>

        <!-- Items -->
        <div class="receipt-items">
            @foreach ($sale->saleDetails as $detail)
                <div class="item">
                    <div class="item-name">{{ $detail->product->product_name }}</div>
                    <div class="item-details">
                        <span>{{ $detail->product_quantity }} x Rp
                            {{ number_format($detail->product->price, 0, ',', '.') }}</span>
                        <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Summary -->
        <div class="receipt-summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($sale->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>PPN (11%)</span>
                <span>Rp {{ number_format($sale->tax_amount, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row total">
                <span>TOTAL</span>
                <span>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row" style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #000;">
                <span>Tunai</span>
                <span>Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Kembalian</span>
                <span>Rp {{ number_format($sale->change_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="receipt-footer">
            <div class="footer-thanks">Terima Kasih!</div>
            <div>Semoga hari Anda menyenangkan</div>
            <div style="margin-top: 10px;">www.cr-cafe.com</div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="buttons">
        <button class="btn btn-print" onclick="window.print()">
            🖨️ Print Struk
        </button>
        <a href="{{ route('cashier.index') }}" class="btn btn-back">
            ← Kembali ke Kasir
        </a>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>

</html>
