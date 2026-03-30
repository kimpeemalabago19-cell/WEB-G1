@extends('layouts.admin')

@section('title', 'Found Items - CHMSU Lost & Found')

@section('content')

<!-- PAGE HEADER -->
<div style="display:flex;align-items:center;gap:18px; margin-bottom: 25px;">
    <h5 class="m-0">
        <i class="bi bi-search admin-icon"></i>
        Found Items
    </h5>
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
                        <img class="item-img" src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/70x60/dcfce7/16a34a?text=' . substr($item->item_name, 0, 12) }}" alt="{{ $item->item_name }}">
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
                    <td>{{ $item->date_found ?? 'N/A' }}</td>
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
    transition: var(--transition-smooth);
    border: 2px solid #dcfce7;
}

.item-img:hover {
    transform: scale(1.12);
    border-color: var(--success);
    box-shadow: 0 0 0 0.3rem rgba(22, 163, 74, 0.2);
}

.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
}

@media (max-width: 768px) {
    .table-container { padding: 15px; }
    .custom-table thead th, .custom-table td { font-size: 12px; padding: 12px 8px; }
}
</style>
@endsection
