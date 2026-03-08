@extends('layouts.main')

@push('styles')
<style>
    .admin-header {
        background: #1e293b;
        color: #fff;
        padding: 20px 30px;
        border-radius: 10px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .system-title {
        border: 2px solid #2563eb;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: bold;
        font-size: 1.5rem;
    }
    
    .nav-pills-custom .nav-link {
        color: #cbd5e1;
        border-radius: 6px;
        padding: 8px 15px;
    }
    
    .nav-pills-custom .nav-link.active {
        background-color: #2563eb;
        color: #fff;
    }
    
    .items-table {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    
    .table-header {
        background: #2563eb;
        color: #fff;
        font-weight: bold;
    }
    
    .table td, .table th {
        vertical-align: middle;
    }
    
    .item-image {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
    }
    
    .status-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-lost { background: #fee2e2; color: #dc2626; }
    .status-found { background: #dcfce7; color: #16a34a; }
    .status-claimed { background: #fef3c7; color: #b45309; }
    
    .btn-action {
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 13px;
        margin-right: 5px;
    }
    
    .btn-edit { background: #16a34a; color: #fff; }
    .btn-delete { background: #dc2626; color: #fff; }
    
    .form-card {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        max-width: 700px;
        margin: 0 auto;
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

<!-- Admin Header -->
<div class="admin-header">
    <div class="system-title">CHMSU Lost & Found Management System</div>
    <div>
        <span style="margin-right: 15px;">Welcome, {{ Auth::user()->name }}</span>
        <a href="{{ route('logout') }}" class="btn btn-sm btn-primary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<!-- Navigation Tabs -->
<ul class="nav nav-pills-custom mb-4 justify-content-center" style="gap: 15px;">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.items') && !request('type') ? 'active' : '' }}" href="{{ route('admin.items') }}">
            <i class="bi bi-list-ul"></i> All Items
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('type') == 'lost' ? 'active' : '' }}" href="{{ route('admin.items', ['type' => 'lost']) }}">
            <i class="bi bi-exclamation-circle"></i> Lost Items
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('type') == 'found' ? 'active' : '' }}" href="{{ route('admin.items', ['type' => 'found']) }}">
            <i class="bi bi-check-circle"></i> Found Items
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('type') == 'claimed' ? 'active' : '' }}" href="{{ route('admin.items', ['type' => 'claimed']) }}">
            <i class="bi bi-hand-thumbs-up"></i> Claimed Items
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('items.create') }}" style="background: #10b981; color: #fff;">
            <i class="bi bi-plus-circle"></i> Add New Item
        </a>
    </li>
</ul>

<!-- Items Table -->
<div class="items-table" style="max-width: 1400px; margin: 0 auto;">
    <table class="table table-hover mb-0">
        <thead class="table-header">
            <tr>
                <th style="width: 100px;">Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Status</th>
                <th>Date Found</th>
                <th>Reported At</th>
                <th style="width: 150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="item-image" alt="{{ $item->item_name }}">
                        @else
                            <img src="https://via.placeholder.com/80x60?text=No+Image" class="item-image" alt="No Image">
                        @endif
                    </td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ Str::limit($item->description, 50) }}</td>
                    <td>{{ $item->category }}</td>
                    <td>
                        <span class="status-badge 
                            @if($item->status == 'lost') status-lost
                            @elseif($item->status == 'found') status-found
                            @else status-claimed @endif">
                            {{ strtoupper($item->status) }}
                        </span>
                    </td>
                    <td>{{ $item->date_found ? \Carbon\Carbon::parse($item->date_found)->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $item->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('items.edit', $item->id) }}" class="btn-action btn-edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this item?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-5">No items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($items->hasPages())
    <div style="display: flex; justify-content: center; padding: 20px;">
        {{ $items->appends(request()->query())->links() }}
    </div>
@endif
@endsection

