@extends('layouts.user')

@section('title', 'Dashboard - Lost & Found')

@section('styles')
<style>
/* 🌈 GLOBAL DESIGN */
body {
    background: #f6f8fc;
    font-family: 'Inter', sans-serif;
}

/* 🔷 HERO HEADER */
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

/* 📊 STATS */
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

/* 🚀 TOOLBAR */
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
<img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://placehold.co/400x250' }}" class="w-100 item-img" style="cursor:pointer;" onclick="openImageModal({{ $loop->index }}, @json($items))" alt="{{ $item->item_name }}">
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

    <!-- CLEAN ITEM LIGHTBOX MODAL -->
    <div id="imageModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.95); z-index:9999;">
        <!-- CLOSE -->
        <div onclick="closeImageModal()" style="position:absolute; top:20px; right:25px; font-size:40px; color:white; cursor:pointer;">
            &times;
        </div>

        <!-- LEFT ARROW -->
        <div onclick="prevImage()" style="position:absolute; left:20px; top:50%; transform:translateY(-50%); font-size:40px; color:white; cursor:pointer;">
            ❮
        </div>

        <!-- RIGHT ARROW -->
        <div onclick="nextImage()" style="position:absolute; right:20px; top:50%; transform:translateY(-50%); font-size:40px; color:white; cursor:pointer;">
            ❯
        </div>

        <!-- IMAGE -->
        <div style="display:flex; justify-content:center; align-items:center; height:100%;">
            <img id="modalImage" style="max-width:80%; max-height:80%; border-radius:10px; transition:0.3s;">
        </div>
    </div>
@endsection
</xai:function_call}





<xai:function_call name="edit_file">
<parameter name="path">c:/xampp/htdocs/web-g2-laravel/resources/views/user/dashboard.blade.php
@section('scripts')
<script>
    <script>
window.currentImages = [];
window.currentIndex = 0;

window.openImageModal = function(index, items) {
    window.currentImages = items;
    window.currentIndex = index;

    document.getElementById('imageModal').style.display = 'block';
    document.body.style.overflow = 'hidden';

    showImage(index);
};

function showImage(index) {
    if (!window.currentImages || window.currentImages.length === 0) return;

    let item = window.currentImages[index];

    document.getElementById('modalImage').src = item.image;
    window.currentIndex = index;
}

window.nextImage = function() {
    if (!window.currentImages.length) return;

    let next = (window.currentIndex + 1) % window.currentImages.length;
    showImage(next);
};

window.prevImage = function() {
    if (!window.currentImages.length) return;

    let prev = (window.currentIndex - 1 + window.currentImages.length) % window.currentImages.length;
    showImage(prev);
};

window.closeImageModal = function() {
    document.getElementById('imageModal').style.display = 'none';
    document.body.style.overflow = '';
};

document.addEventListener('keydown', function(e) {
    if (document.getElementById('imageModal').style.display === 'block') {
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'Escape') closeImageModal();
    }
});
    </script>

@endsection
