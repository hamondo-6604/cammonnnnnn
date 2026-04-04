@extends('layouts.app')

@section('title', 'All Bookings')

@section('page-title', 'Bookings')

@section('page-sub', 'Manage all booking reservations')

@section('content')
<div class="dash-panel">
    <div class="panel-head">
        <div>
            <h2 class="panel-title">All Bookings</h2>
            <p class="panel-sub">Manage all booking reservations</p>
        </div>
        <a href="{{ route('admin.bookings.create') }}" class="panel-link">
            Add New <i class="fa-solid fa-plus"></i>
        </a>
    </div>
    <div class="panel-body">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
        @endif

        <table class="booking-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Booking Ref</th>
                    <th>User</th>
                    <th>Bus</th>
                    <th>Seat</th>
                    <th>Status</th>
                    <th>Amount Paid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $booking->booking_reference }}</td>
                    <td>{{ $booking->user->name ?? '-' }}</td>
                    <td>{{ $booking->bus->name ?? '-' }}</td>
                    <td>{{ $booking->seat_number ?? '-' }}</td>
                    <td class="capitalize">{{ $booking->status }}</td>
                    <td>${{ $booking->amount_paid }}</td>
                    <td class="booking-actions">
                        <button type="button" class="booking-action-btn booking-action-btn--view" onclick="openShowModal({{ $booking->id }})">
                            View
                        </button>
                        <button type="button" class="booking-action-btn booking-action-btn--edit" onclick="openEditModal({{ $booking->id }})">
                            Edit
                        </button>
                        <button type="button" class="booking-action-btn booking-action-btn--delete" 
                                onclick="openDeleteModal({{ $booking->id }}, '{{ $booking->booking_reference }}', '{{ $booking->user->name ?? 'N/A' }}', '{{ $booking->bus->name ?? 'N/A' }}')">
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No bookings found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection

<!-- Edit Booking Modal -->
<div id="editModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h2 class="panel-title">Edit Booking</h2>
                    <p class="panel-sub">Update booking information and status</p>
                </div>
                <button type="button" class="modal-close" onclick="closeEditModal()">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be loaded here via AJAX -->
                <div class="loading-spinner">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <span>Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-container modal-container--small">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h2 class="panel-title">Delete Booking</h2>
                    <p class="panel-sub">Confirm booking deletion</p>
                </div>
                <button type="button" class="modal-close" onclick="closeDeleteModal()">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="delete-confirmation">
                    <div class="delete-icon">
                        <i class="fa-solid fa-exclamation-triangle"></i>
                    </div>
                    <div class="delete-content">
                        <h3>Are you sure you want to delete this booking?</h3>
                        <p>This action cannot be undone. All booking data will be permanently removed.</p>
                        <div class="delete-details" id="deleteDetails">
                            <!-- Booking details will be inserted here -->
                        </div>
                    </div>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn--secondary" onclick="closeDeleteModal()">
                        <i class="fa-solid fa-times"></i> Cancel
                    </button>
                    <form id="deleteForm" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn--danger">
                            <i class="fa-solid fa-trash"></i> Delete Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Show Booking Modal -->
<div id="showModal" class="modal-overlay">
    <div class="modal-container modal-container--large">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h2 class="panel-title">Booking Details</h2>
                    <p class="panel-sub">View complete booking information</p>
                </div>
                <button type="button" class="modal-close" onclick="closeShowModal()">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="showModalBody">
                <!-- Content will be loaded here via AJAX -->
                <div class="loading-spinner">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <span>Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('head')
<style>
.booking-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.booking-table th {
    font-weight: 600;
    color: var(--muted);
    text-align: left;
    padding: 12px;
    border-bottom: 2px solid var(--border);
    background: var(--bg2);
}

.booking-table td {
    padding: 12px;
    border-bottom: 1px solid var(--border);
    color: var(--ink);
}

.booking-table tr:hover {
    background: var(--bg2);
}

.booking-table tr:hover td {
    color: var(--ink);
}

.booking-table td:last-child {
    border-bottom: none;
}

.booking-actions {
    display: flex;
    gap: 8px;
    align-items: center;
}

.booking-action-btn {
    padding: 6px 12px;
    border-radius: var(--radius-sm);
    text-decoration: none;
    font-size: .75rem;
    font-weight: 600;
    transition: all .2s;
    border: none;
    cursor: pointer;
}

.booking-action-btn--view {
    background: var(--c-blue-bg);
    color: var(--c-blue);
}

.booking-action-btn--view:hover {
    background: var(--c-blue);
    color: var(--white);
}

.booking-action-btn--edit {
    background: var(--c-amber-bg);
    color: var(--c-amber);
}

.booking-action-btn--edit:hover {
    background: var(--c-amber);
    color: var(--white);
}

.booking-action-btn--delete {
    background: var(--c-red-bg);
    color: var(--c-red);
}

.booking-action-btn--delete:hover {
    background: var(--c-red);
    color: var(--white);
}

.booking-action-form {
    display: inline-block;
    margin: 0;
}

.text-center {
    text-align: center;
}

.capitalize {
    text-transform: capitalize;
}

.bg-green-100 {
    background-color: var(--c-green-bg);
    color: var(--c-green);
    padding: 12px;
    border-radius: var(--radius);
    margin-bottom: 16px;
}

/* Pagination Styles */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 24px;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}

.pagination-wrapper .pagination {
    display: flex;
    align-items: center;
    gap: 8px;
}

.pagination-wrapper .pagination li {
    display: flex;
    align-items: center;
    justify-content: center;
}

.pagination-wrapper .pagination a,
.pagination-wrapper .pagination span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 8px 12px;
    border-radius: var(--radius-sm);
    text-decoration: none;
    font-size: .8rem;
    font-weight: 500;
    transition: all .2s ease;
    border: 1px solid var(--border);
    color: var(--text-dim);
    background: var(--white);
}

.pagination-wrapper .pagination a:hover {
    background: var(--khaki-bg);
    color: var(--khaki-dark);
    border-color: var(--khaki);
    transform: translateY(-1px);
}

.pagination-wrapper .pagination .active {
    background: var(--khaki);
    color: var(--white);
    border-color: var(--khaki-dark);
    font-weight: 600;
}

.pagination-wrapper .pagination .disabled {
    opacity: 0.5;
    cursor: not-allowed;
    color: var(--muted);
}

.pagination-wrapper .pagination .disabled:hover {
    background: var(--white);
    color: var(--muted);
    border-color: var(--border);
    transform: none;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 20px;
    place-items: center;
}

.modal-overlay.show {
    display: flex;
}

.modal-container {
    max-width: 800px;
    width: 100%;
    max-height: 90vh;
    overflow: visible;
    margin: auto;
    position: relative;
    transform: translateZ(0);
}

.modal-container--small {
    max-width: 500px;
}

.modal-container--large {
    max-width: 900px;
    max-height: 85vh;
    overflow: visible;
    margin: auto;
    position: relative;
    transform: translateZ(0);
}

.modal-content {
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 24px 24px 20px;
    border-bottom: 1px solid var(--border);
}

.modal-close {
    background: none;
    border: none;
    color: var(--muted);
    font-size: 1.2rem;
    cursor: pointer;
    padding: 8px;
    border-radius: var(--radius-sm);
    transition: all .2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-close:hover {
    background: var(--bg2);
    color: var(--ink);
}

.modal-body {
    padding: 24px;
    overflow: visible;
}

.loading-spinner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 40px;
    color: var(--muted);
    font-size: 1rem;
}

.loading-spinner i {
    font-size: 1.5rem;
}

/* Form styles inside modal */
.modal-body .booking-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.modal-body .form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 16px;
}

.modal-body .form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.modal-body .form-label {
    font-weight: 600;
    color: var(--ink);
    font-size: .85rem;
    display: flex;
    align-items: center;
    gap: 6px;
}

.modal-body .form-label i {
    color: var(--khaki-dark);
    font-size: .8rem;
    width: 14px;
}

.modal-body .form-input,
.modal-body .form-select {
    padding: 10px 14px;
    border: 2px solid var(--border);
    border-radius: var(--radius-sm);
    font-size: .85rem;
    font-family: 'Outfit', sans-serif;
    transition: all .2s ease;
    background: var(--white);
    color: var(--ink);
}

.modal-body .form-input:focus,
.modal-body .form-select:focus {
    outline: none;
    border-color: var(--khaki);
    box-shadow: 0 0 0 3px rgba(195, 176, 145, .12);
}

.modal-body .form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}

.modal-body .btn {
    padding: 10px 20px;
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: .85rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all .2s ease;
    min-width: 100px;
    justify-content: center;
}

.modal-body .btn--primary {
    background: var(--khaki);
    color: var(--white);
    box-shadow: 0 2px 4px rgba(195, 176, 145, .2);
}

.modal-body .btn--primary:hover {
    background: var(--khaki-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(195, 176, 145, .3);
}

.modal-body .btn--secondary {
    background: var(--bg2);
    color: var(--text-dim);
    border: 2px solid var(--border);
}

.modal-body .btn--secondary:hover {
    background: var(--bg3);
    color: var(--ink);
    border-color: var(--muted);
}

/* Modal error message */
.modal-body .error-message {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px;
    background: var(--c-red-bg);
    border: 2px solid var(--c-red);
    border-radius: var(--radius);
    margin-bottom: 20px;
}

.modal-body .error-icon {
    color: var(--c-red);
    font-size: 1.1rem;
    flex-shrink: 0;
    margin-top: 2px;
}

.modal-body .error-content h4 {
    color: var(--c-red);
    font-weight: 600;
    margin-bottom: 6px;
    font-size: .9rem;
}

.modal-body .error-content ul {
    margin: 0;
    padding-left: 20px;
    color: var(--c-red);
}

.modal-body .error-content li {
    margin-bottom: 4px;
    font-size: .8rem;
}

/* Responsive modal */
@media (max-width: 768px) {
    .modal-container {
        max-width: 95%;
        max-height: 95vh;
    }
    
    .modal-header {
        padding: 20px 20px 16px;
    }
    
    .modal-body {
        padding: 20px;
    }
    
    .modal-body .form-grid {
        grid-template-columns: 1fr;
    }
    
    .modal-body .form-actions {
        flex-direction: column;
    }
    
    .modal-body .btn {
        width: 100%;
    }
}

/* Delete Modal Styles */
.delete-confirmation {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
}

.delete-icon {
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--c-red-bg);
    color: var(--c-red);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.delete-content h3 {
    color: var(--ink);
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 8px;
}

.delete-content p {
    color: var(--muted);
    font-size: .9rem;
    line-height: 1.5;
    margin-bottom: 16px;
}

.delete-details {
    background: var(--bg2);
    border-radius: var(--radius-sm);
    padding: 12px 16px;
    font-size: .85rem;
}

.delete-details strong {
    color: var(--ink);
    font-weight: 600;
}

.modal-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    padding-top: 20px;
    border-top: 1px solid var(--border);
}

.delete-form {
    display: inline-block;
}

.btn--danger {
    background: var(--c-red);
    color: var(--white);
    box-shadow: 0 2px 4px rgba(239, 68, 68, .2);
}

.btn--danger:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(239, 68, 68, .3);
}

.btn--danger:disabled {
    background: var(--muted);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.btn--export {
    background: var(--c-blue);
    color: var(--white);
    box-shadow: 0 2px 4px rgba(59, 130, 246, .2);
}

.btn--export:hover {
    background: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(59, 130, 246, .3);
}

/* Show Modal Content Styles */
#showModalBody .booking-status-card {
    background: linear-gradient(135deg, var(--khaki-bg), var(--bg2));
    border-radius: var(--radius);
    padding: 24px;
    margin-bottom: 32px;
    border: 1px solid var(--border);
}

#showModalBody .status-header {
    display: flex;
    align-items: center;
    gap: 16px;
}

#showModalBody .status-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: var(--khaki);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    box-shadow: 0 4px 12px rgba(195, 176, 145, .3);
}

#showModalBody .status-info {
    flex: 1;
}

#showModalBody .status-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 8px;
}

#showModalBody .status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: .8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

#showModalBody .status-badge--pending {
    background: var(--c-amber-bg);
    color: var(--c-amber);
}

#showModalBody .status-badge--confirmed {
    background: var(--c-green-bg);
    color: var(--c-green);
}

#showModalBody .status-badge--cancelled {
    background: var(--c-red-bg);
    color: var(--c-red);
}

#showModalBody .status-badge--completed {
    background: var(--c-blue-bg);
    color: var(--c-blue);
}

/* Details Grid */
#showModalBody .details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

#showModalBody .details-section {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px;
}

#showModalBody .section-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

#showModalBody .section-title i {
    color: var(--khaki-dark);
    font-size: .9rem;
}

#showModalBody .details-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

#showModalBody .detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
}

#showModalBody .detail-item:last-child {
    border-bottom: none;
}

#showModalBody .detail-label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--muted);
    font-size: .9rem;
    font-weight: 500;
}

#showModalBody .detail-label i {
    color: var(--khaki-dark);
    font-size: .8rem;
    width: 16px;
}

#showModalBody .detail-value {
    color: var(--ink);
    font-weight: 600;
    font-size: .9rem;
    text-align: right;
}

#showModalBody .amount-paid {
    color: var(--c-green);
    font-size: 1.1rem;
    font-weight: 700;
}

#showModalBody .payment-status {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: .75rem;
    font-weight: 600;
}

#showModalBody .payment-status--paid {
    background: var(--c-green-bg);
    color: var(--c-green);
}

#showModalBody .payment-status--unpaid {
    background: var(--c-red-bg);
    color: var(--c-red);
}

/* Action Buttons */
#showModalBody .show-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    padding-top: 24px;
    border-top: 1px solid var(--border);
}

#showModalBody .btn {
    padding: 12px 24px;
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: .9rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all .2s ease;
    min-width: 120px;
    justify-content: center;
}

#showModalBody .btn--primary {
    background: var(--khaki);
    color: var(--white);
    box-shadow: 0 2px 4px rgba(195, 176, 145, .2);
}

#showModalBody .btn--primary:hover {
    background: var(--khaki-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(195, 176, 145, .3);
}

#showModalBody .btn--secondary {
    background: var(--bg2);
    color: var(--text-dim);
    border: 2px solid var(--border);
}

#showModalBody .btn--secondary:hover {
    background: var(--bg3);
    color: var(--ink);
    border-color: var(--muted);
}

#showModalBody .btn--danger {
    background: var(--c-red);
    color: var(--white);
    box-shadow: 0 2px 4px rgba(239, 68, 68, .2);
}

#showModalBody .btn--danger:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(239, 68, 68, .3);
}

/* Responsive for Show Modal */
@media (max-width: 768px) {
    #showModalBody .details-grid {
        grid-template-columns: 1fr;
    }
    
    #showModalBody .show-actions {
        flex-direction: column;
    }
    
    #showModalBody .btn {
        width: 100%;
    }
    
    #showModalBody .status-header {
        flex-direction: column;
        text-align: center;
        gap: 12px;
    }
    
    #showModalBody .detail-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    
    #showModalBody .detail-value {
        text-align: left;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Modal functionality
function openEditModal(bookingId) {
    const modal = document.getElementById('editModal');
    const modalBody = document.getElementById('modalBody');
    
    // Show modal with loading
    modal.classList.add('show');
    modalBody.innerHTML = `
        <div class="loading-spinner">
            <i class="fa-solid fa-spinner fa-spin"></i>
            <span>Loading...</span>
        </div>
    `;
    
    // Load edit form via AJAX
    fetch(`/admin/bookings/${bookingId}/edit`)
        .then(response => response.text())
        .then(html => {
            // Extract the form content from the response
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const formContent = doc.querySelector('.booking-form') || doc.querySelector('form');
            
            if (formContent) {
                modalBody.innerHTML = formContent.outerHTML;
                // Re-bind form submission
                bindModalForm(bookingId);
            } else {
                modalBody.innerHTML = '<div class="error-message"><div class="error-icon"><i class="fa-solid fa-exclamation-triangle"></i></div><div class="error-content"><h4>Error</h4><p>Unable to load edit form.</p></div></div>';
            }
        })
        .catch(error => {
            modalBody.innerHTML = '<div class="error-message"><div class="error-icon"><i class="fa-solid fa-exclamation-triangle"></i></div><div class="error-content"><h4>Error</h4><p>Unable to load edit form. Please try again.</p></div></div>';
        });
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.remove('show');
}

// Delete modal functionality
function openDeleteModal(bookingId, bookingRef, userName, busName) {
    const modal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const deleteDetails = document.getElementById('deleteDetails');
    
    // Set form action
    deleteForm.action = `/admin/bookings/${bookingId}`;
    
    // Show booking details
    deleteDetails.innerHTML = `
        <div><strong>Booking Reference:</strong> ${bookingRef}</div>
        <div><strong>User:</strong> ${userName}</div>
        <div><strong>Bus:</strong> ${busName}</div>
    `;
    
    // Show modal
    modal.classList.add('show');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('show');
}

// Show modal functionality
function openShowModal(bookingId) {
    const modal = document.getElementById('showModal');
    const modalBody = document.getElementById('showModalBody');
    
    // Show modal with loading
    modal.classList.add('show');
    modalBody.innerHTML = `
        <div class="loading-spinner">
            <i class="fa-solid fa-spinner fa-spin"></i>
            <span>Loading...</span>
        </div>
    `;
    
    // Load booking details via AJAX
    fetch(`/admin/bookings/${bookingId}`)
        .then(response => response.text())
        .then(html => {
            // Extract the content from the response
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const panelBody = doc.querySelector('.panel-body');
            
            if (panelBody) {
                modalBody.innerHTML = panelBody.innerHTML;
                // Re-bind modal buttons within the loaded content
                bindShowModalButtons(bookingId);
            } else {
                modalBody.innerHTML = '<div class="error-message"><div class="error-icon"><i class="fa-solid fa-exclamation-triangle"></i></div><div class="error-content"><h4>Error</h4><p>Unable to load booking details.</p></div></div>';
            }
        })
        .catch(error => {
            modalBody.innerHTML = '<div class="error-message"><div class="error-icon"><i class="fa-solid fa-exclamation-triangle"></i></div><div class="error-content"><h4>Error</h4><p>Unable to load booking details. Please try again.</p></div></div>';
        });
}

function closeShowModal() {
    const modal = document.getElementById('showModal');
    modal.classList.remove('show');
}

function bindShowModalButtons(bookingId) {
    // Find and bind edit button in the modal
    const editBtn = document.querySelector('#showModalBody button[onclick*="openEditModal"]');
    if (editBtn) {
        editBtn.setAttribute('onclick', `closeShowModal(); openEditModal(${bookingId})`);
    }
    
    // Find and bind delete button in the modal
    const deleteBtn = document.querySelector('#showModalBody button[onclick*="openDeleteModal"]');
    if (deleteBtn) {
        const onclick = deleteBtn.getAttribute('onclick');
        // Extract the booking details from the onclick attribute
        const matches = onclick.match(/openDeleteModal\(([^)]+)\)/);
        if (matches) {
            deleteBtn.setAttribute('onclick', `closeShowModal(); openDeleteModal(${matches[1]})`);
        }
    }
    
    // Add export button to modal actions
    const modalActions = document.querySelector('#showModalBody .show-actions');
    if (modalActions && !modalActions.querySelector('.export-btn')) {
        const exportBtn = document.createElement('a');
        exportBtn.href = `/admin/bookings/${bookingId}/export`;
        exportBtn.className = 'btn btn--export export-btn';
        exportBtn.innerHTML = '<i class="fa-solid fa-download"></i> Export Booking';
        exportBtn.target = '_blank';
        modalActions.insertBefore(exportBtn, modalActions.firstChild);
    }
}

function bindModalForm(bookingId) {
    const form = document.querySelector('#modalBody form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Updating...';
            submitBtn.disabled = true;
            
            // Submit form via AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'text/html'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Check if there are validation errors
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const errorElements = doc.querySelectorAll('.error-message');
                
                if (errorElements.length > 0) {
                    // Show errors in modal
                    const modalBody = document.getElementById('modalBody');
                    modalBody.innerHTML = doc.querySelector('.booking-form').outerHTML;
                    bindModalForm(bookingId);
                } else {
                    // Success - close modal and refresh page
                    closeEditModal();
                    window.location.reload();
                }
            })
            .catch(error => {
                // Show error
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                const modalBody = document.getElementById('modalBody');
                modalBody.innerHTML = '<div class="error-message"><div class="error-icon"><i class="fa-solid fa-exclamation-triangle"></i></div><div class="error-content"><h4>Error</h4><p>Failed to update booking. Please try again.</p></div></div>';
            });
        });
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('editModal');
    if (e.target === modal) {
        closeEditModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
        closeDeleteModal();
        closeShowModal();
    }
});

// Handle delete form submission
document.getElementById('deleteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Deleting...';
    submitBtn.disabled = true;
    
    // Submit form
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'text/html'
        }
    })
    .then(response => response.text())
    .then(html => {
        // Close modal and refresh page on success
        closeDeleteModal();
        window.location.reload();
    })
    .catch(error => {
        // Show error
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        alert('Failed to delete booking. Please try again.');
    });
});
</script>
@endpush
