<style>
    :root {
        --primary-blue: #0c19d3;
        --secondary-blue: #0c19d3;
        --accent-orange: #ff7300;
        --light-orange: #f36709;
        --white: #ffffff;
        --light-gray: #f8f9fa;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
        color: var(--primary-blue);
    }

    /* Navbar */
    .navbar {
        background: rgba(12, 25, 211, 0.95) !important;
        backdrop-filter: blur(10px);
        padding: 20px 0;
        transition: all 0.3s ease;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--white) !important;
        letter-spacing: 1px;
    }

    .navbar-brand span {
        color: var(--accent-orange);
    }

    .nav-link {
        color: var(--white) !important;
        font-weight: 500;
        margin: 0 15px;
        transition: color 0.3s ease;
        position: relative;
    }

    .nav-link:hover {
        color: var(--accent-orange) !important;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -5px;
        left: 0;
        background: var(--accent-orange);
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    /* Hero Section */
    .hero {
        position: relative;
        height: 100vh;
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        overflow: hidden;
        display: flex;
        align-items: center;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=1600') center/cover;
        opacity: 0.15;
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        color: var(--white);
    }

    .hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 72px;
        font-weight: 700;
        margin-bottom: 20px;
        animation: fadeInUp 1s ease;
    }

    .hero h1 span {
        color: var(--accent-orange);
    }

    .hero p {
        font-size: 20px;
        margin-bottom: 40px;
        animation: fadeInUp 1.2s ease;
        max-width: 600px;
    }

    .btn-custom {
        background: var(--accent-orange);
        color: var(--white);
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        animation: fadeInUp 1.4s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-custom:hover {
        background: var(--light-orange);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(255, 107, 53, 0.4);
    }

    .hero-image {
        position: relative;
        animation: float 3s ease-in-out infinite;
    }

    .hero-image img {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    /* About Section */
    .about {
        padding: 100px 0;
        background: var(--light-gray);
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 48px;
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60%;
        height: 4px;
        background: var(--accent-orange);
    }

    .about-text {
        font-size: 18px;
        line-height: 1.8;
        color: var(--secondary-blue);
        margin-top: 30px;
    }

    .feature-box {
        text-align: center;
        padding: 30px;
        background: var(--white);
        border-radius: 15px;
        transition: all 0.3s ease;
        margin-top: 30px;
        height: 100%;
    }

    .feature-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
        font-size: 48px;
        color: var(--accent-orange);
        margin-bottom: 20px;
    }

    .feature-box h4 {
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--primary-blue);
    }

    /* Menu Section */
    .menu {
        padding: 100px 0;
        background: var(--white);
    }

    .menu-card {
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        margin-bottom: 30px;
        height: 100%;
    }

    .menu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }

    .menu-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .menu-card-body {
        padding: 25px;
    }

    .menu-card-body h4 {
        font-weight: 600;
        color: var(--primary-blue);
        margin-bottom: 10px;
    }

    .menu-card-body p {
        color: var(--secondary-blue);
        font-size: 14px;
        margin-bottom: 15px;
    }

    .price {
        color: var(--accent-orange);
        font-weight: 700;
        font-size: 24px;
    }

    /* Gallery */
    .gallery {
        padding: 100px 0;
        background: var(--light-gray);
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        margin-bottom: 30px;
        cursor: pointer;
    }

    .gallery-item img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(12, 25, 211, 0.8), rgba(255, 107, 53, 0.8));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-overlay i {
        font-size: 48px;
        color: var(--white);
    }

    /* Contact */
    .contact {
        padding: 100px 0;
        background: var(--primary-blue);
        color: var(--white);
    }

    .contact .section-title {
        color: var(--white);
    }

    .contact-info {
        margin-top: 40px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
    }

    .contact-item i {
        font-size: 24px;
        color: var(--accent-orange);
        margin-right: 20px;
        width: 40px;
    }

    .contact-item div h5 {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .social-links {
        margin-top: 40px;
    }

    .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: var(--accent-orange);
        color: var(--white);
        border-radius: 50%;
        margin-right: 15px;
        transition: all 0.3s ease;
        font-size: 20px;
    }

    .social-links a:hover {
        background: var(--light-orange);
        transform: translateY(-5px);
    }

    /* Membership Program Section */
    .membership-program {
        padding: 100px 0;
        background: linear-gradient(135deg, var(--primary-blue) 0%, rgba(12, 25, 211, 0.9) 100%);
        color: var(--white);
    }

    .membership-content {
        position: relative;
    }

    .membership-image {
        margin-bottom: 30px;
    }

    .membership-image img {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .membership-title {
        color: var(--white);
    }

    .membership-title::after {
        background: var(--accent-orange);
    }

    .membership-subtitle {
        font-size: 20px;
        color: rgba(255, 255, 255, 0.9);
        margin-top: 15px;
        margin-bottom: 40px;
    }

    .membership-benefits {
        margin: 40px 0;
    }

    .benefit-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .benefit-item:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateX(10px);
    }

    .benefit-icon {
        flex-shrink: 0;
        width: 50px;
        height: 50px;
        background: var(--accent-orange);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        font-size: 24px;
    }

    .benefit-content h5 {
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--white);
    }

    .benefit-content p {
        color: rgba(255, 255, 255, 0.85);
        font-size: 14px;
        margin: 0;
    }

    .membership-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin: 40px 0;
    }

    .stat-item {
        text-align: center;
        padding: 25px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-item h4 {
        font-size: 28px;
        font-weight: 700;
        color: var(--accent-orange);
        margin-bottom: 8px;
    }

    .stat-item p {
        color: rgba(255, 255, 255, 0.85);
        font-size: 14px;
        margin: 0;
    }

    .btn-membership {
        margin-top: 30px;
        padding: 15px 50px;
        font-size: 16px;
    }

    .membership-login {
        margin-top: 20px;
        color: rgba(255, 255, 255, 0.9);
    }

    .membership-login a {
        color: var(--accent-orange);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .membership-login a:hover {
        text-decoration: underline;
    }

    .membership-status {
        margin-top: 30px;
        padding: 15px 20px;
        background: rgba(76, 175, 80, 0.2);
        border-left: 4px solid #4CAF50;
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.95);
        font-weight: 500;
    }

    /* Footer */
    footer {
        background: var(--primary-blue);
        color: var(--white);
        padding: 30px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 42px;
        }

        .hero p {
            font-size: 16px;
        }

        .section-title {
            font-size: 36px;
        }

        .hero {
            height: auto;
            padding: 100px 0;
        }

        .membership-stats {
            grid-template-columns: 1fr;
        }

        .benefit-item {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .benefit-icon {
            margin-right: 0;
            margin-bottom: 15px;
        }
    }
</style>
