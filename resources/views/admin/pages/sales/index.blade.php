@extends('admin.layouts.app')

@section('style')
    <style>
        :root {
            --pos-primary: #ffba25;
            --pos-dark: #212529;
            --pos-bg: #f8f9fa;
        }

        .filter-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            border: 1px solid #eee;
        }

        .table-custom thead th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #eee;
        }

        .table-custom tbody tr {
            transition: all 0.2s ease;
        }

        .table-custom tbody tr:hover {
            background-color: #fffbf0;
            /* Warna kuning sangat muda saat hover */
            transform: translateY(-1px);
        }

        .trans-id {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: var(--pos-dark);
            background: #fff;
            border: 1px solid #ddd;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .price-text {
            color: #d39e00;
            font-weight: bold;
        }

        .btn-action-view {
            background-color: #e2e6ea;
            color: var(--pos-dark);
            border: none;
        }

        .btn-action-view:hover {
            background-color: var(--pos-primary);
            color: #000;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid p-0">

        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Riwayat Transaksi</h4>
                <p class="text-muted mb-0 font-14">Pantau semua pemasukan dan data pesanan di sini.</p>
            </div>
            <!-- Optional: Bisa tambah tombol export excel disini nanti -->
        </div>

        <!-- Filter Card -->
        <div class="filter-card p-4 mb-4">
            <form action="{{ route('sales.index') }}" method="GET">
                <div class="row g-3">
                    <!-- Search Text -->
                    <div class="col-lg-4 col-md-12">
                        <label class="form-label small text-muted">Pencarian</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="ti ti-search"></i></span>
                            <input type="text" name="search" class="form-control border-start-0"
                                placeholder="Cari Nama / No Transaksi..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label small text-muted">Rentang Tanggal</label>
                        <div class="input-group">
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            <span class="input-group-text bg-light border-start-0 border-end-0">s/d</span>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label small text-muted">Rentang Harga (Rp)</label>
                        <div class="input-group">
                            <input type="number" name="price_from" class="form-control" placeholder="Min"
                                value="{{ request('price_from') }}">
                            <span class="input-group-text bg-light">-</span>
                            <input type="number" name="price_to" class="form-control" placeholder="Max"
                                value="{{ request('price_to') }}">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('sales.index') }}" class="btn btn-light border">
                            <i class="ti ti-rotate-clockwise me-1"></i> Reset
                        </a>
                        <button type="submit" class="btn btn-dark px-4" style="background-color: var(--pos-dark);">
                            <i class="ti ti-filter me-1"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0 align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4">No. Transaksi</th>
                                <th>Tanggal & Waktu</th>
                                <th>Pelanggan</th>
                                <th>Total Transaksi</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <span class="trans-id">#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-semibold text-dark">{{ $sale->created_at->format('d M Y') }}</span>
                                            <small class="text-muted">{{ $sale->created_at->format('H:i') }} WIB</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-2 me-2 d-flex justify-content-center align-items-center"
                                                style="width: 35px; height: 35px;">
                                                <i class="ti ti-user text-muted"></i>
                                            </div>
                                            <span
                                                class="fw-medium">{{ $sale->customer->customer_name ?? 'Pelanggan Umum' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="price-text fs-5">Rp
                                            {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('sales.show', $sale->id) }}"
                                                class="btn btn-sm btn-action-view rounded-start" title="Lihat Detail">
                                                <i class="ti ti-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('cashier.receipt', $sale->id) }}" target="_blank"
                                                class="btn btn-sm btn-outline-secondary rounded-end" title="Cetak Struk">
                                                <i class="ti ti-printer"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="mb-3 p-3 bg-light rounded-circle">
                                                <i class="ti ti-file-off fs-1 text-muted"></i>
                                            </div>
                                            <h6 class="fw-semibold text-dark">Tidak ada data transaksi ditemukan.</h6>
                                            <p class="text-muted small">Coba ubah filter pencarian Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Footer -->
            @if ($sales->hasPages())
                <div class="card-footer bg-white border-top p-3">
                    <div class="d-flex justify-content-end">
                        {{ $sales->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
