@extends('layouts.admin')

@section('title', 'Manage Users - Admin')
@section('page-title', 'User Management')

@section('content')
    <!-- Premium Header Banner -->
    <div class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 rounded-3xl overflow-hidden shadow-2xl mb-8">
        <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
        <div class="relative px-8 py-16">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1 space-y-2">
                    <h1 class="text-3xl font-semibold text-white font-heading tracking-tight underline decoration-blue-500/30 decoration-8 underline-offset-4">
                        User Management
                    </h1>
                    <p class="text-lg text-primary-100/80 font-normal">
                        Control platform access, moderate roles, and manage registered members.
                    </p>
                </div>
            </div>
        </div>
    </div>

<!-- Filters Section -->
<div class="bg-white shadow-xl shadow-gray-200/60 rounded-3xl p-8 border border-gray-50 mb-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900 font-heading tracking-tight uppercase">User <span class="text-blue-600">Discovery</span> Tool</h2>
    </div>
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 relative z-10">
        <div>
            <label class="field-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="input-field" 
                   placeholder="Search by name or email...">
        </div>
        <div>
            <x-select 
                name="role" 
                label="Role" 
                height="h-10"
                :value="request('role')"
                :options="[
                    ['value' => '', 'label' => 'All Roles'],
                    ['value' => 'admin', 'label' => 'Admin'],
                    ['value' => 'user', 'label' => 'User']
                ]"
            />
        </div>
        <div>
            <x-select 
                name="status" 
                label="Status" 
                height="h-10"
                :value="request('status')"
                :options="[
                    ['value' => '', 'label' => 'All Status'],
                    ['value' => 'active', 'label' => 'Active'],
                    ['value' => 'inactive', 'label' => 'Inactive']
                ]"
            />
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-primary w-full">
                Apply Filters
            </button>
        </div>
    </form>
</div>

<!-- Users Table Section -->
<div class="bg-white shadow-2xl shadow-gray-200/60 rounded-3xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">User Profile</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Permission</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Account Status</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Member Since</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Activity</th>
                    <th class="px-8 py-5 text-right text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($users as $user)
                <tr class="group border-b border-gray-50 hover:bg-gray-50/50 transition-all duration-200">
                    <td class="px-8 py-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-14 w-14">
                                @if($user->avatar && file_exists(storage_path('app/public/' . $user->avatar)))
                                    <img class="h-14 w-14 rounded-2xl object-cover border-4 border-white shadow-md" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                @else
                                    <div class="h-14 w-14 rounded-2xl bg-primary-50 border-4 border-white shadow-md flex items-center justify-center">
                                        <span class="text-lg font-semibold text-primary-600 uppercase">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-600 mt-1">{{ $user->email }}</div>
                                @if($user->phone)
                                    <div class="text-xs text-gray-500 mt-1">{{ $user->phone }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium border
                            {{ $user->role === 'admin' ? 'bg-gray-100 text-gray-800 border-gray-200' : 'bg-teal-50 text-teal-700 border-teal-200' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium border
                            {{ $user->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-6 text-sm text-gray-600">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-6 text-sm text-gray-600">
                        @if($user->role === 'admin')
                            {{ $user->properties()->count() }} properties
                        @else
                            {{ $user->savedProperties()->count() }} saved
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <button onclick="viewUser({{ $user->id }})" 
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-400 hover:text-primary-900 hover:bg-gray-100 transition-all duration-200 border border-transparent hover:border-gray-100"
                                    title="View User">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                            @if($user->id !== auth()->id())
                                <button onclick="toggleUserStatus({{ $user->id }}, {{ $user->is_active ? 'false' : 'true' }})" 
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-400 hover:text-{{ $user->is_active ? 'red' : 'green' }}-600 hover:bg-{{ $user->is_active ? 'red' : 'green' }}-50 transition-all duration-200 border border-transparent hover:border-{{ $user->is_active ? 'red' : 'green' }}-100"
                                        title="{{ $user->is_active ? 'Deactivate' : 'Activate' }} User">
                                    @if($user->is_active)
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                            <p class="text-gray-600 max-w-sm">No users match your current filters. Try adjusting your search criteria.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="bg-gray-50/50 px-8 py-5 border-t border-gray-100">
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- User Details Modal -->
<div id="userModal" class="fixed inset-0 bg-primary-900/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border border-white/20 w-full max-w-md shadow-2xl rounded-3xl bg-white animate-fade-in-up">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-medium text-gray-900">User Details</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-900 transition-colors">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="userDetails">
            <!-- User details will be loaded here -->
        </div>
    </div>
</div>

@push('scripts')
<script>
function viewUser(userId) {
    // In a real application, you would fetch user details via AJAX
    document.getElementById('userDetails').innerHTML = `
        <div class="space-y-6">
            <div class="text-center">
                <div class="h-20 w-20 rounded-md bg-gray-100 mx-auto mb-4 flex items-center justify-center">
                    <span class="text-lg font-medium text-gray-900">U</span>
                </div>
                <h4 class="text-lg font-medium text-gray-900">User Details</h4>
                <p class="text-sm text-gray-600 mt-1">User ID: ${userId}</p>
            </div>
            <div class="border-t border-gray-200 pt-6">
                <p class="text-sm text-gray-600">Full user details would be loaded here via AJAX in a real application.</p>
            </div>
        </div>
    `;
    document.getElementById('userModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('userModal').classList.add('hidden');
}

function toggleUserStatus(userId, newStatus) {
    if (confirm(`Are you sure you want to ${newStatus === 'true' ? 'activate' : 'deactivate'} this user?`)) {
        // In a real application, you would send an AJAX request to update user status
        alert('User status would be updated via AJAX in a real application.');
        location.reload();
    }
}
</script>
@endpush
@endsection
