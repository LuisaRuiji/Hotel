@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Room Header -->
    <div class="row mb-5">
        <div class="col-lg-8">
            <div class="position-relative rounded-3 overflow-hidden shadow-sm" style="height: 500px;">
                <img src="{{ $room->image_url }}" 
                     alt="{{ $room->type }}" 
                     class="img-cover"
                     onerror="this.onerror=null; this.src='{{ asset('images/room-placeholder.jpg') }}'">
                <div class="position-absolute top-0 start-0 m-4">
                    <span class="badge bg-dark bg-opacity-75 px-3 py-2 rounded-pill">
                        Room {{ $room->room_number }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="card-title h3 mb-4" style="color: var(--primary-color);">{{ $room->type }}</h4>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Price per night</span>
                            <span class="h4 mb-0" style="color: var(--accent-color);">₱{{ number_format($room->price_per_night, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Max Guests</span>
                            <span>{{ $room->capacity }} persons</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Room Status</span>
                            <span class="badge bg-success">Available</span>
                        </div>
                    </div>
                    <a href="{{ route('rooms.book', $room) }}" 
                       class="btn btn-lg w-100 mb-3" 
                       style="background-color: var(--accent-color); color: var(--primary-color);">
                        Book Now
                    </a>
                    <p class="small text-muted text-center mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Free cancellation up to 24 hours before check-in
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Room Details -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <!-- Description -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4" style="color: var(--primary-color);">Room Description</h5>
                    <p class="card-text">{{ $room->description }}</p>
                </div>
            </div>

            <!-- Amenities -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4" style="color: var(--primary-color);">Room Features</h5>
                    <div class="row g-3">
                        @foreach($room->amenities as $amenity)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2" style="color: var(--accent-color);"></i>
                                    <span>{{ $amenity }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Additional Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4" style="color: var(--primary-color);">Room Details</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-building me-3" style="color: var(--accent-color);"></i>
                                <div>
                                    <small class="text-muted d-block">Floor</small>
                                    <span>{{ $room->floor }}F</span>
                                </div>
                            </div>
                        </li>
                        @if($room->has_view)
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-mountain me-3" style="color: var(--accent-color);"></i>
                                <div>
                                    <small class="text-muted d-block">View</small>
                                    <span>City View</span>
                                </div>
                            </div>
                        </li>
                        @endif
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-smoking{{ $room->is_smoking ? '' : '-ban' }} me-3" style="color: var(--accent-color);"></i>
                                <div>
                                    <small class="text-muted d-block">Smoking</small>
                                    <span>{{ $room->is_smoking ? 'Allowed' : 'Not Allowed' }}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Policies -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4" style="color: var(--primary-color);">Policies</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-3" style="color: var(--accent-color);"></i>
                                <div>
                                    <small class="text-muted d-block">Check-in</small>
                                    <span>From 14:00</span>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-3" style="color: var(--accent-color);"></i>
                                <div>
                                    <small class="text-muted d-block">Check-out</small>
                                    <span>Until 12:00</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-shield-alt me-3" style="color: var(--accent-color);"></i>
                                <div>
                                    <small class="text-muted d-block">Cancellation</small>
                                    <span>Free up to 24h before check-in</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 