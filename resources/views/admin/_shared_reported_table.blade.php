@php
    /**
     * Shared Blade layout for admin tables (Reported/Found/Lost/Claim)
     * NOTE: Frontend-only refactor; does not change controller/backend logic.
     */

    $routeName = $routeName ?? null;
    $items = $items ?? collect();
    $title = $title ?? '';
    $subtitle = $subtitle ?? '';
    $iconClass = $iconClass ?? 'bi bi-list-check admin-icon text-success opacity-75';
    $deleteAllTitle = $deleteAllTitle ?? '';
    $deleteAllRoute = $deleteAllRoute ?? null;
    $emptyIconClass = $emptyIconClass ?? 'bi bi-list-ul fs-1 opacity-50 mb-3 d-block';
    $emptyText = $emptyText ?? 'No items reported yet.';
@endphp

<!-- ================= PAGE HEADER ================= -->
<div style="display:flex;align-items:center;gap:18px; margin-bottom: 25px; position: sticky; top: 0; z-index: 1000;">
    <div>
        <h5 class="m-0 d-flex align-items-center gap-2 fw-semibold {{ $iconClass }}">
            <i class="bi {{ substr($iconClass, 3) }}"></i>
            {{ $title }}
        </h5>
        <small class="text-muted">{{ $subtitle }}</small>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ $routeName ? route($routeName) : '' }}" style="display:flex;gap:8px;margin-left:20px;">
        <input type="text" name="search" placeholder="Search items..." value="{{ request('search') }}" class="form-control" style="width: 250px;">
        <button type="submit" class="btn btn-primary action-icon-btn" title="Search">
            <i class="bi bi-search admin-icon-sm"></i>
        </button>
        @if(request('search'))
            <a href="{{ $routeName ? route($routeName) : '' }}" class="btn btn-secondary action-icon-btn" title="Clear">
                <i class="bi bi-x admin-icon-sm"></i>
            </a>
        @endif
    </form>

    @if(!empty($deleteAllRoute))
        <!-- Delete All Button -->
        <button type="button" class="btn-delete-all" data-bs-toggle="modal" data-bs-target="#deleteAllModal" title="Delete All {{ $title }}">
            <i class="bi bi-trash3"></i>
        </button>
    @endif
</div>

<!-- ================= TABLE ================= -->
<div class="table-container">
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 {{ !empty($deleteAllRoute) ? '' : 'mb-3' }}">
            <i class="bi bi-check-circle admin-icon-sm text-success"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table class="table table-hover text-center align-middle custom-table">
            <thead>
                <tr>
                    <th><i class="bi bi-image admin-icon-sm"></i> Image</th>
                    <th><i class="bi bi-person admin-icon-sm"></i> Reporter</th>
                    <th><i class="bi bi-tag admin-icon-sm"></i> Item</th>
                    <th><i class="bi bi-file-text admin-icon-sm"></i> Description</th>
                    <th><i class="bi bi-grid admin-icon-sm"></i> Category</th>
                    <th><i class="bi bi-info-circle admin-icon-sm"></i> Status</th>
                    <th><i class="bi bi-calendar admin-icon-sm"></i> Date</th>
                    <th><i class="bi bi-clock admin-icon-sm"></i> Reported</th>
                    <th><i class="bi bi-gear admin-icon-sm"></i> Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>
                            <img class="item-img" src="{{ $item->image ? asset('storage/' . $item->image.'?v='.$item->updated_at) : 'https://via.placeholder.com/70x60/2563eb/ffffff?text=' . substr($item->item_name, 0, 12) }}" alt="{{ $item->item_name }}">
                        </td>
                        <td class="fw-semibold">{{ $item->reporter_name ?? 'N/A' }}</td>
                        <td class="fw-semibold">{{ $item->item_name }}</td>
                        <td class="text-muted small">{{ $item->description }}</td>
                        <td><span class="badge bg-primary">{{ $item->category }}</span></td>

                        <td>
                            @if($item->status === 'lost')
                                <span class="status-lost status-badge">
                                    <i class="bi bi-x-lg"></i> LOST
                                </span>
                            @elseif($item->status === 'found')
                                <span class="status-found status-badge">
                                    <i class="bi bi-check-lg"></i> FOUND
                                </span>
                            @else
                                <span class="status-claimed status-badge">
                                    <i class="bi bi-hand-thumbs-up"></i> CLAIMED
                                </span>
                            @endif
                        </td>

                        <td>{{ $item->date_found ? \Carbon\Carbon::parse($item->date_found)->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $item->created_at ? $item->created_at->format('Y-m-d H:i') : 'N/A' }}</td>

                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.items.edit', $item->id) }}" class="action-icon-btn btn-edit" title="Edit Item">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="action-icon-btn btn-delete" title="Delete Item" onclick="confirmDelete('{{ $item->id }}', '{{ $item->item_name }}')">
                                    <i class="bi bi-trash3"></i>
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
                        <td colspan="9" class="text-muted text-center py-5">
                            <i class="{{ $emptyIconClass }}"></i>
                            {{ $emptyText }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(!empty($deleteAllRoute))
    <!-- Delete All Confirmation Modal -->
    <div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                <div class="modal-header" style="background: linear-gradient(135deg, #dc2626, #b91c1c); color: white; border-radius: 16px 16px 0 0;">
                    <h5 class="modal-title fw-semibold" id="deleteAllModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $deleteAllTitle }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <i class="bi bi-trash3-fill" style="font-size: 3rem; color: #dc2626; margin-bottom: 15px; display: block;"></i>
                    <h5 class="fw-bold text-dark mb-2">Are you sure?</h5>
                    <p class="text-muted mb-4">This will permanently delete <strong>ALL {{ strtolower(str_replace(' ', '_', $title)) }}</strong> from the system. This action <span class="text-danger fw-bold">cannot be undone</span>.</p>
                    <div class="alert alert-danger d-flex align-items-start gap-2 text-start mb-3" style="border-radius: 12px;">
                        <i class="bi bi-shield-exclamation mt-1"></i>
                        <div>
                            <strong>Security Confirmation Required</strong><br>
                            Type <code class="fw-bold text-danger">DELETE</code> below to confirm this destructive action.
                        </div>
                    </div>

                    <input type="text" id="deleteAllConfirmInput" class="form-control text-center fw-bold" placeholder="Type DELETE to confirm" autocomplete="off" style="border-radius: 12px; border: 2px solid #e5e7eb; letter-spacing: 2px;">
                </div>
                <div class="modal-footer justify-content-center gap-2 pb-4 border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 12px;">Cancel</button>
                    <form action="{{ route($deleteAllRoute) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="deleteAllConfirmBtn" class="btn px-4" disabled style="border-radius: 12px; background: #dc2626; color: white; font-weight: 600; opacity: 0.6; transition: all 0.3s ease;">
                            <i class="bi bi-trash3 me-1"></i> Yes, Delete All
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

