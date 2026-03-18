@extends('layouts.admin')

@section('title', 'Add Item - CHMSU Lost & Found')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    Add New Item
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                    @endforeach
                    @endif

                    <form method="POST" action="{{ route('admin.items.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Reporter Name (Person who reported the item lost)</label>
                            <input type="text" name="reporter_name" class="form-control" required placeholder="Enter the full name of the person reporting">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Item Name</label>
                            <input type="text" name="item_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="">Select Status</option>
                                <option value="lost">Lost</option>
                                <option value="found">Found</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date Found</label>
                            <input type="date" name="date_found" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Item Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle"></i> Add Item
                        </button>
                    </form>
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

.card-header {
    font-weight: 600;
    font-size: 16px;
}

.form-control,
.form-select {
    padding: 10px;
}

.form-control:focus,
.form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 0.15rem rgba(37, 99, 235, 0.25);
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

