<script>
    let cart = [];
    const TAX_RATE = 0.11; // PPN 11%
    const POINTS_PER_1000 = 10; // 10 poin per Rp 1000

    // Customer Type Toggle
    document.querySelectorAll('input[name="customer_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const guestSection = document.getElementById('guestCustomerSection');
            const memberSection = document.getElementById('memberCustomerSection');

            if (this.value === 'guest') {
                guestSection.style.display = 'block';
                memberSection.style.display = 'none';
                document.querySelector('input[name="customer_name"]').required = true;
                document.getElementById('memberSelect').required = false;
                document.getElementById('memberSelect').value = '';
            } else {
                guestSection.style.display = 'none';
                memberSection.style.display = 'block';
                document.querySelector('input[name="customer_name"]').required = false;
                document.getElementById('memberSelect').required = true;
            }

            updateCart();
        });
    });

    // Member Select Change
    document.getElementById('memberSelect').addEventListener('change', function() {
        const memberInfoSection = document.getElementById('memberInfoSection');
        const pointDiscountSection = document.getElementById('pointDiscountSection');

        if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const point = parseInt(selectedOption.dataset.point);

            document.getElementById('currentPoint').textContent = point;
            document.getElementById('maxPoint').textContent = point;
            memberInfoSection.style.display = 'block';
            pointDiscountSection.style.display = 'block';
        } else {
            memberInfoSection.style.display = 'none';
            pointDiscountSection.style.display = 'none';
            document.getElementById('usePointDiscount').checked = false;
        }

        updateCart();
    });

    // Use Point Discount Toggle
    document.getElementById('usePointDiscount').addEventListener('change', function() {
        const discountAmountSection = document.getElementById('discountAmountSection');

        if (this.checked) {
            discountAmountSection.style.display = 'block';
        } else {
            discountAmountSection.style.display = 'none';
            document.getElementById('pointToUse').value = 0;
        }

        updateCart();
    });

    // Point to Use Input Change
    document.getElementById('pointToUse').addEventListener('input', function() {
        const maxPoint = parseInt(document.getElementById('maxPoint').textContent);
        let value = parseInt(this.value) || 0;

        // Validate max point
        if (value > maxPoint) {
            value = maxPoint;
            this.value = maxPoint;
        }

        // Update discount amount (1 poin = Rp 1)
        const discount = value;
        document.getElementById('discountAmount').textContent = formatNumber(discount);

        updateCart();
    });

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
            document.getElementById('earnedPoint').textContent = '0';
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
                        <div class="flex-grow-1 pe-2">
                            <h6 class="mb-0 fw-bold text-dark">${item.name}</h6>
                            <small class="text-muted">@ Rp ${formatNumber(item.price)}</small>
                        </div>
                        <div class="fw-bold text-end">Rp ${formatNumber(itemSubtotal)}</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="input-group input-group-sm" style="width: 90px;">
                            <button class="btn btn-outline-secondary" onclick="updateQuantity(${index}, -1)" type="button">-</button>
                            <input type="text" class="form-control text-center bg-white px-0" value="${item.quantity}" disabled>
                            <button class="btn btn-outline-secondary" onclick="updateQuantity(${index}, 1)" type="button">+</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-light text-danger" onclick="removeFromCart(${index})">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
        `;
        });

        // Calculate tax and total
        const tax = subtotal * TAX_RATE;
        let total = subtotal + tax;

        // Calculate earned points
        const earnedPoints = Math.floor(subtotal / 1000) * POINTS_PER_1000;

        // Deduct discount if using points
        if (document.getElementById('usePointDiscount').checked) {
            const pointToUse = parseInt(document.getElementById('pointToUse').value) || 0;
            total -= pointToUse;
        }

        cartItemsDiv.innerHTML = html;
        subtotalPriceDiv.textContent = 'Rp ' + formatNumber(subtotal);
        taxAmountDiv.textContent = 'Rp ' + formatNumber(tax);
        totalPriceDiv.textContent = 'Rp ' + formatNumber(Math.max(0, total));
        document.getElementById('earnedPoint').textContent = earnedPoints;

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
            document.getElementById('guestCustomerSection').style.display = 'block';
            document.getElementById('memberCustomerSection').style.display = 'none';
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

        // Validate customer type
        const customerType = document.querySelector('input[name="customer_type"]:checked').value;

        if (customerType === 'guest' && !document.querySelector('input[name="customer_name"]').value) {
            alert('Nama pelanggan harus diisi!');
            return;
        }

        if (customerType === 'member' && !document.getElementById('memberSelect').value) {
            alert('Pilih member terlebih dahulu!');
            return;
        }

        // Calculate total
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += item.price * item.quantity;
        });
        const tax = subtotal * TAX_RATE;
        let totalPrice = subtotal + tax;

        // Handle point discount
        let pointToUse = 0;
        if (document.getElementById('usePointDiscount').checked && customerType === 'member') {
            pointToUse = parseInt(document.getElementById('pointToUse').value) || 0;
            if (pointToUse > 0) {
                const confirmed = confirm(`Anda akan menggunakan ${pointToUse} poin untuk diskon Rp${formatNumber(pointToUse)}?\n\nTotal pembayaran akan menjadi: Rp${formatNumber(totalPrice - pointToUse)}`);
                if (!confirmed) {
                    return;
                }
            }
            totalPrice -= pointToUse;
        }

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
            user_id: customerType === 'member' ? document.getElementById('memberSelect').value : null,
            use_point_discount: document.getElementById('usePointDiscount').checked,
            point_to_use: pointToUse,
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
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
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
            console.error('Error:', error);
            alert('Terjadi kesalahan! ' + error.message);
        } finally {
            checkoutBtn.disabled = false;
            checkoutBtn.innerHTML = '<i class="ti ti-shopping-cart"></i> Checkout';
        }
    });
</script>
