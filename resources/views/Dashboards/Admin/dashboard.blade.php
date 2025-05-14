@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Admin Dashboard</h2>
                
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="card bg-primary/10">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-primary mb-2">Total Rooms</h3>
                            <p class="text-3xl font-bold text-primary">{{ $totalRooms ?? '0' }}</p>
                        </div>
                    </div>
                    
                    <div class="card bg-success/10">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-success mb-2">Available Rooms</h3>
                            <p class="text-3xl font-bold text-success">{{ $availableRooms ?? '0' }}</p>
                        </div>
                    </div>
                    
                    <div class="card bg-warning/10">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-warning mb-2">Current Bookings</h3>
                            <p class="text-3xl font-bold text-warning">{{ $currentBookings ?? '0' }}</p>
                        </div>
                    </div>
                    
                    <div class="card bg-info/10">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-info mb-2">Total Revenue</h3>
                            <p class="text-3xl font-bold text-info">${{ number_format($totalRevenue ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.rooms.create') }}" class="card hover:shadow-lg transition-shadow p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <span class="text-gray-900 dark:text-white font-medium">Add New Room</span>
                        </a>
                        
                        <a href="{{ route('admin.users.create') }}" class="card hover:shadow-lg transition-shadow p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span class="text-gray-900 dark:text-white font-medium">Add New Staff</span>
                        </a>
                        
                        <a href="{{ route('admin.reports') }}" class="card hover:shadow-lg transition-shadow p-4 text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-gray-900 dark:text-white font-medium">Generate Reports</span>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Recent Activity</h3>
                    <div class="card">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Activity</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentActivities ?? [] as $activity)
                                    <tr>
                                        <td>{{ $activity->description }}</td>
                                        <td>{{ $activity->user->name }}</td>
                                        <td>{{ $activity->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $activity->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($activity->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($activity->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-gray-500">No recent activities</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 