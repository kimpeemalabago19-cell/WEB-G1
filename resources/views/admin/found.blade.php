@extends('layouts.admin')

@section('title', 'Found Items - CHMSU Lost & Found')

@section('content')

<div class="table-container">
    <div class="table-wrapper">
        <table class="table table-hover text-center align-middle custom-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Date Found</th>
                    <th>Reported At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>
                        <img class="item-img" src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/70x60' }}">
                    </td>
                    <td class="fw-semibold">{{ $item->item_name }}</td>
                    <td class="text-muted small">{{ $item->description }}</td>
                    <td><span class="badge bg-secondary">{{ $item->category }}</span></td>
                    <td><span class="item-status">{{ strtoupper($item->status) }}</span></td>
                    <td>{{ $item->date_found ?? 'N/A' }}</td>
                    <td>{{ $item->created_at ? $item->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                    <td>
                        <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this item?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8">No found items.</td></tr>
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
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.05);
}

.table-wrapper {
    max-height: 70vh;
    overflow-y: auto;
}

.custom-table {
    margin-bottom: 0;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    width: 100%;
    min-width: 800px;
}

.custom-table thead th {
    position: sticky;
    top: 0;
    z-index: 15;
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;
    padding: 16px;
    font-size: 14px;
    font-weight: 600;
}

.custom-table td {
    padding: 14px;
    vertical-align: middle;
}

.custom-table tbody tr:hover {
    background: #f1f5f9;
}

.item-img {
    width: 70px;
    height: 60px;
    object-fit: cover;
    border-radius: 10px;
    transition: 0.3s;
}

.item-img:hover {
    transform: scale(1.1);
}

.item-status {
    background: #dcfce7;
    color: #16a34a;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.btn-delete {
    background: #dc2626;
    color: white;
    border: none;
    border-radius: 10px;
    padding: 6px 14px;
    font-size: 13px;
    transition: 0.3s;
    cursor: pointer;
    text-decoration: none;
}

.btn-delete:hover {
    background: #b91c1c;
    transform: scale(1.1);
    color: white;
}

@media (max-width: 768px) {
    .table-container { padding: 10px; }
    .custom-table thead th, .custom-table td { font-size: 12px; padding: 10px; }
}
</style>
@endsection

