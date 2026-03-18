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
            <img src="{{ $item->image ? asset('storage/' . urlencode($item->image)) : 'https://placehold.co/400x300/1e3a8a/ffffff?text=' . urlencode($item->item_name) }}" 
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
[Full styles unchanged - omitted for brevity]
</style>
@endsection

@section('scripts')
[Full scripts unchanged]
</script>
@endsection

