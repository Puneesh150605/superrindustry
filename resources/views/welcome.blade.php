@extends('layouts.app')

@section('title', 'Exquisite Wooden Craftsmanship')

@push('styles')
<style>
    /* Hero Section */
    .hero {
        height: 100vh;
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    .hero-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 120%; /* For deeper parallax */
        object-fit: cover;
        z-index: -2;
        filter: brightness(0.5);
    }

    .hero-gradient {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(15, 17, 16, 0.9) 0%, rgba(15, 17, 16, 0.4) 50%, rgba(15, 17, 16, 0.1) 100%);
        z-index: -1;
    }

    .hero-content {
        max-width: 800px;
        opacity: 0; /* GSAP will animate this */
        transform: translateY(30px);
    }

    .hero-subtitle {
        font-family: var(--font-body);
        font-size: 1rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 1.5rem;
        display: block;
    }

    .hero-title {
        font-size: 5rem;
        margin-bottom: 2rem;
        color: #ffffff;
        line-height: 1.1;
    }

    .hero-desc {
        font-size: 1.2rem;
        line-height: 1.6;
        color: var(--text-secondary);
        margin-bottom: 3rem;
        max-width: 600px;
    }

    /* Brand Story */
    .brand-story {
        padding: 10rem 0;
        background-color: var(--bg-dark);
        position: relative;
    }
    
    .story-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6rem;
        align-items: center;
    }
    
    .story-text h2 {
        font-size: 3.5rem;
        margin-bottom: 2rem;
    }
    
    .story-text p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }
    
    .story-img-container {
        position: relative;
    }
    
    .story-img-container img {
        width: 100%;
        border-radius: 4px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.5);
    }

    /* Collections */
    .collections {
        padding: 8rem 0;
        background: var(--bg-card);
    }

    .collections-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .collection-card {
        position: relative;
        height: 500px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .collection-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.5s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 1;
        filter: brightness(0.6);
    }

    .collection-card:hover .collection-img {
        transform: scale(1.05);
        filter: brightness(0.4);
    }

    .collection-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .collection-title {
        font-size: 3rem;
        color: #fff;
        margin-bottom: 1rem;
    }

    /* Featured Section */
    .featured-section {
        padding: 10rem 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 5rem;
    }

    .section-title {
        font-size: 3.5rem;
        color: var(--text-primary);
        margin-bottom: 1rem;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 3rem;
    }

    .product-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        padding: 2rem;
        border-radius: 4px;
        transition: var(--transition-smooth);
        text-decoration: none;
        display: block;
        color: var(--text-primary);
    }

    .product-card:hover {
        transform: translateY(-10px);
        border-color: var(--accent);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }

    .product-img-wrapper {
        width: 100%;
        height: 350px;
        overflow: hidden;
        margin-bottom: 2rem;
        border-radius: 2px;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .product-card:hover .product-img {
        transform: scale(1.08);
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-title {
        font-size: 1.5rem;
        font-family: var(--font-heading);
    }

    .product-price {
        font-size: 1.2rem;
        color: var(--accent);
    }

    /* Eco-Friendly */
    .eco-promise {
        padding: 8rem 0;
        text-align: center;
        border-top: 1px solid var(--border-color);
    }

    .eco-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 4rem;
        margin-top: 5rem;
    }

    .eco-item h3 {
        font-size: 1.5rem;
        color: var(--accent);
        margin-bottom: 1rem;
    }

    .eco-item p {
        color: var(--text-secondary);
        line-height: 1.6;
    }

    /* Process Timeline */
    .process-section {
        padding: 8rem 0;
        background: var(--bg-dark);
    }
    
    .process-steps {
        display: flex;
        justify-content: space-between;
        margin-top: 4rem;
        position: relative;
    }
    
    .process-steps::before {
        content: '';
        position: absolute;
        top: 30px;
        left: 5%;
        right: 5%;
        height: 1px;
        background: var(--border-color);
        z-index: 1;
    }

    .process-step {
        text-align: center;
        flex: 1;
        position: relative;
        z-index: 2;
    }

    .step-number {
        width: 60px;
        height: 60px;
        background: var(--bg-dark);
        border: 1px solid var(--accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        font-size: 1.5rem;
        font-family: var(--font-heading);
        color: var(--accent);
        transition: transform 0.5s ease;
    }

    .process-step:hover .step-number {
        transform: scale(1.1);
        background: var(--accent);
        color: var(--bg-dark);
    }

    .process-step h3 {
        font-size: 1.2rem;
        margin-bottom: 1rem;
        color: #fff;
    }

    .process-step p {
        color: var(--text-secondary);
        font-size: 0.95rem;
        max-width: 80%;
        margin: 0 auto;
    }

    /* Marquee */
    .marquee-wrapper {
        background: var(--accent);
        color: var(--bg-dark);
        padding: 2rem 0;
        overflow: hidden;
        white-space: nowrap;
        position: relative;
    }

    .marquee-content {
        display: inline-block;
        font-size: 2rem;
        font-family: var(--font-heading);
        text-transform: uppercase;
        letter-spacing: 2px;
        animation: marquee 20s linear infinite;
    }

    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    /* Massive Parallax */
    .massive-parallax {
        height: 80vh;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .massive-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 150%;
        object-fit: cover;
        z-index: -1;
        filter: brightness(0.4);
    }

    .massive-text {
        text-align: center;
        color: #fff;
        max-width: 800px;
        padding: 2rem;
    }

    .massive-text h2 {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    /* Newsletter */
    .newsletter {
        padding: 6rem 0;
        background: rgba(25, 28, 26, 0.8);
        text-align: center;
    }

    .newsletter input {
        padding: 1rem;
        width: 300px;
        background: transparent;
        border: 1px solid var(--border-color);
        color: #fff;
        margin-right: 1rem;
        outline: none;
    }

    .newsletter input:focus {
        border-color: var(--accent);
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <img src="{{ asset('images/hero_v2.png') }}" alt="Super Industries Showroom" class="hero-img" id="heroImage">
        <div class="hero-gradient"></div>
        <div class="container">
            <div class="hero-content" id="heroContent">
                <span class="hero-subtitle">Super Industries</span>
                <h1 class="hero-title">Nature's Finest Craftsmanship.</h1>
                <p class="hero-desc">Discover our massive, exclusive collection of over 50 hand-carved wooden soft toys and luxury baby hampers. Sustainable, timeless, and uniquely yours.</p>
                <a href="{{ url('/shop') }}" class="btn-primary">Explore Full Catalog</a>
            </div>
        </div>
    </section>

    <!-- Brand Story -->
    <section class="brand-story container">
        <div class="story-grid">
            <div class="story-text gsap-reveal">
                <span class="hero-subtitle">Our Heritage</span>
                <h2>Master Artisans at Work</h2>
                <p>At Super Industries, we believe that true luxury lies in the details. Every piece in our extensive collection is individually conceptualized and hand-carved by master artisans who have honed their craft over decades.</p>
                <p>We source only the finest, most sustainable woods—rich mahogany, durable oak, and elegant walnut—transforming them into heirlooms that can be passed down through generations.</p>
                <a href="{{ url('/about') }}" class="btn-primary" style="margin-top: 2rem;">Read Our Story</a>
            </div>
            <div class="story-img-container gsap-reveal">
                <img src="{{ asset('images/product_premium_blocks.png') }}" alt="Artisan Craftsmanship">
            </div>
        </div>
    </section>

    <!-- Collections -->
    <section class="collections">
        <div class="container">
            <div class="section-header gsap-reveal">
                <h2 class="section-title">Explore by Collection</h2>
            </div>
            <div class="collections-grid">
                <a href="{{ url('/shop?category=premium-soft-toys') }}" class="collection-card gsap-reveal">
                    <img src="{{ asset('images/product_carved_train.png') }}" alt="Wooden Soft Toys" class="collection-img">
                    <div class="collection-content">
                        <h3 class="collection-title">Wooden Soft Toys</h3>
                        <span class="btn-primary">View Collection</span>
                    </div>
                </a>
                <a href="{{ url('/shop?category=luxury-hampers') }}" class="collection-card gsap-reveal">
                    <img src="{{ asset('images/product_baby_rattle.png') }}" alt="Luxury Hampers" class="collection-img">
                    <div class="collection-content">
                        <h3 class="collection-title">Luxury Hampers</h3>
                        <span class="btn-primary">View Collection</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Massive Parallax Divider -->
    <section class="massive-parallax">
        <img src="{{ asset('images/massive_parallax.png') }}" alt="Forest" class="massive-img" id="massiveImg">
        <div class="massive-text gsap-reveal">
            <h2>Born from Nature.</h2>
            <p style="font-size: 1.5rem; color: #ccc;">Crafted for generations.</p>
        </div>
    </section>

    <!-- Marquee -->
    <div class="marquee-wrapper">
        <div class="marquee-content">
            ✦ FEATURED IN VOGUE LIVING ✦ AWARD WINNING CRAFTSMANSHIP ✦ 100% SUSTAINABLE ✦ WORLDWIDE SHIPPING ✦ 
            ✦ FEATURED IN VOGUE LIVING ✦ AWARD WINNING CRAFTSMANSHIP ✦ 100% SUSTAINABLE ✦ WORLDWIDE SHIPPING ✦ 
        </div>
    </div>

    <!-- Featured Products -->
    <section class="featured-section container">
        <div class="section-header gsap-reveal">
            <span class="hero-subtitle">Curated Selection</span>
            <h2 class="section-title">Featured Masterpieces</h2>
            <p class="text-secondary" style="font-size: 1.1rem; max-width: 600px; margin: 0 auto;">A glimpse into our expansive catalog of luxury wooden creations.</p>
        </div>

        <div class="product-grid">
            @foreach($featuredProducts as $product)
                <a href="{{ url('/product/' . $product->slug) }}" class="product-card gsap-reveal">
                    <div class="product-img-wrapper">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                    </div>
                    <div class="product-meta">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <span class="product-price">${{ number_format($product->price, 2) }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div style="text-align: center; margin-top: 4rem;" class="gsap-reveal">
            <a href="{{ url('/shop') }}" class="btn-primary">View All 50+ Products</a>
        </div>
    </section>

    <!-- Eco Promise -->
    <section class="eco-promise container">
        <div class="gsap-reveal">
            <h2 class="section-title">The Eco-Friendly Promise</h2>
            <p class="text-secondary" style="max-width: 600px; margin: 0 auto;">We are committed to preserving the planet that provides our beautiful materials.</p>
        </div>
        
        <div class="eco-grid">
            <div class="eco-item gsap-reveal">
                <h3>100% Sustainable Wood</h3>
                <p>All our timber is ethically sourced from certified sustainable forests, ensuring minimal environmental impact.</p>
            </div>
            <div class="eco-item gsap-reveal">
                <h3>Organic Finishes</h3>
                <p>We use only natural, non-toxic, organic oils and waxes to finish our toys, keeping them safe for children and the earth.</p>
            </div>
            <div class="eco-item gsap-reveal">
                <h3>Zero Plastic Packaging</h3>
                <p>Every order is shipped using 100% biodegradable and recyclable materials, reflecting our eco-luxury ethos.</p>
            </div>
        </div>
    </section>

    <!-- Craftsmanship Process -->
    <section class="process-section">
        <div class="container">
            <div class="section-header gsap-reveal">
                <span class="hero-subtitle">The Journey</span>
                <h2 class="section-title">How It's Made</h2>
            </div>
            <div class="process-steps">
                <div class="process-step gsap-step">
                    <div class="step-number">01</div>
                    <h3>Ethical Sourcing</h3>
                    <p>Selecting the finest, sustainable timber from certified forests.</p>
                </div>
                <div class="process-step gsap-step">
                    <div class="step-number">02</div>
                    <h3>Precision Carving</h3>
                    <p>Master artisans sculpt the wood, bringing the design to life.</p>
                </div>
                <div class="process-step gsap-step">
                    <div class="step-number">03</div>
                    <h3>Hand Sanding</h3>
                    <p>Meticulous sanding ensures every edge is perfectly smooth and safe.</p>
                </div>
                <div class="process-step gsap-step">
                    <div class="step-number">04</div>
                    <h3>Organic Finishing</h3>
                    <p>Coating the piece in natural oils to protect and enhance the wood grain.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container gsap-reveal">
            <h2 style="font-family: var(--font-heading); font-size: 2.5rem; margin-bottom: 1rem;">Join the Inner Circle</h2>
            <p class="text-secondary" style="margin-bottom: 2rem;">Subscribe to receive exclusive access to new releases and limited edition pieces.</p>
            <form action="#" method="POST" style="display: flex; justify-content: center; align-items: center;">
                <input type="email" placeholder="Your email address" required>
                <button type="submit" class="btn-primary" style="padding: 1rem 2rem;">Subscribe</button>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Hero entrance animation
        gsap.to("#heroContent", {
            y: 0,
            opacity: 1,
            duration: 1.5,
            delay: 0.2,
            ease: "power3.out"
        });

        // Parallax for hero image (deeper effect)
        gsap.to("#heroImage", {
            yPercent: 25,
            ease: "none",
            scrollTrigger: {
                trigger: ".hero",
                start: "top top",
                end: "bottom top",
                scrub: true
            }
        });

        // Massive Parallax
        gsap.to("#massiveImg", {
            yPercent: -20,
            ease: "none",
            scrollTrigger: {
                trigger: ".massive-parallax",
                start: "top bottom",
                end: "bottom top",
                scrub: true
            }
        });

        // Staggered steps
        gsap.from(".gsap-step", {
            scrollTrigger: {
                trigger: ".process-steps",
                start: "top 80%",
            },
            y: 50,
            opacity: 0,
            duration: 0.8,
            stagger: 0.2,
            ease: "power2.out"
        });
    });
</script>
@endpush
