@extends('layouts.admin')

@section('title', 'Edit Item - CHMSU Lost & Found')

@section('content')

<!-- HEADER -->
<div class="header mb-4">
    <h5 class="m-0">
        <i class="bi bi-pencil-square admin-icon"></i> 
        Edit Item
    </h5>
</div>

<div class="container-fluid">
    <div class="card shadow-xl border-0">
        
        <div class="card-header">
            <i class="bi bi-gear admin-icon"></i>
            Update Item Details
        </div>

        <div class="card-body">
            @if($errors && $errors->any())
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-exclamation-triangle admin-icon-sm"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
            @endif

            <div class="row align-items-start g-4">

                <!-- LEFT: IMAGE -->
                <div class="col-lg-5 text-center">
                    @php $image = $item->image ?? null; @endphp

                    <div class="image-wrapper p-4 bg-light rounded-3">
                        <img class="item-img-large" 
                             src="{{ $image ? asset('storage/' . $image) : 'https://via.placeholder.com/420x320/1e3a8a/ffffff?text=' . substr($item->item_name, 0, 20) }}" 
                             alt="{{ $item->item_name }}">
                    </div>

                    <div class="mt-4">
                        <span class="status-badge {{ ($item->status ?? '')=='lost' ? 'status-lost' : (($item->status ?? '')=='found' ? 'status-found' : 'status-claimed') }}">
                            @if($item->status === 'lost')
                                <i class="bi bi-x-lg"></i> LOST
                            @elseif($item->status === 'found')
                                <i class="bi bi-check-lg"></i> FOUND  
                            @else
                                <i class="bi bi-hand-thumbs-up"></i> CLAIMED
                            @endif
                        </span>
                    </div>
                </div>

                <!-- RIGHT: FORM -->
                <div class="col-lg-7">
                    <form method="POST" action="{{ route('admin.items.update',$item->id ?? 0) }}" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-tag admin-icon-sm"></i>
                                Item Name
                            </label>
                            <input id="item_name_input" name="item_name" class="form-control" value="{{ old('item_name',$item->item_name ?? '') }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-file-text admin-icon-sm"></i>
                                Description
                            </label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description',$item->description ?? '') }}</textarea>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="bi bi-grid admin-icon-sm"></i>
                                    Category
                                </label>
                                <select id="category_select" name="category" class="form-select">
                                    @foreach($categories ?? [] as $cat)
                                        <option value="{{ $cat }}" {{ ($item->category ?? '')==$cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="bi bi-info-circle admin-icon-sm"></i>
                                    Status
                                </label>
                                <select name="status" class="form-select">
                                    <option value="lost" {{ ($item->status ?? '')=='lost'?'selected':'' }}>Lost</option>
                                    <option value="found" {{ ($item->status ?? '')=='found'?'selected':'' }}>Found</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-image admin-icon-sm"></i>
                                Update Image (optional)
                            </label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Replace current image</small>
                        </div>

                        <div class="d-flex gap-3">
                            <button class="btn btn-primary flex-grow-1">
                                <i class="bi bi-check-circle admin-icon-sm"></i>
                                Update Item
                            </button>
                            <a href="{{ route('admin.reported') }}" class="btn btn-outline-secondary action-icon-btn" title="Back">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>
                    </form>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const categorySelect = document.getElementById('category_select');
                            const itemNameInput = document.getElementById('item_name_input');
                            if (categorySelect && itemNameInput) {
                                categorySelect.addEventListener('change', function() {
                                    if (this.value) {
                                        itemNameInput.value = this.value;
                                    }
                                });
                            }
                        });
                    </script>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
.image-wrapper {
    border: 3px dashed #e5e7eb;
    transition: var(--transition-smooth);
}

.image-wrapper:hover {
    border-color: #2563eb;
    background: #f8fafc;
}

.item-img-large {
    width: 100%;
    max-width: 420px;
    height: 320px;
    object-fit: cover;
    border-radius: 16px;
    transition: var(--transition-smooth);
}

.item-img-large:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 40px rgba(0,0,0,0.2);
}

@media (max-width: 991px) {
    .item-img-large { height: 280px; }
}
</style>
@endsection
