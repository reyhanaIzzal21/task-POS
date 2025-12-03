@extends('user.layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1>Welcome to <span>Urban Starlet</span></h1>
                        <p>Tempat nongkrong favorit anak muda dengan vibes modern, coffee berkualitas, dan suasana yang
                            instagramable!</p>
                        <button class="btn btn-custom">Explore Menu</button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <img src="{{ asset('assets/images/backgrounds/hero.jpg') }}" alt="Coffee" class="w-600">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="section-title">About Us</h2>
                    <p class="about-text">
                        Urban Starlet adalah cafe modern yang dirancang khusus untuk generasi muda yang mencintai coffee
                        culture dan aesthetic vibes. Kami menghadirkan pengalaman ngopi yang berbeda dengan interior
                        modern, musik chill, dan tentunya kopi berkualitas premium.
                    </p>
                    <p class="about-text">
                        Di sini, kamu bisa bekerja, belajar, atau sekadar hangout dengan teman sambil menikmati berbagai
                        pilihan menu kopi, makanan, dan dessert yang instagramable!
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="fas fa-coffee feature-icon"></i>
                                <h4>Premium Coffee</h4>
                                <p>Biji kopi pilihan dari berbagai daerah di Indonesia</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="fas fa-wifi feature-icon"></i>
                                <h4>Free WiFi</h4>
                                <p>Internet cepat untuk remote work atau study</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="fas fa-camera feature-icon"></i>
                                <h4>Instagramable</h4>
                                <p>Spot foto aesthetic di setiap sudut cafe</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="fas fa-music feature-icon"></i>
                                <h4>Chill Vibes</h4>
                                <p>Musik santai yang bikin betah berlama-lama</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="menu" id="menu">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Our Menu</h2>
                <p class="mt-3">Signature drinks dan makanan yang wajib kamu coba!</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card">
                        <img src="https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400" alt="Espresso">
                        <div class="menu-card-body">
                            <h4>Signature Espresso</h4>
                            <p>Double shot espresso dengan crema sempurna</p>
                            <span class="price">Rp 28.000</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card">
                        <img src="https://images.unsplash.com/photo-1517487881594-2787fef5ebf7?w=400" alt="Latte">
                        <div class="menu-card-body">
                            <h4>Urban Latte</h4>
                            <p>Creamy latte dengan latte art yang cantik</p>
                            <span class="price">Rp 35.000</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card">
                        <img src="https://images.unsplash.com/photo-1578314675249-a6910f80cc4e?w=400" alt="Matcha">
                        <div class="menu-card-body">
                            <h4>Starlet Matcha</h4>
                            <p>Matcha latte premium dengan foam tebal</p>
                            <span class="price">Rp 38.000</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card">
                        <img src="https://images.unsplash.com/photo-1558326567-98ae2405596b?w=400" alt="Croissant">
                        <div class="menu-card-body">
                            <h4>Butter Croissant</h4>
                            <p>Croissant renyah dengan butter premium</p>
                            <span class="price">Rp 25.000</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card">
                        <img src="https://images.unsplash.com/photo-1551024506-0bccd828d307?w=400" alt="Pasta">
                        <div class="menu-card-body">
                            <h4>Aglio Olio Pasta</h4>
                            <p>Pasta klasik dengan twist modern</p>
                            <span class="price">Rp 45.000</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card">
                        <img src="https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?w=400" alt="Cake">
                        <div class="menu-card-body">
                            <h4>Tiramisu Cake</h4>
                            <p>Dessert favorit dengan rasa autentik</p>
                            <span class="price">Rp 32.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery -->
    <section class="gallery" id="gallery">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Gallery</h2>
                <p class="mt-3">Intip suasana dan vibes di Urban Starlet!</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?w=400" alt="Interior">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?w=400" alt="Coffee">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1521017432531-fbd92d768814?w=400" alt="Ambiance">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=400" alt="Food">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=400" alt="Barista">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=400" alt="Coffee Art">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Program Section -->
    <section class="membership-program" id="membership">
        <div class="container">
            <div class="membership-content">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="membership-image">
                            <img src="{{ asset('assets/images/backgrounds/cta.jpg') }}"
                                alt="Membership" class="w-500">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h2 class="section-title membership-title">Bergabunglah dengan Urban Starlet Members</h2>
                        <p class="membership-subtitle">Dapatkan keuntungan eksklusif sebagai member kami!</p>

                        <div class="membership-benefits">
                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="benefit-content">
                                    <h5>Kumpulkan Poin Reward</h5>
                                    <p>Setiap pembelian, dapatkan poin yang dapat ditukarkan dengan diskon menarik!</p>
                                </div>
                            </div>

                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <div class="benefit-content">
                                    <h5>Tukar Poin dengan Diskon</h5>
                                    <p>Kumpulkan 1000 poin = Rp 50.000 diskon untuk pembelian berikutnya</p>
                                </div>
                            </div>

                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-cake-candles"></i>
                                </div>
                                <div class="benefit-content">
                                    <h5>Bonus di Hari Istimewa</h5>
                                    <p>Dapatkan bonus poin 2x lipat di hari ulang tahun Anda!</p>
                                </div>
                            </div>

                            <div class="benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-crown"></i>
                                </div>
                                <div class="benefit-content">
                                    <h5>VIP Membership</h5>
                                    <p>Nikmati akses eksklusif dan promo khusus member premium</p>
                                </div>
                            </div>
                        </div>

                        <div class="membership-stats">
                            <div class="stat-item">
                                <h4>10x Poin</h4>
                                <p>Per Rp 1000 pembelian</p>
                            </div>
                            <div class="stat-item">
                                <h4>Unlimited</h4>
                                <p>Poin tidak pernah hangus</p>
                            </div>
                            <div class="stat-item">
                                <h4>Gratis!</h4>
                                <p>Tidak ada biaya membership</p>
                            </div>
                        </div>

                        @if (Route::has('login'))
                            @auth
                                <p class="membership-status">✓ Anda sudah menjadi member kami! Terima kasih.</p>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-custom btn-membership">Daftar Member
                                    Sekarang</a>
                                <p class="membership-login">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                                </p>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
