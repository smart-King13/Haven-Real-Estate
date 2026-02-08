<form method="GET" action="{{ route('properties.index') }}" 
      class="bg-white rounded-[30px] md:rounded-full shadow-[0_32px_64px_-16px_rgba(0,0,0,0.15)] p-4 md:p-3 border border-gray-100 flex flex-col md:flex-row items-center gap-4 md:gap-3">
    
    <!-- Keywords segment -->
    <div class="flex-1 w-full px-8 md:px-10 py-6 group/input relative">
        <label class="block text-[9px] font-black uppercase tracking-[0.4em] text-gray-400 mb-3 group-focus-within/input:text-accent-600 transition-colors">Keywords</label>
        <div class="flex items-center gap-4">
            <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Haven..." 
                   class="w-full bg-transparent border-none p-0 focus:ring-0 text-base font-black text-primary-950 placeholder-gray-300 tracking-wide uppercase">
        </div>
        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[1px] h-12 bg-gray-100 hidden md:block"></div>
    </div>

    <!-- Portfolio Type Dropdown -->
    <div class="flex-1 w-full px-8 md:px-10 py-6 group/input relative" 
         x-data="{ open: false, selected: '{{ request('type') ? (request('type') == 'sale' ? 'For Sale' : 'For Rent') : 'All Types' }}' }">
        <label class="block text-[9px] font-black uppercase tracking-[0.4em] text-gray-400 mb-3 group-focus-within/input:text-accent-600 transition-colors">Portfolio Type</label>
        <div @click="open = !open" @click.away="open = false" class="relative flex items-center gap-4 cursor-pointer">
            <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            <span class="text-base font-black text-primary-950 tracking-wide uppercase truncate" x-text="selected"></span>
            <input type="hidden" name="type" :value="selected === 'For Sale' ? 'sale' : (selected === 'For Rent' ? 'rent' : '')">
            <svg class="w-3 h-3 text-gray-400 absolute right-0 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="absolute left-0 right-0 top-full mt-4 bg-white/95 backdrop-blur-xl rounded-[30px] shadow-2xl border border-gray-100 overflow-hidden z-50 p-2">
            @foreach(['All Types', 'For Sale', 'For Rent'] as $type)
                <div @click="selected = '{{ $type }}'; open = false" class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-primary-950 hover:bg-accent-500 hover:text-white rounded-[20px] transition-all cursor-pointer">
                    {{ $type }}
                </div>
            @endforeach
        </div>
        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[1px] h-12 bg-gray-100 hidden md:block"></div>
    </div>

    <!-- Category Dropdown -->
    @php
        $selectedCategoryName = 'All Categories';
        if (request('category_id')) {
            foreach ($categories as $cat) {
                if (is_object($cat) && $cat->id == request('category_id')) {
                    $selectedCategoryName = $cat->name;
                    break;
                } elseif (is_array($cat) && $cat['id'] == request('category_id')) {
                    $selectedCategoryName = $cat['name'];
                    break;
                }
            }
        }
        $categoryMap = [];
        foreach ($categories as $cat) {
            if (is_object($cat)) {
                $categoryMap[$cat->name] = $cat->id;
            } else {
                $categoryMap[$cat['name']] = $cat['id'];
            }
        }
    @endphp
    <div class="flex-1 w-full px-8 md:px-10 py-6 group/input relative" 
         x-data="{ open: false, selected: '{{ $selectedCategoryName }}' }">
        <label class="block text-[9px] font-black uppercase tracking-[0.4em] text-gray-400 mb-3 group-focus-within/input:text-accent-600 transition-colors">Category</label>
        <div @click="open = !open" @click.away="open = false" class="relative flex items-center gap-4 cursor-pointer">
            <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
            <span class="text-base font-black text-primary-950 tracking-wide uppercase truncate" x-text="selected"></span>
            <input type="hidden" name="category_id" :value="selected === 'All Categories' ? '' : {!! json_encode($categoryMap) !!}[selected]">
            <svg class="w-3 h-3 text-gray-400 absolute right-0 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="absolute left-0 right-0 top-full mt-4 bg-white/95 backdrop-blur-xl rounded-[30px] shadow-2xl border border-gray-100 overflow-hidden z-50 p-2 max-h-60 overflow-y-auto">
            <div @click="selected = 'All Categories'; open = false" class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-primary-950 hover:bg-accent-500 hover:text-white rounded-[20px] transition-all cursor-pointer">All Categories</div>
            @foreach($categories as $category)
                <div @click="selected = '{{ is_object($category) ? $category->name : $category['name'] }}'; open = false" class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-primary-950 hover:bg-accent-500 hover:text-white rounded-[20px] transition-all cursor-pointer">
                    {{ is_object($category) ? $category->name : $category['name'] }}
                </div>
            @endforeach
        </div>
        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[1px] h-12 bg-gray-100 hidden md:block"></div>
    </div>

    <!-- Investment Dropdown -->
    <div class="flex-1 w-full px-8 md:px-10 py-6 group/input relative" 
         x-data="{ open: false, selected: '{{ request('max_price') ? 'Up to $' . number_format(request('max_price')) : 'Any Investment' }}' }">
        <label class="block text-[9px] font-black uppercase tracking-[0.4em] text-gray-400 mb-3 group-focus-within/input:text-accent-600 transition-colors">Investment</label>
        <div @click="open = !open" @click.away="open = false" class="relative flex items-center gap-4 cursor-pointer">
            <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-base font-black text-primary-950 tracking-wide uppercase truncate" x-text="selected"></span>
            <input type="hidden" name="max_price" :value="selected === 'Any Investment' ? '' : selected.replace(/[^0-9]/g, '')">
            <svg class="w-3 h-3 text-gray-400 absolute right-0 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="absolute left-0 right-0 top-full mt-4 bg-white/95 backdrop-blur-xl rounded-[30px] shadow-2xl border border-gray-100 overflow-hidden z-50 p-2">
            @foreach(['Any Investment', 'Up to $1M', 'Up to $5M', 'Up to $10M', 'Up to $50M'] as $price)
                <div @click="selected = '{{ $price }}'; open = false" class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-primary-950 hover:bg-accent-500 hover:text-white rounded-[20px] transition-all cursor-pointer">
                    {{ $price }}
                </div>
            @endforeach
        </div>
    </div>

    <!-- Action Button -->
    <button type="submit" class="w-full md:w-auto px-12 py-4 md:py-6 bg-accent-600 text-white font-black uppercase tracking-[0.3em] rounded-[20px] md:rounded-full hover:bg-accent-500 transition-all duration-500 text-[10px] shadow-2xl active:scale-95 group/btn">
        <span class="flex items-center justify-center gap-3">
            Search Portfolio
            <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </span>
    </button>
</form>
