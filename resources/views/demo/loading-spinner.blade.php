@extends('layouts.app')

@section('title', 'Loading Spinner Demo - Haven')

@section('content')
<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-4xl mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black font-heading text-primary-950 mb-4">Haven Loading Spinner</h1>
            <p class="text-gray-600 text-lg">Elegant loading states for the Haven application</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Manual Controls -->
            <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold font-heading text-primary-950 mb-6">Manual Controls</h2>
                
                <div class="space-y-4">
                    <button onclick="HavenLoader.show(2000)" 
                            class="w-full px-6 py-3 bg-accent-600 text-white font-bold rounded-lg hover:bg-accent-500 transition-colors">
                        Show Loading Spinner (2s)
                    </button>
                    
                    <button onclick="HavenLoader.hide()" 
                            class="w-full px-6 py-3 bg-accent-600 text-white font-bold rounded-lg hover:bg-accent-500 transition-colors">
                        Hide Loading Spinner
                    </button>

                    <button onclick="HavenLoader.resetStartup(); location.reload();" 
                            class="w-full px-6 py-3 bg-accent-600 text-white font-bold rounded-lg hover:bg-accent-500 transition-colors">
                        Reset & Show Startup Spinner
                    </button>
                </div>

                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-bold text-sm text-gray-700 mb-2">JavaScript Usage:</h3>
                    <code class="text-xs text-gray-600">
                        HavenLoader.show(2000); // Show for 2 seconds<br>
                        HavenLoader.hide();
                    </code>
                </div>
            </div>

            <!-- Automatic Triggers -->
            <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200">
                <h2 class="text-xl font-bold font-heading text-primary-950 mb-6">Automatic Triggers</h2>
                
                <div class="space-y-4">
                    <a href="{{ route('home') }}" 
                       class="block w-full px-6 py-3 bg-accent-600 text-white font-bold rounded-lg hover:bg-accent-500 transition-colors text-center">
                        Navigate to Home (No Spinner)
                    </a>
                    
                    <a href="{{ route('properties.index') }}" 
                       class="block w-full px-6 py-3 bg-accent-600 text-white font-bold rounded-lg hover:bg-accent-500 transition-colors text-center">
                        Navigate to Properties (No Spinner)
                    </a>
                    
                    <form method="GET" action="{{ route('home') }}" class="w-full">
                        <button type="submit" class="w-full px-6 py-3 bg-accent-600 text-white font-bold rounded-lg hover:bg-accent-500 transition-colors">
                            Submit Form (No Spinner)
                        </button>
                    </form>
                </div>

                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h3 class="font-bold text-sm text-blue-700 mb-2">Startup Only:</h3>
                    <p class="text-xs text-blue-600">
                        The spinner only shows on the very first page load when starting the project. 
                        Navigation between pages will not trigger the spinner.
                    </p>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="mt-12 bg-white rounded-xl p-8 shadow-sm border border-gray-200">
            <h2 class="text-2xl font-bold font-heading text-primary-950 mb-6">Features</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-accent-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-primary-950 mb-2">Automatic Detection</h3>
                    <p class="text-sm text-gray-600">Automatically shows on page navigation and form submissions</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-accent-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-primary-950 mb-2">Mobile Optimized</h3>
                    <p class="text-sm text-gray-600">Responsive design that works perfectly on all devices</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-accent-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-primary-950 mb-2">Brand Consistent</h3>
                    <p class="text-sm text-gray-600">Matches Haven's luxury aesthetic with smooth animations</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
