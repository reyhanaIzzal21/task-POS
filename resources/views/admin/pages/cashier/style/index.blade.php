<style>
    :root {
        --pos-primary: #0c19d3;
        /* Warna Emas Utama */
        --pos-dark: #212529;
        --pos-bg: #f8f9fa;
    }

    /* Container styling agar rapi di dalam Admin Template */
    .pos-container {
        background-color: var(--pos-bg);
        min-height: 85vh;
        /* Mengisi layar */
    }

    /* --- PRODUCT SECTION (KIRI) --- */
    .search-container input {
        border-radius: 50px;
        padding: 12px 20px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }

    .search-container input:focus {
        border-color: var(--pos-primary);
        box-shadow: 0 0 0 0.25rem rgba(255, 186, 37, 0.25);
    }

    .product-card {
        border: none;
        border-radius: 12px;
        background: white;
        transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        height: 100%;
        /* Agar tinggi kartu seragam */
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--pos-primary);
    }

    .product-img-wrapper {
        height: 140px;
        overflow: hidden;
        background-color: #f1f1f1;
        position: relative;
    }

    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-img-wrapper img {
        transform: scale(1.05);
    }

    /* Badge Stok */
    .stock-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
    }

    .price-text {
        color: #0c19d3;
        font-weight: 800;
        font-size: 1rem;
    }

    /* --- CART SECTION (KANAN) --- */
    .cart-panel {
        background: white;
        border-radius: 15px;
        box-shadow: -5px 0 20px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        height: calc(100vh - 100px);
        /* Menyesuaikan tinggi layar dikurangi navbar */
        position: sticky;
        top: 20px;
    }

    .cart-header {
        background: var(--pos-dark);
        color: white;
        padding: 15px 20px;
        border-radius: 15px 15px 0 0;
    }

    .cart-body {
        flex: 1;
        min-height: 300px;
        overflow-y: auto;
        padding: 15px;
    }

    /* Styling Item di Keranjang */
    .cart-item {
        border-bottom: 1px dashed #eee;
        padding: 12px 0;
        transition: background 0.2s;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-footer {
        background: #fff;
        padding: 20px;
        border-top: 2px solid #f1f1f1;
        border-radius: 0 0 15px 15px;
    }

    /* Input Pembayaran Besar */
    .input-payment {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--pos-dark);
        text-align: right;
        border: 2px solid #eee;
        border-radius: 10px;
        padding: 10px;
    }

    .input-payment:focus {
        border-color: var(--pos-primary);
        box-shadow: none;
    }

    /* Tombol Utama */
    .btn-checkout {
        background-color: var(--pos-primary);
        color: #f8f9fa;
        font-weight: 800;
        border: none;
        padding: 15px;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
    }

    .btn-checkout:hover:not(:disabled) {
        background-color: rgb(12, 25, 211);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(12, 25, 211, 0.4);
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #bbb;
    }
</style>
