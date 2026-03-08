@extends('layouts.main')

@push('styles')
<style>
    .form-card {
        background: #fff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        max-width: 700px;
        margin: 0 auto;
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }
    
    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #1e293b;
    }
    
    label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #334155;
        margin-bottom: 6px;
    }
    
    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #cbd5e1;
        transition: 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
        outline: none;
    }
    
    textarea {
        resize: none;
        height: 100px;
    }
    
    .btn-submit {
        background: #2563eb;
        color: #fff;
        padding: 14px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
    }
    
    .btn-submit:hover {
        background: #1e40af;
        transform: translateY(-2px);
    }
    
    .btn-cancel {
        background: #e2e8f0;
        color: #334155;
        padding: 14px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
    }
    
    .btn-cancel:hover {
        background: #cbd5e1;
    }
    
    .button-group {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    
    .image-upload {
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
    }
    
    .image-upload:hover {
        border-color: #2563eb;
        background: #f1f5f9;
    }
    
    .back-link {
        text-align: center;
        margin-top: 20px;
    }
    
    .back-link a {
        text-decoration: none;
        color: #2563eb;
        font-size: 0.95rem;
    }
    
    .back-link a:hover {
        text-decoration: underline;
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
<div style="background: #1e293b; color: #fff; padding: 20px 30px; border-radius: 10px; margin-bottom: 30px; max-width: 770px; margin-left: auto; margin-right: auto;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div style="border: 2px solid #2563eb; padding: 10px 20px; border-radius: 8px; font-weight: bold; font-size: 1.5rem;">
            CHMSU Lost & Found
        </div>
        <a href="{{ route('admin.items') }}" style="background: #2563eb; color: #fff; padding: 8px 15px; border-radius: 6px; text-decoration: none;">
            <i class="bi bi-arrow-left"></i> Back to Items
        </a>
    </div>
</div>

<!-- Add Item Form -->
<div class="form-card">
    <h2><i class="bi bi-plus-circle"></i> Add New Item</h2>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input type="text" name="item_name" class="form-control" placeholder="Enter item name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" placeholder="Enter detailed description" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select" required>
                <option value="">Select Category</option>
                <option value="Clothing">Clothing</option>
                <option value="Bags">Bags</option>
                <option value="Gadgets">Gadgets</option>
                <option value="Documents">Documents</option>
                <option value="Accessories">Accessories</option>
                <option value="Others">Others</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="lost">Lost</option>
                <option value="found">Found</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Date Found (Optional)</label>
            <input type="date" name="date_found" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Image (Optional)</label>
            <div class="image-upload" onclick="document.getElementById('image').click()">
                <i class="bi bi-cloud-upload" style="font-size: 2rem; color: #64748b;"></i>
                <p style="margin-top: 10px; color: #64748b;">Click to upload image</p>
                <input type="file" name="image" id="image" accept="image/*" style="display: none;" onchange="previewImage(this)">
                <img id="imagePreview" style="display: none; max-width: 100%; margin-top: 15px; border-radius: 10px;">
            </div>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-submit">Add Item</button>
            <button type="button" class="btn-cancel" onclick="window.location='{{ route('admin.items') }}'">Cancel</button>
        </div>
    </form>

    <div class="back-link">
        <a href="{{ route('admin.items') }}"><i class="bi bi-arrow-left"></i> Back to All Items</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

