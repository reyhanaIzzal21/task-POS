@extends('admin.layouts.app')

@section('style')
    @include('admin.pages.cashier.style.index')
@endsection


@section('content')
    <div class="pos-container px-3 py-3">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-0 text-dark"><i class="ti ti-coffee me-2 text-info"></i>Daftar Menu</h4>
                        <small class="text-muted">Pilih produk untuk menambah ke pesanan</small>
                    </div>
                    <div class="search-container w-50">
                        <input type="text" id="searchProduct" class="form-control" placeholder="Cari menu...">
                    </div>
                </div>

                <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3" id="productList">
                    @foreach ($products as $product)
                        <div class="col product-item">
                            <div class="card product-card h-100"
                                onclick="addToCart({{ $product->id }}, '{{ $product->product_name }}', {{ $product->price }}, {{ $product->stock }})">

                                <div class="product-img-wrapper">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->product_name }}">
                                    @else
                                        <div
                                            class="d-flex align-items-center justify-content-center h-100 bg-light text-secondary">
                                            <i class="ti ti-photo fs-1"></i>
                                        </div>
                                    @endif
                                    <span class="stock-badge">Stok: {{ $product->stock }}</span>
                                </div>

                                <div class="card-body p-3 d-flex flex-column">
                                    <h6 class="fw-bold mb-1 text-dark text-truncate" title="{{ $product->product_name }}">
                                        {{ $product->product_name }}
                                    </h6>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="price-text">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-panel">
                    <div class="cart-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-white"><i class="ti ti-shopping-cart me-2"></i>Current Order</h5>
                        <button type="button" class="btn btn-sm btn-outline-light border-0" onclick="clearCart()">
                            <i class="ti ti-trash"></i> Reset
                        </button>
                    </div>

                    <div class="cart-body" id="cartItems">
                        <div
                            class="d-flex flex-column align-items-center justify-content-center h-100 text-muted opacity-50">
                            <i class="ti ti-shopping-cart-off fs-1 mb-2"></i>
                            <p>Belum ada item dipilih</p>
                        </div>
                    </div>

                    <div class="cart-footer">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-secondary">Subtotal</span>
                            <span class="fw-bold text-dark" id="subtotalPrice">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary">PPN (11%)</span>
                            <span class="fw-bold text-dark" id="taxAmount">Rp 0</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3 pt-3 border-top">
                            <h4 class="fw-bold mb-0">Total</h4>
                            <h3 class="fw-bold text-primary mb-0" id="totalPrice" style="color: #0c19d3 !important;">Rp 0
                            </h3>
                        </div>

                        <form id="checkoutForm">
                            <div class="mb-3">
                                <label class="small text-muted mb-1 fw-bold">Tipe Pelanggan</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="customer_type" id="customerTypeGuest" value="guest" checked>
                                    <label class="btn btn-outline-primary" for="customerTypeGuest">Guest</label>

                                    <input type="radio" class="btn-check" name="customer_type" id="customerTypeMember" value="member">
                                    <label class="btn btn-outline-primary" for="customerTypeMember">Member</label>
                                </div>
                            </div>

                            <!-- Guest Customer -->
                            <div id="guestCustomerSection">
                                <div class="mb-3">
                                    <input type="text" name="customer_name" class="form-control bg-light border-0 py-2"
                                        placeholder="Nama Pelanggan (Wajib)" required>
                                </div>
                            </div>

                            <!-- Member Customer -->
                            <div id="memberCustomerSection" style="display: none;">
                                <div class="mb-3">
                                    <label class="small text-muted mb-1">Pilih Member</label>
                                    <select id="memberSelect" name="user_id" class="form-select bg-light border-0 py-2">
                                        <option value="">-- Pilih Member --</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}" data-point="{{ $member->point }}">
                                                {{ $member->name }} (Poin: {{ $member->point }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="memberInfoSection" style="display: none;">
                                    <div class="alert alert-soft-info py-2 px-3 mb-3" style="background-color: #cff0fc;">
                                        <small class="text-info-emphasis">
                                            <strong>Poin Saat Ini:</strong> <span id="currentPoint">0</span> poin
                                        </small>
                                    </div>

                                    <div class="alert alert-soft-success py-2 px-3 mb-3" style="background-color: #d1e7dd;">
                                        <small class="text-success-emphasis">
                                            <strong>Poin Didapat:</strong> <span id="earnedPoint">0</span> poin
                                        </small>
                                    </div>

                                    <div id="pointDiscountSection" style="display: none;">
                                        <label class="small text-muted mb-2 fw-bold">
                                            <input type="checkbox" id="usePointDiscount" name="use_point_discount">
                                            Tukar Poin menjadi Diskon
                                        </label>
                                        <div id="discountAmountSection" style="display: none; margin-top: 10px;">
                                            <input type="number" id="pointToUse" name="point_to_use" class="form-control bg-light border-0 py-2"
                                                placeholder="Jumlah poin yang ingin ditukar (default: 0)" min="0" value="0">
                                            <small class="text-muted d-block mt-1">Max: <span id="maxPoint">0</span> poin</small>
                                            <div class="alert alert-soft-warning py-2 px-3 mt-2" style="background-color: #fff3cd;">
                                                <small class="text-warning-emphasis">
                                                    Diskon yang didapat: Rp <span id="discountAmount">0</span>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="small text-muted mb-1">Uang Diterima (Rp)</label>
                                <input type="number" id="paidAmount" name="paid_amount" class="form-control input-payment"
                                    placeholder="0" required min="0" step="1000">
                            </div>

                            <div class="alert alert-soft-success py-2 px-3 mb-3" id="changeAlert"
                                style="display: none; background-color: #d1e7dd;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="fw-bold text-success-emphasis">Kembalian:</small>
                                    <h5 class="mb-0 fw-bold text-success-emphasis" id="changeAmount">Rp 0</h5>
                                </div>
                            </div>

                            <button type="submit" class="btn-checkout w-100 shadow" id="checkoutBtn">
                                <i class="ti ti-check me-2"></i> PROSES PEMBAYARAN
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    @include('admin.pages.cashier.widgets.script.index')
@endsection
