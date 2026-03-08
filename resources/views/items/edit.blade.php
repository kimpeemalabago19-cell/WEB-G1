@extends('layouts.main')

@push('styles')
<style>
    .edit-card {
        background: #fff;
        width: 100%;
        max-width: 600px;
        padding: 40px;
        border-radius: 30px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        margin: 0 auto;
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }
    
    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #1e293b;
    }
    
    label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #334155;
    }
    
    input, textarea, select {
        width: 100%;
        padding: 12px;
        margin-top: 6px;
        margin-bottom: 18px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.95rem;
        transition: 0.3s;
    }
    
    input:focus, textarea:focus, select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
        outline: none;
    }
    
    textarea {
        resize: none;
        height: 90px;
    }
    
    .image-preview {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .image-preview img {
        width: 160px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        border: 3px solid #2563eb;
    }
    
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        margin-bottom: 15px;
    }
    
    .status-lost { background: #fee2e2; color: #dc2626; }
    .status-found { background: #dcfce7; color: #16a34a; }
    
    .button-group {
        display: flex;
        gap: 10px;
    }
    
    .btn {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }
    
    .btn-update {
        background: #2563eb;
        color: #fff;
    }
    
    .btn-update:hover {
        background: #1e40af;
        transform: translateY(-2px);
    }
    
    .btn-cancel {
        background: #e2e8f0;
    }
    
    .btn-cancel:hover {
        background: #cbd5e1;
    }
    
    .back-link {
        text-align: center;
        margin-top: 15px;
    }
    
    .back-link a {
        text-decoration: none;
        color: #2563eb;
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
<!-- Admin Header -->
<div style="background: #1e293b; color: #fff; padding: 20px 30px; border-radius: 10px; margin-bottom: 30px; max-width: 670px; margin-left: auto; margin-right: auto;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div style="border: 2px solid #2563eb; padding: 10px 20px; border-radius: 8px; font-weight: bold; font-size: 1.5rem;">
            CHMSU Lost & Found
        </div>
        <a href="{{ route('admin.items') }}" style="background: #2563eb; color: #fff; padding: 8px 15px; border-radius: 6px; text-decoration: none;">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="edit-card">
    <h2>Update Item Details</h2>

    <div class="image-preview">
        @if($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->item_name }}">
        @else
            <img src="https://via.placeholder.com/160x120?text=No+Image" alt="No Image">
        @endif
    </div>

    <div style="text-align: center;">
        <span class="status-badge {{ $item->status == 'lost' ? 'status-lost' : 'status-found' }}">
            {{ strtoupper($item->status) }}
        </span>
    </div>

    <form method="POST" action="{{ route('items.update', $item->id) }}">
        @csrf
        @method('PUT')

        <label>Item Name</label>
        <input name="item_name" value="{{ old('item_name', $item->item_name) }}" required>

        <label>Description</label>
        <textarea name="description">{{ old('description', $item->description) }}</textarea>

        <label>Category</label>
        <input name="category" value="{{ old('category', $item->category) }}">

        <label>Status</label>
        <select name="status">
            <option value="lost" {{ old('status', $item->status) == 'lost' ? 'selected' : '' }}>Lost</option>
            <option value="found" {{ old('status', $item->status) == 'found' ? 'selected' : '' }}>Found</option>
        </select>

        <div class="button-group">
            <button type="submit" class="btn btn-update">Update Item</button>
            <button type="button" class="btn btn-cancel" onclick="window.location='{{ route('admin.items') }}'">Cancel</button>
        </div>
    </form>

    <div class="back-link">
        <a href="{{ route('admin.items') }}">← Back to All Items</a>
    </div>
</div>
@endsection

