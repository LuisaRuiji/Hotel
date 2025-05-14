<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    public function bookingForm(Room $room)
    {
        return view('rooms.booking', compact('room'));
    }

    public function processBooking(Request $request, Room $room)
    {
        $request->validate([
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:' . $room->capacity,
            'special_requests' => 'nullable|string|max:500'
        ]);

        // Check if room is available for these dates
        $isAvailable = !Booking::where('room_id', $room->id)
            ->where(function($query) use ($request) {
                $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                    ->orWhereBetween('check_out', [$request->check_in, $request->check_out]);
            })->exists();

        if (!$isAvailable) {
            return back()->withErrors(['message' => 'Room is not available for these dates']);
        }

        // Calculate total nights and price
        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = $room->price_per_night * $nights;

        // Create booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guests' => $request->guests,
            'special_requests' => $request->special_requests,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        return redirect()->route('bookings.confirmation', $booking)
            ->with('success', 'Your booking has been submitted successfully!');
    }
} 