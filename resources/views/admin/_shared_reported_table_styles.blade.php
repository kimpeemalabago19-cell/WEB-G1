@section('styles')
<style>
/* ================= TABLE CONTAINER ================= */
.table-container {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    overflow: hidden;
}

/* ================= WRAPPER (NO HORIZONTAL SWIPE) ================= */
.table-wrapper {
    max-height: 70vh;
    overflow-y: auto;
    overflow-x: hidden; /* same as CLAIM PAGE */

    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE/Edge */
}

.table-wrapper::-webkit-scrollbar {
    display: none; /* Chrome/Safari */
}

/* ================= TABLE ================= */
.custom-table {
    margin-bottom: 0;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    width: 100%;
    table-layout: auto; /* same as CLAIM PAGE */
}

/* ================= HEADER ================= */
.custom-table thead th {
    position: sticky;
    top: 0;
    z-index: 15;
    background: var(--primary-gradient);
    color: white;
    padding: 16px 10px;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
}

/* ================= CELLS ================= */
.custom-table td {
    padding: 14px 10px;
    vertical-align: middle;
    word-break: break-word;
}

/* ================= STATUS COLUMN FIX ================= */
.custom-table th:nth-child(6),
.custom-table td:nth-child(6) {
    min-width: 110px;
    text-align: center;
    white-space: nowrap;
}

/* ================= IMAGE ================= */
.item-img {
    width: 70px;
    height: 60px;
    object-fit: cover;
    border-radius: 12px;
    transition: 0.3s ease;
    border: 3px solid #dbeafe;
}

.item-img:hover {
    transform: scale(1.08);
    border-color: #2563eb;
}

/* ================= ACTION BUTTONS ================= */
.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}

/* ================= ROW HOVER ================= */
.custom-table tbody tr:hover {
    background: #f8fafc;
}

/* ================= BADGES ================= */
.badge {
    white-space: nowrap;
}

/* ================= GLOBAL SAFETY ================= */
body {
    overflow: hidden;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .table-container {
        padding: 15px;
    }

    .custom-table td,
    .custom-table th {
        font-size: 12px;
        padding: 10px 6px;
    }
}

/* ================= DELETE ALL BUTTON ================= */
.btn-delete-all {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    background: var(--danger);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-smooth);
    cursor: pointer;
    font-size: 1em;
    margin-left: 8px;
    flex-shrink: 0;
}

.btn-delete-all:hover {
    background: #b91c1c;
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
}

.btn-delete-all:active {
    transform: scale(0.95);
}

/* ================= DELETE ALL MODAL ================= */
#deleteAllModal .form-control:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
}

#deleteAllConfirmBtn:not(:disabled) {
    opacity: 1 !important;
    background: #dc2626 !important;
}

#deleteAllConfirmBtn:not(:disabled):hover {
    background: #b91c1c !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
}

</style>
@endsection

