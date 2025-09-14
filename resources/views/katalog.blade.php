<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muallimin Mart - Solusi Belanja Terpercaya</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2E8B57;
            --secondary-color: #FF6B35;
            --accent-color: #FFE135;
            --text-dark: #2C3E50;
            --gradient-primary: linear-gradient(135deg, #2E8B57 0%, #3CB371 100%);
            --gradient-secondary: linear-gradient(135deg, #FF6B35 0%, #FF8C42 100%);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-section {
            background: var(--gradient-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: slideInUp 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 2rem;
            animation: slideInUp 1s ease-out 0.2s both;
        }

        .btn-hero {
            background: var(--gradient-secondary);
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(255,107,53,0.4);
            animation: slideInUp 1s ease-out 0.4s both;
        }

        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255,107,53,0.6);
            color: white;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .product-image {
            height: 200px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: #6c757d;
        }

        .stats-section {
            background: var(--gradient-secondary);
            color: white;
            padding: 80px 0;
        }

        .stat-item {
            text-align: center;
            margin-bottom: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            display: block;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            margin: 1rem 0;
        }

        .testimonial-avatar {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: white;
        }

        .contact-section {
            background: #f8f9fa;
            padding: 80px 0;
        }

        .contact-info {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            height: 100%;
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            color: white;
        }

        .footer {
            background: var(--text-dark);
            color: white;
            padding: 40px 0 20px;
            /* position: absolute;
            width: 100%;
            bottom: 0; */
        }

        .social-links a {
            color: white;
            font-size: 1.5rem;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            color: var(--accent-color);
            transform: translateY(-3px);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .btn-hero {
                padding: 12px 30px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-shopping-basket me-2"></i>Muallimin Mart</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Katalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Testimoni</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
   <section>
    <div class="container-fluid py-5">
        <h1 class="mb-3 text-center">KATALOG PRODUCT</h1>
        <hr class="mb-4 w-25 mx-auto">

        {{-- Grid produk otomatis menyesuaikan layar --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach ($getProduct as $gp)
                <div class="col">
                    <div class="product-card fade-in border shadow rounded-3 overflow-hidden h-100 d-flex flex-column">
                        {{-- Gambar Produk --}}
                        <div class="product-image  position-relative">
                            @if ($gp->foto)
                                <img src="{{ asset('storage/' . $gp->foto) }}"
                                     alt="{{ $gp->name }}" class="img-fluid w-100 product-img">
                            @else
                                <div class="d-flex justify-content-center align-items-center bg-light product-img">
                                    <i class="fas fa-box fa-3x text-secondary"></i>
                                </div>
                            @endif

                            {{-- Badge Status --}}

                        </div>

                        {{-- Info Produk --}}
                        <div class="product-info p-3 flex-grow-1 d-flex flex-column">
                            <div class="product-sku text-muted small mb-1">SKU: {{ $gp->sku }}</div>
                            <h5 class="product-name fw-semibold">{{ $gp->name }}</h5>

                            <div class="product-price d-flex justify-content-between align-items-center mt-2">
                                <div>
                                    <div class="selling-price fw-bold text-success">
                                        Rp{{ number_format($gp->selling_price, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="product-unit text-uppercase small text-muted">
                                    {{ $gp->unit }}
                                </div>
                            </div>

                            <div class="product-details mt-auto">
                                <span class="product-stock {{ $gp->stock > 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="fas fa-cube me-1"></i>
                                    {{ $gp->stock > 0 ? $gp->stock . ' tersedia' : 'Stok habis' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .product-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: #fff;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }
    .product-img {
        height: 200px;
        object-fit: cover;
    }
</style>


    {{-- CSS tambahan agar lebih elegan --}}
    <style>
        .product-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background: #fff;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }
        .product-image img {
            height: 200px;
            object-fit: cover;
        }
    </style>

    <!-- Footer -->
    @include('component.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 70;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.15)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            }
        });

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, observerOptions);

        // Observe all elements with animate-on-scroll class
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });

        // Counter animation for stats
        const animateCounters = () => {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = counter.textContent.replace(/[^0-9]/g, '');
                const count = +target;
                const increment = count / 200;
                let current = 0;

                const updateCounter = () => {
                    if (current < count) {
                        current += increment;
                        counter.textContent = Math.ceil(current) + (counter.textContent.includes('+') ? '+' : '');
                        setTimeout(updateCounter, 10);
                    } else {
                        counter.textContent = counter.textContent;
                    }
                };
                updateCounter();
            });
        };

        // Trigger counter animation when stats section is visible
        const statsSection = document.querySelector('.stats-section');
        let statsAnimated = false;

        const statsObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting && !statsAnimated) {
                    animateCounters();
                    statsAnimated = true;
                }
            });
        }, { threshold: 0.5 });

        if (statsSection) {
            statsObserver.observe(statsSection);
        }

        // Add hover effects for cards
        document.querySelectorAll('.feature-card, .product-card, .testimonial-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add loading animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.3s ease';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });

        // Add click effects for buttons
        document.querySelectorAll('.btn-hero').forEach(btn => {
            btn.addEventListener('click', function(e) {
                let ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255,255,255,0.6)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.left = (e.clientX - e.target.offsetLeft - 25) + 'px';
                ripple.style.top = (e.clientY - e.target.offsetTop - 25) + 'px';
                ripple.style.width = ripple.style.height = '50px';

                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add ripple animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>