<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Service;
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
        $services = Service::where('is_available', true)->get();
        return view('rooms.booking', compact('room', 'services'));
    }

    public function processBooking(Request $request, Room $room)
    {
        $request->validate([
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:' . $room->capacity,
            'special_requests' => 'nullable|string|max:500',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
            'service_quantity' => 'nullable|array',
            'service_quantity.*' => 'integer|min:1|max:5'
        ]);

        // Check if room is available for these dates
        $isAvailable = !Booking::where('room_id', $room->id)
            ->where(function($query) use ($request) {
                $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                    ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                    ->orWhere(function($q) use ($request) {
                        $q->where('check_in', '<=', $request->check_in)
                          ->where('check_out', '>=', $request->check_out);
                    });
            })->exists();

        if (!$isAvailable) {
            return back()->withErrors(['message' => 'Room is not available for these dates']);
        }

        // Calculate total nights and room price
        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);
        
        if ($nights < 1) {
            return back()->withErrors(['message' => 'Minimum stay is 1 night']);
        }

        // Calculate room total
        $roomTotal = $room->price_per_night * $nights;

        // Calculate services total
        $servicesTotal = 0;
        $selectedServices = [];
        
        if ($request->has('services')) {
            $services = Service::whereIn('id', $request->services)->get();
            foreach ($services as $service) {
                $quantity = (int) $request->input("service_quantity.{$service->id}", 1);
                
                // For services that might need to be multiplied by nights (like breakfast)
                $serviceTotal = $service->price * $quantity;
                if ($service->category === 'dining' && $service->name === 'In-Room Breakfast') {
                    $serviceTotal *= $nights; // Multiply by number of nights for breakfast
                }
                
                $selectedServices[] = [
                    'service_id' => $service->id,
                    'quantity' => $quantity,
                    'price' => $serviceTotal
                ];
                
                $servicesTotal += $serviceTotal;
            }
        }

        // Calculate final total
        $totalPrice = $roomTotal + $servicesTotal;

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

        // Attach services to booking
        foreach ($selectedServices as $service) {
            $booking->services()->attach($service['service_id'], [
                'quantity' => $service['quantity'],
                'scheduled_at' => $request->check_in,
                'notes' => null
            ]);
        }

        return redirect()->route('bookings.confirmation', $booking)
            ->with('success', 'Your booking has been submitted successfully!');
    }
} 