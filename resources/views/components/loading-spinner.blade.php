<!-- Haven Mobile App Style Loading Screen -->
<div class="fixed inset-0 z-[9999] hidden items-center justify-center bg-white opacity-0 transition-opacity duration-300" id="haven-loading-spinner">
    <!-- Mobile App Background -->
    <div class="absolute inset-0 bg-gradient-to-b from-white via-gray-50 to-white"></div>
    
    <!-- Mobile Loading Content -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full w-full px-4 sm:px-6 md:px-8">
        
        <!-- App Logo Section -->
        <div class="flex flex-col items-center mb-12 sm:mb-16 md:mb-20">
            <!-- App Icon -->
            <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 rounded-2xl sm:rounded-3xl mb-4 sm:mb-6 flex items-center justify-center mobile-app-bounce overflow-hidden">
                @if(file_exists(public_path('images/haven-logo.png')))
                    <img src="{{ asset('images/haven-logo.png') }}" alt="Haven Logo" class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 object-contain rounded-2xl">
                @else
                    <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 bg-accent-600 rounded-2xl sm:rounded-3xl shadow-lg flex items-center justify-center">
                        <span class="text-white font-black text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-heading">H</span>
                    </div>
                @endif
            </div>
            
            <!-- App Name -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 font-heading mb-1 sm:mb-2">Haven</h1>
            <p class="text-gray-500 text-xs sm:text-sm md:text-base font-medium">Luxury Properties</p>
        </div>

        <!-- Mobile Loading Animation -->
        <div class="flex flex-col items-center space-y-6 sm:space-y-8 md:space-y-10">
            
            <!-- Modern Mobile Spinner -->
            <div class="relative">
                <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 lg:w-16 lg:h-16">
                    <!-- iOS Style Spinner -->
                    <svg class="w-full h-full mobile-spinner-rotate" viewBox="0 0 50 50">
                        <circle
                            cx="25"
                            cy="25"
                            r="20"
                            fill="none"
                            stroke="#e5e7eb"
                            stroke-width="3"
                        />
                        <circle
                            cx="25"
                            cy="25"
                            r="20"
                            fill="none"
                            stroke="#0d9488"
                            stroke-width="3"
                            stroke-linecap="round"
                            stroke-dasharray="31.416"
                            stroke-dashoffset="31.416"
                            class="mobile-progress-circle"
                        />
                    </svg>
                </div>
            </div>

            <!-- Loading Text -->
            <div class="text-center space-y-2 sm:space-y-3">
                <p class="text-gray-600 font-medium text-sm sm:text-base md:text-lg mobile-loading-text">Loading...</p>
                <div class="flex justify-center space-x-1 sm:space-x-1.5">
                    <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-accent-600 rounded-full mobile-dot-bounce mobile-dot-1"></div>
                    <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-accent-600 rounded-full mobile-dot-bounce mobile-dot-2"></div>
                    <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-accent-600 rounded-full mobile-dot-bounce mobile-dot-3"></div>
                </div>
            </div>
        </div>

        <!-- Mobile App Footer -->
        <div class="absolute bottom-8 sm:bottom-12 md:bottom-16 left-0 right-0 text-center px-4">
            <p class="text-xs sm:text-sm text-gray-400 font-medium">Preparing your experience</p>
        </div>
        
    </div>
</div>