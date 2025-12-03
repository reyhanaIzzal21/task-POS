@extends('admin.layouts.app')

@section('style')
    <style>
        :root {
            --pos-primary: #ffba25;
            --pos-dark: #212529;
        }

        /* Invoice Paper Style */
        .invoice-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }

        .invoice-header {
            background-color: #fcfcfc;
            border-bottom: 2px dashed #eee;
            padding: 30px;
        }

        .info-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #888;
            margin-bottom: 4px;
        }

        .info-value {
            font-weight: 600;
            color: var(--pos-dark);
            font-size: 1rem;
        }

        .table-invoice th {
            font-size: 0.85rem;
            color: #666;
            font-weight: 600;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }

        .table-invoice td {
            padding-top: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f8f8f8;
            vertical-align: middle;
        }

        .table-invoice tr:last-child td {
            border-bottom: none;
        }

        .summary-box {
            background-color: #f9f9f9;
            border-radius: 12px;
            padding: 20px;
        }

        .grand-total {
            font-size: 1.5rem;
            color: #d39e00;
            /* Darker Gold */
            font-weight: 800;
        }

        .btn-gold {
            background-color: var(--pos-primary);
            color: #212529;
            font-weight: 700;
            border: none;
        }

        .btn-gold:hover {
            background-color: #e0a800;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumb / Back Button -->
        <div class="mb-4">
            <a href="{{ route('sales.index') }}"
                class="text-decoration-none text-muted d-inline-flex align-items-center hover-dark">
                <i class="ti ti-arrow-left me-2"></i> Kembali ke Riwayat
            </a>
        </div>

        <div class="invoice-card">
            <!-- Header Invoice -->
            <div class="invoice-header">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-dark rounded-pill px-3 py-2">PAID / LUNAS</span>
                        </div>
                        <h3 class="fw-bold text-dark mb-0">Invoice #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</h3>
                    </div>
                    <div class="mt-3 mt-md-0 text-md-end">
                        <a href="{{ route('cashier.receipt', $sale->id) }}" target="_blank"
                            class="btn btn-gold px-4 py-2 shadow-sm">
                            <i class="ti ti-printer me-2"></i> Cetak Struk
                        </a>
                    </div>
                </div>

                <div class="row mt-4 pt-2 g-4">
                    <div class="col-6 col-md-3">
                        <div class="info-label"><i class="ti ti-calendar me-1"></i> Tanggal Transaksi</div>
                        <div class="info-value">{{ $sale->created_at->format('d F Y') }}</div>
                        <small class="text-muted">{{ $sale->created_at->format('H:i') }} WIB</small>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="info-label"><i class="ti ti-user me-1"></i> Pelanggan</div>
                        <div class="info-value">{{ $sale->customer->customer_name ?? 'Pelanggan Umum' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="info-label"><i class="ti ti-id-badge me-1"></i> Kasir</div>
                        <div class="info-value">Admin</div> <!-- Ganti dengan $sale->user->name jika ada relasi -->
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="info-label"><i class="ti ti-credit-card me-1"></i> Metode Bayar</div>
                        <div class="info-value">Tunai / Cash</div>
                    </div>
                </div>
            </div>

            <!-- Body Invoice (List Item) -->
            <div class="p-4 p-lg-5">
                <h6 class="fw-bold mb-4 text-dark border-start border-4 border-warning ps-3">Rincian Pesanan</h6>

                <div class="table-responsive mb-4">
                    <table class="table table-invoice w-100 mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50%;">NAMA PRODUK</th>
                                <th class="text-center" style="width: 15%;">QTY</th>
                                <th class="text-end" style="width: 15%;">HARGA SATUAN</th>
                                <th class="text-end" style="width: 20%;">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sale->saleDetails as $detail)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $detail->product->product_name }}</div>
                                        <small class="text-muted">ID: {{ $detail->product_id }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-light text-dark border px-3">{{ $detail->product_quantity }}</span>
                                    </td>
                                    <td class="text-end text-muted">
                                        Rp {{ number_format($detail->product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end fw-bold text-dark">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Summary -->
                <div class="row justify-content-end">
                    <div class="col-md-6 col-lg-5 col-xl-4">
                        <div class="summary-box">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span class="fw-semibold">Rp {{ number_format($sale->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Pajak (PPN 11%)</span>
                                <span class="text-danger fw-semibold">+ Rp
                                    {{ number_format($sale->tax_amount, 0, ',', '.') }}</span>
                            </div>
                            <hr class="my-3" style="border-top-style: dashed;">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold text-dark fs-5">Total Bayar</span>
                                <span class="grand-total">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                            </div>

                            <div class="bg-white p-3 rounded border">
                                <div class="d-flex justify-content-between mb-1 text-muted small">
                                    <span>Uang Tunai</span>
                                    <span>Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between text-success fw-bold">
                                    <span>Kembalian</span>
                                    <span>Rp {{ number_format($sale->change_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
