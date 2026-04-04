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

@push('head')
<style>
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
}

.modal-overlay.show {
    display: flex;
}

.modal-container {
    max-width: 800px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-container--small {
    max-width: 500px;
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

.btn {
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

.btn--secondary {
    background: var(--bg2);
    color: var(--text-dim);
    border: 2px solid var(--border);
}

.btn--secondary:hover {
    background: var(--bg3);
    color: var(--ink);
    border-color: var(--muted);
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
                modalBody.innerHTML = '<div class="delete-confirmation"><div class="delete-icon"><i class="fa-solid fa-exclamation-triangle"></i></div><div class="delete-content"><h4>Error</h4><p>Unable to load edit form.</p></div></div>';
            }
        })
        .catch(error => {
            modalBody.innerHTML = '<div class="delete-confirmation"><div class="delete-icon"><i class="fa-solid fa-exclamation-triangle"></i></div><div class="delete-content"><h4>Error</h4><p>Unable to load edit form. Please try again.</p></div></div>';
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
                modalBody.innerHTML = '<div class="delete-confirmation"><div class="delete-icon"><i class="fa-solid fa-exclamation-triangle"></i></div><div class="delete-content"><h4>Error</h4><p>Failed to update booking. Please try again.</p></div></div>';
            });
        });
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');
    if (e.target === editModal) {
        closeEditModal();
    }
    if (e.target === deleteModal) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
        closeDeleteModal();
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
        window.location.href = '/admin/bookings';
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
