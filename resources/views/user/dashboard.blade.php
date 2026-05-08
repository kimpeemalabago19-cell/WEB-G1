@extends('layouts.user')

@section('title', 'Dashboard - Lost & Found')

@section('styles')
<style>
/* ðŸŒˆ GLOBAL DESIGN */
body {
    background: #f6f8fc;
    font-family: 'Inter', sans-serif;
}

/* ðŸ”· HERO HEADER */
.hero-header {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    min-height: 140px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(79, 70, 229, 0.3);
}
.hero-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: rgba(255,255,255,0.2);
}
.hero-header .title-section {
    flex: 1;
    min-width: 0;
}
.hero-header .title-section h2 {
    font-size: 2.25rem;
    font-weight: 800;
    margin: 0 0 0.5rem 0;
    line-height: 1.2;
    letter-spacing: -0.02em;
}
.hero-header .title-section p {
    opacity: 0.95;
    margin: 0;
    font-size: 1.1rem;
    line-height: 1.4;
    direction: auto;
}
.hero-header .stats-section {
    flex-shrink: 0;
    text-align: center;
    padding: 1rem 1.5rem;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.3);
    transition: all 0.3s ease;
}
.hero-header .stats-section:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.2);
    background: rgba(255,255,255,0.2);
}

/* ðŸ“Š STATS */
.stat-card {
    border: none;
    border-radius: 16px;
    padding: 20px;
    color: white;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.08);
}
.stat-icon {
    font-size: 1.5rem;
    opacity: 0.85;
}

/* ðŸš€ TOOLBAR */
.toolbar {
    border-radius: 24px;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(0,0,0,0.05);
    padding: 1rem 1.5rem;
    margin-bottom: 25px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    background: white;
}
.toolbar .form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 0.2rem rgba(79,70,229,0.15);
}

/* FILTER BUTTONS */
.filter-btn {
    font-size: 0.9rem;
    font-weight: 500;
    min-width: 85px;
    transition: all 0.2s ease;
    border-radius: 50px;
}
.filter-btn.active, .filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}

/* ITEM CARDS */
.item-card {
    border: none;
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    overflow: visible;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.item-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
}
.item-img {
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}
.item-card:hover .item-img {
    transform: scale(1.05);
}

/* STATUS BADGE */
.badge-status {
    position: absolute;
    top: 10px;
    right: 10px;
    border-radius: 16px;
    padding: 5px 12px;
    font-size: 0.8rem;
    font-weight: 600;
    color: white;
}
.bg-danger { background: #ef4444; }
.bg-success { background: #10b981; }
.bg-primary { background: #3b82f6; }

/* EMPTY STATE */
.empty-box {
    text-align: center;
    padding: 60px;
    color: #9ca3af;
}

/* CLAIM MODAL - ENHANCED */
.claim-modal .modal-dialog {
    max-width: min(700px, 90vw);
    width: calc(100% - 2rem);
    margin: 1.75rem auto;
    z-index: 1065;
}
.claim-modal .modal-content {
    border-radius: 24px;
    overflow: hidden;
    border: none;
    box-shadow: 0 35px 70px rgba(0,0,0,0.2);
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    backdrop-filter: blur(10px);
}
.claim-modal .modal-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    padding: 1.5rem 2.5rem;
}
.claim-modal .modal-body {
    display: flex;
    flex-direction: column;
    gap: 1.75rem;
    padding: 2.5rem;
    max-height: 80vh;
    overflow-y: auto;
}
.claim-modal .image-container {
    text-align: center;
}
.claim-modal img {
    max-width: 350px;
    width: 100%;
    height: auto;
    max-height: 280px;
    object-fit: cover;
    border-radius: 20px;
    border: 3px solid #10b981;
    box-shadow: 0 15px 35px rgba(16,185,129,0.15);
    transition: all 0.3s ease;
}
.claim-modal img:hover {
    transform: scale(1.02);
    box-shadow: 0 20px 45px rgba(16,185,129,0.25);
}
.claim-modal #modalItemName {
    text-align: center;
    margin-bottom: 0;
    font-size: 1.5rem;
    font-weight: 700;
}
.claim-form-group {
    margin-bottom: 0;
}
.claim-form-group label {
    display: block;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.75rem;
    font-size: 1rem;
}
.claim-form-group input, 
.claim-form-group textarea {
    width: 100%;
    min-height: 52px;
    padding: 14px 20px;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    font-size: 1rem;
    background: #fff;
    transition: all 0.3s ease;
    box-sizing: border-box;
}
.claim-form-group textarea {
    min-height: 100px;
    resize: vertical;
}
.claim-form-group input:focus, 
.claim-form-group textarea:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 4px rgba(16,185,129,0.1);
    outline: none;
    transform: translateY(-1px);
}
.claim-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 2px solid #dcfce7;
    border-radius: 16px;
    margin-bottom: 0;
}
.claim-checkbox .form-check-input {
    margin-top: 0.1rem;
    width: 22px;
    height: 22px;
    flex-shrink: 0;
}
.claim-checkbox .form-check-label {
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 0;
}
.claim-modal .modal-footer {
    border-top: 1px solid #e5e7eb;
    justify-content: flex-end !important;
    gap: 1.25rem;
    padding: 1.75rem 2.5rem;
    background: #fafbfc;
}
.claim-modal .modal-footer .btn {
    min-width: 130px;
    padding: 14px 28px;
    border-radius: 16px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}
.claim-modal .modal-footer .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.claim-modal .btn-secondary {
    background: #f3f4f6;
    border: 2px solid #e5e7eb;
    color: #374151;
}
.claim-modal .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: 2px solid #10b981;
}

/* MODAL ANIMATION */
.claim-modal.fade .modal-dialog {
    transform: scale(0.85) translateY(-30px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.claim-modal.show .modal-dialog {
    transform: scale(1) translateY(0);
    opacity: 1;
}

/* IMAGE MODAL STYLES */
.image-modal-content {
    max-height: 90vh;
    overflow: hidden;
}
.image-container {
    position: relative;
}
.image-container button {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.image-container button:hover {
    background: white;
}
#modalImage {
    transition: opacity 0.3s ease;
}

/* RESPONSIVE IMAGE MODAL */
@media (max-width: 992px) {
    .image-modal-content {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        width: 95%;
        max-width: 600px;
    }
    .image-container {
        min-height: 300px;
    }
    #modalImage {
        max-height: 60vh;
    }
}
@media (max-width: 576px) {
    #imageModal {
        padding: 20px;
    }
    .image-modal-content {
        border-radius: 16px;
        width: 98vw;
    }
    .image-container button {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
}

/* RESPONSIVE IMPROVEMENTS */
@media (max-width: 768px) {
    .claim-modal .modal-dialog {
        width: 95vw;
        margin: 1rem auto;
    }
    .claim-modal .modal-body {
        padding: 1.75rem;
        gap: 1.25rem;
    }
    .claim-modal img {
        max-width: 280px;
        max-height: 220px;
    }
    .claim-modal .modal-footer {
        padding: 1.25rem;
        flex-direction: column;
        gap: 1rem;
    }
    .claim-modal .modal-footer .btn {
        width: 100%;
    }
    .claim-checkbox {
        padding: 1.25rem;
    }
}
@media (max-width: 576px) {
    .claim-modal .modal-body {
        padding: 1.5rem;
    }
    .claim-modal #modalItemName {
        font-size: 1.25rem;
    }
    .claim-form-group input, 
    .claim-form-group textarea {
        min-height: 48px;
        padding: 12px 16px;
    }
    .hero-header .title-section h2 {
        font-size: 1.75rem;
    }
    .hero-header .title-section p {
        font-size: 1rem;
    }
    .item-img { 
        height: 180px; 
    }
}
@media(max-width:992px){
    .hero-header {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
        padding: 2rem 1.5rem;
        min-height: auto;
    }
    .hero-header .title-section {
        width: 100%;
    }
    .hero-header .stats-section {
        width: 100%;
        max-width: 280px;
        margin: 0 auto;
    }
}

/* ITEM DETAIL MODAL - NEW */
#itemDetailModal .modal-content {
    border: none;
    border-radius: 24px;
    box-shadow: 0 25px 80px rgba(0,0,0,0.35);
    overflow: hidden;
}
#itemDetailModal .modal-header {
    padding: 1.25rem 1.5rem 0.5rem;
    border-bottom: none;
}
#itemDetailModal .modal-body {
    padding: 0;
}
#modalImage {
    transition: opacity 0.3s ease;
}
#modalDetailsWrapper {
    transition: opacity 0.3s ease;
}
.modal-nav-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: rgba(255,255,255,0.95);
    color: #1f2937;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    transition: all 0.2s ease;
}
.modal-nav-btn:hover {
    background: white;
    transform: scale(1.1);
}
.modal-nav-btn.d-none {
    display: none !important;
}
#footerPrevBtn.d-none, #footerNextBtn.d-none {
    display: none !important;
}
@media (max-width: 991px) {
    #itemDetailModal .modal-dialog {
        margin: 0.5rem auto;
        max-width: calc(100% - 1rem);
    }
    #itemDetailModal .modal-content {
        border-radius: 16px !important;
    }
    #modalImage {
        max-height: 45vh;
    }
    .modal-nav-btn {
        width: 40px;
        height: 40px;
    }
    .modal-nav-btn i {
        font-size: 1rem;
    }
}
@media (max-width: 576px) {
    #itemDetailModal .modal-header {
        padding: 1rem;
    }
    #itemDetailModal .col-lg-5 {
        padding: 1.25rem !important;
    }
}
</style>
@endsection

@section('content')
<div class="container py-4">
    <!-- HERO -->
    <div class="hero-header">
        <div class="title-section">
            <h2>Lost & Found Dashboard</h2>
            <p dir="auto">Track, search, and recover your lost items in one place</p>
        </div>
        <div class="stats-section">
            {{ $stats['total'] }}
            <small class="opacity-90">Total Items</small>
        </div>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card bg-danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Lost</h5>
                        {{ $stats['lost'] }}
                    </div>
                    <i class="bi bi-exclamation-triangle stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Found</h5>
                        {{ $stats['found'] }}
                    </div>
                    <i class="bi bi-check-circle stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Available for Claim</h5>
                        {{ $stats['available'] }}
                    </div>
                    <i class="bi bi-box stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- SEARCH & FILTER -->
    <div class="toolbar">
        <form method="GET" class="d-flex flex-wrap gap-2 justify-content-between w-100">
            <div class="d-flex gap-2">
                <a href="{{ route('user.dashboard',['search_category'=>'lost']) }}" 
                   class="btn filter-btn {{ $category=='lost'?'active':'' }}">Lost</a>
                <a href="{{ route('user.dashboard',['search_category'=>'found']) }}" 
                   class="btn filter-btn {{ $category=='found'?'active':'' }}">Found</a>
                <a href="{{ route('user.dashboard') }}" 
                   class="btn filter-btn {{ empty($category) || $category=='all'?'active':'' }}">All</a>
            </div>
            <div class="d-flex flex-grow-1 max-w-500">
                <input type="text" name="search" class="form-control rounded-start-pill ps-3 flex-grow-1 border-end-0" placeholder="Search items..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary rounded-end-pill px-3"><i class="bi bi-search"></i></button>
                @if(request('search'))
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary ms-1 rounded-pill px-2"><i class="bi bi-x-circle"></i></a>
                @endif
            </div>
        </form>
    </div>

    <!-- ITEMS GRID -->
    <div class="row g-4 mt-2">
        @forelse($items as $item)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card item-card h-100 position-relative">
                    <div class="position-relative">
                        <img src="{{ $item->image ? asset('storage/'.$item->image.'?v='.$item->updated_at) : 'https://placehold.co/400x250' }}" class="w-100 item-img" style="cursor:pointer;" onclick='openImageModal(@json($item))' alt="{{ $item->item_name }}">
                        <span class="badge-status @if($item->status=='lost') bg-danger @elseif($item->status=='found') bg-success @else bg-primary @endif">{{ ucfirst($item->status) }}</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold text-truncate">{{ $item->item_name }}</h5>
                        <p class="text-muted small">{{ Str::limit($item->description, 60) }}</p>
                        <small class="text-muted">{{ $item->created_at->format('M d, Y') }}</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-box">
                <i class="bi bi-inbox display-4"></i>
                <h4>No Items Found</h4>
            </div>
        @endforelse
    </div>
</div>

<!-- ITEM DETAIL MODAL (Two Column) -->
<div class="modal fade" id="itemDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">Item Details</h5>
                <button type="button" class="btn-close" onclick="closeImageModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-0 h-100">
                    <!-- LEFT: IMAGE -->
                    <div class="col-lg-7 bg-dark position-relative d-flex align-items-center justify-content-center" style="min-height: 350px; border-radius: 16px;">
                        <button id="imgPrevBtn" class="btn btn-light rounded-circle position-absolute start-0 top-50 translate-middle-y ms-3 modal-nav-btn" onclick="prevImage()">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button id="imgNextBtn" class="btn btn-light rounded-circle position-absolute end-0 top-50 translate-middle-y me-3 modal-nav-btn" onclick="nextImage()">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        <img id="modalImage" class="img-fluid" style="max-height: 65vh; width: 100%; object-fit: contain;" src="" alt="">
                    </div>
                    <!-- RIGHT: DETAILS -->
                    <div class="col-lg-5 p-4 p-lg-5 d-flex flex-column bg-white">
                        <div id="modalDetailsWrapper">
                            <h3 id="modalItemName" class="fw-bold mb-1 text-dark"></h3>
                            <p id="modalItemCategory" class="text-muted small mb-3 fw-medium"></p>
                            
                            <div class="mb-3">
                                <span id="modalItemStatus" class="badge rounded-pill px-3 py-2"></span>
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="fw-bold text-dark mb-2">Description</h6>
                                <p id="modalItemDescription" class="text-muted mb-0" style="line-height: 1.7;"></p>
                            </div>
                            
                            <div class="d-flex flex-column gap-3 mb-4">
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border">
                                    <i class="bi bi-calendar-event text-primary fs-5"></i>
                                    <div>
                                        <small class="text-muted d-block">Date Posted</small>
                                        <span id="modalItemDatePosted" class="fw-semibold text-dark"></span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border" id="modalDateFoundRow">
                                    <i class="bi bi-calendar-check text-primary fs-5"></i>
                                    <div>
                                        <small class="text-muted d-block">Date Found</small>
                                        <span id="modalItemDateFound" class="fw-semibold text-dark"></span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border">
                                    <i class="bi bi-person text-primary fs-5"></i>
                                    <div>
                                        <small class="text-muted d-block">Reported By</small>
                                        <span id="modalItemReporter" class="fw-semibold text-dark"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-auto pt-3 d-flex gap-2 border-top">
                            <button id="footerPrevBtn" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold" onclick="prevImage()">
                                <i class="bi bi-arrow-left me-2"></i> Previous
                            </button>
                            <button id="footerNextBtn" class="btn btn-primary rounded-pill px-4 fw-semibold ms-auto" onclick="nextImage()">
                                Next <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
window.dashboardItems = @json($items);
window.currentImages = [];
window.currentIndex = 0;

let itemDetailModalEl = document.getElementById('itemDetailModal');
let bsItemModal = itemDetailModalEl ? new bootstrap.Modal(itemDetailModalEl, {
    backdrop: true,
    keyboard: true
}) : null;

window.openImageModal = function(item) {
    window.currentImages = window.dashboardItems;
    window.currentIndex = window.dashboardItems.findIndex(i => i.id === item.id);
    if (bsItemModal) bsItemModal.show();
    showImage(window.currentIndex);
};

function showImage(index) {
    if (!window.currentImages || window.currentImages.length === 0) return;

    let item = window.currentImages[index];
    let imgEl = document.getElementById('modalImage');
    let detailsEl = document.getElementById('modalDetailsWrapper');

    // Fade out
    if (imgEl) imgEl.style.opacity = '0';
    if (detailsEl) detailsEl.style.opacity = '0';

    setTimeout(function() {
        // Update image
        if (imgEl) imgEl.src = item.image ? '/storage/' + item.image : 'https://placehold.co/600x400?text=No+Image';

        // Update details
        let nameEl = document.getElementById('modalItemName');
        if (nameEl) nameEl.textContent = item.item_name || 'Untitled Item';

        let catEl = document.getElementById('modalItemCategory');
        if (catEl) catEl.textContent = item.category || 'Uncategorized';

        let statusEl = document.getElementById('modalItemStatus');
        if (statusEl) {
            statusEl.textContent = item.status ? item.status.charAt(0).toUpperCase() + item.status.slice(1) : 'Unknown';
            statusEl.className = 'badge rounded-pill px-3 py-2 ' + (item.status === 'lost' ? 'bg-danger' : (item.status === 'found' ? 'bg-success' : 'bg-primary'));
        }

        let descEl = document.getElementById('modalItemDescription');
        if (descEl) descEl.textContent = item.description || 'No description provided.';

        let datePostedEl = document.getElementById('modalItemDatePosted');
        if (datePostedEl) datePostedEl.textContent = item.created_at ? new Date(item.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : '—';

        let dateFoundEl = document.getElementById('modalItemDateFound');
        if (dateFoundEl) dateFoundEl.textContent = item.date_found ? new Date(item.date_found).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : '—';

        let dateFoundRow = document.getElementById('modalDateFoundRow');
        if (dateFoundRow) dateFoundRow.style.display = item.date_found ? 'flex' : 'none';

        let reporterEl = document.getElementById('modalItemReporter');
        if (reporterEl) reporterEl.textContent = item.reporter_name || (item.reporter ? item.reporter.name : 'Anonymous');

        window.currentIndex = index;

        updateNavButtons();

        // Fade in
        setTimeout(function() {
            if (imgEl) imgEl.style.opacity = '1';
            if (detailsEl) detailsEl.style.opacity = '1';
        }, 50);
    }, 200);
}

function updateNavButtons() {
    let total = window.currentImages.length;
    let isFirst = window.currentIndex <= 0;
    let isLast = window.currentIndex >= total - 1;

    let imgPrev = document.getElementById('imgPrevBtn');
    let imgNext = document.getElementById('imgNextBtn');
    let footPrev = document.getElementById('footerPrevBtn');
    let footNext = document.getElementById('footerNextBtn');

    if (imgPrev) imgPrev.classList.toggle('d-none', isFirst);
    if (imgNext) imgNext.classList.toggle('d-none', isLast);
    if (footPrev) footPrev.classList.toggle('d-none', isFirst);
    if (footNext) footNext.classList.toggle('d-none', isLast);
}

window.nextImage = function() {
    if (!window.currentImages.length) return;
    if (window.currentIndex >= window.currentImages.length - 1) return;
    showImage(window.currentIndex + 1);
};

window.prevImage = function() {
    if (!window.currentImages.length) return;
    if (window.currentIndex <= 0) return;
    showImage(window.currentIndex - 1);
};

window.closeImageModal = function() {
    if (bsItemModal) bsItemModal.hide();
    document.body.style.overflow = '';
};

document.addEventListener('keydown', function(e) {
    if (!itemDetailModalEl) return;
    let isVisible = itemDetailModalEl.classList.contains('show');
    if (!isVisible) return;

    if (e.key === 'ArrowRight') nextImage();
    if (e.key === 'ArrowLeft') prevImage();
    if (e.key === 'Escape') closeImageModal();
});

// Cleanup body overflow when modal hides
if (itemDetailModalEl) {
    itemDetailModalEl.addEventListener('hidden.bs.modal', function() {
        document.body.style.overflow = '';
    });
}
</script>
@endsection

