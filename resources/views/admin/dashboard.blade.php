@extends('layouts.admin')

@section('title', 'Dashboard - CHMSU Lost & Found')

@section('styles')
    <style>
        /* User Dashboard Styles - Applied to Admin */
        .hero-header {
            background: var(--primary-gradient);
            color: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 25px;
        }

        .hero-header h2 {
            font-weight: 700;
        }

        .hero-header p {
            opacity: 0.9;
        }

        .stat-card {
            border: none;
            border-radius: 16px;
            padding: 20px;
            color: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }

        .stat-icon {
            font-size: 1.5rem;
            opacity: 0.8;
        }

        .toolbar {
            border-radius: 24px;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .toolbar .form-control:focus {
            border-color: #2563eb;
            box-shadow: var(--icon-glow);
        }

.item-card {
    border: none;
    border-radius: 18px;
    overflow: visible;
    transition: var(--transition-smooth);
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
}

        .item-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        .item-img {
            height: 200px;
            object-fit: cover;
        }

        .badge-status {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .claim-btn {
            transition: var(--transition-smooth);
        }

        .claim-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16,185,129,0.4);
        }

        /* Admin Add Item Card Enhancement */
        .add-item-section {
            margin-bottom: 40px;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Admin Header like userdash -->
        <div class="col-12 mb-4">
            <div class="hero-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2><i class="bi bi-speedometer2 admin-icon"></i> Admin Dashboard</h2>
                    <p>Manage lost & found items and claims</p>
                </div>
                <div class="text-end">
                    <h4 class="mb-0">{{ $items->count() }}</h4>
                    <small>Total Items</small>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="col-lg-10 mx-auto mb-5">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="stat-card bg-danger shadow-lg border-0 rounded-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5>Lost</h5>
                                <h3>{{ $items->where('status','lost')->count() }}</h3>
                            </div>
                            <i class="bi bi-exclamation-triangle stat-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card bg-success shadow-lg border-0 rounded-3" style="background: var(--success) !important;">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5>Found</h5>
                                <h3>{{ $items->where('status','found')->count() }}</h3>
                            </div>
                            <i class="bi bi-check-circle stat-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card bg-primary shadow-lg border-0 rounded-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5>Available for Claim</h5>
                                <h3>{{ $items->where('status','found')->whereNull('claimed_by')->count() }}</h3>
                            </div>
                            <i class="bi bi-box stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Item Section -->
        <div class="col-lg-10 mx-auto add-item-section">
            <div class="card shadow-lg">
                <div class="card-header" style="background: var(--primary-gradient); color: white; border-radius: 12px 12px 0 0 !important;">
                    <i class="bi bi-plus-circle admin-icon"></i>
                    Add New Item
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-check-circle admin-icon-sm text-success"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-exclamation-triangle admin-icon-sm"></i>
                        {{ $error }}
                    </div>
                    @endforeach
                    @endif

                    <form method="POST" action="{{ route('admin.items.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-person admin-icon-sm"></i>
                                    Reporter Name
                                </label>
                                <input type="text" name="reporter_name" class="form-control" value="{{ old('reporter_name') }}" required placeholder="Enter the full name of the person reporting">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-tag admin-icon-sm"></i>
                                    Item Name
                                </label>
                                <input type="text" id="item_name_input" name="item_name" class="form-control" value="{{ old('item_name') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-file-text admin-icon-sm"></i>
                                Description
                            </label>
                            <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-grid admin-icon-sm"></i>
                                    Category
                                </label>
                                <select id="category_select" name="category" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="bi bi-info-circle admin-icon-sm"></i>
                                    Status
                                </label>
                                <select name="status" class="form-select" required>
                                    <option value="">Select Status</option>
                                    <option value="lost" {{ old('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                                    <option value="found" {{ old('status') == 'found' ? 'selected' : '' }}>Found</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-calendar admin-icon-sm"></i>
                                Date Found
                            </label>
                            <input type="date" name="date_found" class="form-control" value="{{ old('date_found') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-image admin-icon-sm"></i>
                                Item Image
                            </label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Upload clear photo of the item (optional)</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 shadow-lg">
                            <i class="bi bi-plus-circle admin-icon-sm"></i>
                            Add Item
                        </button>
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
                                if (categorySelect.value && !itemNameInput.value.trim()) {
                                    itemNameInput.value = categorySelect.value;
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>

        <!-- Recent Lost Items for Claim -->
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-lg mb-5">
                <div class="card-header" style="background: var(--danger); color: white; border-radius: 12px 12px 0 0 !important;">
                    <i class="bi bi-exclamation-triangle admin-icon"></i>
                    Recent Lost Items - Available for Matching
                </div>
                <div class="card-body p-0">
                    @if($items->where('status', 'lost')->count() > 0)
                        <div class="row g-4 p-4">
                            @foreach($items->where('status', 'lost')->take(6) as $item)
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="card item-card h-100">
                                        <div class="position-relative">
                                            <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://placehold.co/400x250' }}" class="w-100 item-img">
                                            <span class="badge badge-status bg-danger">Lost</span>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="fw-bold">{{ $item->item_name }}</h6>
                                            <p class="text-muted small">{{ Str::limit($item->description, 80) }}</p>
                                            <small class="text-muted">{{ $item->created_at->format('M d, Y') }}</small>
                                            <a href="{{ route('admin.lost') }}" class="btn btn-outline-danger btn-sm mt-auto">
                                                <i class="bi bi-eye"></i> View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-4 text-muted mb-3"></i>
                            <h5>No Lost Items</h5>
                            <p class="text-muted">Add some lost items to get started.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Found Items -->
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header" style="background: var(--success); color: white; border-radius: 12px 12px 0 0 !important;">
                    <i class="bi bi-check-circle admin-icon"></i>
                    Recent Found Items for Claim Processing
                </div>
                <div class="card-body p-0">
                    @if($items->where('status', 'found')->whereNull('claimed_by')->count() > 0)
                        <div class="row g-4 p-4">
                            @foreach($items->where('status', 'found')->whereNull('claimed_by')->take(6) as $item)
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="card item-card h-100">
                                        <div class="position-relative">
                                            <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://placehold.co/400x250' }}" class="w-100 item-img">
                                            <span class="badge badge-status bg-success">Found</span>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="fw-bold">{{ $item->item_name }}</h6>
                                            <p class="text-muted small">{{ Str::limit($item->description, 80) }}</p>
                                            <small class="text-muted">{{ $item->created_at->format('M d, Y') }}</small>
                                            <div class="mt-auto d-flex gap-2 flex-wrap">
                                                <a href="{{ route('admin.claim') }}" class="btn btn-success btn-sm flex-fill" style="white-space: nowrap; position: relative; z-index: 10;">
                                                    <i class="bi bi-check-circle me-1"></i> Process Claim
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-check-circle display-4 text-success mb-3"></i>
                            <h5>No Available Claims</h5>
                            <p class="text-muted">Great job! No pending found items.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Claim Modal (same as user dashboard) -->
<div class="modal fade claim-modal" id="claimModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-check-circle"></i> Claim Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="item-preview mb-4">
                            <img id="modalItemImg" src="" alt="Item Image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 id="modalItemName" class="fw-bold mb-3">Item Name</h5>
                        <form id="claimForm" method="POST">
                            @csrf
                            <input type="hidden" id="itemId" name="item_id">
                            <div class="claim-form-group">
                                <label>Contact Number</label>
                                <input type="tel" id="claimContact" name="contact" class="form-control" required>
                            </div>
                            <div class="claim-form-group">
                                <label>Additional Details</label>
                                <textarea name="details" class="form-control" rows="3" placeholder="Describe how you can identify this item..."></textarea>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="claimConfirm" required>
                                <label class="form-check-label" for="claimConfirm">
                                    I confirm this is my item and will coordinate pickup
                                </label>
                            </div>
                            <button type="submit" id="submitClaim" class="btn btn-success w-100 mt-3 shadow-lg">
                                Submit Claim
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- Same JS as user dashboard -->
    <script>
        // Event delegation for claim buttons
        document.addEventListener('DOMContentLoaded', function() {
            const claimButtons = document.querySelectorAll('.claim-btn');
            const modal = document.getElementById('claimModal');
            
            claimButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('itemId').value = this.dataset.itemId;
                    document.getElementById('modalItemName').textContent = this.dataset.itemName;
                    document.getElementById('modalItemImg').src = this.dataset.itemImg || 'https://placehold.co/400x250';
                    
                    document.getElementById('claimForm').reset();
                    
                    const bsModal = new bootstrap.Modal(modal, {backdrop: 'static', keyboard: false});
                    bsModal.show();
                });
            });
        });

        // Form validation
        document.getElementById('claimForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitClaim');
            const confirm = document.getElementById('claimConfirm');
            
            if (!confirm.checked) {
                e.preventDefault();
                alert('Please confirm your claim');
                confirm.focus();
                return;
            }
            
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Submitting...';
            submitBtn.disabled = true;
        });
    </script>
@endsection
