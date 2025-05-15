<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get current booking (active or upcoming)
        $currentBooking = Booking::where('user_id', $user->id)
            ->where(function($query) {
                $today = Carbon::today();
                $query->where(function($q) use ($today) {
                    $q->where('check_in_date', '<=', $today)
                      ->where('check_out_date', '>=', $today);
                })->orWhere(function($q) use ($today) {
                    $q->where('check_in_date', '>', $today)
                      ->orderBy('check_in_date', 'asc');
                });
            })
            ->first();

        // Get booking history (all bookings)
        $bookingHistory = Booking::where('user_id', $user->id)
            ->with('room')
            ->orderByRaw("FIELD(status, 'pending', 'checked_in', 'completed', 'cancelled') ASC")
            ->orderBy('check_in_date', 'desc')
            ->get();

        // Get available rooms
        $availableRooms = Room::where('is_available', true)
            ->orderBy('price_per_night')
            ->take(3)
            ->get();

        return view('Dashboards.Customer.dashboard', compact('currentBooking', 'bookingHistory', 'availableRooms'));
    }
} 