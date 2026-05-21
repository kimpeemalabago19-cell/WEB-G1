@extends('layouts.admin')

@section('title', 'Edit Item - CHMSU Lost & Found System Management')

@section('content')

<!-- HEADER -->
 
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
                        <img id="itemImageClickable" class="item-img-large"
                             src="{{ $image ? asset('storage/' . $image.'?v='.$item->updated_at) : 'https://via.placeholder.com/420x320/1e3a8a/ffffff?text=' . substr($item->item_name, 0, 20) }}"
                             alt="{{ $item->item_name }}" style="cursor: zoom-in;">
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
                                // Do NOT auto-fill item name from category to avoid overwriting user input
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
/* ================= ITEM IMAGE LIGHTBOX (Admin Edit Only) ================= */
.item-image-lightbox-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 20000;
    padding: 20px;
}

.item-image-lightbox-overlay.active {
    display: flex;
}

.item-image-lightbox-dialog {
    position: relative;
    max-width: 1100px;
    width: 100%;
}

.item-image-lightbox-close {
    position: absolute;
    top: -14px;
    right: 0;
    background: rgba(255,255,255,0.95);
    border: none;
    border-radius: 999px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
}

.item-image-lightbox-close:focus {
    outline: 2px solid rgba(37,99,235,0.5);
    outline-offset: 2px;
}

.item-image-lightbox-img {
    width: 100%;
    max-height: 80vh;
    object-fit: contain; /* no distortion */
    border-radius: 16px;
    background: #0b1220;
    box-shadow: 0 25px 70px rgba(0,0,0,0.45);
    display: block;
    margin: 0 auto;
}

@media (max-width: 575px) {
    .item-image-lightbox-close {
        top: -10px;
        width: 36px;
        height: 36px;
    }

    .item-image-lightbox-img {
        max-height: 75vh;
    }
}


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

/* ================= ITEM IMAGE LIGHTBOX (Admin Edit Only) ================= */
.item-image-lightbox-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 20000;
    padding: 20px;
}

.item-image-lightbox-overlay.active {
    display: flex;
}

.item-image-lightbox-dialog {
    position: relative;
    max-width: 1100px;
    width: 100%;
}

.item-image-lightbox-close {
    position: absolute;
    top: -14px;
    right: 0;
    background: rgba(255,255,255,0.95);
    border: none;
    border-radius: 999px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
}

.item-image-lightbox-close:focus {
    outline: 2px solid rgba(37,99,235,0.5);
    outline-offset: 2px;
}

.item-image-lightbox-img {
    width: 100%;
    max-height: 80vh;
    object-fit: contain; /* no distortion */
    border-radius: 16px;
    background: #0b1220;
    box-shadow: 0 25px 70px rgba(0,0,0,0.45);
    display: block;
    margin: 0 auto;
}

@media (max-width: 575px) {
    .item-image-lightbox-close {
        top: -10px;
        width: 36px;
        height: 36px;
    }

    .item-image-lightbox-img {
        max-height: 75vh;
    }
}

</style>


@endsection

@section('scripts')
<script>

    (function () {
        const img = document.getElementById('itemImageClickable');
        if (!img) return;

        const overlay = document.createElement('div');
        overlay.className = 'item-image-lightbox-overlay';
        overlay.id = 'itemImageLightboxOverlay';
        overlay.innerHTML = '
            <div class="item-image-lightbox-dialog">
                <button type="button" class="item-image-lightbox-close" aria-label="Close">✕</button>
                <img class="item-image-lightbox-img" id="itemImageLightboxImg" alt="Item Image" src="" />
            </div>
        ';

        document.body.appendChild(overlay);

        const lightboxImg = overlay.querySelector('#itemImageLightboxImg');
        const closeBtn = overlay.querySelector('.item-image-lightbox-close');

        function openLightbox(src) {
            lightboxImg.src = src;
            overlay.classList.add('active');
            // Prevent background scroll
            document.body.dataset.prevOverflow = document.body.style.overflow;
            document.body.style.overflow = 'hidden';
            // Focus close button for accessibility
            closeBtn && closeBtn.focus();
        }

        function closeLightbox() {
            overlay.classList.remove('active');
            // Restore background scroll
            const prev = document.body.dataset.prevOverflow;
            document.body.style.overflow = prev !== undefined ? prev : '';
        }

        img.addEventListener('click', function () {
            openLightbox(img.currentSrc || img.src);
        });

        closeBtn && closeBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            closeLightbox();
        });

        overlay.addEventListener('click', function (e) {
            // Close when clicking outside the dialog
            if (e.target === overlay) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && overlay.classList.contains('active')) {
                closeLightbox();
            }
        });
    })();
</script>
@endsection
