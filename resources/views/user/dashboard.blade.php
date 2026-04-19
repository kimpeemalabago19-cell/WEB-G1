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
    overflow: hidden;
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
<div class="card item-card h-100"
    data-id="{{ $item->id }}"
    data-name="{{ $item->item_name }}"
    data-desc="{{ $item->description }}"
    data-img="{{ $item->image ? asset('storage/'.$item->image) : 'https://placehold.co/400x250' }}"
    data-date="{{ $item->created_at->format('M d, Y') }}"
    data-status="{{ ucfirst($item->status) }}"
    style="cursor: pointer;" onclick="openItemModal({{ $loop->index }}, @json($items));">

                    <div class="position-relative">
<img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://placehold.co/400x250' }}" class="w-100 item-img" alt="{{ $item->item_name }}"> 
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
    
    <style>
/* 🆕 ITEM MODAL STYLES - MODERN SPLIT VIEW */
.item-modal {
    position: fixed;
    inset: 0;
    z-index: 9998;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(8px);
    background: rgba(0,0,0,0.6);
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.item-modal.show {
    opacity: 1;
    visibility: visible;
}
.item-modal .modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.5);
    cursor: pointer;
}
.item-modal-dialog {
    position: relative;
    width: 90vw;
    max-width: 1000px;
    max-height: 90vh;
    transform: scale(0.8) translateY(-20px);
    transition: all 0.4s ease;
}
.item-modal.show .item-modal-dialog {
    transform: scale(1) translateY(0);
}
.item-modal-content {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 35px 80px rgba(0,0,0,0.25);
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    backdrop-filter: blur(20px);
}
.item-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}
.item-modal-header .close-btn {
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.3s ease;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.item-modal-header .close-btn:hover {
    background: rgba(255,255,255,0.2);
    transform: rotate(90deg);
}
.item-modal-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    padding: 2.5rem;
    flex: 1;
    overflow-y: auto;
}
.modal-image-section {
    display: flex;
    align-items: center;
    justify-content: center;
}
.image-wrapper {
    position: relative;
    width: 100%;
    max-width: 400px;
    aspect-ratio: 4/3;
}
.modal-item-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    transition: all 0.4s ease;
    cursor: zoom-in;
}
.modal-item-img:hover {
    transform: scale(1.03);
    box-shadow: 0 25px 50px rgba(0,0,0,0.2);
}
.modal-details-section .detail-row {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}
.modal-details-section label {
    font-weight: 600;
    color: #374151;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.detail-value {
    font-size: 1.1rem;
    line-height: 1.5;
}
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
}
.status-lost { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
.status-found { background: linear-gradient(135deg, #10b981, #059669); color: white; }
.status-available { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
.item-modal-footer {
    padding: 1.5rem 2.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}
.item-modal-footer .btn {
    padding: 12px 28px;
    border-radius: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.item-modal-footer .btn:hover {
    transform: translateY(-2px);
}

/* 🔄 RESPONSIVE - MOBILE STACK */
@media (max-width: 768px) {
    .item-modal-dialog {
        width: 95vw;
        margin: 1rem;
    }
    .item-modal-body {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 1.75rem;
    }
    .modal-image-section {
        order: -1;
    }
    .image-wrapper {
        max-width: 350px;
        margin: 0 auto;
    }
    .item-modal-header {
        padding: 1.25rem 1.5rem;
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    .item-modal-header h4 {
        margin: 0;
    }
    .detail-value {
        font-size: 1rem;
    }
}
@media (max-width: 480px) {
    .item-modal-body {
        padding: 1.5rem;
    }
    .item-modal-footer {
        flex-direction: column;
        padding: 1.25rem;
    }
    .item-modal-footer .btn {
        width: 100%;
    }
}
</style>
</div>

    <!-- 🆕 NEW ITEM DETAILS MODAL -->
    <div id="itemModal" class="item-modal" style="display: none;">
        <!-- Backdrop overlay -->
        <div class="modal-backdrop" onclick="closeItemModal()"></div>
        
        <!-- Modal content -->
        <div class="item-modal-dialog">
            <div class="item-modal-content">
                <!-- Header -->
                <div class="item-modal-header">
                    <h4 class="modal-title">
                        <i class="bi bi-info-circle"></i> Item Details
                    </h4>
                    <button class="close-btn" onclick="closeItemModal()">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                
                <!-- Body -->
                <div class="item-modal-body">
                    <div class="modal-image-section">
                        <div class="image-wrapper">
                            <img id="modalItemImage" src="" alt="Item Image" class="modal-item-img">
                        </div>
                    </div>
                    <div class="modal-details-section">
                        <div class="detail-row">
                            <label>Name</label>
                            <div id="modalItemName" class="detail-value fw-bold fs-4"></div>
                        </div>
                        <div class="detail-row">
                            <label>Description</label>
                            <div id="modalItemDesc" class="detail-value"></div>
                        </div>
                        <div class="detail-row">
                            <label>Status</label>
                            <span id="modalItemStatus" class="status-badge"></span>
                        </div>
                        <div class="detail-row">
                            <label>Date Posted</label>
                            <div id="modalItemDate" class="detail-value small text-muted"></div>
                        </div>
                        <div class="detail-row" id="modalItemLocationRow" style="display: none;">
                            <label>Location</label>
                            <div id="modalItemLocation" class="detail-value"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="item-modal-footer">
                    <button class="btn btn-secondary" onclick="closeItemModal()">Close</button>
                    @auth
                    <a href="{{ route('user.claim', ['id' => ':id']) }}" id="modalClaimBtn" class="btn btn-success" style="display:none;">
                        <i class="bi bi-hand-thumbs-up"></i> Claim Item
                    </a>
                    @endauth
                </div>
            </div>
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

<!-- Item View Modal -->
<div class="modal fade" id="itemViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-box-seam"></i> Item Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <img id="viewItemImg" src="" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
                    </div>

                    <div class="col-md-6">
                        <h4 id="viewItemName" class="fw-bold"></h4>

                        <p class="mb-2">
                            <span class="badge bg-secondary" id="viewItemStatus"></span>
                        </p>

                        <p class="text-muted" id="viewItemDesc"></p>

                        <small class="text-muted">
                            <i class="bi bi-calendar"></i>
                            <span id="viewItemDate"></span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
window.currentImages = [];
window.currentIndex = 0;
window.itemsData = [];
window.currentItemIndex = 0;

// Item Modal Functions
window.openItemModal = function(index, items) {
    window.itemsData = items;
    window.currentItemIndex = index;
    const item = items[index];
    const modal = document.getElementById('itemModal');
    
    // Populate fields
    document.getElementById('modalItemName').textContent = item.item_name || 'Unnamed Item';
    document.getElementById('modalItemDesc').textContent = item.description || 'No description';
    document.getElementById('modalItemDate').textContent = new Date(item.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    
    // Status badge
    const statusEl = document.getElementById('modalItemStatus');
    const status = item.status || 'available';
    statusEl.textContent = status.charAt(0).toUpperCase() + status.slice(1);
    statusEl.className = `status-badge status-${status}`;
    
    // Image
    const imgSrc = item.image ? '/storage/' + item.image : 'https://placehold.co/500x375/1e3a8a/ffffff?text=No+Image';
    document.getElementById('modalItemImage').src = imgSrc;
    
    // Location row
    const locationRow = document.getElementById('modalItemLocationRow');
    if (item.location && item.location.trim()) {
        document.getElementById('modalItemLocation').textContent = item.location;
        locationRow.style.display = 'block';
    } else {
        locationRow.style.display = 'none';
    }
    
    // Claim button logic
    const claimBtn = document.getElementById('modalClaimBtn');
    if (status === 'found') {
        claimBtn.href = "{{ route('user.claim', 0) }}".replace('0', item.id);
        claimBtn.style.display = 'inline-flex';
    } else {
        claimBtn.style.display = 'none';
    }
    
    // Show modal
    modal.style.display = 'flex';
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
};

window.closeItemModal = function() {
    const modal = document.getElementById('itemModal');
    modal.classList.remove('show');
    setTimeout(() => modal.style.display = 'none', 400);
    document.body.style.overflow = '';
};

window.openImageModal = function(index, images) {
    window.currentImages = images.map(i => i.image ? '/storage/' + i.image : '');
    window.currentIndex = index;
    document.getElementById('imageModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
    showCurrentImage();
};

function showCurrentImage() {
    const imgEl = document.getElementById('modalImage');
    imgEl.src = window.currentImages[window.currentIndex] || 'https://placehold.co/600x400';
}

window.nextImage = function() {
    if (window.currentImages && window.currentImages.length > 1) {
        window.currentIndex = (window.currentIndex + 1) % window.currentImages.length;
        showCurrentImage();
    }
};

window.prevImage = function() {
    if (window.currentImages && window.currentImages.length > 1) {
        window.currentIndex = (window.currentIndex - 1 + window.currentImages.length) % window.currentImages.length;
        showCurrentImage();
    }
};

window.closeImageModal = function() {
    document.getElementById('imageModal').style.display = 'none';
    document.body.style.overflow = '';
};

// Global event listeners
document.addEventListener('click', function(e) {
    if (e.target.classList && (e.target.classList.contains('modal-backdrop') || e.target.classList.contains('item-modal'))) {
        closeItemModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeItemModal();
        closeImageModal();
    }
    if (e.key === 'ArrowRight' && document.getElementById('imageModal').style.display === 'block') {
        nextImage();
    }
    if (e.key === 'ArrowLeft' && document.getElementById('imageModal').style.display === 'block') {
        prevImage();
    }
});

// ITEM VIEW MODAL FUNCTIONALITY
document.addEventListener('DOMContentLoaded', function () {
    const viewModal = new bootstrap.Modal(document.getElementById('itemViewModal'));

    document.querySelectorAll('.item-card').forEach(card => {
        card.addEventListener('click', function (e) {

            // Prevent triggering when clicking buttons/links inside card
            if (e.target.closest('a') || e.target.closest('button')) {
                return;
            }

            document.getElementById('viewItemImg').src = this.dataset.img;
            document.getElementById('viewItemName').textContent = this.dataset.name;
            document.getElementById('viewItemDesc').textContent = this.dataset.desc;
            document.getElementById('viewItemDate').textContent = this.dataset.date;
            document.getElementById('viewItemStatus').textContent = this.dataset.status;

            // badge color
            const badge = document.getElementById('viewItemStatus');
            badge.className = 'badge';

            if (this.dataset.status.toLowerCase() === 'lost') {
                badge.classList.add('bg-danger');
            } else {
                badge.classList.add('bg-success');
            }

            viewModal.show();
        });
    });
});
</script>
@endsection


</xai:function_call}





<xai:function_call name="edit_file">
<parameter name="path">c:/xampp/htdocs/web-g2-laravel/resources/views/user/dashboard.blade.php
@section('scripts')
<script>
window.currentImages = [];
window.currentIndex = 0;
window.itemsData = [];
window.currentItemIndex = 0;

// Item Modal Functions
window.openItemModal = function(index, items) {
    window.itemsData = items;
    window.currentItemIndex = index;
    const item = items[index];
    const modal = document.getElementById('itemModal');
    
    // Populate fields
    document.getElementById('modalItemName').textContent = item.item_name || 'Unnamed Item';
    document.getElementById('modalItemDesc').textContent = item.description || 'No description';
    document.getElementById('modalItemDate').textContent = new Date(item.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    
    // Status
    const statusEl = document.getElementById('modalItemStatus');
    const status = item.status || 'available';
    statusEl.textContent = status.charAt(0).toUpperCase() + status.slice(1);
    statusEl.className = `status-badge status-${status}`;
    
    // Image
    const imgSrc = item.image ? '/storage/' + item.image : 'https://placehold.co/500x375/1e3a8a/ffffff?text=No+Image';
    document.getElementById('modalItemImage').src = imgSrc;
    
    // Location (hide if missing)
    const locationRow = document.getElementById('modalItemLocationRow');
    if (item.location) {
        document.getElementById('modalItemLocation').textContent = item.location;
        locationRow.style.display = 'block';
    } else {
        locationRow.style.display = 'none';
    }
    
    // Claim button for found items
    const claimBtn = document.getElementById('modalClaimBtn');
    if (item.status === 'found') {
        claimBtn.href = `{{ route('user.claim', ':id') }}`.replace(':id', item.id);
        claimBtn.style.display = 'inline-flex';
    } else {
        claimBtn.style.display = 'none';
    }
    
    // Show
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
};

window.closeItemModal = function() {
    document.getElementById('itemModal').classList.remove('show');
    document.body.style.overflow = '';
    window.itemsData = [];
    window.currentItemIndex = 0;
};

// Image Lightbox (preserve existing)
window.openImageModal = function(index, images) {
    window.currentImages = images.map(img => '/storage/' + img.image);
    window.currentIndex = index;
    document.getElementById('imageModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
    showImage(index);
};

function showImage(index) {
    document.getElementById('modalImage').src = window.currentImages[index];
    window.currentIndex = index;
}

window.nextImage = function() {
    if (window.currentImages?.length) {
        const next = (window.currentIndex + 1) % window.currentImages.length;
        showImage(next);
    }
};

window.prevImage = function() {
    if (window.currentImages?.length) {
        const prev = (window.currentIndex - 1 + window.currentImages.length) % window.currentImages.length;
        showImage(prev);
    }
};

window.closeImageModal = function() {
    document.getElementById('imageModal').style.display = 'none';
    document.body.style.overflow = '';
};

// Global event listeners (separate for each modal)
document.addEventListener('keydown', function(e) {
    const itemModalOpen = document.getElementById('itemModal').classList.contains('show');
    const imageModalOpen = document.getElementById('imageModal').style.display === 'block';
    
    if (e.key === 'Escape') {
        if (itemModalOpen) closeItemModal();
        if (imageModalOpen) closeImageModal();
    }
    if (imageModalOpen) {
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') prevImage();
    }
});

// Outside click for item modal
document.getElementById('itemModal')?.addEventListener('click', function(e) {
    if (e.target.classList.contains('item-modal') || e.target.classList.contains('modal-backdrop')) {
        closeItemModal();
    }
});
</script>
@endsection
