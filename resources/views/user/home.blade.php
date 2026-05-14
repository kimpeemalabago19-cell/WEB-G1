
@extends('layouts.user')

@section('title', 'Home - CHMSU Lost & Found')

@section('content')
<div class="visually-hidden">user-home</div>
<div class="container-fluid py-4 px-2 px-md-4 user-home" data-page="user-home">
    <div class="row g-4 align-items-stretch mb-4">
        <div class="col-12 col-lg-4 mb-3 mb-lg-0">
<div class="card h-100 shadow border-0 user-welcome-card animate-fadein" data-reveal="true">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:56px;height:56px;font-size:2rem;">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div>
                            @php($u = Auth::user())
                            <h5 class="fw-bold mb-1">Welcome, {{ $u?->name ?? 'User' }} <span class="wave">👋</span></h5>
                            <div class="text-muted small">{{ $u?->email ?? '' }}</div>
                        </div>

                    </div>
                    <div class="mb-3">
                        <span class="badge bg-success me-1">User</span>
                        <span class="badge bg-primary">Lost &amp; Found</span>
                    </div>
                    <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm mt-auto align-self-start">Logout</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card shadow border-0 hero-header animate-fadein">
                        <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 p-4">
                            <div class="flex-grow-1">
                                <h2 class="fw-bold mb-1">Your Dashboard</h2>
                                <p class="mb-0 text-white-50">Start by choosing what you need: search, claim, or track.</p>
                            </div>
                            <div class="stats-section text-center">
                                <i class="bi bi-lightning-charge-fill display-5"></i>
                                <div class="mt-2 fw-semibold">Quick Steps</div>
                                <small class="opacity-90 d-block mt-1">New-user friendly</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row g-3 quick-actions-row">
                        <div class="col-12 col-md-4">
                            <a href="{{ route('user.dashboard', ['search_category' => 'lost']) }}" class="card quick-action-card border-0 shadow-sm h-100 animate-hover">
                                <div class="card-body d-flex flex-column align-items-start gap-2">
                                    <div class="icon-circle bg-danger text-white mb-2"><i class="bi bi-exclamation-triangle"></i></div>
                                    <h6 class="fw-bold mb-1">Lost Items</h6>
                                    <div class="small text-muted">Search your missing belongings</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="{{ route('user.dashboard', ['search_category' => 'found']) }}" class="card quick-action-card border-0 shadow-sm h-100 animate-hover">
                                <div class="card-body d-flex flex-column align-items-start gap-2">
                                    <div class="icon-circle bg-success text-white mb-2"><i class="bi bi-check-circle"></i></div>
                                    <h6 class="fw-bold mb-1">Found Items</h6>
                                    <div class="small text-muted">Available to claim</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="{{ route('user.claim.get') }}" class="card quick-action-card border-0 shadow-sm h-100 animate-hover">
                                <div class="card-body d-flex flex-column align-items-start gap-2">
                                    <div class="icon-circle bg-primary text-white mb-2"><i class="bi bi-hand-thumbs-up-fill"></i></div>
                                    <h6 class="fw-bold mb-1">My Claims</h6>
                                    <div class="small text-muted">Track your requests</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="card shadow border-0 tutorial-section animate-fadein">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-3 text-center text-primary">How to Use Lost &amp; Found</h3>
                    <div class="tutorial-intro mb-4">
                        If you’re using this system for the first time, follow this guide to search safely and claim only when you’re sure.<br><br>
                        <strong>Tip:</strong> Use <strong>Lost Items</strong> to search. Use <strong>Found Items</strong> when you’re ready to claim.
                    </div>
                    <div class="steps-list">
                        <div class="step-item animate-step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h5>Search</h5>
                                <p>Browse the listings for items that match what you lost.</p>
                            </div>
                        </div>
                        <div class="step-item animate-step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h5>Check Details</h5>
                                <p>Open an item and review its description and status.</p>
                            </div>
                        </div>
                        <div class="step-item animate-step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h5>Submit Claim</h5>
                                <p>When the item is a match, submit your claim request.</p>
                            </div>
                        </div>
                        <div class="step-item animate-step">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h5>Track Updates</h5>
                                <p>Your claims appear under <strong>My Claims</strong>.</p>
                            </div>
                        </div>
                        <div class="step-item animate-step">
                            <div class="step-number">5</div>
                            <div class="step-content">
                                <h5>Collect at OSAS</h5>
                                <p>Confirmed items are released at <strong>OSAS (CHMSU Claiming Station)</strong>.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 p-3 rounded-4 bg-light border d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h6 class="fw-bold mb-1">Need help?</h6>
                            <div class="text-muted small" style="line-height:1.7;">
                                Contact the CHMSU Lost &amp; Found team.<br>
                                Email: <strong>cier@chmsu.edu.ph</strong><br>
                                Phone: <strong>(034) 454 0529</strong>
                            </div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('user.dashboard', ['search_category' => 'lost']) }}" class="btn btn-primary rounded-pill px-4">Start Searching</a>
                            <a href="{{ route('user.dashboard', ['search_category' => 'found']) }}" class="btn btn-outline-primary rounded-pill px-4">View Found</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card shadow border-0 h-100 animate-fadein">
                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4 text-center">
                    <i class="bi bi-search-heart display-3 text-primary mb-3"></i>
                    <h5 class="fw-bold mb-2">Lost &amp; Found at CHMSU</h5>
                    <p class="text-muted mb-3">Easily report, search, and claim lost or found items. Your campus, your community, your safety.</p>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary rounded-pill">Go to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
{{-- page-scoped styles --}}
<style>
/* page-scoped */

.user-home[data-page="user-home"]{animation:homeFadeSlide .55s cubic-bezier(.2,.8,.2,1) both;}
@keyframes homeFadeSlide{from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:none;}}
.user-home[data-page="user-home"] [data-reveal="true"]{opacity:0;transform:translateY(14px);transition:opacity .55s cubic-bezier(.2,.8,.2,1),transform .55s cubic-bezier(.2,.8,.2,1);}
.user-home[data-page="user-home"] [data-reveal="true"].is-visible{opacity:1;transform:none;}
.quick-action-card,.user-welcome-card,.hero-header,.tutorial-section{will-change:transform;}
.quick-action-card{transform:translateZ(0);transition:transform .18s ease, box-shadow .18s ease;}
.quick-action-card:hover{transform:translateY(-6px);}
.btn{transition:transform .18s ease, box-shadow .18s ease, background-color .18s ease, border-color .18s ease;}
.btn:hover{transform:translateY(-1px);}
.icon-circle{transition:transform .2s ease, box-shadow .2s ease;}
.quick-action-card:hover .icon-circle{transform:scale(1.05);}
.tutorial-section,.user-welcome-card{border-radius:20px;}
@media (prefers-reduced-motion: reduce){.user-home[data-page="user-home"]{animation:none!important;} .user-home[data-page="user-home"] [data-reveal="true"], .user-home[data-page="user-home"] [data-reveal="true"].is-visible{transition:none!important; transform:none!important; opacity:1!important;} .wave{animation:none!important;}}

.user-welcome-card {
    background: linear-gradient(135deg, #f8fafc 60%, #e0e7ff 100%);
    border-radius: 20px;
    min-height: 220px;
    transition: box-shadow 0.3s;
}
.user-welcome-card:hover {
    box-shadow: 0 8px 32px rgba(59, 130, 246, 0.12);
}
.wave { animation: wave-hand 2s infinite; display: inline-block; }
@keyframes wave-hand {
    0% { transform: rotate(0deg); }
    10% { transform: rotate(14deg); }
    20% { transform: rotate(-8deg); }
    30% { transform: rotate(14deg); }
    40% { transform: rotate(-4deg); }
    50% { transform: rotate(10deg); }
    60% { transform: rotate(0deg); }
    100% { transform: rotate(0deg); }
}
.hero-header {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    border-radius: 20px;
    min-height: 120px;
    box-shadow: 0 20px 40px rgba(79, 70, 229, 0.13);
    transition: box-shadow 0.3s;
}
.hero-header .stats-section {
    background: rgba(255,255,255,0.15);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.3);
    padding: 1rem 1.5rem;
    min-width: 120px;
}
.quick-actions-row .quick-action-card {
    border-radius: 16px;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
    background: #fff;
}
.quick-action-card:hover {
    transform: translateY(-4px) scale(1.03);
    box-shadow: 0 12px 25px rgba(59, 130, 246, 0.10);
    z-index: 2;
}
.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.08);
}
.bg-danger { background: #ef4444 !important; }
.bg-success { background: #10b981 !important; }
.bg-primary { background: #3b82f6 !important; }
.tutorial-section {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    color: #1e293b;
}
.tutorial-section h3 {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: #4f46e5;
}
.tutorial-intro {
    text-align: center;
    margin-bottom: 25px;
    font-size: 15px;
    line-height: 1.8;
    color: #475569;
    padding: 16px;
    background: #f8fafc;
    border-radius: 12px;
}
.steps-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.step-item {
    display: flex;
    align-items: flex-start;
    gap: 18px;
    background: #f8fafc;
    padding: 16px 20px;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    transition: 0.3s;
}
.step-item:hover {
    background: #eff6ff;
    border-color: #bfdbfe;
    transform: translateX(8px) scale(1.01);
}
.step-number {
    min-width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
}
.step-content h5 { font-size: 1rem; font-weight: 600; margin-bottom: 4px; color: #1e293b; }
.step-content p { font-size: 0.95rem; line-height: 1.5; color: #64748b; opacity: 0.9; margin-bottom: 0; }
.animate-fadein { animation: fadeIn 0.7s cubic-bezier(0.4,0,0.2,1); }
@keyframes fadeIn { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: none; } }
.animate-hover:hover { box-shadow: 0 12px 25px rgba(59, 130, 246, 0.13) !important; }
.animate-step { animation: fadeInStep 0.7s cubic-bezier(0.4,0,0.2,1); }
@keyframes fadeInStep { from { opacity: 0; transform: translateX(-20px);} to { opacity: 1; transform: none; } }
@media (max-width: 991.98px) {
    .user-welcome-card { margin-bottom: 18px; }
    .tutorial-section { margin-bottom: 18px; }
}
@media (max-width: 768px) {
    .user-welcome-card, .tutorial-section, .hero-header, .quick-action-card { border-radius: 14px; }
    .steps-list { gap: 10px; }
    .step-item { gap: 10px; padding: 10px 12px; }
    .hero-header .stats-section { min-width: 90px; padding: 0.5rem 0.7rem; }
}
</style>
@endsection

