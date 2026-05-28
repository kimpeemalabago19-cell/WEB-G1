@extends('layouts.admin')

@section('title', 'Reported Items - CHMSU Lost & Found Management System')

@section('content')

<!-- ================= PAGE HEADER ================= -->
<div style="display:flex;align-items:center;gap:18px; margin-bottom: 25px; position: sticky; top: 0; z-index: 1000;">
    <div>
    <h5 class="m-0 d-flex align-items-center gap-2 fw-semibold text-dark">
        <i class="bi bi-list-check admin-icon text-success opacity-75"></i>
        Reported Items
    </h5>
    <small class="text-muted">Review and manage user-reported items</small>
</div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.reported') }}" style="display:flex;gap:8px;margin-left:20px;">
        <input type="text" name="search" placeholder="Search items..." value="{{ request('search') }}" class="form-control" style="width: 250px;">
        <button type="submit" class="btn btn-primary action-icon-btn" title="Search">
            <i class="bi bi-search admin-icon-sm"></i>
        </button>
        @if(request('search'))
            <a href="{{ route('admin.reported') }}" class="btn btn-secondary action-icon-btn" title="Clear">
                <i class="bi bi-x admin-icon-sm"></i>
            </a>
        @endif
    </form>

    <!-- Delete All Button -->
    <button type="button" class="btn-delete-all" data-bs-toggle="modal" data-bs-target="#deleteAllModal" title="Delete All Reported Items">
        <i class="bi bi-trash3"></i>
    </button>
</div>

<!-- ================= TABLE ================= -->
<div class="table-container">
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2">
            <i class="bi bi-check-circle admin-icon-sm text-success"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table class="table table-hover text-center align-middle custom-table">
            <thead>
                <tr>
                    <th><i class="bi bi-image admin-icon-sm"></i> Image</th>
                    <th><i class="bi bi-person admin-icon-sm"></i> Reporter</th>
                    <th><i class="bi bi-tag admin-icon-sm"></i> Item</th>
                    <th><i class="bi bi-file-text admin-icon-sm"></i> Description</th>
                    <th><i class="bi bi-grid admin-icon-sm"></i> Category</th>
                    <th><i class="bi bi-info-circle admin-icon-sm"></i> Status</th>
                    <th><i class="bi bi-calendar admin-icon-sm"></i> Date</th>
                    <th><i class="bi bi-clock admin-icon-sm"></i> Reported</th>
                    <th><i class="bi bi-gear admin-icon-sm"></i> Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>
                            <img class="item-img" src="{{ $item->image ? asset('storage/' . $item->image.'?v='.$item->updated_at) : 'https://via.placeholder.com/70x60/2563eb/ffffff?text=' . substr($item->item_name, 0, 12) }}" alt="{{ $item->item_name }}">
                        </td>
                        <td class="fw-semibold">{{ $item->reporter_name ?? 'N/A' }}</td>
                        <td class="fw-semibold">{{ $item->item_name }}</td>
                        <td class="text-muted small">{{ $item->description }}</td>
                        <td><span class="badge bg-primary">{{ $item->category }}</span></td>
                        <td>
                            @if($item->status === 'lost')
                                <span class="status-lost status-badge">
                                    <i class="bi bi-x-lg"></i> LOST
                                </span>
                            @elseif($item->status === 'found')
                                <span class="status-found status-badge">
                                    <i class="bi bi-check-lg"></i> FOUND
                                </span>
                            @else
                                <span class="status-claimed status-badge">
                                    <i class="bi bi-hand-thumbs-up"></i> PENDING
                                </span>
                            @endif
                        </td>
                        <td>{{ $item->date_found ? \Carbon\Carbon::parse($item->date_found)->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $item->created_at ? $item->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.items.edit', $item->id) }}" class="action-icon-btn btn-edit" title="Edit Item">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="action-icon-btn btn-delete" title="Delete Item" onclick="confirmDelete('{{ $item->id }}', '{{ $item->item_name }}')">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $item->id }}" action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-muted text-center py-5">
                            <i class="bi bi-list-ul fs-1 opacity-50 mb-3 d-block"></i>
                            No items reported yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Delete All Confirmation Modal -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc2626, #b91c1c); color: white; border-radius: 16px 16px 0 0;">
                <h5 class="modal-title fw-semibold" id="deleteAllModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Delete All Reported Items
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="bi bi-trash3-fill" style="font-size: 3rem; color: #dc2626; margin-bottom: 15px; display: block;"></i>
                <h5 class="fw-bold text-dark mb-2">Are you sure?</h5>
                <p class="text-muted mb-4">This will permanently delete <strong>ALL reported items</strong> from the system. This action <span class="text-danger fw-bold">cannot be undone</span>.</p>
                
                <div class="alert alert-danger d-flex align-items-start gap-2 text-start mb-3" style="border-radius: 12px;">
                    <i class="bi bi-shield-exclamation mt-1"></i>
                    <div>
                        <strong>Security Confirmation Required</strong><br>
                        Type <code class="fw-bold text-danger">DELETE</code> below to confirm this destructive action.
                    </div>
                </div>
                
                <input type="text" id="deleteAllConfirmInput" class="form-control text-center fw-bold" placeholder="Type DELETE to confirm" autocomplete="off" style="border-radius: 12px; border: 2px solid #e5e7eb; letter-spacing: 2px;">
            </div>
            <div class="modal-footer justify-content-center gap-2 pb-4 border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 12px;">Cancel</button>
                <form action="{{ route('admin.items.destroyAll') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" id="deleteAllConfirmBtn" class="btn px-4" disabled style="border-radius: 12px; background: #dc2626; color: white; font-weight: 600; opacity: 0.6; transition: all 0.3s ease;">
                        <i class="bi bi-trash3 me-1"></i> Yes, Delete All
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('styles')
<style>

/* ================= TABLE CONTAINER ================= */
.table-container {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    overflow: hidden;
}

/* ================= WRAPPER (NO HORIZONTAL SWIPE) ================= */
.table-wrapper {
    max-height: 70vh;
    overflow-y: auto;
    overflow-x: hidden; /* same as CLAIM PAGE */

    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE/Edge */
}

.table-wrapper::-webkit-scrollbar {
    display: none; /* Chrome/Safari */
}

/* ================= TABLE ================= */
.custom-table {
    margin-bottom: 0;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    width: 100%;
    table-layout: auto; /* same as CLAIM PAGE */
}

/* ================= HEADER ================= */
.custom-table thead th {
    position: sticky;
    top: 0;
    z-index: 15;
    background: var(--primary-gradient);
    color: white;
    padding: 16px 10px;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
}

/* ================= CELLS ================= */
.custom-table td {
    padding: 14px 10px;
    vertical-align: middle;
    word-break: break-word;
}

/* ================= STATUS COLUMN FIX ================= */
.custom-table th:nth-child(6),
.custom-table td:nth-child(6) {
    min-width: 110px;
    text-align: center;
    white-space: nowrap;
}

/* ================= IMAGE ================= */
.item-img {
    width: 70px;
    height: 60px;
    object-fit: cover;
    border-radius: 12px;
    transition: 0.3s ease;
    border: 3px solid #dbeafe;
}

.item-img:hover {
    transform: scale(1.08);
    border-color: #2563eb;
}

/* ================= ACTION BUTTONS ================= */
.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}

/* ================= ROW HOVER ================= */
.custom-table tbody tr:hover {
    background: #f8fafc;
}

/* ================= BADGES ================= */
.badge {
    white-space: nowrap;
}

/* ================= GLOBAL SAFETY ================= */
body {
    overflow: hidden;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .table-container {
        padding: 15px;
    }

    .custom-table td,
    .custom-table th {
        font-size: 12px;
        padding: 10px 6px;
    }
}

/* ================= DELETE ALL BUTTON ================= */
.btn-delete-all {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    background: var(--danger);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-smooth);
    cursor: pointer;
    font-size: 1em;
    margin-left: 8px;
    flex-shrink: 0;
}

.btn-delete-all:hover {
    background: #b91c1c;
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
}

.btn-delete-all:active {
    transform: scale(0.95);
}

/* ================= DELETE ALL MODAL ================= */
#deleteAllModal .form-control:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
}

#deleteAllConfirmBtn:not(:disabled) {
    opacity: 1 !important;
    background: #dc2626 !important;
}

#deleteAllConfirmBtn:not(:disabled):hover {
    background: #b91c1c !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
}

</style>
@endsection

@section('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm(`Are you sure you want to delete "${name}"? This action cannot be undone.`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}

/* ================= DELETE ALL CONFIRMATION ================= */
document.addEventListener('DOMContentLoaded', function() {
    const deleteAllInput = document.getElementById('deleteAllConfirmInput');
    const deleteAllBtn = document.getElementById('deleteAllConfirmBtn');
    
    if (deleteAllInput && deleteAllBtn) {
        deleteAllInput.addEventListener('input', function() {
            if (this.value.trim() === 'DELETE') {
                deleteAllBtn.disabled = false;
                deleteAllBtn.style.opacity = '1';
                deleteAllBtn.style.background = '#dc2626';
            } else {
                deleteAllBtn.disabled = true;
                deleteAllBtn.style.opacity = '0.6';
                deleteAllBtn.style.background = '#dc2626';
            }
        });
        
        // Reset input when modal is closed
        const deleteAllModal = document.getElementById('deleteAllModal');
        if (deleteAllModal) {
            deleteAllModal.addEventListener('hidden.bs.modal', function() {
                deleteAllInput.value = '';
                deleteAllBtn.disabled = true;
                deleteAllBtn.style.opacity = '0.6';
            });
        }
    }
});
</script>
@endsection

