@extends('layouts.user')

@section('title', 'Dashboard - Lost & Found')

@section('styles')
<style>

/* 🌈 GLOBAL DESIGN */
body {
    background: #f6f8fc;
}

/* 🔷 HERO HEADER */
.hero-header {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 25px;
}

.hero-header h2 {
    font-weight: 700;
}

.hero-header p {
    opacity: 0.9;
}

/* 📊 STATS */
.stat-card {
    border: none;
    border-radius: 16px;
    padding: 20px;
    color: white;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.stat-icon {
    font-size: 1.5rem;
    opacity: 0.8;
}

/* 🚀 TOOLBAR STYLES */
.toolbar {
    border-radius: 24px;
    transition: all 0.3s ease;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(0,0,0,0.05);
}

.toolbar .form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 0.2rem rgba(79,70,229,0.15);
}

.filter-btn {
    font-size: 0.9rem;
    font-weight: 500;
    min-width: 85px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1.5px solid transparent;
}

.filter-btn:hover:not(.active) {
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}

/* 🎛 FILTER PILLS */
.filter-pill {
    border-radius: 50px;
    padding: 8px 18px;
}

.filter-pill.active {
    background: #4f46e5;
    color: white;
}

/* 🧱 ITEM CARD */
.item-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    transition: 0.3s;
}

.item-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* IMAGE */
.item-img {
    height: 200px;
    object-fit: cover;
}

/* BADGE */
.badge-status {
    position: absolute;
    top: 10px;
    right: 10px;
}

/* CLAIM MODAL - BULLETPROOF CENTERING + MOBILE */
.claim-modal .modal-dialog {
    position: fixed !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    margin: 0 !important;
    max-width: 700px !important; /* WIDER */
    width: 95vw !important;
    max-height: 90vh !important;
    z-index: 1062 !important;
}

.claim-modal .modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    overflow: hidden;
}

/* NO BACKDROP FOR CLAIM MODAL - ULTRA CLEAN */
.claim-modal .modal-backdrop {
    display: none !important;
}

.claim-modal {
    z-index: 1060 !important;
}

.claim-modal .modal-dialog {
    z-index: 1061 !important;
}

    background-color: rgba(0,0,0,0.5) !important;
}

@media (max-width: 768px) {
    .claim-modal .modal-dialog {
        margin: 1rem;
        max-width: 95vw;
    }
}

    border: none;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.claim-modal .modal-header {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border-radius: 20px 20px 0 0 !important;
}

.claim-modal .modal-body {
    padding: 2rem;
}

.claim-form-group {
    margin-bottom: 1.5rem;
}

.claim-form-group label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    display: block;
}

.claim-form-group input {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 1rem;
    transition: all 0.3s;
}

.claim-form-group input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    outline: none;
}

.item-preview {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.item-preview img {
    display: block !important;
    width: 100%;
    height: 250px;
    object-fit: cover;

/* EMPTY */
.empty-box {
    text-align: center;
    padding: 60px;
}

/* RESPONSIVE */
@media(max-width:768px){
    .hero-header {
        text-align: center;
    }
}

</style>
@endsection


@section('content')
<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>
<div class="container py-4">


    <!-- 🔷 HERO -->
    <div class="hero-header d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2>Lost & Found Dashboard</h2>
            <p>Track, search, and claim your lost items بسهولة</p>
        </div>

        <div class="text-end">
            <h4 class="mb-0">{{ $items->count() }}</h4>
            <small>Total Items</small>
        </div>
    </div>


    <!-- 📊 STATS -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card bg-danger">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Lost</h5>
                        <h3>{{ $items->where('status','lost')->count() }}</h3>
                    </div>
                    <i class="bi bi-exclamation-triangle stat-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card bg-success">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Found</h5>
                        <h3>{{ $items->where('status','found')->count() }}</h3>
                    </div>
                    <i class="bi bi-check-circle stat-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card bg-primary">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>Available for Claim</h5>
                        <h3>{{ $items->where('status','found')->count() }}</h3>
                    </div>
                    <i class="bi bi-box stat-icon"></i>
                </div>
            </div>
        </div>
    </div>


    <!-- 🔍 SEARCH + FILTER -->
    <div class="toolbar bg-white rounded-4 shadow-sm border p-4 mb-4 position-relative">
        <form method="GET" class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            {{-- Filters Left --}}
            <div class="d-flex gap-2 order-2 order-md-1">
                <a href="{{ route('user.dashboard',['search_category'=>'lost']) }}" 
                   class="btn btn-outline-danger rounded-pill px-4 py-2 filter-btn {{ $category=='lost'?'btn-danger shadow-sm fw-semibold':'' }}">
                    Lost
                </a>
                <a href="{{ route('user.dashboard',['search_category'=>'found']) }}" 
                   class="btn btn-outline-success rounded-pill px-4 py-2 filter-btn {{ $category=='found'?'btn-success shadow-sm fw-semibold':'' }}">
                    Found
                </a>
                <a href="{{ route('user.dashboard') }}" 
                   class="btn btn-outline-secondary rounded-pill px-4 py-2 filter-btn {{ empty($category) || $category=='all'?'btn-secondary shadow-sm fw-semibold':'' }}">
                    All
                </a>
            </div>

            {{-- Search Right --}}
            <div class="search-input flex-grow-1 d-flex order-1 order-md-2" style="max-width: 500px;">
                <input type="text" name="search" class="form-control rounded-start-pill ps-4 border-end-0 flex-grow-1" 
                       placeholder="🔍 Search items..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary rounded-end-pill px-4">
                    <i class="bi bi-search"></i>
                </button>
                @if(request('search'))
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary rounded-pill ms-1 px-2" title="Clear">
                    <i class="bi bi-x-circle"></i>
                </a>
                @endif
            </div>
        </form>
    </div>


    <!-- 🧱 ITEMS -->
    <div class="row g-4">

        @forelse($items as $item)

        <div class="col-xl-3 col-lg-4 col-md-6">

            <div class="card item-card h-100">

                <div class="position-relative">
                    <img 
                        src="{{ $item->image ? asset('storage/'.$item->image) : 'https://placehold.co/400x250' }}"
                        class="w-100 item-img">

                    <span class="badge badge-status 
                        @if($item->status=='lost') bg-danger
                        @elseif($item->status=='found') bg-success
                        @else bg-primary
                        @endif">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>

                <div class="card-body d-flex flex-column">

                    <h5 class="fw-bold text-truncate">{{ $item->item_name }}</h5>

                    <p class="text-muted small">
                        {{ Str::limit($item->description, 60) }}
                    </p>

                    <small class="text-muted mb-3">
                        {{ $item->created_at->format('M d, Y') }}
                    </small>



                </div>

            </div>

        </div>

        @empty
        <div class="empty-box">
            <i class="bi bi-inbox display-4 text-muted"></i>
            <h4>No Items Found</h4>
        </div>
        @endforelse

    </div>

</div>


<!-- 🧾 ENHANCED CLAIM MODAL -->
@endsection


@section('scripts')
<script>
// Legacy function - replaced by data attributes
function openClaimModal(id, name, img = '') {
    console.warn('Legacy openClaimModal called - use data attributes');
}

// Modern event delegation for claim buttons
document.addEventListener('DOMContentLoaded', function() {
    const claimButtons = document.querySelectorAll('.claim-btn');
    const modal = document.getElementById('claimModal');
    
    claimButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Claim button clicked!', this.dataset);
            
            document.getElementById('itemId').value = this.dataset.itemId;
            document.getElementById('modalItemName').textContent = this.dataset.itemName;
            document.getElementById('modalItemImg').src = this.dataset.itemImg || 'https://placehold.co/400x250';
            
            // Reset form
            document.getElementById('claimForm').reset();
            
            // Show modal
            const bsModal = new bootstrap.Modal(modal, {backdrop: 'static', keyboard: false});
            bsModal.show();
        });
    });
    
    // Debug: Log lost items count
    console.log('Lost items for claim:', {{ $items->where('status','lost')->count() }});
});



    // Auto-focus contact field for better UX
    setTimeout(() => document.getElementById('claimContact').focus(), 300);
}


// Form validation
document.getElementById('claimForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitClaim');
    const confirm = document.getElementById('claimConfirm');
    
    if (!confirm.checked) {
        e.preventDefault();
        // Modern toast notification
        showToast('Please confirm your claim before submitting.', 'warning');
        confirm.focus();
        return;
    }
    
    // Show loading state
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Submitting...';
    submitBtn.disabled = true;
});

// Toast helper function
function showToast(message, type = 'info') {
    const toastHtml = `
        <div class="toast align-items-center text-bg-${type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'info'} border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="toast-body">
                ${message}
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    const toastContainer = document.getElementById('toastContainer') || createToastContainer();
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    const toast = new bootstrap.Toast(toastContainer.lastElementChild);
    toast.show();
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toastContainer';
    container.className = 'toast-container position-fixed top-0 end-0 p-3';
    document.body.appendChild(container);
    return container;
}

// Show flash messages on page load
@if(session('success'))
    setTimeout(() => showToast("{{ session('success') }}", 'success'), 500);
@endif
@if(session('error'))
    setTimeout(() => showToast("{{ session('error') }}", 'danger'), 500);
@endif

</script>
@endsection
