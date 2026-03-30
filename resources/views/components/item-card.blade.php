@props(['item', 'heading_size' => 5, 'limit' => 60, 'show_claim' => false])

<div class="col-xl-3 col-lg-4 col-md-6">
    <div class="card item-card h-100 position-relative">
        <div class="position-relative">
            <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://via.placeholder.com/420x320/1e3a8a/ffffff?text=' . substr($item->item_name, 0, 20) }}" 
                 class="w-100 item-img" alt="{{ $item->item_name }}">
            <span class="badge badge-status {{ $item->status == 'lost' ? 'bg-danger' : 'bg-success' }}">
                {{ ucfirst($item->status) }}
            </span>
        </div>
        <div class="card-body d-flex flex-column">
            <h{{ $heading_size }} class="fw-bold text-truncate">{{ $item->item_name }}</h{{ $heading_size }}>
            <p class="text-muted small">{{ Str::limit($item->description, $limit) }}</p>
            <small class="text-muted">{{ $item->created_at->format('M d, Y') }}</small>
            @if($show_claim && $item->status == 'found')
                <button class="btn btn-success btn-sm mt-auto claim-btn" 
                        data-item-id="{{ $item->id }}" 
                        data-item-name="{{ $item->item_name }}"
                        data-item-img="{{ asset('storage/'.$item->image) }}">
                    <i class="bi bi-hand-thumbs-up"></i> Claim
                </button>
            @endif
        </div>
    </div>
</div>
