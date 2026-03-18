@extends('layouts.admin')

@section('title', 'Reported Items - CHMSU Lost & Found')

@section('content')

<!-- ================= PAGE HEADER ================= -->
<div style="display:flex;align-items:center;gap:15px; margin-bottom: 20px;">
    <h5 class="m-0"><i class="bi bi-list-check"></i> Reported Items</h5>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.reported') }}" style="display:flex;gap:8px;margin-left:20px;">
        <input type="text" name="search" placeholder="Search items..." value="{{ request('search') }}" class="form-control" style="width: 200px;">
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
        @if(request('search'))
            <a href="{{ route('admin.reported') }}" class="btn btn-secondary">Clear</a>
        @endif
    </form>
</div>

<!-- ================= TABLE ================= -->
<div class="table-container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-wrapper">
        <table class="table table-hover text-center align-middle custom-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Reporter Name</th>
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
                            <img class="item-img" src="{{ $item->image ? asset('storage/' . urlencode($item->image)) : 'https://via.placeholder.com/70x60/1e3a8a/ffffff?text=' . urlencode(substr($item->item_name, 0, 12)) }}" alt="{{ $item->item_name }}">
                        </td>
                        <td class="fw-semibold">{{ $item->reporter_name ?? 'N/A' }}</td>
                        <td class="fw-semibold">{{ $item->item_name }}</td>
                        <td class="text-muted small">{{ $item->description }}</td>
                        <td><span class="badge bg-secondary">{{ $item->category }}</span></td>
                        <td>
                            @if($item->status === 'lost')
                                <span class="status-lost">LOST</span>
                            @elseif($item->status === 'found')
                                <span class="status-found">FOUND</span>
                            @else
                                <span class="status-claimed">CLAIMED</span>
                            @endif
                        </td>
                        <td>{{ $item->date_found ? \Carbon\Carbon::parse($item->date_found)->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $item->created_at ? $item->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.items.edit', $item->id) }}" class="btn-edit" title="Edit">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <button type="button" class="btn-delete" title="Delete" onclick="confirmDelete('{{ $item->id }}', '{{ $item->item_name }}')">
                                    <i class="bi bi-trash3"></i> Delete
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
                        <td colspan="9" class="text-muted">No items found.</td>
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

.status-lost {
    background: #fee2e2;
    color: #dc2626;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-found {
    background: #dcfce7;
    color: #16a34a;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-claimed {
    background: #fef3c7;
    color: #b45309;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.btn-edit {
    background: #16a34a;
    color: white;
    border: none;
    border-radius: 10px;
    padding: 6px 14px;
    font-size: 13px;
    transition: 0.3s;
    text-decoration: none;
    display: inline-block;
}

.btn-edit:hover {
    background: #15803d;
    transform: scale(1.1);
    color: white;
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
}

.btn-delete:hover {
    background: #b91c1c;
    transform: scale(1.1);
}

.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
}

@media (max-width: 768px) {
    .table-container { padding: 10px; }
    .custom-table thead th, .custom-table td { font-size: 12px; padding: 10px; }
}
</style>
@endsection

@section('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm('Are you sure you want to delete "' + name + '"?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection

