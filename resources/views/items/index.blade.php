
@extends('layouts.main')

@push('styles')
<style>
    .page-header {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 30px 15px;
        margin-bottom: 20px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    
    .page-header h1 { font-size: 32px; color: #1e293b; margin-bottom: 10px; }
    .page-header p { color: #64748b; font-size: 15px; max-width: 600px; line-height: 1.4; }
    
    .items-grid {
        width: 95%;
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 25px;
        padding-bottom: 80px;
    }
    
    .item-card {
        background: white;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    
    .item-card:hover {
        box-shadow: 0 12px 25px rgba(0,0,0,0.1);
        transform: translateY(-6px) scale(1.02);
    }
    
    .card-header {
        font-size: 11px;
        padding: 8px;
        text-align: center;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .card-header.lost { background: #fee2e2; color: #b91c1c; }
    .card-header.found { background: #dcfce7; color: #166534; }
    .card-header.claimed { background: #fef3c7; color: #b45309; }
    
    .card-img {
        width: 100%;
        height: 190px;
        object-fit: cover;
        transition: 0.4s;
    }
    
    .item-card:hover .card-img { transform: scale(1.08); }
    
    .card-body {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .card-body h3 { font-size: 15px; margin-bottom: 8px; font-weight: 600; }
    .card-body p { font-size: 13px; color: #64748b; margin-bottom: 14px; line-height: 1.5; min-height: 50px; }
    .card-footer { font-size: 11px; color: #94a3b8; margin-top: auto; }
    
    .claim-btn {
        background: #3b82f6;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
        margin-top: 10px;
    }
    
    .claim-btn:hover { background: #2563eb; }
    
    .empty-state {
        text-align: center;
        padding: 70px;
        color: #64748b;
        font-size: 15px;
        grid-column: 1 / -1;
    }
    
    .modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        justify-content: center;
        align-items: center;
    }
    
    .modal-content {
        background: white;
        width: 90%;
        max-width: 500px;
        border-radius: 15px;
        overflow: hidden;
        animation: zoomIn 0.3s ease;
        position: relative;
    }
    
    .modal-body { padding: 20px; }
    .close-btn { position: absolute; top: 15px; right: 20px; font-size: 28px; color: #1e293b; cursor: pointer; }
    
    .confirm-btn {
        background: #10b981;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 15px;
        transition: 0.3s;
    }
    
    .confirm-btn:hover { background: #059669; }
    
    @keyframes zoomIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    
    @media (max-width: 768px) {
        .items-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 18px; }
        .card-img { height: 150px; }
    }
</style>
@endpush

@section('content')
<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success" style="max-width: 1200px; margin: 20px auto; padding: 15px; border-radius: 10px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" style="max-width: 1200px; margin: 20px auto; padding: 15px; border-radius: 10px;">
        {{ session('error') }}
    </div>
@endif

<!-- Page Header -->
<div class="page-header">
    @if(request('category') == 'all' || !request('category'))
        <h1>Welcome back, {{ Auth::user()->name }}!</h1>
        <p>Quickly report, search, and claim lost items using our system. You can also view found items and your claimed items here.</p>
    @else
        <h1>
            @if(request('category') == 'lost') Lost Items
            @elseif(request('category') == 'found') Found Items
            @elseif(request('category') == 'claimed') Claimed Items
            @endif
        </h1>
    @endif
</div>

<!-- Items Grid -->
@if(request('category') != 'all' && !request('category'))
<div class="items-grid">
    @forelse($items as $item)
        <div class="item-card">
            <div class="card-header 
                @if($item->status == 'lost') lost 
                @elseif($item->status == 'found') found 
                @elseif($item->status == 'claimed' || $item->claimed_by) claimed 
                @endif">
                @if($item->status == 'lost') LOST
                @elseif($item->status == 'found') FOUND
                @elseif($item->claimed_by) CLAIMED
                @endif
            </div>
            
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="card-img" alt="{{ $item->item_name }}">
            @else
                <img src="https://via.placeholder.com/400x300?text=No+Image" class="card-img" alt="No Image">
            @endif
            
            <div class="card-body">
                <div>
                    <h3>{{ $item->item_name }}</h3>
                    <p>{{ $item->description }}</p>
                </div>
                <div class="card-footer">
                    Reported: {{ $item->created_at->format('M d, Y') }}
                    @if($item->claimed_by)
                        <br>Claimed on: {{ $item->claim_date ? \Carbon\Carbon::parse($item->claim_date)->format('M d, Y') : 'N/A' }}
                    @endif
                </div>
                @if($item->status == 'lost')
                    <button class="claim-btn" onclick="openClaimModal('{{ $item->id }}', '{{ $item->item_name }}')">Claim</button>
                @endif
            </div>
        </div>
    @empty
        <div class="empty-state">No items available.</div>
    @endforelse
</div>

<!-- Pagination -->
@if($items->hasPages())
    <div style="display: flex; justify-content: center; padding-bottom: 40px;">
        {{ $items->appends(request()->query())->links() }}
    </div>
@endif

<!-- Claim Modal -->
<div class="modal" id="claimModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeClaimModal()">&times;</span>
        <div class="modal-body">
            <h2>Confirm Claim</h2>
            <p id="claimItemName" style="font-weight: 600; margin-bottom: 10px;"></p>
            <form id="claimForm" method="POST">
                @csrf
                <input type="hidden" name="item_id" id="claimItemId">
                <label>
                    <input type="checkbox" name="confirm" required> 
                    I confirm this is my item and I will claim it at OSAS.
                </label>
                <br>
                <button type="submit" class="confirm-btn">Submit Claim</button>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
function openClaimModal(itemId, itemName) {
    document.getElementById("claimModal").style.display = "flex";
    document.getElementById("claimItemId").value = itemId;
    document.getElementById("claimItemName").innerText = itemName;
    
    // Set the form action
    document.getElementById("claimForm").action = "/items/" + itemId + "/claim";
}

function closeClaimModal() {
    document.getElementById("claimModal").style.display = "none";
}

window.onclick = function(event) {
    const modal = document.getElementById("claimModal");
    if (event.target == modal) {
        closeClaimModal();
    }
}
</script>
@endpush

