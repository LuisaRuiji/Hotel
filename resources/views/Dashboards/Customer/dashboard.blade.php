@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h2 class="mb-4 fw-bold">Welcome, {{ Auth::user()->name }}</h2>

            <!-- Current Booking Status -->
            @if($currentBooking)
            <div class="card shadow-sm mb-5 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Current Stay</span>
                    <span class="badge bg-light text-primary">Room {{ $currentBooking->room_number }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="text-muted small">Check-in</div>
                            <div class="fw-semibold">{{ $currentBooking->check_in_date->format('M d, Y') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Check-out</div>
                            <div class="fw-semibold">{{ $currentBooking->check_out_date->format('M d, Y') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Total Amount</div>
                            <div class="fw-semibold text-success">${{ number_format($currentBooking->total_amount, 2) }}</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('customer.service-request') }}" class="btn btn-outline-primary">Request Service</a>
                        <a href="{{ route('customer.extend-stay') }}" class="btn btn-primary">Extend Stay</a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Available Rooms -->
            <div class="mb-5">
                <h3 class="mb-3 fw-semibold">Available Rooms</h3>
                <div class="row g-4">
                    @forelse($availableRooms as $room)
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ $room->image_url ?? asset('images/rooms/default-room.jpg') }}" alt="{{ $room->type }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-1">{{ $room->type }}</h5>
                                    <div class="mb-2 text-muted">Room {{ $room->room_number }}</div>
                                    <div class="mb-2 fw-semibold text-primary">${{ number_format($room->price_per_night, 2) }} <span class="text-muted small">/night</span></div>
                                    <a href="{{ route('customer.book-room', $room) }}" class="btn btn-success mt-auto">Book Now</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted">No rooms available at the moment.</div>
                    @endforelse
                </div>
            </div>

            <!-- Booking History -->
            <div class="mb-5">
                <h3 class="mb-3 fw-semibold">Booking History</h3>
                <div class="card shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
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
                                    <td>{{ $booking->room->room_number }}</td>
                                    <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                                    <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                                    <td>₱{{ number_format($booking->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge 
                                            {{ $booking->status === 'completed' ? 'bg-success' : 
                                               ($booking->status === 'pending' ? 'bg-warning' :
                                               ($booking->status === 'checked_in' ? 'bg-info' :
                                               ($booking->status === 'cancelled' ? 'bg-danger' : 'bg-secondary'))) }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No booking history found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Special Offers -->
            <div>
                <h3 class="mb-3 fw-semibold">Special Offers</h3>
                <div class="row g-4">
                    @forelse($specialOffers ?? [] as $offer)
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="position-relative">
                                <img src="{{ $offer->image_url }}" alt="{{ $offer->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                <span class="position-absolute top-0 end-0 m-2 badge bg-danger">Save {{ $offer->discount }}%</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $offer->title }}</h5>
                                <p class="card-text text-muted">{{ $offer->description }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <small class="text-muted">Valid until {{ $offer->valid_until->format('M d, Y') }}</small>
                                    <a href="{{ route('customer.book-offer', $offer) }}" class="btn btn-outline-primary btn-sm">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted py-4">
                        No special offers available at the moment
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 