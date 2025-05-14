@extends('layouts.app')

@section('content')
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Please login to complete your booking.</p>
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <div class="mt-3">
                    <p class="mb-0">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                    <p class="mb-0">Forgot your password? <a href="{{ route('password.request') }}">Reset it here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

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

                    <form action="{{ route('rooms.process-booking', $room) }}" method="POST" id="bookingForm">
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

                            <!-- Optional Services -->
                            <div class="col-12">
                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Optional Services</h5>
                                        <div class="row g-3">
                                            @foreach($services->groupBy('category') as $category => $categoryServices)
                                                <div class="col-12">
                                                    <h6 class="mb-3 text-uppercase small">{{ App\Models\Service::CATEGORIES[$category] }}</h6>
                                                    @foreach($categoryServices as $service)
                                                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                                                            <div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input service-checkbox" 
                                                                           type="checkbox" 
                                                                           name="services[]" 
                                                                           value="{{ $service->id }}" 
                                                                           id="service{{ $service->id }}"
                                                                           data-price="{{ $service->price }}">
                                                                    <label class="form-check-label" for="service{{ $service->id }}">
                                                                        <strong>{{ $service->name }}</strong>
                                                                        <br>
                                                                        <small class="text-muted">{{ $service->description }}</small>
                                                                        <br>
                                                                        <small class="text-muted">Duration: {{ $service->duration }}</small>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="text-end">
                                                                <div class="h6 mb-0">₱{{ number_format($service->price, 2) }}</div>
                                                                @if($service->category != 'laundry')
                                                                    <select class="form-select form-select-sm mt-2 service-quantity" 
                                                                            name="service_quantity[{{ $service->id }}]" 
                                                                            style="width: 100px;"
                                                                            disabled>
                                                                        @for($i = 1; $i <= 5; $i++)
                                                                            <option value="{{ $i }}">{{ $i }}x</option>
                                                                        @endfor
                                                                    </select>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
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
                                        <div id="selectedServices" class="mb-2">
                                            <!-- Selected services will be dynamically added here -->
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
                                        style="background-color: var(--accent-color); color: var(--primary-color);"
                                        onclick="return checkAuthentication(event)">
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
function checkAuthentication(event) {
    @if(!Auth::check())
        event.preventDefault();
        var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
        return false;
    @endif
    return true;
}

// Add login form handling
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal and submit booking form
            bootstrap.Modal.getInstance(document.getElementById('loginModal')).hide();
            document.getElementById('bookingForm').submit();
        } else {
            // Show error message
            alert('Login failed. Please check your credentials.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during login. Please try again.');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const numberOfNightsElement = document.getElementById('numberOfNights');
    const totalAmountElement = document.getElementById('totalAmount');
    const selectedServicesElement = document.getElementById('selectedServices');
    const pricePerNight = {{ $room->price_per_night }};
    const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
    const serviceQuantitySelects = document.querySelectorAll('.service-quantity');

    // Enable/disable quantity select based on checkbox
    serviceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const quantitySelect = this.closest('.d-flex').querySelector('.service-quantity');
            if (quantitySelect) {
                quantitySelect.disabled = !this.checked;
            }
            updatePriceSummary();
        });
    });

    // Update price when quantity changes
    serviceQuantitySelects.forEach(select => {
        select.addEventListener('change', updatePriceSummary);
    });

    function updatePriceSummary() {
        let totalAmount = 0;
        let servicesHtml = '';
        let nights = 0;

        // Calculate room cost
        if (checkInInput.value && checkOutInput.value) {
            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);
            nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
            
            if (nights > 0) {
                numberOfNightsElement.textContent = nights;
                const roomTotal = nights * pricePerNight;
                totalAmount = roomTotal;

                // Add room rate to services display
                servicesHtml += `
                    <div class="d-flex justify-content-between mb-2">
                        <span>Room Rate (${nights} night${nights > 1 ? 's' : ''})</span>
                        <span>₱${roomTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                    </div>
                `;
            }
        }

        // Add selected services
        serviceCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const servicePrice = parseFloat(checkbox.dataset.price);
                const serviceContainer = checkbox.closest('.d-flex');
                const serviceName = serviceContainer.querySelector('.form-check-label strong').textContent;
                const quantitySelect = serviceContainer.querySelector('.service-quantity');
                const quantity = quantitySelect ? parseInt(quantitySelect.value) : 1;
                
                // Calculate service total (handle breakfast multiplication by nights)
                let serviceTotal = servicePrice * quantity;
                if (serviceName.includes('Breakfast') && nights > 0) {
                    serviceTotal *= nights;
                }

                servicesHtml += `
                    <div class="d-flex justify-content-between mb-2">
                        <span>${serviceName} ${quantity > 1 ? `(${quantity}x)` : ''} ${serviceName.includes('Breakfast') ? `(${nights} nights)` : ''}</span>
                        <span>₱${serviceTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                    </div>
                `;

                totalAmount += serviceTotal;
            }
        });

        // Update services display
        selectedServicesElement.innerHTML = servicesHtml;

        // Update total amount
        totalAmountElement.textContent = '₱' + totalAmount.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
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