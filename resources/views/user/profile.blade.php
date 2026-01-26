@extends('layouts.user')

@section('title', 'Profile Settings - HAVEN')
@section('page-title', 'Profile Settings')

@section('content')
    <!-- Premium Header Banner -->
    <div class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 rounded-3xl overflow-hidden shadow-2xl mb-8">
        <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
        <div class="relative px-8 py-16">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1 space-y-2">
                    <h1 class="text-3xl font-semibold text-white font-heading tracking-tight underline decoration-accent-500/30 decoration-8 underline-offset-4">
                        Profile Settings
                    </h1>
                    <p class="text-lg text-primary-100/80 font-normal">
                        Manage your personal information and account preferences.
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
                    <div class="w-10 h-10 bg-accent-50 rounded-xl flex items-center justify-center text-accent-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 font-heading tracking-tight uppercase">Personal <span class="text-accent-600">Information</span></h2>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Upload -->
                    <div class="flex flex-col md:flex-row md:items-center gap-8 p-6 bg-gray-50/50 rounded-2xl border border-gray-100">
                        <div class="relative group">
                            <div class="h-24 w-24 rounded-2xl overflow-hidden border-4 border-white shadow-xl ring-1 ring-gray-100 mb-4 md:mb-0">
                                @if($user->avatar && Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar))
                                    <img class="h-full w-full object-cover" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                @else
                                    <div class="h-full w-full bg-primary-900 flex items-center justify-center text-3xl font-semibold text-white">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1 space-y-2">
                            <label class="block text-sm font-semibold text-gray-900 uppercase tracking-wider">Profile Picture</label>
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary-900 file:text-white hover:file:bg-primary-800 transition-all cursor-pointer">
                            <p class="text-xs text-gray-400">Recommended: Square JPG or PNG. Max size 2MB.</p>
                            @error('avatar') <p class="text-xs text-red-600 mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 ml-1">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full px-5 py-4 rounded-xl bg-gray-50 border-gray-100 focus:bg-white focus:ring-2 focus:ring-primary-900/10 focus:border-primary-900 transition-all @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-xs text-red-600 mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700 ml-1">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-5 py-4 rounded-xl bg-gray-50 border-gray-100 focus:bg-white focus:ring-2 focus:ring-primary-900/10 focus:border-primary-900 transition-all @error('email') border-red-500 @enderror">
                            @error('email') <p class="text-xs text-red-600 mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-semibold text-gray-700 ml-1">Phone Number</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                   class="w-full px-5 py-4 rounded-xl bg-gray-50 border-gray-100 focus:bg-white focus:ring-2 focus:ring-primary-900/10 focus:border-primary-900 transition-all">
                        </div>

                        <!-- Address -->
                        <div class="space-y-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700 ml-1">Address</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $user->address ?? '') }}"
                                   class="w-full px-5 py-4 rounded-xl bg-gray-50 border-gray-100 focus:bg-white focus:ring-2 focus:ring-primary-900/10 focus:border-primary-900 transition-all">
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="space-y-2">
                        <label for="bio" class="block text-sm font-semibold text-gray-700 ml-1">Bio</label>
                        <textarea name="bio" id="bio" rows="4"
                                  class="w-full px-5 py-4 rounded-xl bg-gray-50 border-gray-100 focus:bg-white focus:ring-2 focus:ring-primary-900/10 focus:border-primary-900 transition-all placeholder:text-gray-300"
                                  placeholder="Write a brief summary about yourself...">{{ old('bio', $user->bio) }}</textarea>
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
                <div class="absolute top-0 right-0 w-24 h-24 bg-accent-50 rounded-full -mr-12 -mt-12 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 uppercase tracking-wider text-xs">Account <span class="text-accent-600">Insights</span></h3>
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
                            <span class="text-sm font-semibold text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <span class="text-sm text-gray-600">Role</span>
                            </div>
                            <span class="text-xs font-bold text-gray-900 uppercase">Member</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow-xl shadow-gray-200/50 rounded-3xl p-8 border border-gray-100 overflow-hidden relative group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-full -mr-12 -mt-12 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="relative">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 uppercase tracking-wider text-xs">Quick <span class="text-blue-600">Actions</span></h3>
                    <div class="space-y-3">
                        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 p-4 bg-gray-50 hover:bg-blue-50 rounded-2xl border border-gray-100 hover:border-blue-200 transition-all group">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 group-hover:text-blue-700">Dashboard</span>
                        </a>
                        <a href="{{ route('user.saved-properties') }}" class="flex items-center gap-3 p-4 bg-gray-50 hover:bg-red-50 rounded-2xl border border-gray-100 hover:border-red-200 transition-all group">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition-all">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 group-hover:text-red-700">Saved Properties</span>
                        </a>
                        <a href="{{ route('properties.index') }}" class="flex items-center gap-3 p-4 bg-gray-50 hover:bg-green-50 rounded-2xl border border-gray-100 hover:border-green-200 transition-all group">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-all">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 group-hover:text-green-700">Browse Properties</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Security Quick Fix -->
            <div class="bg-gradient-to-br from-accent-900 to-accent-800 shadow-2xl shadow-accent-900/20 rounded-3xl p-8 border border-white/10 relative overflow-hidden">
                <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
                <div class="relative">
                    <h3 class="text-lg font-semibold text-white mb-2">Password Security</h3>
                    <p class="text-accent-100/60 text-sm mb-6">Keep your account safe by updating your credentials periodically.</p>
                    <button type="button" onclick="alert('Password reset link sent to your email!')" class="w-full py-4 bg-white/10 hover:bg-white/20 border border-white/20 rounded-2xl text-white text-sm font-semibold transition-all backdrop-blur-sm">
                        Request Password Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
