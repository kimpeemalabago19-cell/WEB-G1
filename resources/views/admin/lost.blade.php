@extends('layouts.admin')

@section('title', 'Lost Items - CHMSU Lost & Found')

@section('content')

<!-- ================= PAGE HEADER ================= -->
<div style="display:flex;align-items:center;gap:18px; margin-bottom: 25px;">
   <div>
    <h5 class="m-0 d-flex align-items-center gap-2 fw-semibold">
        <i class="bi bi-exclamation-circle text-danger"></i>
        Lost Items
    </h5>
    <small class="text-muted">Track and manage lost item reports</small>
</div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.lost') }}" style="display:flex;gap:8px;margin-left:20px;">
        <input type="text" name="search" placeholder="Search lost items..." value="{{ request('search') }}" class="form-control" style="width: 250px;">
        <button type="submit" class="btn btn-primary action-icon-btn" title="Search">
            <i class="bi bi-search admin-icon-sm"></i>
        </button>
        @if(request('search'))
            <a href="{{ route('admin.lost') }}" class="btn btn-secondary action-icon-btn" title="Clear">
                <i class="bi bi-x admin-icon-sm"></i>
            </a>
        @endif
    </form>
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
                            <img class="item-img" src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/70x60/fee2e2/dc2626?text=' . substr($item->item_name, 0, 12) }}" alt="{{ $item->item_name }}">
                        </td>
                        <td class="fw-semibold">{{ $item->reporter_name ?? 'N/A' }}</td>
                        <td class="fw-semibold">{{ $item->item_name }}</td>
                        <td class="text-muted small">{{ $item->description }}</td>
                        <td><span class="badge bg-danger">{{ $item->category }}</span></td>
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
                                    <i class="bi bi-hand-thumbs-up"></i> CLAIMED
                                </span>
                            @endif
                        </td>
                        <td>{{ $item->date_found ? \Carbon\Carbon::parse($item->date_found)->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $item->created_at ? $item->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                        <td>
                            <div class="action-buttons">
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
                            <i class="bi bi-x-circle fs-1 opacity-50 mb-3 d-block"></i>
                            No lost items found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
}

/* ================= TABLE ================= */
.custom-table {
    margin-bottom: 0;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    width: 100%;
    table-layout: auto; /* IMPORTANT for clean fit */
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
    border: 2px solid #fee2e2;
}

.item-img:hover {
    transform: scale(1.08);
    border-color: #dc2626;
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
    overflow-x: hidden;
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

</style>
@endsection