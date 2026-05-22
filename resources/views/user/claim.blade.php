@extends('layouts.user')

@section('title', 'Claim Found Items - CHMSU Lost & Found Management System')

@section('content')

<!-- ENHANCED PAGE HEADER -->
<div class="claim-page-top-spacer"></div>
<div class="claim-header-card">

    <div class="claim-header-content">
        <div class="claim-header-icon">
            <i class="bi bi-hand-thumbs-up-fill"></i>
        </div>

        <div class="claim-header-text">
            <h4 class="claim-header-title">Found Items Ready to Claim</h4>
            <p class="claim-header-subtitle">
                Browse all recovered items and submit a claim request securely.
            </p>
        </div>
    </div>
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

                    <td style="width: 80px;">
                        <img 
                            src="{{ $item->image ? asset('storage/' . $item->image . '?v=' . $item->updated_at) : 'https://via.placeholder.com/70x60/dcfce7/16a34a?text=' . substr($item->item_name, 0, 12) }}"
                            alt="{{ $item->item_name }}"
                            data-item-id="{{ $item->id }}"
                            data-item-name="{{ $item->item_name }}"
                            style="width: 70px; height: 60px; object-fit: cover; border-radius: 6px;"
                        >
                    </td>

                    <td class="fw-semibold">{{ $item->item_name }}</td>

                    <td class="text-muted small">
                        {{ Str::limit($item->description, 80) }}
                    </td>

                    <td>
                        <span class="badge bg-success">{{ $item->category }}</span>
                    </td>

                    <td>
                        {{ $item->date_found ? \Carbon\Carbon::parse($item->date_found)->format('M d, Y') : 'N/A' }}
                    </td>

                    <td>
                        {{ $item->reporter_name ?? 'Anonymous' }}
                    </td>

                    <td>
                        <button 
                            class="btn btn-success btn-sm claim-btn action-icon-btn"
                            data-item-id="{{ $item->id }}"
                            data-item-name="{{ $item->item_name }}"
                            title="Claim this item"
                        >
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
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-slide">
        <div class="modal-content shadow rounded-4 border-0 p-2" style="padding: 0.5rem 0.5rem 0 0.5rem;">
            <form id="claimForm" method="POST" action="{{ route('user.claim') }}" autocomplete="off">
                @csrf
                <!-- MODAL HEADER -->
                <div class="modal-header border-0 pb-2 pt-3 px-3" style="background: none;">
                    <h6 class="modal-title d-flex align-items-center gap-2 fw-semibold" id="claimModalLabel">
                        <i class="bi bi-hand-thumbs-up-fill text-success"></i> Claim Item
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- MODAL BODY -->
                <div class="modal-body pt-2 pb-0 px-3">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img id="modalItemImage" src="https://via.placeholder.com/80x80/16a34a/ffffff?text=ITEM" alt="Item" style="width: 64px; height: 64px; object-fit: cover; border-radius: 10px; border: 1.5px solid #16a34a; box-shadow: 0 2px 8px rgba(22,163,74,0.08);">
                        <div>
                            <div id="modalItemName" class="fw-bold text-success small mb-1"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label mb-1">Email Address</label>
                        <input type="email" class="form-control rounded-lg border-1 shadow-none px-3 py-2" id="contact" name="contact" required maxlength="255" placeholder="Enter your email">
                        <div class="invalid-feedback d-none" id="emailError">This field is required and must be a valid email address.</div>
                        @error('contact')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="proof" class="form-label mb-1">Proof of Ownership</label>
                        <textarea class="form-control rounded-lg border-1 shadow-none px-3 py-2" id="proof" name="proof" rows="3" required minlength="30" maxlength="1000" placeholder="Describe unique details only the owner would know."></textarea>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <div class="form-text">Minimum 30 characters.</div>
                            <div class="form-text" id="proofCount">0/30</div>
                        </div>
                        <div class="invalid-feedback d-none" id="proofError">This field is required and must be at least 30 characters.</div>
                        @error('proof')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check mb-2 mt-3">
                        <input class="form-check-input" type="checkbox" id="confirm" name="confirm" required>
                        <label class="form-check-label" for="confirm">
                            I confirm this item belongs to me.
                        </label>
                    </div>
                    <div class="text-danger small d-none" id="confirmError">You must check this box to proceed.</div>
                    @error('confirm')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <input type="hidden" id="item_id" name="item_id">
                </div>
                <!-- FOOTER -->
                <div class="modal-footer border-0 pt-0 pb-3 px-3 d-flex flex-column align-items-stretch gap-2">
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="submitClaimBtn" class="btn btn-success rounded-pill px-4" disabled>Submit Claim</button>
                    </div>
                    <div class="form-text text-center mt-2" style="color: #6b7280; font-size: 0.95em;">
                        Verification will be done at the CHMSU OSAS office.
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT -->
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

    const proofEl = document.getElementById('proof');
    const contactEl = document.getElementById('contact');
    const confirmCheck = document.getElementById('confirm');
    const submitBtn = document.getElementById('submitClaimBtn');

    function setInvalid(el, isInvalid) {
        if (!el) return;
        if (isInvalid) el.classList.add('is-invalid');
        else el.classList.remove('is-invalid');
    }

    function validateEmail(email) {
        return typeof email === 'string' && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim());
    }

    function validateProof(text) {
        return typeof text === 'string' && text.trim().length >= 30;
    }

    const proofMin = 30;
    function updateProofCounter() {
        const count = (proofEl?.value || '').trim().length;
        const proofCountEl = document.getElementById('proofCount');
        if (proofCountEl) proofCountEl.textContent = `${count}/${proofMin}`;
    }

    function validateForm() {
        updateProofCounter();

        const emailVal = contactEl?.value || '';
        const proofVal = proofEl?.value || '';
        const emailOk = validateEmail(emailVal);
        const proofOk = validateProof(proofVal);
        const confirmOk = !!confirmCheck?.checked;

        setInvalid(contactEl, !emailOk);
        setInvalid(proofEl, !proofOk);

        // Inline messages (client-side)
        const emailError = document.getElementById('emailError');
        if (emailError) emailError.classList.toggle('d-none', emailOk);
        const proofError = document.getElementById('proofError');
        if (proofError) proofError.classList.toggle('d-none', proofOk);

        const canSubmit = emailOk && proofOk && confirmOk;
        if (submitBtn) submitBtn.disabled = !canSubmit;

        return canSubmit;
    }

    ['input', 'change'].forEach(evt => {
        contactEl?.addEventListener(evt, validateForm);
        proofEl?.addEventListener(evt, validateForm);
        confirmCheck?.addEventListener(evt, validateForm);
    });

    // Initialize state when modal loads
    validateForm();

    claimForm.addEventListener('submit', function(e) {
        const ok = validateForm();
        if (!ok) {
            e.preventDefault();
            return false;
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

.form-control:focus,
.form-control:active {
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

/* FIX NAVBAR SPACING (match Home/Dashboard layout) */
/* The header is fixed at 70px height in layouts/user.blade.php, and main-wrapper already adds padding.
   On the Claim page, remove any extra/competing padding rules to avoid the header and content looking "stuck".
*/
.content-wrapper,
.main-content,
.container-fluid {
    padding-top: 0 !important;
}

/* Add consistent top spacing between header area and the page content */
.claim-page-top-spacer {
    height: 10px;
}


/* ENHANCED HEADER */
.claim-header-card {
    position: relative;
    overflow: hidden;
    background: var(--primary-gradient);
    border-radius: 22px;
    padding: 24px 28px;
    margin-bottom: 28px;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.15);
}

.claim-header-card::before {
    content: '';
    position: absolute;
    top: -40px;
    right: -40px;
    width: 180px;
    height: 180px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}

.claim-header-card::after {
    content: '';
    position: absolute;
    bottom: -60px;
    left: -60px;
    width: 220px;
    height: 220px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}

.claim-header-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 20px;
}

.claim-header-icon {
    width: 72px;
    height: 72px;
    min-width: 72px;
    border-radius: 20px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: inset 0 1px 2px rgba(255,255,255,0.2);
}

.claim-header-icon i {
    font-size: 32px;
    color: #fff;
}

.claim-header-title {
    margin: 0;
    color: #fff;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: -0.5px;
}

.claim-header-subtitle {
    margin: 6px 0 0;
    color: rgba(255,255,255,0.85);
    font-size: 14px;
}

/* TABLE CONTAINER */
.table-container {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    overflow: hidden;
}

/* TABLE WRAPPER */
.table-wrapper {
    max-height: 70vh;
    overflow-y: auto;
    overflow-x: hidden;
}

/* TABLE */
.custom-table {
    margin-bottom: 0;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    width: 100%;
    table-layout: auto;
}

/* HEADER */
.custom-table thead th {
    position: sticky;
    top: 0;
    z-index: 5;
    background: var(--primary-gradient);
    color: white;
    padding: 16px 10px;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
}

/* CELLS */
.custom-table td {
    padding: 14px 10px;
    vertical-align: middle !important;
    word-break: break-word;
}

/* ACTION */
.custom-table th:last-child,
.custom-table td:last-child {
    width: 130px;
    text-align: center;
    white-space: nowrap;
}

/* HOVER */
.custom-table tbody tr:hover {
    background: #f8fafc;
}

/* IMAGE */
.item-img {
    width: 70px;
    height: 60px;
    object-fit: cover;
    border-radius: 12px;
    transition: 0.3s ease;
    border: 2px solid #dcfce7;
    cursor: pointer;
}

.item-img:hover {
    transform: scale(1.08);
    border-color: #16a34a;
    box-shadow: 0 0 0 0.3rem rgba(22, 163, 74, 0.2);
}

/* BUTTON */
.claim-btn {
    padding: 6px 14px;
    font-weight: 500;
    border-radius: 8px;
    white-space: nowrap;
    transition: 0.3s ease;
}

.claim-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
}

/* ACTION BUTTONS */
.action-icon-btn {
    padding: 8px 12px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    transition: 0.3s ease;
}

/* RESPONSIVE */
@media (max-width: 992px) {

    .custom-table {
        font-size: 13px;
    }

    .custom-table td,
    .custom-table th {
        padding: 10px 6px;
    }

    .claim-header-card {
        padding: 20px;
    }

    .claim-header-content {
        gap: 14px;
    }

    .claim-header-icon {
        width: 58px;
        height: 58px;
        min-width: 58px;
        border-radius: 16px;
    }

    .claim-header-icon i {
        font-size: 24px;
    }

    .claim-header-title {
        font-size: 20px;
    }

    .claim-header-subtitle {
        font-size: 13px;
    }
}

</style>

@endsection