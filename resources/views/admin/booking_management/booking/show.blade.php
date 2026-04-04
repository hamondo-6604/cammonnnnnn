@extends('layouts.app')

@section('title', 'Booking Details')

@section('page-title', 'Booking Details')

@section('page-sub', 'View complete booking information')

@section('content')
<div class="dash-panel">
    <div class="panel-head">
        <div>
            <h2 class="panel-title">Booking Details</h2>
            <p class="panel-sub">View complete booking information</p>
        </div>
        <div class="panel-actions">
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="panel-link">
                <i class="fa-solid fa-edit"></i> Edit Booking
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="panel-link">
                <i class="fa-solid fa-arrow-left"></i> Back to Bookings
            </a>
        </div>
    </div>
    <div class="panel-body">
        <!-- Booking Status Card -->
        <div class="booking-status-card">
            <div class="status-header">
                <div class="status-icon">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <div class="status-info">
                    <h3 class="status-title">{{ $booking->booking_reference }}</h3>
                    <span class="status-badge status-badge--{{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Booking Details Grid -->
        <div class="details-grid">
            <!-- Primary Information -->
            <div class="details-section">
                <h4 class="section-title">
                    <i class="fa-solid fa-info-circle"></i> Primary Information
                </h4>
                <div class="details-list">
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fa-solid fa-user"></i> User
                        </span>
                        <span class="detail-value">{{ $booking->user->name ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fa-solid fa-bus"></i> Bus
                        </span>
                        <span class="detail-value">{{ $booking->bus->name ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fa-solid fa-chair"></i> Seat
                        </span>
                        <span class="detail-value">{{ $booking->seat_number ?? '-' }} ({{ $booking->seat_type }})</span>
                    </div>
                </div>
            </div>

            <!-- Schedule Information -->
            <div class="details-section">
                <h4 class="section-title">
                    <i class="fa-solid fa-clock"></i> Schedule Information
                </h4>
                <div class="details-list">
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fa-solid fa-plane-departure"></i> Departure
                        </span>
                        <span class="detail-value">{{ $booking->departure_time?->format('d M Y, H:i') ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fa-solid fa-plane-arrival"></i> Arrival
                        </span>
                        <span class="detail-value">{{ $booking->arrival_time?->format('d M Y, H:i') ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fa-solid fa-calendar-times"></i> Cancelled At
                        </span>
                        <span class="detail-value">{{ $booking->cancelled_at?->format('d M Y, H:i') ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="details-section">
                <h4 class="section-title">
                    <i class="fa-solid fa-credit-card"></i> Payment Information
                </h4>
                <div class="details-list">
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fa-solid fa-dollar-sign"></i> Amount Paid
                        </span>
                        <span class="detail-value amount-paid">${{ $booking->amount_paid }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fa-solid fa-receipt"></i> Payment Status
                        </span>
                        <span class="detail-value payment-status payment-status--{{ $booking->payment_status }}">
                            {{ ucfirst($booking->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="show-actions">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn--secondary">
                <i class="fa-solid fa-arrow-left"></i> Back to Bookings
            </a>
            <button type="button" class="btn btn--primary" onclick="openEditModal({{ $booking->id }})">
                <i class="fa-solid fa-edit"></i> Edit Booking
            </button>
            <button type="button" class="btn btn--danger" 
                    onclick="openDeleteModal({{ $booking->id }}, '{{ $booking->booking_reference }}', '{{ $booking->user->name ?? 'N/A' }}', '{{ $booking->bus->name ?? 'N/A' }}')">
                <i class="fa-solid fa-trash"></i> Delete Booking
            </button>
        </div>
    </div>
</div>

<!-- Include modals from index page -->
@include('admin.booking_management.booking._modals')
@endsection

@push('head')
<style>
/* Booking Status Card */
.booking-status-card {
    background: linear-gradient(135deg, var(--khaki-bg), var(--bg2));
    border-radius: var(--radius);
    padding: 24px;
    margin-bottom: 32px;
    border: 1px solid var(--border);
}

.status-header {
    display: flex;
    align-items: center;
    gap: 16px;
}

.status-icon {
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

.status-info {
    flex: 1;
}

.status-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 8px;
}

.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: .8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge--pending {
    background: var(--c-amber-bg);
    color: var(--c-amber);
}

.status-badge--confirmed {
    background: var(--c-green-bg);
    color: var(--c-green);
}

.status-badge--cancelled {
    background: var(--c-red-bg);
    color: var(--c-red);
}

.status-badge--completed {
    background: var(--c-blue-bg);
    color: var(--c-blue);
}

/* Details Grid */
.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

.details-section {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px;
}

.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-title i {
    color: var(--khaki-dark);
    font-size: .9rem;
}

.details-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--muted);
    font-size: .9rem;
    font-weight: 500;
}

.detail-label i {
    color: var(--khaki-dark);
    font-size: .8rem;
    width: 16px;
}

.detail-value {
    color: var(--ink);
    font-weight: 600;
    font-size: .9rem;
    text-align: right;
}

.amount-paid {
    color: var(--c-green);
    font-size: 1.1rem;
    font-weight: 700;
}

.payment-status {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: .75rem;
    font-weight: 600;
}

.payment-status--paid {
    background: var(--c-green-bg);
    color: var(--c-green);
}

.payment-status--unpaid {
    background: var(--c-red-bg);
    color: var(--c-red);
}

/* Action Buttons */
.show-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    padding-top: 24px;
    border-top: 1px solid var(--border);
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

.btn--primary {
    background: var(--khaki);
    color: var(--white);
    box-shadow: 0 2px 4px rgba(195, 176, 145, .2);
}

.btn--primary:hover {
    background: var(--khaki-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(195, 176, 145, .3);
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

/* Responsive */
@media (max-width: 768px) {
    .details-grid {
        grid-template-columns: 1fr;
    }
    
    .show-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
    
    .status-header {
        flex-direction: column;
        text-align: center;
        gap: 12px;
    }
    
    .detail-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    
    .detail-value {
        text-align: left;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Include modal functions from index page
// These functions are already defined in the index page
</script>
@endpush
