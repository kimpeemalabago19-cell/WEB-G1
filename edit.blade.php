@extends('layouts.admin')

@section('title', 'Edit Item - CHMSU Lost & Found')

@section('content')

<!-- HEADER -->
<div class="header">
    <h5 class="m-0">
        <i class="bi bi-pencil-square"></i> Edit Item
    </h5>
    <span>
        <i class="bi bi-person-circle"></i> Admin
    </span>
</div>

<div class="container-fluid mt-3">
    <div class="card shadow-lg border-0">
        
        <div class="card-header bg-primary text-white">
            Update Item Details
        </div>

        <div class="card-body">
            @if($errors && $errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
            @endif

            <div class="row align-items-start">

                <!-- LEFT: IMAGE -->
                <div class="col-lg-5 mb-4 mb-lg-0 text-center">

                    @php
                    $image = $item->image ?? null;
                    @endphp

                    <div class="image-wrapper">
                        <img class="item-img-large" 
                             src="{{ $image ? asset('storage/' . $image) : 'https://via.placeholder.com/400x300/1e3a8a/ffffff?text=' . substr($item->item_name, 0, 20) }}" 
                             alt="{{ $item->item_name }}">
                    </div>

                    <div class="mt-3">
                        <span class="status-badge {{ ($item->status ?? '')=='lost' ? 'status-lost' : 'status-found' }}">
                            {{ strtoupper($item->status ?? 'UNKNOWN') }}
                        </span>
                    </div>

                </div>

                <!-- RIGHT: FORM -->
                <div class="col-lg-7">

                    <form method="POST" action="{{ route('admin.items.update',$item->id ?? 0) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Item Name</label>
                            <input name="item_name" class="form-control" value="{{ old('item_name',$item->item_name ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description',$item->description ?? '') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    @foreach($categories ?? [] as $cat)
                                        <option value="{{ $cat }}" {{ ($item->category ?? '')==$cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="lost" {{ ($item->status ?? '')=='lost'?'selected':'' }}>Lost</option>
                                    <option value="found" {{ ($item->status ?? '')=='found'?'selected':'' }}>Found</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Update Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        <button class="btn btn-primary w-100">
                            <i class="bi bi-check-circle"></i> Update Item
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('admin.reported') }}" class="back-link">
                            ← Back to Reported Items
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>

/* CARD */
.card {
    border-radius: 16px;
}

/* IMAGE SECTION */
.image-wrapper {
    padding: 15px;
    background: #f1f5f9;
    border-radius: 16px;
}

/* BIGGER IMAGE */
.item-img-large {
    width: 100%;
    max-width: 420px;
    height: 300px;
    object-fit: cover;
    border-radius: 14px;
    border: 4px solid #2563eb;
    transition: 0.3s ease;
}

/* HOVER EFFECT */
.item-img-large:hover {
    transform: scale(1.03);
}

/* STATUS */
.status-badge {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 600;
}

/* COLORS */
.status-lost {
    background: #fee2e2;
    color: #dc2626;
}

.status-found {
    background: #dcfce7;
    color: #16a34a;
}

/* FORM */
.form-control,
.form-select {
    padding: 12px;
    border-radius: 10px;
}

.form-control:focus,
.form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 0.15rem rgba(37,99,235,0.25);
}

/* BUTTON */
.btn-primary {
    background: #2563eb;
    border: none;
    padding: 12px;
    font-weight: 500;
    border-radius: 10px;
}

.btn-primary:hover {
    background: #1e40af;
}

/* BACK LINK */
.back-link {
    text-decoration: none;
    color: #64748b;
    font-size: 14px;
}

.back-link:hover {
    color: #2563eb;
}

/* RESPONSIVE */
@media (max-width: 991px) {
    .item-img-large {
        height: 250px;
    }
}

</style>
@endsection