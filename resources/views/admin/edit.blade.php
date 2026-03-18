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

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow">
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

                <!-- IMAGE -->
                <div class="text-center mb-3">
                    @php
                    $image = $item->image ?? null;
                    @endphp
                    <img class="item-img" src="{{ $image ? asset('storage/'.$image) : 'https://via.placeholder.com/160x120' }}">
                </div>

                <div class="text-center mb-3">
                    <span class="status-badge {{ ($item->status ?? '')=='lost' ? 'status-lost' : 'status-found' }}">
                        {{ strtoupper($item->status ?? 'UNKNOWN') }}
                    </span>
                </div>

                <form method="POST" action="{{ route('admin.items.update',$item->id ?? 0) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Item Name</label>
                        <input name="item_name" class="form-control" value="{{ old('item_name',$item->item_name ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control">{{ old('description',$item->description ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            @foreach($categories ?? [] as $cat)
                                <option value="{{ $cat }}" {{ ($item->category ?? '')==$cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="lost" {{ ($item->status ?? '')=='lost'?'selected':'' }}>Lost</option>
                            <option value="found" {{ ($item->status ?? '')=='found'?'selected':'' }}>Found</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Item Image (optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <button class="btn btn-primary w-100">
                        <i class="bi bi-check-circle"></i> Update Item
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('admin.reported') }}" style="text-decoration:none;">
                        ← Back to Reported Items
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
.card {
    border: none;
    border-radius: 12px;
}

.form-control,
.form-select {
    padding: 10px;
}

.form-control:focus,
.form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 0.15rem rgba(37,99,235,0.25);
}

.item-img {
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
}

.status-lost {
    background: #fee2e2;
    color: #dc2626;
}

.status-found {
    background: #dcfce7;
    color: #16a34a;
}

.btn-primary {
    background: #2563eb;
    border: none;
}

.btn-primary:hover {
    background: #1e40af;
}
</style>
@endsection

