@extends('layouts.admin')

@section('title', 'Admin Profile - Haven')
@section('page-title', 'My Profile')

@section('content')
<?php 
    // Convert to object if array
    $u = is_array($user) ? (object)$user : $user;
?>
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <p class="text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Premium Header Banner -->
    <div class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 rounded-3xl overflow-hidden shadow-2xl mb-8">
        <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
        <div class="relative px-8 py-16">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1 space-y-2">
                    <h1 class="text-3xl font-semibold text-white font-heading tracking-tight underline decoration-indigo-500/30 decoration-8 underline-offset-4">
                        Account Settings
                    </h1>
                    <p class="text-lg text-primary-100/80 font-normal">
                        Manage your administrative profile and security preferences.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Form Card -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white shadow-2xl shadow-gray-200/60 rounded-3xl p-8 border border-gray-100">
                <div class="flex items-center gap-3 mb-8 pb-6 border-b border-gray-50">
                    <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 font-heading tracking-tight uppercase">Personal <span class="text-indigo-600">Information</span></h2>
                </div>

                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Upload -->
                    <div class="flex flex-col md:flex-row md:items-center gap-8 p-6 bg-gray-50/50 rounded-2xl border border-gray-100">
                        <div class="relative group">
                            <div class="h-24 w-24 rounded-2xl overflow-hidden border-4 border-white shadow-xl ring-1 ring-gray-100 mb-4 md:mb-0">
                                @if(isset($u->avatar) && $u->avatar)
                                    <img class="h-full w-full object-cover" src="{{ asset('storage/' . $u->avatar) }}?v={{ time() }}" alt="{{ $u->name ?? 'User' }}">
                                @else
                                    <div class="h-full w-full bg-primary-900 flex items-center justify-center text-3xl font-semibold text-white">
                                        {{ substr($u->name ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1 space-y-2">
                            <label class="block text-sm font-semibold text-gray-900 uppercase tracking-wider">Profile Picture</label>
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary-900 file:text-white hover:file:bg-primary-800 transition-all cursor-pointer">
                            <p class="text-xs text-gray-400">Recommended: Square JPG or PNG. Max size 2MB.</p>
                            @error('avatar') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 ml-1">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $u->name ?? '') }}" required
                                   class="w-full px-5 py-4 rounded-xl bg-gray-50 border-gray-100 focus:bg-white focus:ring-2 focus:ring-primary-900/10 focus:border-primary-900 transition-all @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-xs text-red-600 mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email (Read-only) -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700 ml-1">Email Address</label>
                            <input type="email" id="email" value="{{ $u->email ?? '' }}" readonly
                                   class="w-full px-5 py-4 rounded-xl bg-gray-100 border-gray-200 text-gray-500 cursor-not-allowed">
                            <p class="text-xs text-gray-400 mt-1 ml-1">Email cannot be changed</p>
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-semibold text-gray-700 ml-1">Phone Number</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $u->phone ?? '') }}"
                                   class="w-full px-5 py-4 rounded-xl bg-gray-50 border-gray-100 focus:bg-white focus:ring-2 focus:ring-primary-900/10 focus:border-primary-900 transition-all @error('phone') border-red-500 @enderror">
                            @error('phone') <p class="text-xs text-red-600 mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Address -->
                        <div class="space-y-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700 ml-1">Address</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $u->address ?? '') }}"
                                   class="w-full px-5 py-4 rounded-xl bg-gray-50 border-gray-100 focus:bg-white focus:ring-2 focus:ring-primary-900/10 focus:border-primary-900 transition-all @error('address') border-red-500 @enderror">
                            @error('address') <p class="text-xs text-red-600 mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-8 border-t border-gray-50">
                        <button type="submit" class="btn-primary px-10 py-4 rounded-xl shadow-xl shadow-primary-900/10 transform hover:-translate-y-0.5 transition-all">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-8">
            <!-- Account Insights -->
            <div class="bg-white shadow-xl shadow-gray-200/50 rounded-3xl p-8 border border-gray-100 overflow-hidden relative group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-full -mr-12 -mt-12 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 uppercase tracking-wider text-xs">Account <span class="text-indigo-600">Insights</span></h3>
                    <div class="space-y-5">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <span class="text-sm text-gray-600">Status</span>
                            </div>
                            <span class="text-xs font-bold text-green-700 uppercase">Active</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <span class="text-sm text-gray-600">Joined</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">{{ isset($u->created_at) ? date('M d, Y', strtotime($u->created_at)) : 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" /></svg>
                                </div>
                                <span class="text-sm text-gray-600">Role</span>
                            </div>
                            <span class="text-xs font-bold text-gray-900 uppercase">Super Admin</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Quick Fix -->
            <div class="bg-gradient-to-br from-indigo-900 to-indigo-800 shadow-2xl shadow-indigo-900/20 rounded-3xl p-8 border border-white/10 relative overflow-hidden">
                <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
                <div class="relative">
                    <h3 class="text-lg font-semibold text-white mb-2">Password Security</h3>
                    <p class="text-indigo-100/60 text-sm mb-6">Keep your account safe by updating your credentials periodically.</p>
                    <button type="button" onclick="alert('Password reset link sent to your email!')" class="w-full py-4 bg-white/10 hover:bg-white/20 border border-white/20 rounded-2xl text-white text-sm font-semibold transition-all backdrop-blur-sm">
                        Request Password Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
