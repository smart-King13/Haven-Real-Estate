<!-- Newsletter Section: Exceptional Narrative -->
<div class="py-40 bg-primary-950 relative overflow-hidden">
    <!-- Abstract Watermark -->
    <div class="absolute top-1/2 left-0 -translate-y-1/2 opacity-[0.03] select-none pointer-events-none -rotate-90">
        <span class="text-[200px] font-black leading-none tracking-tighter text-white">JOURNAL</span>
    </div>

    <div class="max-w-[1600px] mx-auto px-6 lg:px-12 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-32 items-center">
            <!-- Left: High-Impact Typography -->
            <div class="space-y-12 animate-reveal">
                <div class="space-y-6">
                    <span class="text-accent-500 font-bold uppercase tracking-[0.4em] text-[10px]">Weekly Insights</span>
                    <h2 class="text-6xl md:text-8xl font-black text-white leading-none tracking-tighter">
                        The Haven <br>
                        <span class="text-accent-500 italic">Chronicle.</span>
                    </h2>
                </div>
                <p class="text-xl text-gray-400 font-light leading-relaxed max-w-xl">
                    Join a curated community of investors and homeowners. Receive off-market opportunities and architectural narratives directly.
                </p>
                
                <div class="flex items-center gap-12 pt-6">
                    <div class="space-y-2">
                        <?php
                            $subscriberCount = \Illuminate\Support\Facades\Cache::remember('subscriber_count', 300, function() {
                                try {
                                    $supabase = app(\App\Services\SupabaseService::class);
                                    return $supabase->count('newsletter_subscribers');
                                } catch (\Exception $e) {
                                    return 0;
                                }
                            });
                        ?>
                        <div class="text-3xl font-black text-white">{{ $subscriberCount > 0 ? $subscriberCount : '0' }}<span class="text-accent-500">+</span></div>
                        <div class="text-[9px] font-bold uppercase tracking-[0.3em] text-gray-500">Subscribers</div>
                    </div>
                    <div class="w-[1px] h-12 bg-white/10"></div>
                    <div class="space-y-2">
                        <div class="text-3xl font-black text-white">Weekly</div>
                        <div class="text-[9px] font-bold uppercase tracking-[0.3em] text-gray-500">Editions</div>
                    </div>
                </div>
            </div>

            <!-- Right: Sophisticated Minimal Form -->
            <div class="animate-reveal [animation-delay:0.3s]">
                <div class="glass-premium p-12 md:p-16 rounded-[60px] exceptional-shadow border-white/5">
                    <!-- Success/Error Messages -->
                    <div id="newsletter-message" class="hidden mb-6"></div>

                    @auth
                        <form id="newsletter-form" class="space-y-10">
                            @csrf
                            <div class="space-y-8">
                                <div class="relative group/input">
                                    <label class="block text-[10px] font-black uppercase tracking-[0.3em] text-accent-500 mb-4 group-focus-within/input:text-accent-400 transition-colors">Identity</label>
                                    <input type="text" name="name" placeholder="Your full name" value="{{ session('supabase_profile')->name ?? '' }}"
                                           class="w-full bg-transparent border-0 border-b border-white/10 pb-4 text-xl text-white placeholder-white/20 focus:ring-0 focus:border-accent-500 focus:border-b-2 focus:placeholder-white/40 transition-all font-light group-focus-within/input:border-accent-400">
                                    <p class="error-message mt-2 text-xs text-red-400 hidden"></p>
                                </div>

                                <div class="relative group/input">
                                    <label class="block text-[10px] font-black uppercase tracking-[0.3em] text-accent-500 mb-4 group-focus-within/input:text-accent-400 transition-colors">Correspondence</label>
                                    <input type="email" name="email" placeholder="Your primary email" value="{{ session('supabase_user')->email ?? '' }}" required
                                           class="w-full bg-transparent border-0 border-b border-white/10 pb-4 text-xl text-white placeholder-white/20 focus:ring-0 focus:border-accent-500 focus:border-b-2 focus:placeholder-white/40 transition-all font-light group-focus-within/input:border-accent-400">
                                    <p class="error-message mt-2 text-xs text-red-400 hidden"></p>
                                </div>
                            </div>

                            <div class="pt-6">
                                <button type="submit" id="subscribe-btn" class="w-full py-7 bg-white text-primary-950 font-black uppercase tracking-[0.4em] rounded-full hover:bg-accent-600 hover:text-white transition-all duration-500 text-xs shadow-2xl transform hover:-translate-y-1">
                                    <span class="btn-text">Secure Invitation</span>
                                    <span class="btn-loading hidden">
                                        <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>

                            <p class="text-center text-[9px] font-bold uppercase tracking-[0.2em] text-gray-500">
                               No compromise on privacy. Unsubscribe anytime.
                            </p>
                        </form>
                    @else
                        <div class="text-center space-y-8">
                            <div class="space-y-4">
                                <svg class="w-16 h-16 mx-auto text-accent-500/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <h3 class="text-2xl font-black text-white uppercase tracking-wider">Members Only</h3>
                                <p class="text-gray-400 text-sm font-light">Please sign in to subscribe to our newsletter</p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-primary-950 font-black uppercase tracking-[0.3em] rounded-full hover:bg-accent-600 hover:text-white transition-all duration-500 text-xs shadow-2xl">
                                    Sign In
                                </a>
                                <a href="{{ route('register') }}" class="px-8 py-4 bg-transparent border-2 border-white/20 text-white font-black uppercase tracking-[0.3em] rounded-full hover:border-accent-500 hover:text-accent-500 transition-all duration-500 text-xs">
                                    Register
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@auth
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsletter-form');
    const messageDiv = document.getElementById('newsletter-message');
    const submitBtn = document.getElementById('subscribe-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');

    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Disable button and show loading
            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');

            // Clear previous messages
            messageDiv.classList.add('hidden');
            document.querySelectorAll('.error-message').forEach(el => el.classList.add('hidden'));

            const formData = new FormData(form);

            try {
                const response = await fetch('{{ route("newsletter.subscribe") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    // Success
                    messageDiv.className = 'mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-2xl text-green-400 text-sm';
                    messageDiv.textContent = data.message || 'Successfully subscribed!';
                    messageDiv.classList.remove('hidden');
                    
                    // Reset form
                    form.reset();
                    
                    // Scroll to message
                    messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else {
                    // Error
                    if (data.errors) {
                        // Validation errors
                        Object.keys(data.errors).forEach(key => {
                            const input = form.querySelector(`[name="${key}"]`);
                            if (input) {
                                const errorMsg = input.parentElement.querySelector('.error-message');
                                if (errorMsg) {
                                    errorMsg.textContent = data.errors[key][0];
                                    errorMsg.classList.remove('hidden');
                                }
                            }
                        });
                    } else {
                        // General error
                        messageDiv.className = 'mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm';
                        messageDiv.textContent = data.message || 'Failed to subscribe. Please try again.';
                        messageDiv.classList.remove('hidden');
                    }
                }
            } catch (error) {
                messageDiv.className = 'mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm';
                messageDiv.textContent = 'An error occurred. Please try again.';
                messageDiv.classList.remove('hidden');
            } finally {
                // Re-enable button
                submitBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
            }
        });
    }
});
</script>
@endauth
