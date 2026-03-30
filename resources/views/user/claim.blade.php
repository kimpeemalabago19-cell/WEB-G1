@extends('layouts.user')

@section('title', 'Claim Found Items - CHMSU Lost & Found')

@section('content')
<!-- PAGE HEADER -->
<div style="display:flex;align-items:center;gap:18px; margin-bottom: 25px;">
    <h5 class="m-0">
        <i class="bi bi-hand-thumbs-up-fill admin-icon"></i>
        Found Items Ready to Claim
    </h5>
</div>

<!-- SEARCH FORM -->
<form method="GET" action="{{ route('user.claim.get') }}" style="display:flex;gap:8px;margin-bottom:25px;max-width:500px;">
    <select name="search_category" class="form-select" style="flex:1;">
        <option value="all" {{ $search_category === 'all' ? 'selected' : '' }}>All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ $search_category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>
    <input type="text" name="search" placeholder="Search items..." value="{{ $search }}" class="form-control">
    <button type="submit" class="btn btn-primary action-icon-btn" title="Search">
        <i class="bi bi-search admin-icon-sm"></i>
    </button>
    @if($search || $search_category !== 'all')
        <a href="{{ route('user.claim.get') }}" class="btn btn-secondary action-icon-btn" title="Clear">
            <i class="bi bi-x admin-icon-sm"></i>
        </a>
    @endif
</form>

<div class="table-container">
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-check-circle admin-icon-sm text-success"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table class="table table-hover text-center align-middle custom-table">
            <thead>
                <tr>
                    <th><i class="bi bi-image admin-icon-sm"></i> Image</th>
                    <th><i class="bi bi-tag admin-icon-sm"></i> Item Name</th>
                    <th><i class="bi bi-file-text admin-icon-sm"></i> Description</th>
                    <th><i class="bi bi-grid admin-icon-sm"></i> Category</th>
                    <th><i class="bi bi-calendar-check admin-icon-sm"></i> Date Found</th>
                    <th><i class="bi bi-geo-alt admin-icon-sm"></i> Reporter</th>
                    <th><i class="bi bi-hand-thumbs-up admin-icon-sm"></i> Claim</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>
                        <img class="item-img" src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/70x60/dcfce7/16a34a?text=' . substr($item->item_name, 0, 12) }}" alt="{{ $item->item_name }}" data-item-id="{{ $item->id }}" data-item-name="{{ $item->item_name }}">
                    </td>
                    <td class="fw-semibold">{{ $item->item_name }}</td>
                    <td class="text-muted small">{{ Str::limit($item->description, 80) }}</td>
                    <td><span class="badge bg-success">{{ $item->category }}</span></td>
                    <td>{{ $item->date_found ? \Carbon\Carbon::parse($item->date_found)->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $item->reporter_name ?? 'Anonymous' }}</td>
                    <td>
                        <button class="btn btn-success btn-sm claim-btn action-icon-btn" data-item-id="{{ $item->id }}" data-item-name="{{ $item->item_name }}" title="Claim this item">
                            <i class="bi bi-hand-thumbs-up"></i> Claim
                        </button>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted text-center py-5">
                            <i class="bi bi-search-heart fs-1 opacity-50 mb-3 d-block"></i>
                            <h6>No found items available for claiming yet.</h6>
                            <p class="mb-0">Check back later or report your lost item.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- CLAIM MODAL -->
<div class="modal fade" id="claimModal" tabindex="-1" aria-labelledby="claimModalLabel" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-slide">
        <div class="modal-content shadow-sm rounded-4 border-0">

            <form id="claimForm" method="POST" action="{{ route('user.claim') }}">
                @csrf

                <!-- MODAL HEADER -->
                <div class="modal-header bg-success text-white rounded-top px-4 py-3">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="claimModalLabel">
                        <i class="bi bi-hand-thumbs-up-fill"></i> Claim Item
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- MODAL BODY -->
                <div class="modal-body px-4 py-3">
                    <div class="row g-4 align-items-center">

                        <!-- LEFT: ITEM IMAGE -->
                        <div class="col-md-4 text-center">
                            <img id="modalItemImage" src="https://via.placeholder.com/180x140/16a34a/ffffff?text=ITEM" alt="Item" class="img-fluid rounded shadow-sm border border-success">
                        </div>

                        <!-- RIGHT: FORM FIELDS -->
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Item Name:</label>
                                <h6 id="modalItemName" class="text-success"></h6>
                            </div>

                            <div class="mb-3">
                                <label for="contact" class="form-label fw-semibold">Contact Number / Email <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control form-control-sm shadow-sm" id="contact" name="contact" required maxlength="255" placeholder="Enter your contact">
                            </div>

                            <div class="mb-3">
                                <label for="proof" class="form-label fw-semibold">Proof of Ownership (optional)</label>
                                <textarea class="form-control form-control-sm shadow-sm" id="proof" name="proof" rows="3" placeholder="Describe how you can prove this is yours..."></textarea>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="confirm" name="confirm" required>
                                <label class="form-check-label fw-semibold" for="confirm">
                                    I confirm this is my belonging and I will proceed to CHMSU OSAS office to claim it personally.
                                </label>
                            </div>

                            <div class="alert alert-info d-flex align-items-center mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                <div>
                                    After confirmation, please proceed to CHMSU OSAS office to claim your item personally.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL FOOTER -->
                <div class="modal-footer border-top-0 px-4 py-3">
                    <input type="hidden" id="item_id" name="item_id">
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm rounded-pill">
                        <i class="bi bi-check-lg me-1"></i> Submit Claim
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- SCRIPT: Populate modal dynamically -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const claimModalEl = document.getElementById('claimModal');
    const claimModal = new bootstrap.Modal(claimModalEl, { backdrop: false });
    const claimForm = document.getElementById('claimForm');
    const claimButtons = document.querySelectorAll('.claim-btn');
    const itemIdInput = document.getElementById('item_id');
    const itemNameSpan = document.getElementById('modalItemName');
    const modalLabel = document.getElementById('claimModalLabel');
    const modalImage = document.getElementById('modalItemImage');

    claimButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const itemName = this.dataset.itemName;
            const itemImg = this.dataset.itemImage || this.closest('tr').querySelector('img').src;

            itemIdInput.value = itemId;
            itemNameSpan.textContent = itemName;
            modalLabel.textContent = `Claim "${itemName}"`;
            modalImage.src = itemImg;

            claimModal.show();
        });
    });

    claimForm.addEventListener('submit', function(e) {
        const confirmCheck = document.getElementById('confirm');
        if (!confirmCheck.checked) {
            e.preventDefault();
            alert('Please confirm this is your belonging before submitting.');
        }
    });
});
</script>

<style>
/* MODAL ANIMATION */
.modal-dialog-slide {
    transform: translateY(-50px);
    transition: transform 0.4s ease, opacity 0.4s ease;
}
.modal.show .modal-dialog-slide {
    transform: translateY(0);
    opacity: 1;
}

.modal-content {
    border-radius: 16px;
    transition: all 0.3s ease;
}

.modal-body img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    border: 2px solid #16a34a;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.modal-body img:hover {
    transform: scale(1.06);
    box-shadow: 0 8px 25px rgba(22, 163, 74, 0.25);
}

.form-control:focus, .form-control:active {
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
    border-color: #2563eb;
    transition: all 0.3s ease;
}

.btn-success {
    transition: all 0.3s ease;
}
.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);
}
</style>

@endsection

@section('styles')
<style>
/* TABLE STYLES */
.table-container {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}

.table-wrapper {
    max-height: 70vh;
    overflow-y: auto;
}

.custom-table {
    margin-bottom: 0;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    overflow: hidden;
    width: 100%;
    min-width: 850px;
}

.custom-table thead th {
    position: sticky;
    top: 0;
    z-index: 15;
    background: var(--primary-gradient);
    color: white;
    padding: 18px 12px;
    font-size: 14px;
    font-weight: 600;
}

.custom-table td {
    padding: 16px 12px;
    vertical-align: middle;
}

.custom-table tbody tr:hover {
    background: #f8fafc;
}

.item-img {
    width: 70px;
    height: 60px;
    object-fit: cover;
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 2px solid #dcfce7;
    cursor: pointer;
}

.item-img:hover {
    transform: scale(1.12);
    border-color: #16a34a;
    box-shadow: 0 0 0 0.3rem rgba(22, 163, 74, 0.2);
}

.claim-btn {
    padding: 8px 16px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.claim-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
}

.action-icon-btn {
    padding: 8px 12px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    transition: all 0.3s ease;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.modal-content {
    border-radius: 16px;
}

#proof {
    min-height: 100px;
}

.alert {
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .table-container { padding: 15px; }
    .custom-table { min-width: 100%; font-size: 12px; }
    .custom-table thead th, .custom-table td { padding: 12px 8px; }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const claimModalEl = document.getElementById('claimModal');
    const claimModal = new bootstrap.Modal(claimModalEl, { backdrop: false });
    const claimForm = document.getElementById('claimForm');
    const claimButtons = document.querySelectorAll('.claim-btn');
    const itemIdInput = document.getElementById('item_id');
    const itemNameSpan = document.getElementById('modalItemName');
    const modalLabel = document.getElementById('claimModalLabel');

    claimButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const itemName = this.dataset.itemName;

            itemIdInput.value = itemId;
            itemNameSpan.textContent = itemName;
            modalLabel.textContent = `Claim "${itemName}"`;

            claimModal.show();
        });
    });

    claimForm.addEventListener('submit', function(e) {
        const confirmCheck = document.getElementById('confirm');
        if (!confirmCheck.checked) {
            e.preventDefault();
            alert('Please confirm this is your belonging before submitting.');
        }
    });
});
</script>
@endsection