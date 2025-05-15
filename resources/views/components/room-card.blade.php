@props(['room'])

<div class="card h-100 border-0 shadow-sm room-card">
    <x-room-image 
        :image="$room->image_url"
        :alt="$room->type . ' - Room ' . $room->room_number"
    />
    <div class="card-body d-flex flex-column">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h5 class="card-title mb-0" style="color: var(--primary-color);">{{ $room->type }}</h5>
            <span class="badge" style="background-color: var(--accent-color);">Room {{ $room->room_number }}</span>
        </div>
        <p class="card-text small text-muted mb-3">{{ Str::limit($room->description, 100) }}</p>
        <div class="room-features small mb-3">
            <div class="d-flex align-items-center mb-2">
                <i class="fas fa-user-friends me-2"></i>
                <span>Up to {{ $room->capacity }} guests</span>
            </div>
            @if($room->has_view)
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-mountain me-2"></i>
                    <span>Scenic View</span>
                </div>
            @endif
            @if(!$room->is_smoking)
                <div class="d-flex align-items-center">
                    <i class="fas fa-smoking-ban me-2"></i>
                    <span>Non-smoking</span>
                </div>
            @endif
        </div>
        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="h5 mb-0" style="color: var(--accent-color);">₱{{ number_format($room->price_per_night, 2) }}</span>
                    <span class="small text-muted">/night</span>
                </div>
                <a href="{{ route('rooms.book', $room) }}" class="btn btn-sm" style="background-color: var(--primary-color); color: white;">Book Now</a>
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