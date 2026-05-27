@extends('layouts.app')

@section('title', 'Welcome - CHMSU Lost & Found Management System')

@section('content')

<!-- smooth scroll anchor offset helper -->
<div id="top" aria-hidden="true" style="height:1px;"></div>

<!-- HERO -->
<div class="hero animate__animated animate__fadeInDown" style="will-change: transform, opacity;">

    <div class="hero-icon-wrapper">
        
    </div>

    <h1 class="hero-title animate__animated animate__fadeInUp">Reconnect People With <span>Their Belongings</span></h1>

    <p class="hero-sub animate__animated animate__fadeIn" style="color:#e0e7ef; opacity:0.95;">
        Quickly report, search, and recover lost items with our system. Making it
        easier for everyone to find what matters most.
    </p>

</div>


<!-- QUICK ACTIONS -->
<div class="container py-5" aria-label="Quick Actions">
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-2" style="color:#1e293b;">Quick Actions</h2>
        <p class="text-muted mb-0" style="max-width: 720px; margin: 0 auto;">
            Access verified campus records and manage your item claims securely.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-md-6 col-lg-3">
            <a href="{{ auth()->check() ? route('user.dashboard') : route('login') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm rounded-4 border-0 quick-action-card" role="group" aria-label="View Recorded Items">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="quick-action-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-folder-check" aria-hidden="true"></i>
                            </div>
                        </div>
                        <h5 class="card-title fw-bold mb-2">View Recorded Items</h5>
                        <p class="card-text text-muted mb-0" style="line-height:1.5;">Browse officially recorded lost and found items encoded by the administrative office.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <a href="{{ route('user.dashboard') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm rounded-4 border-0 quick-action-card" role="group" aria-label="Search & Filter Listings">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="quick-action-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-search" aria-hidden="true"></i>
                            </div>
                        </div>
                        <h5 class="card-title fw-bold mb-2">Search &amp; Filter Listings</h5>
                        <p class="card-text text-muted mb-0" style="line-height:1.5;">Locate belongings using categorized and organized records within the centralized database.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <a href="{{ route('user.dashboard') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm rounded-4 border-0 quick-action-card" role="group" aria-label="Submit Claim Request">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="quick-action-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-text" aria-hidden="true"></i>
                            </div>
                        </div>
                        <h5 class="card-title fw-bold mb-2">Submit Claim Request</h5>
                        <p class="card-text text-muted mb-0" style="line-height:1.5;">Request ownership verification for matched items before proceeding to physical claiming at the administrative office.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <a href="{{ route('user.dashboard') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm rounded-4 border-0 quick-action-card" role="group" aria-label="Track Claim Status">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="quick-action-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-clipboard-data" aria-hidden="true"></i>
                            </div>
                        </div>
                        <h5 class="card-title fw-bold mb-2">Track Claim Status</h5>
                        <p class="card-text text-muted mb-0" style="line-height:1.5;">Monitor the status of your claimed items and proceed to the OSAS office with proof of ownership to claim your item.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    /* Quick Actions - fit within current welcome design */
    .quick-action-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .quick-action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 35px rgba(96, 165, 250, 0.14) !important;
    }
    .quick-action-icon {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
        color: #fff;
        font-size: 1.4rem;
        box-shadow: 0 8px 18px rgba(96, 165, 250, 0.18);
    }
    .quick-action-icon i {
        line-height: 1;
    }
</style>

<!-- VISUAL SEPARATOR -->
<div class="section-divider" aria-hidden="true"></div>

<!-- TUTORIAL SECTION -->
<div class="tutorial-section animate__animated animate__fadeInUp" id="how-to-claim">

    <h2>
        <i class="bi bi-compass" aria-hidden="true"></i>
        How to Claim Your Belongings
    </h2>

    <div class="tutorial-intro">
        All items reported in the system and marked as <strong>“Found”</strong> are now available for claiming at the
        <strong>OSAS (CHMSU Claiming Station)</strong>. Please follow the instructions below to verify ownership and securely retrieve your lost belongings.
        You can also contact us for assistance:
        <br><br>
        <strong>Carlos Hilado Memorial State University</strong><br>
        Email: <strong>cier@chmsu.edu.ph</strong> | Phone: <strong>(034) 454 0529</strong>
    </div>

    <div class="steps">
        <div class="step">
            <div class="step-number">1</div>
            <div class="step-content">
                <h4><i class="bi bi-bag" aria-hidden="true"></i> Browse Lost Items</h4>
                <p>Go to the <strong>Lost Items</strong> section to search for your missing belongings.</p>
            </div>
        </div>

        <div class="step">
            <div class="step-number">2</div>
            <div class="step-content">
                <h4><i class="bi bi-card-list" aria-hidden="true"></i> View Item Details</h4>
                <p>Click on the item card to view detailed information, including the finder's contact details.</p>
            </div>
        </div>

        <div class="step">
            <div class="step-number">3</div>
            <div class="step-content">
                <h4><i class="bi bi-check2-circle" aria-hidden="true"></i> Claim Your Item</h4>
                <p>Once you locate your item, click the <strong>Claim</strong> button. A confirmation modal will appear.</p>
            </div>
        </div>

        <div class="step">
            <div class="step-number">4</div>
            <div class="step-content">
                <h4><i class="bi bi-upload" aria-hidden="true"></i> Submit Claim</h4>
                <p>Confirm your claim by checking the box and submitting. The item will be marked as claimed with your name.</p>
            </div>
        </div>

        <div class="step">
            <div class="step-number">5</div>
            <div class="step-content">
                <h4><i class="bi bi-shop" aria-hidden="true"></i> Collect Your Item</h4>
                <p>Proceed to <strong>OSAS (CHMSU CLAIMING STATION)</strong> to physically collect your item.</p>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="site-footer" aria-label="Site footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="footer-brand">
                    
                    <h3>Lost &amp; Found</h3>
                </div>
                <p class="footer-desc">Quickly report, search, and recover lost items in our system. Helping everyone reconnect with their belongings.</p>
            </div>

            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li>
                        <a class="footer-link" href="{{ url('/') }}">
                            <i class="bi bi-arrow-right-short" aria-hidden="true"></i>
                            Home
                        </a>
                    </li>

                    <li>
                        <a class="footer-link" href="{{ route('login') }}">
                            <i class="bi bi-arrow-right-short" aria-hidden="true"></i>
                            Sign In
                        </a>
                    </li>
                    <li>
                        <a class="footer-link" href="{{ route('register') }}">
                            <i class="bi bi-arrow-right-short" aria-hidden="true"></i>
                            Sign Up
                        </a>
                    </li>
                </ul>
            </div>


            <div class="footer-col">
                <h4>Contact Us</h4>
                <ul class="footer-contact">
                    <li>
                        <i class="bi bi-building" aria-hidden="true"></i>
                        <a class="footer-link" href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" aria-label="Facebook: Carlos Hilado Memorial State University">
                            <i class="bi bi-arrow-left" aria-hidden="true"></i>
                            <span>Facebook: Carlos Hilado Memorial State University</span>
                        </a>
                    </li>

                    <li>
                        <i class="bi bi-envelope" aria-hidden="true"></i>
                        <a class="footer-link" href="mailto:cier@chmsu.edu.ph">
                            <i class="bi bi-arrow-left" aria-hidden="true"></i>
                            <span>cier@chmsu.edu.ph</span>
                        </a>
                    </li>
                    <li>
                        <i class="bi bi-telephone" aria-hidden="true"></i>
                        <a class="footer-link" href="tel:0344540529">
                            <i class="bi bi-arrow-left" aria-hidden="true"></i>
                            <span>(034) 454 0529</span>
                        </a>
                    </li>

                </ul>
            </div>

        </div>

        <div class="footer-divider" aria-hidden="true"></div>

        <div class="footer-bottom">
            &copy; {{ date('Y') }} Lost &amp; Found System. All rights reserved.
        </div>
    </div>
</footer>
@endsection


@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
/* smooth scroll + reduce motion support */
html { scroll-behavior: smooth; }
@media (prefers-reduced-motion: reduce) {
    html { scroll-behavior: auto; }
    *, *::before, *::after {
        animation-duration: 0.001ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.001ms !important;
        scroll-behavior: auto !important;
    }
}

.hero {


    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 80px 20px 50px 20px;
    background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
    border-radius: 24px;
    margin: 32px 0 32px 0;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(16, 23, 40, 0.12);
    min-height: 320px;
}
.hero-icon-wrapper {
    margin-bottom: 18px;
}

@keyframes heroIconPulse {
    0%, 100% { box-shadow: 0 4px 16px rgba(96, 165, 250, 0.18); }
    50% { box-shadow: 0 0 32px 8px rgba(96, 165, 250, 0.22); }
}
.hero-title {
    font-size: 2.7rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
}
.hero-title span {
    color: #60a5fa;
    background: linear-gradient(90deg, #60a5fa 0%, #a78bfa 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-sub {
    font-size: 1.2rem;
    color: #33d3f3;
    opacity: 0.95;
    margin-bottom: 0;
}
.tutorial-section {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(16, 23, 40, 0.07);
    padding: 40px 32px 32px 32px;
    margin: 0 auto 32px auto;
    max-width: 900px;
}
.tutorial-section h2 {
    font-weight: 700;
    margin-bottom: 18px;
    color: #1e293b;
    text-align: center;
}
.tutorial-intro {
    font-size: 1.08rem;
    color: #374151;
    margin-bottom: 28px;
}
.section-divider {
    height: 18px;
    margin: 12px auto 24px auto;
    max-width: 900px;
    background: linear-gradient(90deg, rgba(96, 165, 250, 0) 0%, rgba(96, 165, 250, 0.18) 35%, rgba(167, 139, 250, 0.22) 65%, rgba(167, 139, 250, 0) 100%);
    border-radius: 999px;
}




.steps {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
}
.step {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: #f8fafc;
    border-radius: 16px;
    padding: 18px 18px;
    box-shadow: 0 2px 10px rgba(96, 165, 250, 0.05);
    border: 1px solid rgba(148, 163, 184, 0.22);
    transition: box-shadow 0.22s ease, transform 0.22s ease;
    min-height: 118px;
}
.step:hover {
    box-shadow: 0 14px 35px rgba(96, 165, 250, 0.14);
    transform: translateY(-3px);
}

.step-number {
    background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
    color: #fff;
    font-weight: 800;
    font-size: 1.15rem;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 18px rgba(96, 165, 250, 0.18);
    flex-shrink: 0;
}

.step-content h4 {
    font-size: 1.05rem;
    font-weight: 800;
    margin-bottom: 6px;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
}

.step-content h4 i {
    color: #3b82f6;
    filter: drop-shadow(0 6px 10px rgba(59, 130, 246, 0.18));
}

.step-content p {
    margin: 0;
    color: #374151;
    font-size: 0.98rem;
    line-height: 1.45;
}

.footer-inner {
    max-width: 1100px;
    margin: 0 auto;
}

.site-footer {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
    color: rgba(226, 232, 240, 0.95);
    padding: 54px 20px 36px 20px;
    margin-top: 28px;
    position: relative;
    overflow: hidden;
}

.site-footer::before {
    content: '';
    position: absolute;
    inset: -40px;
    background: radial-gradient(circle at 10% 0%, rgba(96, 165, 250, 0.22), transparent 45%),
        radial-gradient(circle at 90% 20%, rgba(167, 139, 250, 0.20), transparent 45%);
    pointer-events: none;
}

.footer-grid {
    position: relative;
    display: grid;
    grid-template-columns: 1.25fr 1fr 1fr;
    gap: 26px;
    align-items: start;
}

.footer-col h3,
.footer-col h4 {
    margin-bottom: 14px;
    color: #60a5fa;
    font-weight: 800;
}

.footer-desc {
    max-width: 420px;
    line-height: 1.6;
    color: rgba(226, 232, 240, 0.90);
}

.footer-links,
.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.footer-links a,
.footer-contact a.footer-link {
    color: rgba(96, 165, 250, 0.95);
    text-decoration: none;
    transition: color 0.18s ease, transform 0.18s ease, text-decoration-color 0.18s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    position: relative;
    font-weight: 600;
}

.footer-links a:hover,
.footer-contact a.footer-link:hover {
    color: #93c5fd;
    transform: translateX(4px);
    text-decoration: underline;
    text-decoration-color: rgba(147, 197, 253, 0.9);
    text-underline-offset: 3px;
}


.footer-contact li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    color: rgba(226, 232, 240, 0.92);
}

.footer-contact i {
    color: #60a5fa;
    margin-top: 3px;
}

.footer-contact a {
    color: rgba(226, 232, 240, 0.95);
    text-decoration: none;
    transition: color 0.22s ease, transform 0.22s ease;
}

.footer-contact a:hover {
    color: #ffffff;
    transform: translateX(6px);
}

.footer-divider {
    position: relative;
    height: 1px;
    background: rgba(96, 165, 250, 0.25);
    margin: 28px auto 18px auto;
    max-width: 1100px;
}

.footer-bottom {
    position: relative;
    text-align: center;
    color: rgba(226, 232, 240, 0.75);
    font-size: 0.92rem;
}

@media (max-width: 900px) {
    .steps {
        grid-template-columns: 1fr;
    }
    .footer-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 600px) {
    .hero {
        padding: 40px 10px 30px 10px;
        border-radius: 14px;
        min-height: 180px;
    }
    .hero-title {
        font-size: 1.5rem;
    }
    .tutorial-section {
        padding: 18px 8px 18px 8px;
        border-radius: 10px;
    }
    .step {
        padding: 12px 10px;
        gap: 10px;
    }
    .step-number {
        width: 28px;
        height: 28px;
        font-size: 1rem;
    }
}
</style>
@endsection
