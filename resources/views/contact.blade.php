@extends('layouts.app')

@section('title', 'Contact Haven - Get in Touch')
@section('meta_description', 'Contact Haven for premium real estate services. Reach out to our expert team for property inquiries, consultations, and exceptional client support.')

@section('content')
<!-- Hero Section: Contact Introduction -->
<div class="relative min-h-screen flex items-center overflow-hidden bg-primary-950">
    <!-- Background: Modern Architecture -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=2070&q=80" 
             alt="Modern Architecture" 
             class="w-full h-full object-cover opacity-40 transform scale-105 animate-slow-zoom">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950/95 via-primary-950/60 to-primary-950/95"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 w-full max-w-[1600px] mx-auto px-6 lg:px-12 pt-32 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Side: Contact Introduction -->
            <div class="lg:col-span-8 space-y-12">
                <!-- Brand Badge -->
                <div class="inline-flex items-center gap-4 animate-reveal">
                    <div class="w-12 h-[2px] bg-accent-500"></div>
                    <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[10px]">Contact Haven</span>
                </div>

                <!-- Main Headline -->
                <h1 class="text-6xl md:text-8xl lg:text-9xl font-black text-white leading-[0.9] tracking-tighter animate-reveal [animation-delay:0.2s]">
                    Let's Create <br>
                    <span class="text-accent-500">Something Exceptional.</span>
                </h1>

                <!-- Contact Description -->
                <div class="max-w-2xl space-y-8 animate-reveal [animation-delay:0.4s]">
                    <p class="text-xl md:text-2xl text-gray-300 font-light leading-relaxed border-l-4 border-accent-500/50 pl-8">
                        Ready to discover your perfect property? Our expert team is here to guide you through every step of your real estate journey with personalized service and unmatched expertise.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-8">
                        <a href="#contact-form" class="px-12 py-5 bg-accent-600 text-white font-black uppercase tracking-[0.2em] rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 shadow-2xl transform hover:-translate-y-1 text-sm">
                            Get Started
                        </a>
                        <a href="#contact-info" class="group flex items-center gap-4 text-white hover:text-accent-400 transition-all duration-300">
                            <span class="text-[11px] font-bold uppercase tracking-[0.3em] border-b border-white/20 pb-1 group-hover:border-accent-500 transition-all">Contact Info</span>
                            <div class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center group-hover:bg-accent-500 group-hover:border-accent-500 transition-all">
                                <svg class="w-3 h-3 translate-x-[-1px] group-hover:translate-x-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m0 0l7-7"></path></svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side: Quick Contact -->
            <div class="hidden lg:block lg:col-span-4 self-end animate-reveal [animation-delay:0.6s]">
                <div class="glass-premium p-10 rounded-[50px] exceptional-shadow text-white space-y-8 max-w-[340px] ml-auto">
                    <div class="flex justify-between items-start">
                        <span class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-60">Available 24/7</span>
                        <div class="flex items-center gap-2">
                             <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                             <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-accent-400">Online Now</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-2xl font-black leading-none mb-3 text-accent-500">Ready to Help</div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] opacity-40 leading-relaxed">Expert Consultation <br>Premium Service</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Form & Info Section -->
<div class="py-40 bg-white overflow-hidden">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-start">
            <!-- Left: Contact Form -->
            <div id="contact-form" class="space-y-12">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-green-800">Message Sent Successfully!</h3>
                                <p class="text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="space-y-6">
                    <span class="text-accent-600 font-bold uppercase tracking-[0.4em] text-[10px]">Send Message</span>
                    <h2 class="text-5xl md:text-7xl font-black text-primary-950 leading-[1.1] tracking-tighter">
                        Start Your <br>
                        <span class="text-accent-500 italic">Journey Today.</span>
                    </h2>
                </div>
                
                <div class="space-y-8 text-lg text-gray-600 font-light leading-relaxed max-w-xl">
                    <p>
                        Whether you're looking to buy, rent, or need expert consultation, we're here to provide personalized guidance tailored to your unique needs and preferences.
                    </p>
                </div>

                <!-- Contact Form -->
                <form class="space-y-8" action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="field-label required">Full Name</label>
                            <input type="text" name="name" class="input-field" placeholder="Your full name" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="field-label required">Email Address</label>
                            <input type="email" name="email" class="input-field" placeholder="your.email@example.com" value="{{ old('email') }}" required>
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="field-label">Phone Number</label>
                        <input type="tel" name="phone" class="input-field" placeholder="+234 (0) 812 944 8461" value="{{ old('phone') }}">
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="field-label required">Subject</label>
                        <select name="subject" class="select-field" required>
                            <option value="">Select inquiry type</option>
                            <option value="Property Purchase" {{ old('subject') == 'Property Purchase' ? 'selected' : '' }}>Property Purchase</option>
                            <option value="Property Rental" {{ old('subject') == 'Property Rental' ? 'selected' : '' }}>Property Rental</option>
                            <option value="Sell My Property" {{ old('subject') == 'Sell My Property' ? 'selected' : '' }}>Sell My Property</option>
                            <option value="Expert Consultation" {{ old('subject') == 'Expert Consultation' ? 'selected' : '' }}>Expert Consultation</option>
                            <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('subject')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="field-label required">Message</label>
                        <textarea name="message" rows="6" class="textarea-field" placeholder="Tell us about your property needs, preferences, or any questions you have..." required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-start gap-3">
                        <input type="checkbox" name="newsletter" class="checkbox-field mt-1" {{ old('newsletter') ? 'checked' : '' }}>
                        <label class="text-sm text-gray-600">
                            I'd like to receive updates about new properties and market insights from Haven.
                        </label>
                    </div>

                    <div class="text-center">
                        <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                            By submitting this form, you agree to our 
                            <a href="{{ route('terms') }}" class="text-accent-600 hover:text-accent-700 underline">Terms of Service</a> 
                            and 
                            <a href="{{ route('privacy') }}" class="text-accent-600 hover:text-accent-700 underline">Privacy Policy</a>.
                        </p>
                    </div>

                    <button type="submit" class="w-full md:w-auto px-16 py-7 bg-accent-600 text-white font-black uppercase tracking-[0.3em] rounded-full hover:bg-accent-500 transition-all duration-500 shadow-2xl transform hover:-translate-y-1 text-sm">
                        Send Message
                        <svg class="w-5 h-5 ml-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Right: Contact Information -->
            <div id="contact-info" class="space-y-12">
                <div class="space-y-6">
                    <span class="text-accent-600 font-bold uppercase tracking-[0.4em] text-[10px]">Contact Information</span>
                    <h2 class="text-5xl md:text-7xl font-black text-primary-950 leading-[1.1] tracking-tighter">
                        Multiple Ways <br>
                        <span class="text-accent-500 italic">To Connect.</span>
                    </h2>
                </div>

                <!-- Contact Methods -->
                <div class="space-y-8">
                    <!-- Phone -->
                    <div class="flex items-start gap-6 p-8 bg-gray-50 rounded-[30px] hover:bg-primary-950 hover:text-white transition-all duration-500 group">
                        <div class="w-16 h-16 bg-accent-100 group-hover:bg-accent-600 rounded-[20px] flex items-center justify-center shrink-0 transition-all duration-500">
                            <svg class="w-8 h-8 text-accent-600 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-bold text-primary-950 group-hover:text-white transition-colors duration-500">Phone</h3>
                            <p class="text-gray-600 group-hover:text-white/80 transition-colors duration-500">Speak directly with our experts</p>
                            <a href="tel:+2348129448461" class="text-accent-600 group-hover:text-accent-400 font-semibold transition-colors duration-500">{{ env('CONTACT_PHONE_FORMATTED', '+234 (0) 812 944 8461') }}</a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-6 p-8 bg-gray-50 rounded-[30px] hover:bg-primary-950 hover:text-white transition-all duration-500 group">
                        <div class="w-16 h-16 bg-accent-100 group-hover:bg-accent-600 rounded-[20px] flex items-center justify-center shrink-0 transition-all duration-500">
                            <svg class="w-8 h-8 text-accent-600 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-bold text-primary-950 group-hover:text-white transition-colors duration-500">Email</h3>
                            <p class="text-gray-600 group-hover:text-white/80 transition-colors duration-500">Send us a detailed message</p>
                            <a href="mailto:hello@haven.com" class="text-accent-600 group-hover:text-accent-400 font-semibold transition-colors duration-500">hello@haven.com</a>
                        </div>
                    </div>

                    <!-- Office -->
                    <div class="flex items-start gap-6 p-8 bg-gray-50 rounded-[30px] hover:bg-primary-950 hover:text-white transition-all duration-500 group">
                        <div class="w-16 h-16 bg-accent-100 group-hover:bg-accent-600 rounded-[20px] flex items-center justify-center shrink-0 transition-all duration-500">
                            <svg class="w-8 h-8 text-accent-600 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-bold text-primary-950 group-hover:text-white transition-colors duration-500">Office</h3>
                            <p class="text-gray-600 group-hover:text-white/80 transition-colors duration-500">Visit us for in-person consultation</p>
                            <address class="text-accent-600 group-hover:text-accent-400 font-semibold transition-colors duration-500 not-italic">
                                Adebola Street, Off Adeniran Ogunsanya Road<br>
                                Surulere, Lagos State, Nigeria
                            </address>
                        </div>
                    </div>

                    <!-- Hours -->
                    <div class="flex items-start gap-6 p-8 bg-gray-50 rounded-[30px] hover:bg-primary-950 hover:text-white transition-all duration-500 group">
                        <div class="w-16 h-16 bg-accent-100 group-hover:bg-accent-600 rounded-[20px] flex items-center justify-center shrink-0 transition-all duration-500">
                            <svg class="w-8 h-8 text-accent-600 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-bold text-primary-950 group-hover:text-white transition-colors duration-500">Business Hours</h3>
                            <p class="text-gray-600 group-hover:text-white/80 transition-colors duration-500">We're here when you need us</p>
                            <div class="text-accent-600 group-hover:text-accent-400 font-semibold transition-colors duration-500">
                                <div>Mon - Fri: 9:00 AM - 7:00 PM</div>
                                <div>Sat - Sun: 10:00 AM - 5:00 PM</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action Section -->
<div class="py-40 bg-primary-950 relative overflow-hidden">
    <!-- Abstract Brand Watermark -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-[0.03] select-none pointer-events-none">
        <span class="text-[300px] font-black leading-none tracking-tighter text-white">CONNECT</span>
    </div>
    
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10 space-y-16">
        <div class="space-y-6">
            <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[10px]">Ready to Begin</span>
            <h2 class="text-5xl md:text-7xl font-black text-white leading-none tracking-tighter">
                Your Perfect Property <br>
                <span class="text-accent-500">Awaits.</span>
            </h2>
        </div>
        
        <p class="text-xl text-gray-400 font-light leading-relaxed max-w-2xl mx-auto opacity-80">
            Don't wait to start your real estate journey. Our expert team is ready to help you discover exceptional properties that match your vision and lifestyle.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-10 justify-center items-center pt-8">
            <a href="{{ route('properties.index') }}" class="px-16 py-7 bg-accent-600 text-white font-black uppercase tracking-[0.3em] rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 shadow-2xl transform hover:-translate-y-1 text-xs">
                Browse Properties
            </a>
            <a href="{{ route('home') }}" class="group flex items-center gap-4 text-white hover:text-accent-400 transition-all duration-500">
                <span class="font-bold text-[11px] uppercase tracking-[0.3em] border-b border-white/20 pb-2 group-hover:border-accent-500 transition-all">Return Home</span>
                <div class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center group-hover:bg-accent-500 group-hover:border-accent-500 transition-all duration-500">
                    <svg class="w-4 h-4 translate-x-[-1px] group-hover:translate-x-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
