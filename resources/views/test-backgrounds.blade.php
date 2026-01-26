<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Background Texture Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto space-y-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Background Texture Test</h1>
        
        <!-- Carbon Texture Test -->
        <div class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 rounded-3xl overflow-hidden shadow-2xl p-8">
            <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
            <div class="relative">
                <h2 class="text-2xl font-bold text-white mb-4">Carbon Texture Background</h2>
                <p class="text-primary-100">This should show a subtle carbon fiber-like texture pattern.</p>
            </div>
        </div>
        
        <!-- Subtle Texture Test -->
        <div class="relative bg-gradient-to-r from-accent-900 to-accent-800 rounded-3xl overflow-hidden shadow-2xl p-8">
            <div class="absolute inset-0 bg-texture-subtle opacity-10"></div>
            <div class="relative">
                <h2 class="text-2xl font-bold text-white mb-4">Subtle Texture Background</h2>
                <p class="text-accent-100">This should show a subtle geometric pattern.</p>
            </div>
        </div>
        
        <!-- Dots Texture Test -->
        <div class="relative bg-gradient-to-r from-indigo-900 to-indigo-800 rounded-3xl overflow-hidden shadow-2xl p-8">
            <div class="absolute inset-0 bg-texture-dots opacity-10"></div>
            <div class="relative">
                <h2 class="text-2xl font-bold text-white mb-4">Dots Texture Background</h2>
                <p class="text-indigo-100">This should show a subtle dot pattern.</p>
            </div>
        </div>
        
        <!-- Property Images Test -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Property Images Test</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach(['6syAzXsdKkg7MPnyt0tE9cjbvJ8ZW6cPbgx5KdM7.jpg', 'BuEyo9htGOMsX1cl2KERhkDAtJx7CWEYj5Gkknv6.jpg', 'kAccxWDwysAK3SRzkUSY3Lnk6Iye8V6Stg1WsgET.jpg'] as $image)
                <div class="aspect-square rounded-lg overflow-hidden shadow-md">
                    <img src="{{ asset('storage/properties/' . $image) }}" 
                         alt="Test Property Image" 
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Status Check</h2>
            <ul class="space-y-2 text-sm">
                <li class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span>Storage symlink: {{ file_exists(public_path('storage')) ? 'Working' : 'Not working' }}</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span>CSS compiled: {{ file_exists(public_path('build/manifest.json')) ? 'Yes' : 'No' }}</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span>App URL: {{ config('app.url') }}</span>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>
