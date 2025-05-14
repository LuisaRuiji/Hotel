@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Receptionist Dashboard</h2>
                
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="card bg-primary/10">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-primary mb-2">Today's Check-ins</h3>
                            <p class="text-3xl font-bold text-primary">{{ $todayCheckins ?? '0' }}</p>
                        </div>
                    </div>
                    
                    <div class="card bg-success/10">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-success mb-2">Today's Check-outs</h3>
                            <p class="text-3xl font-bold text-success">{{ $todayCheckouts ?? '0' }}</p>
                        </div>
                    </div>
                    
                    <div class="card bg-info/10">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-info mb-2">Available Rooms</h3>
                            <p class="text-3xl font-bold text-info">{{ $availableRooms ?? '0' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="{{ route('receptionist.checkin') }}" class="card hover:shadow-lg transition-shadow p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="text-gray-900 dark:text-white font-medium">New Check-in</span>
                        </a>
                        
                        <a href="{{ route('receptionist.checkout') }}" class="card hover:shadow-lg transition-shadow p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="text-gray-900 dark:text-white font-medium">Process Check-out</span>
                        </a>
                        
                        <a href="{{ route('receptionist.bookings.create') }}" class="card hover:shadow-lg transition-shadow p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-gray-900 dark:text-white font-medium">New Booking</span>
                        </a>
                        
                        <a href="{{ route('receptionist.rooms') }}" class="card hover:shadow-lg transition-shadow p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="text-gray-900 dark:text-white font-medium">Room Status</span>
                        </a>
                    </div>
                </div>

                <!-- Today's Schedule -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Today's Schedule</h3>
                    <div class="card">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Guest Name</th>
                                        <th>Room</th>
                                        <th>Action</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($todaySchedule ?? [] as $schedule)
                                    <tr>
                                        <td>{{ $schedule->time }}</td>
                                        <td>{{ $schedule->guest_name }}</td>
                                        <td>{{ $schedule->room_number }}</td>
                                        <td>{{ $schedule->action }}</td>
                                        <td>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $schedule->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($schedule->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($schedule->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-gray-500">No scheduled activities for today</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Notifications -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Recent Notifications</h3>
                    <div class="space-y-4">
                        @forelse($notifications ?? [] as $notification)
                        <div class="card p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 {{ $notification->type === 'alert' ? 'text-red-500' : 'text-blue-500' }}" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $notification->message }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-gray-500">No new notifications</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 