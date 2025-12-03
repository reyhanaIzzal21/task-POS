@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <!-- Customer Info Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-lg mb-3" style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: bold;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h5 class="card-title fw-semibold mb-2">{{ $user->name }}</h5>
                    </div>

                    <div class="customer-info">
                        <div class="info-item mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block">Email</small>
                            <p class="mb-0">{{ $user->email }}</p>
                        </div>

                        <div class="info-item mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block">No. Telepon</small>
                            <p class="mb-0">{{ $user->phone_number ?? 'Tidak ada' }}</p>
                        </div>

                        <div class="info-item mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block">Alamat</small>
                            <p class="mb-0">{{ $user->address ?? 'Tidak ada' }}</p>
                        </div>

                        <div class="info-item mb-3 pb-3 border-bottom">
                            <small class="text-muted d-block">Member Poin</small>
                            <h5 class="mb-0">
                                <span class="badge bg-primary fs-6">{{ $user->point ?? 0 }} poin</span>
                            </h5>
                        </div>

                        <div class="info-item">
                            <small class="text-muted d-block">Terdaftar Sejak</small>
                            <p class="mb-0">{{ $user->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="col-lg-8 col-md-6 mb-4">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-left-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div style="flex: 1;">
                                    <p class="text-muted text-sm mb-2">Total Pembelian</p>
                                    <h3 class="fw-semibold mb-0">{{ $totalPurchases }}</h3>
                                </div>
                                <div style="font-size: 32px; color: #667eea; opacity: 0.2;">
                                    <i class="ti ti-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-left-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div style="flex: 1;">
                                    <p class="text-muted text-sm mb-2">Total Pengeluaran</p>
                                    <h3 class="fw-semibold mb-0">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h3>
                                </div>
                                <div style="font-size: 32px; color: #28a745; opacity: 0.2;">
                                    <i class="ti ti-currency-rupiah"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-left-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div style="flex: 1;">
                                    <p class="text-muted text-sm mb-2">Total Item</p>
                                    <h3 class="fw-semibold mb-0">{{ $totalItems }}</h3>
                                </div>
                                <div style="font-size: 32px; color: #ffc107; opacity: 0.2;">
                                    <i class="ti ti-package"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchase Chart -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Ringkasan Pembelian</h5>

                    @if($sales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-muted" style="font-size: 12px;">Tanggal</th>
                                        <th class="text-muted" style="font-size: 12px;">Total</th>
                                        <th class="text-muted" style="font-size: 12px;">Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales->take(5) as $sale)
                                        <tr>
                                            <td style="font-size: 12px;">{{ $sale->created_at->format('d M Y') }}</td>
                                            <td style="font-size: 12px; font-weight: 600;">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                            <td style="font-size: 12px;">{{ $sale->saleDetails->sum('product_quantity') }} item</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Belum ada riwayat pembelian</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase History -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Riwayat Pembelian Lengkap</h5>

                    @if($sales->count() > 0)
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">No. Transaksi</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Tanggal</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Total Item</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Total Harga</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Pajak</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Dibayar</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Aksi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <span class="badge bg-primary rounded-3 fw-semibold">#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-normal">{{ $sale->created_at->format('d M Y H:i') }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-normal">{{ $sale->saleDetails->sum('product_quantity') }} item</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-normal">Rp {{ number_format($sale->tax_amount, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-normal">Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-info d-inline-flex align-items-center gap-1">
                                                    <i class="ti ti-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            <p class="mb-0"><i class="ti ti-info-circle"></i> Pelanggan ini belum melakukan pembelian apapun.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Products Purchased -->
    @if($sales->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Produk yang Pernah Dibeli</h5>

                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Produk</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Harga</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Total Terbeli</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Frekuensi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $productStats = $sales->flatMap(function ($sale) {
                                            return $sale->saleDetails->map(function ($detail) {
                                                return [
                                                    'product' => $detail->product,
                                                    'quantity' => $detail->product_quantity,
                                                    'subtotal' => $detail->subtotal
                                                ];
                                            });
                                        })->groupBy('product.id')->map(function ($items) {
                                            return [
                                                'product' => $items->first()['product'],
                                                'total_quantity' => $items->sum('quantity'),
                                                'frequency' => $items->count(),
                                                'total_spent' => $items->sum('subtotal')
                                            ];
                                        })->sortByDesc('total_quantity');
                                    @endphp

                                    @forelse($productStats as $stat)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <div class="d-flex align-items-center">
                                                    @if($stat['product']->image)
                                                        <img src="{{ asset('storage/' . $stat['product']->image) }}" alt="{{ $stat['product']->product_name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px; margin-right: 10px;">
                                                    @else
                                                        <div style="width: 40px; height: 40px; background: #f0f0f0; border-radius: 5px; margin-right: 10px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="ti ti-photo" style="color: #999;"></i>
                                                        </div>
                                                    @endif
                                                    <p class="mb-0">{{ $stat['product']->product_name }}</p>
                                                </div>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">Rp {{ number_format($stat['product']->price, 0, ',', '.') }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0">{{ $stat['total_quantity'] }} {{ $stat['total_quantity'] > 1 ? 'items' : 'item' }}</p>
                                            </td>
                                            <td class="border-bottom-0">
                                                <span class="badge bg-success rounded-3">{{ $stat['frequency'] }} kali</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">Tidak ada data produk</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Back Button -->
    <div class="row mt-4">
        <div class="col-12">
            <a href="{{ route('customers.index') }}" class="btn btn-light">
                <i class="ti ti-arrow-left"></i> Kembali ke Daftar Customer
            </a>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .border-left-primary {
            border-left: 4px solid #667eea !important;
        }

        .border-left-success {
            border-left: 4px solid #28a745 !important;
        }

        .border-left-warning {
            border-left: 4px solid #ffc107 !important;
        }

        .text-sm {
            font-size: 0.875rem;
        }
    </style>
@endpush
