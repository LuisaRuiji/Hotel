@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h4 class="mb-0">Room Management</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('receptionist.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Rooms</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4">
        <!-- Status Summary Cards -->
        <div class="col-12">
            <div class="row g-3">
                <div class="col-sm-6 col-md-3">
                    <div class="card bg-success bg-opacity-10 border-success border-opacity-25">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-success fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-title mb-1">Available</h6>
                                    <h3 class="mb-0">{{ $availableRooms }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card bg-danger bg-opacity-10 border-danger border-opacity-25">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-bed text-danger fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-title mb-1">Occupied</h6>
                                    <h3 class="mb-0">{{ $occupiedRooms }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card bg-warning bg-opacity-10 border-warning border-opacity-25">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-clock text-warning fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-title mb-1">Reserved</h6>
                                    <h3 class="mb-0">{{ $reservedRooms }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card bg-info bg-opacity-10 border-info border-opacity-25">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-broom text-info fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-title mb-1">Cleaning</h6>
                                    <h3 class="mb-0">{{ $cleaningRooms }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rooms List -->
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">All Rooms</h5>
                        </div>
                        <div class="col-auto">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchRoom" placeholder="Search room...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Room</th>
                                    <th>Type</th>
                                    <th>Floor</th>
                                    <th>Status</th>
                                    <th>Current Guest</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="room-number fw-bold">{{ $room->room_number }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $room->type }}</td>
                                    <td>{{ floor($room->room_number / 100) }}</td>
                                    <td>
                                        @if($room->status === 'available')
                                            <span class="badge bg-success">Available</span>
                                        @elseif($room->status === 'occupied')
                                            <span class="badge bg-danger">Occupied</span>
                                        @elseif($room->status === 'reserved')
                                            <span class="badge bg-warning">Reserved</span>
                                        @elseif($room->status === 'cleaning')
                                            <span class="badge bg-info">Cleaning</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($room->currentBooking)
                                            {{ $room->currentBooking->user->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($room->currentBooking)
                                            {{ $room->currentBooking->check_in_date->format('M d, Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($room->currentBooking)
                                            {{ $room->currentBooking->check_out_date->format('M d, Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            @if($room->status === 'available')
                                                <a href="{{ route('receptionist.bookings.create', ['room' => $room->id]) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-plus me-1"></i>New Booking
                                                </a>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#roomDetails{{ $room->id }}">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($rooms->hasPages())
                <div class="card-footer bg-white">
                    {{ $rooms->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@foreach($rooms as $room)
<!-- Room Details Modal -->
<div class="modal fade" id="roomDetails{{ $room->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Room {{ $room->room_number }} Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <p class="mb-1 text-muted">Room Type</p>
                        <p class="fw-bold">{{ $room->type }}</p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted">Floor</p>
                        <p class="fw-bold">{{ floor($room->room_number / 100) }}</p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted">Status</p>
                        <p class="fw-bold">
                            @if($room->status === 'available')
                                <span class="text-success">Available</span>
                            @elseif($room->status === 'occupied')
                                <span class="text-danger">Occupied</span>
                            @elseif($room->status === 'reserved')
                                <span class="text-warning">Reserved</span>
                            @elseif($room->status === 'cleaning')
                                <span class="text-info">Cleaning</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted">Price per Night</p>
                        <p class="fw-bold">₱{{ number_format($room->price_per_night, 2) }}</p>
                    </div>
                    @if($room->currentBooking)
                    <div class="col-12">
                        <hr>
                        <h6>Current Booking</h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <p class="mb-1 text-muted">Guest</p>
                                <p class="fw-bold">{{ $room->currentBooking->user->name }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 text-muted">Check-in</p>
                                <p class="fw-bold">{{ $room->currentBooking->check_in_date->format('M d, Y') }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 text-muted">Check-out</p>
                                <p class="fw-bold">{{ $room->currentBooking->check_out_date->format('M d, Y') }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 text-muted">Total Amount</p>
                                <p class="fw-bold">₱{{ number_format($room->currentBooking->total_amount, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                @if($room->status === 'available')
                    <a href="{{ route('receptionist.bookings.create', ['room' => $room->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>New Booking
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@push('styles')
<style>
    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
    }
    
    .table > :not(caption) > * > * {
        padding: 1rem;
    }

    .room-number {
        font-size: 1.1rem;
        color: var(--primary-color);
    }

    .modal-body .text-muted {
        font-size: 0.875rem;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchRoom');
    const tableRows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();

        tableRows.forEach(row => {
            const roomNumber = row.querySelector('.room-number').textContent.toLowerCase();
            const roomType = row.cells[1].textContent.toLowerCase();
            
            if (roomNumber.includes(searchTerm) || roomType.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
@endsection 