@extends('layouts.user')

@section('title', 'Found Items - CHMSU Lost & Found')

@section('content')
<!-- PAGE TITLE -->
<div class="page-header">
    <div class="header-content">
        <h1>Lost & Found Items</h1>
        <p class="header-subtitle">Track and claim your lost belongings</p>
    </div>
    <div class="header-stats">
        <div class="stat-pill">
            <i class="bi bi-archive"></i>
            <span>{{ $items->count() }} Items</span>
        </div>
    </div>
</div>

<!-- FILTERS -->
<div class="filters-container">
    <div class="filter-buttons">
        <a href="{{ route('user.dashboard', ['search_category' => 'lost']) }}" 
           class="filter-pill {{ $category == 'lost' ? 'active' : '' }}">
            <i class="bi bi-exclamation-triangle"></i>
            Lost
        </a>
        <a href="{{ route('user.dashboard', ['search_category' => 'found']) }}" 
           class="filter-pill {{ $category == 'found' ? 'active' : '' }}">
            <i class="bi bi-check-circle"></i>
            Found
        </a>

        <a href="{{ route('user.dashboard') }}" 
           class="filter-pill {{ $category == 'all' ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            All
        </a>
    </div>
    
    <!-- SEARCH -->
    <form method="GET" action="{{ route('user.dashboard') }}" class="search-container">
        <input type="hidden" name="search_category" value="{{ $category }}">
        <div class="search-wrapper">
            <i class="bi bi-search"></i>
            <input type="text" 
                   name="search" 
                   placeholder="Search for an item..." 
                   value="{{ request('search') }}"
                   class="search-input">
        </div>
        @if(request('search'))
            <a href="{{ route('user.dashboard', ['search_category' => $category]) }}" class="clear-btn">
                <i class="bi bi-x-lg"></i> Clear
            </a>
        @endif
    </form>
</div>

<!-- ITEMS GRID -->
<div class="items-grid">
    @forelse($items as $item)
    <div class="item-card">
        <div class="card-image">
            <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/400x300/1e3a8a/60a5fa?text=No+Image' }}" 
                 alt="{{ $item->item_name }}">
            <span class="status-badge 
                @if($item->status == 'lost') status-lost
                @elseif($item->status == 'found') status-found
                @else status-claimed
                @endif">
                @if($item->status == 'lost')
                    <i class="bi bi-exclamation-triangle"></i> Lost
                @elseif($item->status == 'found')
                    <i class="bi bi-check-circle"></i> Found
                @else
                    <i class="bi bi-trophy"></i> Claimed
                @endif
            </span>
            <div class="card-overlay"></div>
        </div>
        
        <div class="card-content">
            <h3 class="item-name">{{ $item->item_name }}</h3>
            
            <div class="item-details">
                <div class="detail-row">
                    <i class="bi bi-geo-alt"></i>
                    <span>{{ $item->description ?: 'Location not specified' }}</span>
                </div>
                <div class="detail-row">
                    <i class="bi bi-calendar3"></i>
                    <span>Reported: {{ $item->created_at ? $item->created_at->format('M d, Y H:i') : 'N/A' }} by {{ $item->reporter_name ?? 'N/A' }}</span>
                </div>
                @if($item->claimer)
                <div class="detail-row">
                    <i class="bi bi-person-check"></i>
                    <span>Claimed: {{ $item->claim_date ? $item->claim_date->format('M d, Y H:i') : 'N/A' }} by {{ $item->claimer->username ?? $item->claimer->name }}</span>
                </div>
                @endif
                @if($item->date_found)
                <div class="detail-row">
                    <i class="bi bi-clock"></i>
                    <span>Found on: {{ $item->date_found->format('M d, Y H:i') }}</span>
                </div>
                @endif
                <div class="detail-row status-row">
                    <span class="status-label">Status:</span>
                    <span class="status-value 
                        @if($item->status == 'claimed') status-processing-claimed
                        @elseif($item->status == 'found') status-processing
                        @else status-lost-text
                        @endif">
                        @if($item->status == 'claimed')
                            <i class="bi bi-check2-all"></i> Claimed
                        @elseif($item->status == 'found')
                            <i class="bi bi-hourglass-split"></i> Processing
                        @else
                            <i class="bi bi-exclamation-circle"></i> Unclaimed
                        @endif
                    </span>
                </div>
            </div>

            @if($item->status == 'lost')
            <button class="claim-btn" onclick="openClaimModal('{{ $item->id }}', '{{ $item->item_name }}')">
                <i class="bi bi-hand-thumbs-up"></i> Claim This Item
            </button>
            @endif
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-icon">
            <i class="bi bi-inbox"></i>
        </div>
        <h3>No items found</h3>
        <p>There are no items matching your criteria. Try adjusting your filters or search terms.</p>
    </div>
    @endforelse
</div>

<!-- CLAIM MODAL -->
<div id="claimModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-content">
        <button class="modal-close" onclick="closeClaimModal()" aria-label="Close modal">
            <i class="bi bi-x-lg"></i>
        </button>
        
        <div class="modal-header">
            <div class="modal-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <h3 id="modal-title">Confirm Your Claim</h3>
        </div>
        
        <div class="modal-body">
            <p class="modal-text">Are you sure you want to claim this item? Please verify the details match your lost item.</p>
            <div class="item-highlight" id="claimItemNameContainer" role="status" aria-live="polite"></div>
        </div>

        <form method="POST" action="{{ route('user.claim') }}" class="modal-form" id="claimForm" novalidate>
            @csrf
            <input type="hidden" name="item_id" id="claimItemId">
            
            <div class="confirmation-section">
                <label class="checkbox-container" for="confirmCheckbox">
                    <input type="checkbox" name="confirm" id="confirmCheckbox" required aria-required="true">
                    <span class="checkmark"></span>
                    <span class="checkbox-text">✓ I confirm this is my item and all details are correct</span>
                </label>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeClaimModal()" aria-label="Cancel claim">
                    Cancel
                </button>
                <button type="submit" class="btn-submit" id="submitBtn" disabled>
                    <span class="btn-text">Submit Claim</span>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="visually-hidden">Submitting...</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
/* PAGE HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    flex-wrap: wrap;
    gap: 20px;
}

.header-content h1 {
    font-size: 36px;
    font-weight: 800;
    color: #1a1a2e;
    letter-spacing: -1px;
    margin-bottom: 8px;
}

.header-subtitle {
    font-size: 15px;
    color: #6b7280;
    font-weight: 400;
}

.header-stats {
    display: flex;
    gap: 12px;
}

.stat-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: rgba(132, 94, 194, 0.1);
    border: 1px solid rgba(132, 94, 194, 0.2);
    border-radius: 50px;
    color: #845ec2;
    font-size: 14px;
    font-weight: 600;
}

.stat-pill i {
    font-size: 16px;
}

/* FILTERS */
.filters-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid rgba(132, 94, 194, 0.08);
}

.filter-buttons {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.filter-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    background: rgba(255, 255, 255, 0.8);
    color: #6b7280;
    border: 1px solid rgba(132, 94, 194, 0.1);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
}

.filter-pill i {
    font-size: 14px;
}

.filter-pill:hover {
    background: rgba(132, 94, 194, 0.08);
    color: #845ec2;
    border-color: rgba(132, 94, 194, 0.2);
}

.filter-pill.active {
    background: linear-gradient(135deg, #845ec2 0%, #9b59b6 100%);
    color: #ffffff;
    border-color: transparent;
    box-shadow: 0 4px 20px rgba(132, 94, 194, 0.4);
}

/* SEARCH */
.search-container {
    display: flex;
    align-items: center;
    gap: 12px;
}

.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-wrapper i {
    position: absolute;
    left: 16px;
    color: #9ca3af;
    font-size: 16px;
}

.search-input {
    width: 340px;
    padding: 14px 20px 14px 48px;
    border: 2px solid rgba(132, 94, 194, 0.1);
    border-radius: 14px;
    font-size: 14px;
    color: #1a1a2e;
    background: rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
}

.search-input:focus {
    outline: none;
    border-color: #845ec2;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(132, 94, 194, 0.15);
}

.search-input::placeholder {
    color: #9ca3af;
}

.clear-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 12px 18px;
    background: rgba(255, 107, 107, 0.1);
    color: #ff6b6b;
    border-radius: 12px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 107, 107, 0.2);
}

.clear-btn:hover {
    background: rgba(255, 107, 107, 0.2);
    transform: translateY(-2px);
}

/* ITEMS GRID */
.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 28px;
}

.item-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(132, 94, 194, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
}

.item-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #845ec2, #ff6b6b);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.item-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(132, 94, 194, 0.15);
    border-color: rgba(132, 94, 194, 0.2);
}

.item-card:hover::before {
    opacity: 1;
}

.card-image {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.item-card:hover .card-image img {
    transform: scale(1.1);
}

.card-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 80px;
    background: linear-gradient(to top, rgba(255, 255, 255, 0.95), transparent);
    pointer-events: none;
}

.status-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 6px;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid;
}

.status-badge i {
    font-size: 12px;
}

/* Status Colors - Clean & Unique */
.status-found {
    background: rgba(78, 205, 196, 0.2);
    color: #4ecdc4;
    border-color: rgba(78, 205, 196, 0.3);
}

.status-lost {
    background: rgba(255, 217, 61, 0.25);
    color: #e6b800;
    border-color: rgba(255, 217, 61, 0.4);
}

.status-claimed {
    background: rgba(132, 94, 194, 0.2);
    color: #845ec2;
    border-color: rgba(132, 94, 194, 0.3);
    box-shadow: 0 0 20px rgba(132, 94, 194, 0.2);
}

/* CARD CONTENT */
.card-content {
    padding: 24px;
}

.item-name {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 18px;
    line-height: 1.3;
    letter-spacing: -0.3px;
}

.item-details {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.detail-row {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 13px;
    color: #6b7280;
    word-break: break-word;
}

.detail-row i {
    color: #9ca3af;
    margin-top: 2px;
    font-size: 14px;
}

.status-row {
    margin-top: 8px;
    padding-top: 14px;
    border-top: 1px solid rgba(132, 94, 194, 0.06);
}

.status-label {
    font-weight: 500;
    color: #9ca3af;
    font-size: 12px;
}

.status-value {
    font-weight: 600;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.status-value i {
    font-size: 14px;
}

.status-processing {
    color: #ff6b6b;
}

.status-processing-claimed {
    color: #845ec2;
}

.status-lost-text {
    color: #e6b800;
}

/* CLAIM BUTTON */
.claim-btn {
    width: 100%;
    margin-top: 20px;
    padding: 14px 24px;
    background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
}

.claim-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.claim-btn:hover {
    background: linear-gradient(135deg, #ff7d7d 0%, #ff6b6b 100%);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(255, 107, 107, 0.4);
}

.claim-btn:hover::before {
    left: 100%;
}

.claim-btn i {
    font-size: 16px;
}

/* EMPTY STATE */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
}

.empty-icon {
    width: 120px;
    height: 120px;
    background: rgba(132, 94, 194, 0.05);
    border: 2px dashed rgba(132, 94, 194, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
}

.empty-icon i {
    font-size: 48px;
    color: #9ca3af;
}

.empty-state h3 {
    font-size: 22px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 10px;
}

.empty-state p {
    font-size: 15px;
    color: #9ca3af;
    max-width: 400px;
    margin: 0 auto;
}

/* MODAL */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(26, 26, 46, 0.75);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    justify-content: center;
    align-items: center;
    padding: 20px;
    box-sizing: border-box;
    z-index: 9999;
    animation: modalFadeIn 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

@keyframes modalFadeIn {
    from { 
        opacity: 0;
        backdrop-filter: blur(0px);
    }
    to { 
        opacity: 1;
        backdrop-filter: blur(12px);
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.modal-content {
    background: linear-gradient(145deg, #ffffff 0%, #fefefe 50%, #faf9f6 100%);
    margin: auto;
    padding: 2.5rem;
    border-radius: 28px;
    width: 100%;
    max-width: 480px;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    transform: translate(0, 0);
    animation: modalSlideUp 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    border: 1px solid rgba(132, 94, 194, 0.12);
    box-shadow: 
        0 35px 100px rgba(0, 0, 0, 0.25),
        0 15px 35px rgba(0, 0, 0, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 0.9);
}

@keyframes modalSlideUp {
    from { 
        opacity: 0;
        transform: translateY(50px) scale(0.95);
    }
    to { 
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@media (max-width: 480px) {
    .modal-content {
        margin: 10px;
        padding: 2rem;
        border-radius: 20px;
        max-height: 95vh;
    }
}

@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.modal-close {
    position: absolute;
    top: 1.125rem;
    right: 1.125rem;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    border: 1px solid rgba(132, 94, 194, 0.15);
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    font-size: 1.25rem;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.modal-close:hover {
    background: rgba(255, 255, 255, 1);
    color: #ff6b6b;
    border-color: rgba(255, 107, 107, 0.3);
    transform: scale(1.05) rotate(90deg);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.2);
}

.modal-close:focus {
    outline: 2px solid #845ec2;
    outline-offset: 2px;
}

.modal-header {
    text-align: center;
    margin: 0 0 2rem 0;
}

.modal-header h3 {
    font-size: 1.75rem;
    font-weight: 800;
    background: linear-gradient(135deg, #1a1a2e 0%, #845ec2 50%, #ff6b6b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.02em;
    margin-bottom: 0.5rem;
}

.modal-icon {
    width: 5rem;
    height: 5rem;
    background: linear-gradient(135deg, rgba(132, 94, 194, 0.2) 0%, rgba(255, 107, 107, 0.2) 50%, rgba(78, 205, 196, 0.2) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    box-shadow: 0 10px 30px rgba(132, 94, 194, 0.15);
    animation: iconPulse 2s infinite;
}

@keyframes iconPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.modal-icon i {
    font-size: 2.25rem;
    background: linear-gradient(135deg, #845ec2, #ff6b6b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    filter: drop-shadow(0 2px 4px rgba(132, 94, 194, 0.3));
}

.modal-header h3 {
    font-size: 26px;
    font-weight: 700;
    color: #1a1a2e;
    letter-spacing: -0.5px;
}

.modal-text {
    text-align: center;
    color: #6b7280;
    font-size: 15px;
    margin-bottom: 8px;
}

.modal-item-name {
    text-align: center;
    font-size: 18px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 30px;
    padding: 12px;
    background: rgba(132, 94, 194, 0.05);
    border-radius: 10px;
}

.modal-form {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.checkbox-container {
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: 15px;
    color: #6b7280;
    cursor: pointer;
    padding: 12px;
    background: rgba(132, 94, 194, 0.03);
    border-radius: 10px;
    transition: all 0.2s ease;
}

.checkbox-container:hover {
    background: rgba(132, 94, 194, 0.08);
}

.checkbox-container input {
    width: 20px;
    height: 20px;
    accent-color: #845ec2;
    cursor: pointer;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid rgba(132, 94, 194, 0.2);
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-actions {
    display: flex;
    gap: 14px;
}

.btn-cancel {
    flex: 1;
    padding: 14px;
    background: rgba(132, 94, 194, 0.08);
    border: 1px solid rgba(132, 94, 194, 0.1);
    border-radius: 14px;
    font-size: 15px;
    font-weight: 600;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-cancel:hover {
    background: rgba(132, 94, 194, 0.15);
    color: #845ec2;
}

.btn-submit {
    flex: 1;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, #845ec2 0%, #9b59b6 100%);
    border: none;
    border-radius: 16px;
    font-size: 0.95rem;
    font-weight: 700;
    color: white !important;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 6px 20px rgba(132, 94, 194, 0.3);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    min-height: 52px;
}

.btn-submit:not(:disabled):hover {
    background: linear-gradient(135deg, #9b6bc4 0%, #a66bbe 100%);
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(132, 94, 194, 0.4);
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
    background: rgba(132, 94, 194, 0.4);
    box-shadow: 0 4px 12px rgba(132, 94, 194, 0.2);
}

.spinner-border {
    width: 1rem;
    height: 1rem;
}

.visually-hidden {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

body.modal-open {
    overflow: hidden;
}

/* RESPONSIVE */
@media (max-width: 1024px) {
    .items-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }
}

@media (max-width: 768px) {
    .filters-container {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-buttons {
        justify-content: center;
    }
    
    .search-container {
        flex-direction: column;
        width: 100%;
    }
    
    .search-wrapper {
        width: 100%;
    }
    
    .search-input {
        width: 100%;
    }
    
    .items-grid {
        grid-template-columns: 1fr;
    }
    
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .header-content h1 {
        font-size: 28px;
    }
    
    .modal-content {
        padding: 30px;
        margin: 20px;
    }
}
</style>
@endsection

@section('scripts')
<script>
(function() {
    'use strict';

    let modal = null;
    let claimForm = null;
    let confirmCheckbox = null;
    let submitBtn = null;
    let firstFocusable = null;
    let lastFocusable = null;

    function initModal() {
        modal = document.getElementById('claimModal');
        claimForm = document.getElementById('claimForm');
        confirmCheckbox = document.getElementById('confirmCheckbox');
        submitBtn = document.getElementById('submitBtn');

        if (modal && confirmCheckbox && submitBtn) {
            confirmCheckbox.addEventListener('change', toggleSubmitButton);
            claimForm.addEventListener('submit', handleSubmit);
        }
    }

    window.openClaimModal = function(id, name) {
        document.getElementById('claimItemId').value = id;
        document.querySelector('.item-highlight').textContent = `Item: ${name}`;
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        document.body.style.overflow = 'hidden';
        
        // Reset form
        confirmCheckbox.checked = false;
        toggleSubmitButton();
        
        // Focus management
        setTimeout(() => {
            firstFocusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (firstFocusable) firstFocusable.focus();
            trapFocus(modal);
        }, 100);
    };

    window.closeClaimModal = function() {
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        claimForm.reset();
        toggleSubmitButton();
    };

    function toggleSubmitButton() {
        submitBtn.disabled = !confirmCheckbox.checked;
        submitBtn.classList.toggle('btn-disabled', !confirmCheckbox.checked);
    }

    function handleSubmit(e) {
        if (!confirmCheckbox.checked) {
            e.preventDefault();
            return;
        }

        // Show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Submitting...
        `;
    }

    function trapFocus(element) {
        const focusableElements = element.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        firstFocusable = focusableElements[0];
        lastFocusable = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        e.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        e.preventDefault();
                        firstFocusable.focus();
                    }
                }
            }
        });
    }

    // Close on overlay click
    window.onclick = function(e) {
        if (e.target === modal) closeClaimModal();
    };

    // ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeClaimModal();
    });

    // Initialize when DOM loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initModal);
    } else {
        initModal();
    }
})();
</script>
@endsection
