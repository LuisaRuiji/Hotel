@props(['room'])

<div class="card h-100 shadow-sm border-0 room-card">
    <!-- Room Image with Overlay -->
    <div class="position-relative">
        <img src="{{ $room->image_url ?? asset('images/room-placeholder.jpg') }}" 
             class="card-img-top" alt="{{ $room->type }}"
             style="height: 250px; object-fit: cover;"
             onerror="this.onerror=null; this.src='{{ asset('images/room-placeholder.jpg') }}'; this.alt='Room image not available'">
        <div class="position-absolute top-0 end-0 m-3">
            <span class="badge bg-dark bg-opacity-75 px-3 py-2 rounded-pill">
                Room {{ $room->room_number }}
            </span>
        </div>
        @if($room->is_available)
            <div class="position-absolute top-0 start-0 m-3">
                <span class="badge bg-success px-3 py-2 rounded-pill">Available</span>
            </div>
        @endif
    </div>

    <div class="card-body p-4">
        <!-- Room Title and Type -->
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h4 class="card-title h5 text-dark mb-1">{{ $room->type }}</h4>
                <p class="text-muted small mb-0">Standard Room</p>
            </div>
            <!-- Price Badge -->
            <div class="bg-light rounded-3 p-2 text-center" style="background-color: #A7C5BD !important;">
                <div class="fw-bold text-dark" style="color: #2E3B4E !important;">₱{{ number_format($room->price_per_night, 2) }}</div>
                <small class="text-muted">per night</small>
            </div>
        </div>

        <!-- Room Description -->
        <p class="card-text mb-3" style="color: #8E9A92;">{{ $room->description }}</p>

        <!-- Amenities -->
        <div class="mb-4">
            <h6 class="text-dark mb-2 fw-semibold">Room Features</h6>
            <div class="d-flex flex-wrap gap-2">
                @foreach(array_slice($room->amenities, 0, 4) as $amenity)
                    <span class="badge rounded-pill text-dark px-3 py-2" 
                          style="background-color: #F5F7F6;">
                        {{ $amenity }}
                    </span>
                @endforeach
                @if(count($room->amenities) > 4)
                    <span class="badge rounded-pill text-dark px-3 py-2" 
                          style="background-color: #F5F7F6;">
                        +{{ count($room->amenities) - 4 }} more
                    </span>
                @endif
            </div>
        </div>

        <!-- Room Info -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center text-muted">
                <i class="fas fa-user-friends me-2"></i>
                <span>Up to {{ $room->capacity }} guests</span>
            </div>
            @if($room->has_view)
                <div class="d-flex align-items-center text-muted">
                    <i class="fas fa-mountain me-2"></i>
                    <span>City View</span>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="d-grid gap-2">
            <div class="row g-2">
                <div class="col">
                    <a href="{{ route('rooms.show', $room) }}" 
                       class="btn w-100 text-white" 
                       style="background-color: #8E9A92;">
                        View Details
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('rooms.book', $room) }}" 
                       class="btn w-100 text-dark" 
                       style="background-color: #A7C5BD;">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.room-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.room-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
}

.badge {
    font-weight: 500;
}
</style> 