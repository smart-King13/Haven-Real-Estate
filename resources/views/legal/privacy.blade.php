@extends('layouts.app')

@section('title', 'Privacy Policy - Haven')
@section('meta_description', 'Learn how Haven protects your privacy and handles your personal information on our real estate platform.')

@section('content')
<!-- Privacy Hero Section -->
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
                    <span class="text-[10px] font-black uppercase tracking-widest text-white">Privacy Policy</span>
                </li>
            </ol>
        </nav>

        <div class="inline-flex items-center gap-4 mb-6">
            <div class="w-8 h-[2px] bg-accent-500"></div>
            <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[10px]">Your Privacy Matters</span>
            <div class="w-8 h-[2px] bg-accent-500"></div>
        </div>

        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white leading-[0.9] tracking-tighter mb-6">
            Privacy <span class="text-accent-500 italic">Policy.</span>
        </h1>

        <p class="text-xl text-gray-300 font-light leading-relaxed max-w-2xl mx-auto">
            We are committed to protecting your privacy and ensuring the security of your personal information.
        </p>

        <div class="mt-8 text-sm text-white/60">
            Last updated: {{ now()->format('F j, Y') }}
        </div>
    </div>
</div>

<!-- Privacy Content -->
<div class="py-16 lg:py-24 bg-white">
    <div class="max-w-4xl mx-auto px-6 lg:px-12">
        <div class="prose prose-lg max-w-none">
            
            <!-- 1. Introduction -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">1. Introduction</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>Haven Real Estate ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.</p>
                    <p>Please read this Privacy Policy carefully. If you do not agree with the terms of this Privacy Policy, please do not access our site or use our services.</p>
                </div>
            </section>

            <!-- 2. Information We Collect -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">2. Information We Collect</h2>
                
                <h3 class="text-xl font-bold text-primary-950 mb-4">Personal Information</h3>
                <div class="space-y-4 text-gray-700 leading-relaxed mb-6">
                    <p>We may collect personal information that you voluntarily provide to us when you:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Register for an account</li>
                        <li>List a property</li>
                        <li>Make inquiries about properties</li>
                        <li>Contact us for support</li>
                        <li>Subscribe to our newsletter</li>
                        <li>Participate in surveys or promotions</li>
                    </ul>
                    <p>This information may include:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Name and contact information (email, phone, address)</li>
                        <li>Account credentials (username, password)</li>
                        <li>Payment information (processed securely by third parties)</li>
                        <li>Property information and preferences</li>
                        <li>Communication history and messages</li>
                    </ul>
                </div>

                <h3 class="text-xl font-bold text-primary-950 mb-4">Automatically Collected Information</h3>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>When you visit our website, we may automatically collect certain information about your device and usage patterns:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>IP address and location data</li>
                        <li>Browser type and version</li>
                        <li>Operating system</li>
                        <li>Pages visited and time spent</li>
                        <li>Referring website</li>
                        <li>Device information</li>
                    </ul>
                </div>
            </section>

            <!-- 3. How We Use Your Information -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">3. How We Use Your Information</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>We use the information we collect for various purposes, including:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Providing and maintaining our services</li>
                        <li>Processing transactions and payments</li>
                        <li>Communicating with you about your account and our services</li>
                        <li>Personalizing your experience and property recommendations</li>
                        <li>Improving our website and services</li>
                        <li>Preventing fraud and ensuring security</li>
                        <li>Complying with legal obligations</li>
                        <li>Marketing and promotional communications (with your consent)</li>
                    </ul>
                </div>
            </section>

            <!-- 4. Information Sharing -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">4. Information Sharing and Disclosure</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>We may share your information in the following circumstances:</p>
                    
                    <h3 class="text-lg font-semibold text-primary-950 mt-6 mb-3">With Other Users</h3>
                    <p>When you list a property or express interest in a property, certain information may be shared with other users to facilitate transactions.</p>
                    
                    <h3 class="text-lg font-semibold text-primary-950 mt-6 mb-3">With Service Providers</h3>
                    <p>We may share information with third-party service providers who help us operate our business, including:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Payment processors (Stripe, PayStack)</li>
                        <li>Email service providers</li>
                        <li>Analytics providers</li>
                        <li>Customer support tools</li>
                        <li>Security services</li>
                    </ul>
                    
                    <h3 class="text-lg font-semibold text-primary-950 mt-6 mb-3">Legal Requirements</h3>
                    <p>We may disclose your information if required by law or in response to valid legal requests from public authorities.</p>
                    
                    <h3 class="text-lg font-semibold text-primary-950 mt-6 mb-3">Business Transfers</h3>
                    <p>In the event of a merger, acquisition, or sale of assets, your information may be transferred as part of that transaction.</p>
                </div>
            </section>

            <!-- 5. Data Security -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">5. Data Security</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>
                    <p>These measures include:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Encryption of data in transit and at rest</li>
                        <li>Regular security assessments and updates</li>
                        <li>Access controls and authentication</li>
                        <li>Secure payment processing</li>
                        <li>Employee training on data protection</li>
                    </ul>
                    <p>However, no method of transmission over the internet or electronic storage is 100% secure. While we strive to protect your information, we cannot guarantee absolute security.</p>
                </div>
            </section>

            <!-- 6. Your Rights and Choices -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">6. Your Rights and Choices</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>You have certain rights regarding your personal information:</p>
                    
                    <h3 class="text-lg font-semibold text-primary-950 mt-6 mb-3">Access and Correction</h3>
                    <p>You can access and update your account information through your profile settings or by contacting us.</p>
                    
                    <h3 class="text-lg font-semibold text-primary-950 mt-6 mb-3">Data Portability</h3>
                    <p>You can request a copy of your personal information in a structured, machine-readable format.</p>
                    
                    <h3 class="text-lg font-semibold text-primary-950 mt-6 mb-3">Deletion</h3>
                    <p>You can request deletion of your personal information, subject to certain legal and business requirements.</p>
                    
                    <h3 class="text-lg font-semibold text-primary-950 mt-6 mb-3">Marketing Communications</h3>
                    <p>You can opt out of marketing communications by following the unsubscribe instructions in our emails or updating your preferences in your account settings.</p>
                    
                    <h3 class="text-lg font-semibold text-primary-950 mt-6 mb-3">Cookies</h3>
                    <p>You can control cookie preferences through your browser settings, though this may affect website functionality.</p>
                </div>
            </section>

            <!-- 7. Cookies and Tracking -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">7. Cookies and Tracking Technologies</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>We use cookies and similar tracking technologies to enhance your experience on our website. These technologies help us:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Remember your preferences and settings</li>
                        <li>Analyze website traffic and usage patterns</li>
                        <li>Provide personalized content and recommendations</li>
                        <li>Improve website performance and functionality</li>
                        <li>Prevent fraud and enhance security</li>
                    </ul>
                    <p>You can control cookie settings through your browser, but disabling cookies may limit some website features.</p>
                </div>
            </section>

            <!-- 8. Third-Party Links -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">8. Third-Party Links and Services</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>Our website may contain links to third-party websites or services. We are not responsible for the privacy practices or content of these third parties.</p>
                    <p>We encourage you to read the privacy policies of any third-party websites you visit.</p>
                </div>
            </section>

            <!-- 9. Children's Privacy -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">9. Children's Privacy</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>Our services are not intended for children under the age of 18. We do not knowingly collect personal information from children under 18.</p>
                    <p>If we become aware that we have collected personal information from a child under 18, we will take steps to delete such information promptly.</p>
                </div>
            </section>

            <!-- 10. International Data Transfers -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">10. International Data Transfers</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>Your information may be transferred to and processed in countries other than your own. We ensure that such transfers comply with applicable data protection laws and implement appropriate safeguards.</p>
                </div>
            </section>

            <!-- 11. Data Retention -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">11. Data Retention</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>We retain your personal information for as long as necessary to provide our services and fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required by law.</p>
                    <p>When we no longer need your information, we will securely delete or anonymize it.</p>
                </div>
            </section>

            <!-- 12. Changes to Privacy Policy -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">12. Changes to This Privacy Policy</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>We may update this Privacy Policy from time to time. We will notify you of any material changes by posting the new Privacy Policy on this page and updating the "Last updated" date.</p>
                    <p>We encourage you to review this Privacy Policy periodically for any changes.</p>
                </div>
            </section>

            <!-- 13. Contact Us -->
            <section class="mb-12">
                <h2 class="text-2xl lg:text-3xl font-black text-primary-950 mb-6">13. Contact Us</h2>
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>If you have any questions about this Privacy Policy or our privacy practices, please contact us:</p>
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <p><strong>Email:</strong> privacy@haven.com</p>
                        <p><strong>Address:</strong> Haven Real Estate<br>
                        123 Property Lane<br>
                        Real Estate City, RE 12345</p>
                        <p><strong>Phone:</strong> +1 (555) 123-4567</p>
                    </div>
                    <p>For data protection inquiries specifically, you can also contact our Data Protection Officer at: dpo@haven.com</p>
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
