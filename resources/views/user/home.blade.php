@extends('layouts.user')

@section('title', 'Home - CHMSU Lost & Found')

@section('content')
<!-- HERO -->
<div class="hero">
    <h1>Reconnect People With <span>Their Belongings</span></h1>
    <p>
        Quickly report, search, and recover lost items with our system. Making it
        easier for everyone to find what matters most.
    </p>
</div>

<!-- TUTORIAL SECTION -->
<div class="tutorial-section">
    <h2>How to Claim Your Belongings</h2>
    <div class="tutorial-intro">
        All items reported in the system are already available at 
        <strong>OSAS (CHMSU CLAIMING STATION)</strong>. Follow the steps below to safely claim your lost items. 
        You can also contact us for assistance:
        <br><br>
        <strong>Carlos Hilado Memorial State University</strong><br>
        Email: <strong>cier@chmsu.edu.ph</strong> | Phone: <strong>(034) 454 0529</strong>
    </div>

    <div class="steps">
        <div class="step">
            <div class="step-number">1</div>
            <div class="step-content">
                <h4>Browse Lost Items</h4>
                <p>Go to the <strong>Lost Items</strong> section to search for your missing belongings.</p>
            </div>
        </div>

        <div class="step">
            <div class="step-number">2</div>
            <div class="step-content">
                <h4>View Item Details</h4>
                <p>Click on the item card to view detailed information, including the finder's contact details.</p>
            </div>
        </div>

        <div class="step">
            <div class="step-number">3</div>
            <div class="step-content">
                <h4>Claim Your Item</h4>
                <p>Once you locate your item, click the <strong>Claim</strong> button. A confirmation modal will appear.</p>
            </div>
        </div>

        <div class="step">
            <div class="step-number">4</div>
            <div class="step-content">
                <h4>Submit Claim</h4>
                <p>Confirm your claim by checking the box and submitting. The item will be marked as claimed with your name.</p>
            </div>
        </div>

        <div class="step">
            <div class="step-number">5</div>
            <div class="step-content">
                <h4>Collect Your Item</h4>
                <p>Proceed to <strong>OSAS (CHMSU CLAIMING STATION)</strong> to physically collect your item.</p>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>Lost & Found</h3>
            <p>Quickly report, search, and recover lost items in our system. Helping everyone reconnect with their belongings.</p>
        </div>
        <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('user.dashboard', ['search_category' => 'lost']) }}">Lost Items</a></li>
                <li><a href="{{ route('user.dashboard', ['search_category' => 'found']) }}">Found Items</a></li>
                <li><a href="{{ route('user.dashboard', ['search_category' => 'claimed']) }}">Claimed Items</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Contact Us</h4>
            <p>Facebook: Carlos Hilado Memorial State University<br>
            Email: <a href="mailto:cier@chmsu.edu.ph">cier@chmsu.edu.ph</a><br>
            Phone: <strong>(034) 454 0529</strong></p>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; {{ date('Y') }} Lost & Found System. All rights reserved.
    </div>
</footer>
@endsection

@section('styles')
<style>
.hero {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 80px 20px 50px 20px;
    background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
    border-radius: 16px;
    margin: 20px;
}

.hero h1 {
    font-size: 42px;
    line-height: 1.3;
    margin-bottom: 15px;
    font-weight: 700;
    color: white;
}

.hero span {
    color: #60a5fa;
}

.hero p {
    color: #cbd5e1;
    max-width: 650px;
    font-size: 17px;
    line-height: 1.6;
    margin-bottom: 30px;
}

.hero-buttons {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    justify-content: center;
}

.btn-hero {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 28px;
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    transition: 0.3s;
    font-size: 15px;
}

.btn-hero.lost {
    background: #dc2626;
}

.btn-hero.lost:hover {
    background: #b91c1c;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4);
}

.btn-hero.found {
    background: #16a34a;
}

.btn-hero.found:hover {
    background: #15803d;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(22, 163, 74, 0.4);
}

/* TUTORIAL SECTION */
.tutorial-section {
    max-width: 1000px;
    margin: 0 auto 50px auto;
    padding: 50px;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    color: #1e293b;
    margin: 20px;
}

.tutorial-section h2 {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 30px;
    text-align: center;
    color: #0f172a;
}

.tutorial-intro {
    text-align: center;
    margin-bottom: 35px;
    font-size: 15px;
    line-height: 1.8;
    color: #475569;
    padding: 20px;
    background: #f8fafc;
    border-radius: 12px;
}

.tutorial-intro strong {
    color: #0f172a;
}

.steps {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.step {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    background: #f8fafc;
    padding: 20px 24px;
    border-radius: 14px;
    transition: 0.3s;
    border: 1px solid #e2e8f0;
}

.step:hover {
    transform: translateX(8px);
    background: #eff6ff;
    border-color: #bfdbfe;
}

.step-number {
    min-width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 18px;
    flex-shrink: 0;
}

.step-content h4 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #1e293b;
}

.step-content p {
    font-size: 14px;
    line-height: 1.5;
    color: #64748b;
    margin: 0;
}

.step-content strong {
    color: #3b82f6;
}

/* FOOTER */
.site-footer {
    background: #0f172a;
    color: #cbd5e1;
    padding: 50px 20px;
    margin-top: 20px;
}

.footer-content {
    max-width: 1100px;
    margin: auto;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 30px;
}

.footer-section {
    flex: 1;
    min-width: 220px;
}

.footer-section h3 {
    color: #60a5fa;
    font-size: 22px;
    margin-bottom: 15px;
}

.footer-section h4 {
    color: #60a5fa;
    font-size: 16px;
    margin-bottom: 12px;
}

.footer-section p {
    font-size: 14px;
    line-height: 1.6;
}

.footer-section ul {
    list-style: none;
    padding: 0;
    font-size: 14px;
    line-height: 2.2;
}

.footer-section a {
    color: #cbd5e1;
    text-decoration: none;
    transition: 0.3s;
}

.footer-section a:hover {
    color: #60a5fa;
}

.footer-bottom {
    text-align: center;
    margin-top: 35px;
    font-size: 13px;
    color: #64748b;
    padding-top: 20px;
    border-top: 1px solid #1e293b;
}

@media (max-width: 768px) {
    .hero h1 {
        font-size: 28px;
    }
    .hero p {
        font-size: 14px;
    }
    .tutorial-section {
        padding: 25px 20px;
        margin: 15px;
    }
    .tutorial-section h2 {
        font-size: 22px;
    }
    .step {
        gap: 15px;
        padding: 15px;
    }
    .step-number {
        min-width: 36px;
        height: 36px;
        font-size: 16px;
    }
    .btn-hero {
        padding: 12px 20px;
        font-size: 14px;
    }
}
</style>
@endsection

