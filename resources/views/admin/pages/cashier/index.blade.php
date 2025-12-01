@extends('admin.layouts.app')

@section('style')
    <style>
        .product-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .cart-item {
            border-bottom: 1px solid #e9ecef;
            padding: 10px 0;
        }

        .cart-summary {
            position: sticky;
            top: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <!-- Product List -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Daftar Produk</h5>

                    <!-- Search Product -->
                    <div class="mb-4">
                        <input type="text" id="searchProduct" class="form-control" placeholder="Cari produk...">
                    </div>

                    <div class="row" id="productList">
                        @foreach ($products as $product)
                            <div class="col-md-6 col-lg-4 mb-3 product-item">
                                <div class="card product-card"
                                    onclick="addToCart({{ $product->id }}, '{{ $product->product_name }}', {{ $product->price }}, {{ $product->stock }})">
                                    <div class="card-body">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                class="img-fluid rounded mb-2" alt="{{ $product->product_name }}">
                                        @else
                                            <div class="bg-light rounded mb-2 d-flex align-items-center justify-content-center"
                                                style="height: 150px;">
                                                <i class="ti ti-photo fs-1 text-muted"></i>
                                            </div>
                                        @endif
                                        <h6 class="fw-semibold">{{ $product->product_name }}</h6>
                                        <p class="text-primary fw-bold mb-1">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <small class="text-muted">Stok: {{ $product->stock }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart & Checkout -->
        <div class="col-lg-4">
            <div class="card cart-summary">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Keranjang</h5>

                    <!-- Cart Items -->
                    <div id="cartItems" class="mb-3" style="max-height: 300px; overflow-y: auto;">
                        <p class="text-muted text-center">Keranjang kosong</p>
                    </div>

                    <!-- Total -->
                    <div class="border-top pt-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Subtotal:</span>
                            <span class="fw-bold" id="subtotalPrice">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Pajak (PPN 11%):</span>
                            <span class="fw-bold" id="taxAmount">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-top pt-2">
                            <h5 class="mb-0">Total:</h5>
                            <h4 class="text-primary mb-0" id="totalPrice">Rp 0</h4>
                        </div>
                    </div>

                    <!-- Customer Form -->
                    <form id="checkoutForm">
                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan *</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>
                        {{-- <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="address" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="phone_number" class="form-control">
                        </div> --}}

                        <!-- Payment Section -->
                        <div class="border-top pt-3 mb-3">
                            <div class="mb-3">
                                <label class="form-label">Uang Pembeli *</label>
                                <input type="number" id="paidAmount" name="paid_amount"
                                    class="form-control form-control-lg" placeholder="0" required min="0"
                                    step="1000">
                            </div>
                            <div class="alert alert-info mb-3" id="changeAlert" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>Kembalian:</strong>
                                    <h5 class="mb-0 text-success" id="changeAmount">Rp 0</h5>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-danger" onclick="clearCart()">
                                <i class="ti ti-trash"></i> Bersihkan
                            </button>
                            <button type="submit" class="btn btn-primary" id="checkoutBtn">
                                <i class="ti ti-shopping-cart"></i> Checkout
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let cart = [];
        const TAX_RATE = 0.11; // PPN 11%

        // Add to Cart
        function addToCart(id, name, price, stock) {
            const existingItem = cart.find(item => item.product_id === id);

            if (existingItem) {
                if (existingItem.quantity >= stock) {
                    alert('Stok tidak mencukupi!');
                    return;
                }
                existingItem.quantity++;
            } else {
                cart.push({
                    product_id: id,
                    name: name,
                    price: price,
                    quantity: 1,
                    stock: stock
                });
            }

            updateCart();
        }

        // Update Cart Display
        function updateCart() {
            const cartItemsDiv = document.getElementById('cartItems');
            const subtotalPriceDiv = document.getElementById('subtotalPrice');
            const taxAmountDiv = document.getElementById('taxAmount');
            const totalPriceDiv = document.getElementById('totalPrice');

            if (cart.length === 0) {
                cartItemsDiv.innerHTML = '<p class="text-muted text-center">Keranjang kosong</p>';
                subtotalPriceDiv.textContent = 'Rp 0';
                taxAmountDiv.textContent = 'Rp 0';
                totalPriceDiv.textContent = 'Rp 0';
                calculateChange();
                return;
            }

            let html = '';
            let subtotal = 0;

            cart.forEach((item, index) => {
                const itemSubtotal = item.price * item.quantity;
                subtotal += itemSubtotal;

                html += `
            <div class="cart-item">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">${item.name}</h6>
                        <small class="text-muted">Rp ${formatNumber(item.price)}</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeFromCart(${index})">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(${index}, -1)">-</button>
                        <button type="button" class="btn btn-outline-secondary" disabled>${item.quantity}</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(${index}, 1)">+</button>
                    </div>
                    <strong>Rp ${formatNumber(itemSubtotal)}</strong>
                </div>
            </div>
        `;
            });

            // Calculate tax and total
            const tax = subtotal * TAX_RATE;
            const total = subtotal + tax;

            cartItemsDiv.innerHTML = html;
            subtotalPriceDiv.textContent = 'Rp ' + formatNumber(subtotal);
            taxAmountDiv.textContent = 'Rp ' + formatNumber(tax);
            totalPriceDiv.textContent = 'Rp ' + formatNumber(total);

            // Update change calculation
            calculateChange();
        }

        // Update Quantity
        function updateQuantity(index, change) {
            const item = cart[index];
            const newQuantity = item.quantity + change;

            if (newQuantity <= 0) {
                removeFromCart(index);
                return;
            }

            if (newQuantity > item.stock) {
                alert('Stok tidak mencukupi!');
                return;
            }

            item.quantity = newQuantity;
            updateCart();
        }

        // Remove from Cart
        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCart();
        }

        // Clear Cart
        function clearCart() {
            if (confirm('Yakin ingin membersihkan keranjang?')) {
                cart = [];
                updateCart();
                document.getElementById('checkoutForm').reset();
            }
        }

        // Format Number
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Calculate Change
        function calculateChange() {
            const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
            const totalPriceText = document.getElementById('totalPrice').textContent.replace('Rp ', '').replace(/\./g, '');
            const totalPrice = parseFloat(totalPriceText) || 0;

            const change = paidAmount - totalPrice;
            const changeAlert = document.getElementById('changeAlert');
            const changeAmountDiv = document.getElementById('changeAmount');

            if (paidAmount > 0 && change >= 0) {
                changeAlert.style.display = 'block';
                changeAmountDiv.textContent = 'Rp ' + formatNumber(change);
                changeAmountDiv.className = 'mb-0 text-success';
            } else if (paidAmount > 0 && change < 0) {
                changeAlert.style.display = 'block';
                changeAmountDiv.textContent = 'Kurang: Rp ' + formatNumber(Math.abs(change));
                changeAmountDiv.className = 'mb-0 text-danger';
            } else {
                changeAlert.style.display = 'none';
            }
        }

        // Event listener for paid amount
        document.getElementById('paidAmount').addEventListener('input', calculateChange);

        // Search Product
        document.getElementById('searchProduct').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const products = document.querySelectorAll('.product-item');

            products.forEach(product => {
                const text = product.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            });
        });

        // Checkout
        document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            if (cart.length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }

            // Calculate total
            let subtotal = 0;
            cart.forEach(item => {
                subtotal += item.price * item.quantity;
            });
            const totalPrice = subtotal + (subtotal * TAX_RATE);

            // Get paid amount
            const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;

            // Validate payment
            if (paidAmount < totalPrice) {
                alert('Uang pembayaran tidak mencukupi!');
                return;
            }

            const formData = new FormData(this);
            const data = {
                customer_name: formData.get('customer_name'),
                address: formData.get('address'),
                phone_number: formData.get('phone_number'),
                paid_amount: paidAmount,
                cart: cart
            };

            const checkoutBtn = document.getElementById('checkoutBtn');
            checkoutBtn.disabled = true;
            checkoutBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

            try {
                const response = await fetch('{{ route('cashier.checkout') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    // Redirect ke halaman struk
                    window.location.href = result.redirect_url;
                } else {
                    alert(result.message || 'Terjadi kesalahan!');
                }
            } catch (error) {
                alert('Terjadi kesalahan! ' + error.message);
            } finally {
                checkoutBtn.disabled = false;
                checkoutBtn.innerHTML = '<i class="ti ti-shopping-cart"></i> Checkout';
            }
        });
    </script>
@endsection
