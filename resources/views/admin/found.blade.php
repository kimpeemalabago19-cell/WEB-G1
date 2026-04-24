@extends('layouts.admin')

@section('title', 'Found Items - CHMSU Lost & Found')

@section('content')

<!-- PAGE HEADER -->
<div style="display:flex;align-items:center;gap:18px; margin-bottom: 25px; position: sticky; top: 0; z-index: 1000;">
    <div>
    <h5 class="m-0 d-flex align-items-center gap-2 fw-semibold">
        <i class="bi bi-search text-success"></i>
        Found Items
    </h5>
    <small class="text-muted">Review and verify found items</small>
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
</div>

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
                    <th><i class="bi bi-person admin-icon-sm"></i> Reporter</th>
                    <th><i class="bi bi-tag admin-icon-sm"></i> Item
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
                        <img class="item-img" src="{{ $item->image ? asset('storage/' . $item->image.'?v='.$item->updated_at) : 'https://via.placeholder.com/70x60/dcfce7/16a34a?text=' . substr($item->item_name, 0, 12) }}" alt="{{ $item->item_name }}">
                        </td>
                        <td class="fw-semibold">{{ $item->reporter_name ?? 'N/A' }}</td>
                        <td class="fw-semibold">{{ $item->item_name }}</td>

                    <td class="text-muted small">{{ $item->description }}</td>
                    <td><span class="badge bg-success">{{ $item->category }}</span></td>
                    <td>
                        <span class="status-found status-badge">
                            <i class="bi bi-check-lg"></i> {{ strtoupper($item->status) }}
                        </span>
                    </td>
                    <td>{{ $item->date_found ? \Carbon\Carbon::parse($item->date_found)->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $item->created_at ? $item->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                    <td>
                        <div class="action-buttons">
                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-icon-btn btn-delete" title="Delete Item" onclick="return confirm('Are you sure you want to delete this found item?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-muted text-center py-5">

                            <i class="bi bi-search fs-1 opacity-50 mb-3 d-block"></i>
                            No found items yet.
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

/* ================= WRAPPER ================= */
.table-wrapper {
    max-height: 70vh;
    overflow-y: auto;
    overflow-x: hidden; /* SAME AS CLAIM PAGE */

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
    table-layout: auto; /* IMPORTANT FIX */
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

/* ================= IMAGE ================= */
.item-img {
    width: 70px;
    height: 60px;
    object-fit: cover;
    border-radius: 12px;
    transition: 0.3s ease;
    border: 2px solid #dcfce7;
}

.item-img:hover {
    transform: scale(1.08);
    border-color: #16a34a;
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

</style>
@endsection