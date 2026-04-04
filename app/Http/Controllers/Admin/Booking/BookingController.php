<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    // List all bookings
    public function index()
    {
        $bookings = Booking::latest()->paginate(10);
        return view('admin.booking_management.booking.index', compact('bookings'));
    }

    // Show form to create a booking
    public function create()
    {
        return view('admin.booking_management.booking.create');
    }

    // Store new booking
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'bus_id' => 'required|exists:buses,id',
            'seat_number' => 'nullable|string',
            'seat_type' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'departure_time' => 'nullable|date',
            'arrival_time' => 'nullable|date',
            'amount_paid' => 'nullable|numeric',
            'payment_status' => 'nullable|string',
        ]);

        Booking::create($data);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully.');
    }

    // Show single booking
    public function show(Booking $booking)
    {
        return view('admin.booking_management.booking.show', compact('booking'));
    }

    // Export booking details as PDF
    public function export(Booking $booking)
    {
        // For now, we'll create a simple text-based receipt
        // In a real implementation, you might use DOMPDF or similar package
        
        $content = "BOOKING RECEIPT\n";
        $content .= "================\n\n";
        $content .= "Booking Reference: {$booking->booking_reference}\n";
        $content .= "Status: " . ucfirst($booking->status) . "\n";
        $content .= "Payment Status: " . ucfirst($booking->payment_status) . "\n";
        $content .= "Amount Paid: $" . $booking->amount_paid . "\n\n";
        $content .= "Passenger Information:\n";
        $content .= "Name: " . ($booking->user->name ?? 'N/A') . "\n\n";
        $content .= "Trip Details:\n";
        $content .= "Bus: " . ($booking->bus->name ?? 'N/A') . "\n";
        $content .= "Seat: " . ($booking->seat_number ?? 'N/A') . " (" . $booking->seat_type . ")\n";
        $content .= "Departure: " . ($booking->departure_time?->format('d M Y, H:i') ?? 'N/A') . "\n";
        $content .= "Arrival: " . ($booking->arrival_time?->format('d M Y, H:i') ?? 'N/A') . "\n\n";
        $content .= "Generated on: " . now()->format('d M Y, H:i') . "\n";
        
        $filename = "booking_{$booking->booking_reference}_receipt.txt";
        
        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }

    // Show form to edit booking
    public function edit(Booking $booking)
    {
        return view('admin.booking_management.booking.edit', compact('booking'));
    }

    // Update booking
    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'seat_number' => 'nullable|string',
            'seat_type' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'departure_time' => 'nullable|date',
            'arrival_time' => 'nullable|date',
            'amount_paid' => 'nullable|numeric',
            'payment_status' => 'nullable|string',
        ]);

        $booking->update($data);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
    }

    // Delete booking
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }

    // Status views
    public function pending()
    {
        $pendingBookings = Booking::where('status', 'pending')->latest()->paginate(10);
        return view('admin.booking_management.status.pending', compact('pendingBookings'));
    }

    public function completed()
    {
        $completedBookings = Booking::where('status', 'completed')->latest()->paginate(10);
        return view('admin.booking_management.status.completed', compact('completedBookings'));
    }

    public function cancelled()
    {
        $cancelledBookings = Booking::where('status', 'cancelled')->latest()->paginate(10);
        return view('admin.booking_management.status.cancelled', compact('cancelledBookings'));
    }


    // Notifications placeholder
    public function notifications()
    {
        // Implement logic to list or resend booking notifications
        return view('admin.booking_management.booking.notifications');
    }
}
