
@extends('layouts.user')

@section('title', 'Home - CHMSU Lost & Found')

@section('content')
<div class="container-fluid py-4 px-2 px-md-4">
    <div class="row g-4 align-items-stretch mb-4">
        <div class="col-12 col-lg-4 mb-3 mb-lg-0">
            @php($u = Auth::user())
            <div class="card h-100 shadow border-0 user-welcome-card animate-fadein">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="welcome-top d-flex align-items-center justify-content-between gap-3 mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="welcome-avatar rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1 welcome-title">
                                        Welcome, {{ $u?->name ?? 'User' }} <span class="wave">👋</span>
                                    </h5>
                                    <div class="text-muted small">
                                        <span class="email-pill">
                                            <i class="bi bi-envelope-at me-1"></i>
                                            {{ $u?->email ?? '' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <span class="badge user-role-badge me-1">Member</span>
                            <span class="badge user-module-badge">Lost &amp; Found</span>
                        </div>

                        <div class="welcome-stats d-flex gap-3 mb-3">
                            <div class="stat-box">
                                <div class="stat-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                                <div>
                                    <div class="stat-value">Active</div>
                                    <div class="stat-label">Member</div>
                                </div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-icon"><i class="bi bi-journal-check"></i></div>
                                <div>
                                    <div class="stat-value">Claims</div>
                                    <div class="stat-label">Track Requests</div>
                                </div>
                            </div>
                        </div>

                        <p class="welcome-desc mb-4">
                            Search for items you lost, review details, and submit a claim when you’re confident it’s yours.
                        </p>
                    </div>

                    <div class="welcome-actions d-flex gap-2 flex-wrap">
                       
                    </div>
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
                            <a href="{{ route('user.dashboard', ['search_category' => 'lost']) }}" class="card quick-action-card quick-action-lost border-0 shadow-sm h-100 animate-hover" style="touch-action: manipulation;">
                                <div class="card-body d-flex flex-column align-items-start gap-2">
                                    <div class="icon-circle quick-icon-lost text-white mb-2"><i class="bi bi-exclamation-triangle"></i></div>
                                    <h6 class="fw-bold mb-1">Lost Items</h6>
                                    <div class="small text-muted">Search your missing belongings</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="{{ route('user.dashboard', ['search_category' => 'found']) }}" class="card quick-action-card quick-action-found border-0 shadow-sm h-100 animate-hover" style="touch-action: manipulation;">
                                <div class="card-body d-flex flex-column align-items-start gap-2">
                                    <div class="icon-circle quick-icon-found text-white mb-2"><i class="bi bi-check-circle"></i></div>
                                    <h6 class="fw-bold mb-1">Found Items</h6>
                                    <div class="small text-muted">Available to claim</div>
                                </div>
                            </a>
                        </div>


                        <div class="col-12 col-md-4">
                            <a href="{{ route('user.claim.get') }}" class="card quick-action-card quick-action-claims border-0 shadow-sm h-100 animate-hover" style="touch-action: manipulation;">
                                <div class="card-body d-flex flex-column align-items-start gap-2">
                                    <div class="icon-circle quick-icon-claims text-white mb-2"><i class="bi bi-hand-thumbs-up-fill"></i></div>
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
            <p>Browse <strong>Lost</strong> or <strong>Found</strong> listings to locate your item or check reported items.</p>
        </div>
    </div>

    <div class="step-item animate-step">
        <div class="step-number">2</div>
        <div class="step-content">
            <h5>Check Details</h5>
            <p>Open the item to review its description, category, date, and other identifying information.</p>
        </div>
    </div>

    <div class="step-item animate-step">
        <div class="step-number">3</div>
        <div class="step-content">
            <h5>Submit Claim</h5>
            <p>If the item matches yours, submit your claim. The system will automatically save the claim under your account.</p>
        </div>
    </div>

    <div class="step-item animate-step">
        <div class="step-number">4</div>
        <div class="step-content">
            <h5>Proceed to Admin Office</h5>
            <p>After submitting your claim, proceed directly to the <strong>Admin Office / OSAS</strong> for verification and item release.</p>
        </div>
    </div>

    <div class="step-item animate-step">
        <div class="step-number">5</div>
        <div class="step-content">
            <h5>Verification & Release</h5>
            <p>Present valid identification and verify ownership. Once confirmed, your item will be officially released to you.</p>
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
<style>
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
    transition: transform 160ms ease, box-shadow 160ms ease, background 160ms ease, border-color 160ms ease;
    cursor: pointer;
    background: transparent; /* meaning-based backgrounds control the color */
    will-change: transform;
    position: relative;
    overflow: hidden;

    /* Make it feel like a button */
    border: 1px solid rgba(148, 163, 184, 0.22);
}

.quick-actions-row .quick-action-card:hover {
    text-decoration: none;
}



.quick-actions-row .quick-action-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at var(--mx, 50%) var(--my, 50%), rgba(255,255,255,0.35), transparent 45%);
    opacity: 0;
    transition: opacity 220ms ease;
    pointer-events: none;
}

.quick-action-card:hover {
    transform: translateY(-4px) scale(1.03);
    box-shadow: 0 12px 25px rgba(59, 130, 246, 0.10);
    z-index: 2;
}

.quick-action-card:hover::after {
    opacity: 1;
}

.quick-action-card:active {
    transform: translateY(-1px) scale(0.99);
    transition-duration: 80ms;
}

.quick-action-card:focus-visible {
    outline: 3px solid rgba(59, 130, 246, 0.35);
    outline-offset: 3px;
}

/* Meaning-based backgrounds */
.quick-action-lost {
    background: linear-gradient(135deg, #ffe5e5 0%, #ffd6d6 100%);
    border: 1px solid rgba(220,38,38,0.25);
    color: #7f1d1d;
}
.quick-action-found {
    background: linear-gradient(135deg, #e6fff2 0%, #ccffe6 100%);
    border: 1px solid rgba(25,135,84,0.25);
    color: #065f46;
}
.quick-action-claims {
    background: linear-gradient(135deg, #e6f0ff 0%, #d6e4ff 100%);
    border: 1px solid rgba(13,110,253,0.25);
    color: #1d4ed8;
}


/* Card color accents (no layout/markup changes) */
.quick-action-lost,
.quick-action-found,
.quick-action-claims {
    box-shadow: 0 10px 25px rgba(2, 6, 23, 0.04);
}

.quick-action-lost::before,
.quick-action-found::before,
.quick-action-claims::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 7px;
    opacity: 0.95;
}

.quick-action-lost::before {
    background: linear-gradient(90deg, rgba(239,68,68,0.9), rgba(239,68,68,0.25));
}
.quick-action-found::before {
    background: linear-gradient(90deg, rgba(16,185,129,0.9), rgba(16,185,129,0.25));
}
.quick-action-claims::before {
    background: linear-gradient(90deg, rgba(59,130,246,0.95), rgba(124,58,237,0.25));
}

.quick-action-lost h6,
.quick-action-lost .small,
.quick-action-lost i { color: rgba(185, 28, 28, 0.95); }
.quick-action-found h6,
.quick-action-found .small,
.quick-action-found i { color: rgba(4, 120, 87, 0.95); }
.quick-action-claims h6,
.quick-action-claims .small,
.quick-action-claims i { color: rgba(37, 99, 235, 0.98); }

.quick-actions-row .quick-action-card:hover {
    box-shadow: 0 16px 40px rgba(59, 130, 246, 0.12);
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

.quick-icon-lost { background: #ef4444 !important; }
.quick-icon-found { background: #10b981 !important; }
.quick-icon-claims { background: #3b82f6 !important; }

/* Keep existing overrides (if used elsewhere in this file) */
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
    .welcome-stats { flex-direction: column; }
}

/* Enhanced User Welcome Card */
.user-welcome-card {
    position: relative;
    overflow: hidden;
}
.user-welcome-card::before {
    content: '';
    position: absolute;
    inset: -2px;
    background: radial-gradient(circle at 20% 15%, rgba(59,130,246,0.25), transparent 45%),
                radial-gradient(circle at 80% 20%, rgba(124,58,237,0.18), transparent 45%),
                radial-gradient(circle at 50% 95%, rgba(16,185,129,0.12), transparent 45%);
    pointer-events: none;
}
.user-welcome-card .card-body {
    position: relative;
    z-index: 1;
}

.welcome-top {
    padding: 10px 12px;
    border-radius: 16px;
    background: rgba(255,255,255,0.55);
    border: 1px solid rgba(59,130,246,0.12);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

.welcome-avatar {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: #fff;
    box-shadow: 0 16px 30px rgba(37, 99, 235, 0.25);
}
.welcome-avatar i {
    font-size: 2rem;
}

.email-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    border-radius: 999px;
    background: rgba(15,23,42,0.05);
    border: 1px solid rgba(15,23,42,0.08);
    color: rgba(15,23,42,0.75);
    max-width: 100%;
    word-break: break-word;
}

.welcome-title {
    letter-spacing: -0.2px;
}

.user-role-badge {
    background: rgba(16,185,129,0.15) !important;
    color: #059669 !important;
    border: 1px solid rgba(16,185,129,0.25);
    font-weight: 600;
    padding: 9px 12px;
}

.user-module-badge {
    background: rgba(37,99,235,0.12) !important;
    color: #1d4ed8 !important;
    border: 1px solid rgba(37,99,235,0.22);
    font-weight: 600;
    padding: 9px 12px;
}

.welcome-stats {
    display: flex;
    gap: 14px;
}

.stat-box {
    flex: 1;
    display: flex;
    gap: 12px;
    align-items: center;
    padding: 12px 14px;
    border-radius: 16px;
    background: rgba(255,255,255,0.7);
    border: 1px solid rgba(59,130,246,0.12);
}

.stat-icon {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(79,70,229,0.10);
    color: #4f46e5;
}

.stat-box:nth-child(2) .stat-icon {
    background: rgba(16,185,129,0.12);
    color: #059669;
}

.stat-value {
    font-weight: 800;
    line-height: 1.1;
}

.stat-label {
    font-size: 0.82rem;
    color: rgba(15,23,42,0.65);
    margin-top: 2px;
}

.welcome-desc {
    color: rgba(15,23,42,0.72);
    line-height: 1.65;
    font-size: 0.98rem;
}

.welcome-actions .btn {
    box-shadow: 0 10px 25px rgba(37,99,235,0.12);
}
.welcome-actions .btn-outline-primary {
    border-width: 2px;
}
</style>
@endsection


