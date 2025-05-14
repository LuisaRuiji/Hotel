@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Welcome, {{ Auth::user()->name }}</h2>
                
                <!-- Current Booking Status -->
                @if($currentBooking)
                <div class="mb-8">
                    <div class="card bg-primary/5 border border-primary/20">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-primary">Current Stay</h3>
                                <span class="px-3 py-1 text-sm rounded-full bg-primary/10 text-primary">
                                    Room {{ $currentBooking->room_number }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Check-in</p>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $currentBooking->check_in_date->format('M d, Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Check-out</p>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $currentBooking->check_out_date->format('M d, Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Amount</p>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        ${{ number_format($currentBooking->total_amount, 2) }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex space-x-4">
                                <a href="{{ route('customer.service-request') }}" class="btn btn-primary">
                                    Request Service
                                </a>
                                <a href="{{ route('customer.extend-stay') }}" class="btn btn-secondary">
                                    Extend Stay
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Quick Actions -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('customer.book-room') }}" class="card hover:shadow-lg transition-shadow p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-gray-900 dark:text-white font-medium">Book a Room</span>
                        </a>
                        
                        <a href="{{ route('customer.view-rooms') }}" class="card hover:shadow-lg transition-shadow p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="text-gray-900 dark:text-white font-medium">View Rooms</span>
                        </a>
                        
                        <a href="{{ route('customer.special-requests') }}" class="card hover:shadow-lg transition-shadow p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            <span class="text-gray-900 dark:text-white font-medium">Special Requests</span>
                        </a>
                    </div>
                </div>

                <!-- Booking History -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Booking History</h3>
                    <div class="card">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Room</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookingHistory ?? [] as $booking)
                                    <tr>
                                        <td>{{ $booking->room_number }}</td>
                                        <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                                        <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                                        <td>${{ number_format($booking->total_amount, 2) }}</td>
                                        <td>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($booking->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 
                                                   'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-gray-500">No booking history found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Special Offers -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Special Offers</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($specialOffers ?? [] as $offer)
                        <div class="card">
                            <div class="relative">
                                <img src="{{ $offer->image_url }}" alt="{{ $offer->title }}" 
                                     class="w-full h-48 object-cover rounded-t-lg">
                                <div class="absolute top-2 right-2 px-3 py-1 bg-red-500 text-white rounded-full text-sm">
                                    Save {{ $offer->discount }}%
                                </div>
                            </div>
                            <div class="p-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $offer->title }}
                                </h4>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">
                                    {{ $offer->description }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <p class="text-sm text-gray-500">
                                        Valid until {{ $offer->valid_until->format('M d, Y') }}
                                    </p>
                                    <a href="{{ route('customer.book-offer', $offer) }}" class="btn btn-primary">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-2 text-center py-4 text-gray-500">
                            No special offers available at the moment
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 