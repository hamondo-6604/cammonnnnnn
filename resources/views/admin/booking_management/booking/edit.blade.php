@extends('layouts.app')

@section('title', 'Edit Booking')

@section('page-title', 'Edit Booking')

@section('page-sub', 'Update booking information and status')

@section('content')
<div class="dash-panel">
    <div class="panel-head">
        <div>
            <h2 class="panel-title">Edit Booking</h2>
            <p class="panel-sub">Update booking information and status</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="panel-link">
            <i class="fa-solid fa-arrow-left"></i> Back to Bookings
        </a>
    </div>
    <div class="panel-body">
        @if ($errors->any())
            <div class="error-message">
                <div class="error-icon">
                    <i class="fa-solid fa-exclamation-triangle"></i>
                </div>
                <div class="error-content">
                    <h4>Please fix the following errors:</h4>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="booking-form">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label for="seat_number" class="form-label">
                        <i class="fa-solid fa-chair"></i> Seat Number
                    </label>
                    <input type="text" id="seat_number" name="seat_number" 
                           value="{{ old('seat_number', $booking->seat_number) }}" 
                           class="form-input" placeholder="Enter seat number">
                </div>

                <div class="form-group">
                    <label for="seat_type" class="form-label">
                        <i class="fa-solid fa-couch"></i> Seat Type
                    </label>
                    <select id="seat_type" name="seat_type" class="form-select">
                        @foreach (['economy','business'] as $type)
                            <option value="{{ $type }}" {{ old('seat_type', $booking->seat_type) == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">
                        <i class="fa-solid fa-flag"></i> Status
                    </label>
                    <select id="status" name="status" class="form-select">
                        @foreach (['pending','confirmed','cancelled','completed'] as $status)
                            <option value="{{ $status }}" {{ old('status', $booking->status) == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="payment_status" class="form-label">
                        <i class="fa-solid fa-credit-card"></i> Payment Status
                    </label>
                    <select id="payment_status" name="payment_status" class="form-select">
                        <option value="unpaid" {{ old('payment_status', $booking->payment_status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="paid" {{ old('payment_status', $booking->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="departure_time" class="form-label">
                        <i class="fa-solid fa-clock"></i> Departure Time
                    </label>
                    <input type="datetime-local" id="departure_time" name="departure_time" 
                           value="{{ old('departure_time', $booking->departure_time?->format('Y-m-d\TH:i')) }}" 
                           class="form-input">
                </div>

                <div class="form-group">
                    <label for="arrival_time" class="form-label">
                        <i class="fa-solid fa-clock"></i> Arrival Time
                    </label>
                    <input type="datetime-local" id="arrival_time" name="arrival_time" 
                           value="{{ old('arrival_time', $booking->arrival_time?->format('Y-m-d\TH:i')) }}" 
                           class="form-input">
                </div>

                <div class="form-group">
                    <label for="amount_paid" class="form-label">
                        <i class="fa-solid fa-dollar-sign"></i> Amount Paid
                    </label>
                    <input type="number" id="amount_paid" name="amount_paid" step="0.01"
                           value="{{ old('amount_paid', $booking->amount_paid) }}" 
                           class="form-input" placeholder="0.00">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn--secondary">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn--primary">
                    <i class="fa-solid fa-save"></i> Update Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('head')
<style>
/* Form Layout */
.booking-form {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-label {
    font-weight: 600;
    color: var(--ink);
    font-size: .9rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-label i {
    color: var(--khaki-dark);
    font-size: .85rem;
    width: 16px;
}

.form-input, .form-select {
    padding: 12px 16px;
    border: 2px solid var(--border);
    border-radius: var(--radius-sm);
    font-size: .9rem;
    font-family: 'Outfit', sans-serif;
    transition: all .2s ease;
    background: var(--white);
    color: var(--ink);
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: var(--khaki);
    box-shadow: 0 0 0 3px rgba(195, 176, 145, .12);
}

.form-input::placeholder {
    color: var(--muted);
}

.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    padding-top: 20px;
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

/* Error Message */
.error-message {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px;
    background: var(--c-red-bg);
    border: 2px solid var(--c-red);
    border-radius: var(--radius);
    margin-bottom: 24px;
}

.error-icon {
    color: var(--c-red);
    font-size: 1.2rem;
    flex-shrink: 0;
    margin-top: 2px;
}

.error-content h4 {
    color: var(--c-red);
    font-weight: 600;
    margin-bottom: 8px;
    font-size: .95rem;
}

.error-content ul {
    margin: 0;
    padding-left: 20px;
    color: var(--c-red);
}

.error-content li {
    margin-bottom: 4px;
    font-size: .85rem;
}

/* Responsive */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
@endpush
