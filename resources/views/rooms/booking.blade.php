@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Booking Header -->
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" style="color: var(--primary-color);">Book Your Stay</h2>
                <p class="lead text-muted">Complete your reservation for {{ $room->type }} - Room {{ $room->room_number }}</p>
            </div>

            <!-- Room Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <img src="{{ $room->image_url }}" 
                                 alt="{{ $room->type }}" 
                                 class="img-fluid rounded"
                                 style="height: 150px; width: 100%; object-fit: cover;"
                                 onerror="this.onerror=null; this.src='{{ asset('images/room-placeholder.jpg') }}'">
                        </div>
                        <div class="col-md-8">
                            <h4 class="card-title mb-3" style="color: var(--primary-color);">{{ $room->type }}</h4>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Price per night</span>
                                <span class="h5 mb-0" style="color: var(--accent-color);">₱{{ number_format($room->price_per_night, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Max Guests</span>
                                <span>{{ $room->capacity }} persons</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('rooms.process-booking', $room) }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <!-- Dates -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="check_in" class="form-label">Check-in Date</label>
                                    <input type="date" 
                                           class="form-control form-control-lg @error('check_in') is-invalid @enderror" 
                                           id="check_in" 
                                           name="check_in"
                                           value="{{ old('check_in') }}"
                                           min="{{ date('Y-m-d') }}"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="check_out" class="form-label">Check-out Date</label>
                                    <input type="date" 
                                           class="form-control form-control-lg @error('check_out') is-invalid @enderror" 
                                           id="check_out" 
                                           name="check_out"
                                           value="{{ old('check_out') }}"
                                           required>
                                </div>
                            </div>

                            <!-- Number of Guests -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="guests" class="form-label">Number of Guests</label>
                                    <select class="form-select form-select-lg @error('guests') is-invalid @enderror" 
                                            id="guests" 
                                            name="guests"
                                            required>
                                        @for($i = 1; $i <= $room->capacity; $i++)
                                            <option value="{{ $i }}" {{ old('guests') == $i ? 'selected' : '' }}>
                                                {{ $i }} {{ Str::plural('Guest', $i) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <!-- Special Requests -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="special_requests" class="form-label">Special Requests</label>
                                    <textarea class="form-control @error('special_requests') is-invalid @enderror" 
                                              id="special_requests" 
                                              name="special_requests" 
                                              rows="3" 
                                              placeholder="Any special requests? Let us know!">{{ old('special_requests') }}</textarea>
                                    <div class="form-text">Optional: Add any special requests or requirements</div>
                                </div>
                            </div>

                            <!-- Price Summary -->
                            <div class="col-12">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Price Summary</h5>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Room Rate (per night)</span>
                                            <span>₱{{ number_format($room->price_per_night, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Number of Nights</span>
                                            <span id="numberOfNights">-</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <span class="h5 mb-0">Total Amount</span>
                                            <span class="h5 mb-0" id="totalAmount">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <button type="submit" 
                                        class="btn btn-lg w-100" 
                                        style="background-color: var(--accent-color); color: var(--primary-color);">
                                    Confirm Booking
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const numberOfNightsElement = document.getElementById('numberOfNights');
    const totalAmountElement = document.getElementById('totalAmount');
    const pricePerNight = {{ $room->price_per_night }};

    function updatePriceSummary() {
        if (checkInInput.value && checkOutInput.value) {
            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);
            const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
            
            if (nights > 0) {
                numberOfNightsElement.textContent = nights;
                totalAmountElement.textContent = '₱' + (nights * pricePerNight).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            } else {
                numberOfNightsElement.textContent = '-';
                totalAmountElement.textContent = '-';
            }
        }
    }

    checkInInput.addEventListener('change', function() {
        checkOutInput.min = this.value;
        updatePriceSummary();
    });

    checkOutInput.addEventListener('change', updatePriceSummary);
});
</script>
@endpush
@endsection 