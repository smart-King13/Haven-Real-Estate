@extends('layouts.app')

@section('title', 'Terms of Service - Haven')
@section('meta_description', 'Read Haven\'s Terms of Service to understand our policies and your rights when using our real estate platform.')

@section('content')
<!-- Terms Hero Section -->
<div class="relative bg-primary-950 py-24 lg:py-32 pt-32 lg:pt-40">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-12 text-center">
        <!-- Breadcrumb -->
        <nav class="inline-flex px-4 py-2 rounded-full bg-white/5 backdrop-blur-md border border-white/10 mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 md:space-x-4">
                <li>
                    <a href="{{ route('home') }}" class="text-[10px] font-black uppercase tracking-widest text-white/60 hover:text-white transition-colors">Home</a>
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-white/20 text-[10px]">/</span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-white">Terms of Service</span>
                </li>
            </ol>
        </nav>

        <div class="inline-flex items-center gap-4 mb-6">
            <div class="w-8 h-[2px] bg-accent-500"></div>
            <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[10px]">Legal Information</span>
            <div class="w-8 h-[2px] bg-accent-500"></div>
        </div>

        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white leading-[0.9] tracking-tighter mb-6">
            Terms of <span class="text-accent-500 italic">Service.</span>
        </h1>

        <p class="text-xl text-gray-300 font-light leading-relaxed max-w-2xl mx-auto">
            Please read these terms carefully before using Haven's real estate platform and services.
        </p>

        <div class="mt-8 text-sm text-white/60">
            Last updated: {{ now()->format('F j, Y') }}
        </div>
    </div>
</div>

<!-- Terms Content -->
<div class="py-16 lg:py-24 bg-white">
    <div class="max-w-4xl mx-auto px-6 lg:px-12">
        <div class="prose prose-lg max-w-none">
            
            <!-- 1. Acceptance of Terms -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">1. Acceptance of Terms</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>By accessing and using Haven ("we," "our," or "us"), you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>
                    <p>These Terms of Service ("Terms") govern your use of our website located at haven.com (the "Service") operated by Haven Real Estate.</p>
                </div>
            </section>

            <!-- 2. Description of Service -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">2. Description of Service</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>Haven is a real estate platform that connects property buyers, sellers, and renters. Our services include:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Property listings and search functionality</li>
                        <li>Property management tools</li>
                        <li>Payment processing for transactions</li>
                        <li>Communication tools between users</li>
                        <li>Property verification and inspection services</li>
                    </ul>
                </div>
            </section>

            <!-- 3. User Accounts -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">3. User Accounts</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>To access certain features of our Service, you must register for an account. When you create an account, you must provide information that is accurate, complete, and current at all times.</p>
                    <p>You are responsible for safeguarding the password and for all activities that occur under your account. You agree not to disclose your password to any third party.</p>
                    <p>You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p>
                </div>
            </section>

            <!-- 4. Property Listings -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">4. Property Listings</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>Property owners and authorized agents may list properties on our platform. By listing a property, you represent and warrant that:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>You have the legal right to list the property</li>
                        <li>All information provided is accurate and complete</li>
                        <li>The property complies with all applicable laws and regulations</li>
                        <li>You will update listing information promptly when changes occur</li>
                    </ul>
                    <p>We reserve the right to remove any listing that violates these terms or our community guidelines.</p>
                </div>
            </section>

            <!-- 5. Payments and Transactions -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">5. Payments and Transactions</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>Haven facilitates payments between users but is not a party to any transaction. All transactions are between users directly.</p>
                    <p>We use third-party payment processors (Stripe, PayStack) to handle payments. By using our payment services, you agree to their respective terms of service.</p>
                    <p>Transaction fees may apply and will be clearly disclosed before any payment is processed.</p>
                    <p>Refunds are subject to our refund policy and the specific terms of each transaction.</p>
                </div>
            </section>

            <!-- 6. User Conduct -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">6. User Conduct</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>You agree not to use the Service to:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Violate any applicable laws or regulations</li>
                        <li>Post false, misleading, or fraudulent information</li>
                        <li>Harass, abuse, or harm other users</li>
                        <li>Spam or send unsolicited communications</li>
                        <li>Attempt to gain unauthorized access to our systems</li>
                        <li>Use automated tools to access or interact with our Service</li>
                    </ul>
                </div>
            </section>

            <!-- 7. Intellectual Property -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">7. Intellectual Property</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>The Service and its original content, features, and functionality are and will remain the exclusive property of Haven and its licensors.</p>
                    <p>You retain ownership of content you submit to our Service, but grant us a license to use, display, and distribute such content in connection with the Service.</p>
                    <p>You may not use our trademarks, logos, or other proprietary information without our express written consent.</p>
                </div>
            </section>

            <!-- 8. Privacy -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">8. Privacy</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>Your privacy is important to us. Please review our <a href="{{ route('privacy') }}" class="text-accent-600 hover:text-accent-700 font-semibold">Privacy Policy</a>, which also governs your use of the Service, to understand our practices.</p>
                </div>
            </section>

            <!-- 9. Disclaimers -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">9. Disclaimers</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>The Service is provided on an "AS IS" and "AS AVAILABLE" basis. Haven makes no representations or warranties of any kind, express or implied.</p>
                    <p>We do not warrant that the Service will be uninterrupted, secure, or error-free, or that defects will be corrected.</p>
                    <p>We are not responsible for the accuracy, completeness, or reliability of any property listings or user-generated content.</p>
                </div>
            </section>

            <!-- 10. Limitation of Liability -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">10. Limitation of Liability</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>In no event shall Haven, its directors, employees, or agents be liable for any indirect, incidental, special, consequential, or punitive damages arising out of your use of the Service.</p>
                    <p>Our total liability to you for all claims arising out of or relating to the Service shall not exceed the amount you paid us in the twelve months preceding the claim.</p>
                </div>
            </section>

            <!-- 11. Termination -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">11. Termination</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>We may terminate or suspend your account and access to the Service immediately, without prior notice, for conduct that we believe violates these Terms or is harmful to other users, us, or third parties.</p>
                    <p>You may terminate your account at any time by contacting us or using the account deletion feature in your profile settings.</p>
                </div>
            </section>

            <!-- 12. Changes to Terms -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">12. Changes to Terms</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>We reserve the right to modify these Terms at any time. We will notify users of any material changes by posting the new Terms on this page and updating the "Last updated" date.</p>
                    <p>Your continued use of the Service after any such changes constitutes your acceptance of the new Terms.</p>
                </div>
            </section>

            <!-- 13. Contact Information -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">13. Contact Information</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>If you have any questions about these Terms, please contact us:</p>
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <p><strong>Email:</strong> legal@haven.com</p>
                        <p><strong>Address:</strong> Haven Real Estate<br>
                        123 Property Lane<br>
                        Real Estate City, RE 12345</p>
                        <p><strong>Phone:</strong> +1 (555) 123-4567</p>
                    </div>
                </div>
            </section>

        </div>

        <!-- Back to Home -->
        <div class="mt-16 text-center">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-8 py-4 bg-accent-600 text-white font-bold rounded-xl hover:bg-accent-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
