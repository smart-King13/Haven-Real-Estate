@props(['name', 'label' => '', 'options' => [], 'value' => '', 'placeholder' => 'Select an option', 'height' => 'h-14'])

<div class="w-full" 
     x-data="{ 
        open: false, 
        value: @js($value), 
        label: '',
        options: @js($options),
        init() {
            const selected = this.options.find(o => o.value == this.value);
            this.label = selected ? selected.label : '{{ $placeholder }}';
        },
        select(option) {
            this.value = option.value;
            this.label = option.label;
            this.open = false;
            this.$el.dispatchEvent(new CustomEvent('change', { detail: { value: this.value }, bubbles: true }));
        }
     }"
     :class="{ 'relative z-50': open }">
    @if($label)
        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ $label }}</label>
    @endif
    
    <div class="relative">
        <input type="hidden" name="{{ $name }}" :value="value">
        
        <button type="button" 
                @click="open = !open"
                @click.away="open = false" 
                class="w-full flex items-center justify-between px-5 {{ $height }} bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:border-accent-500 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-accent-500/10 group">
            <span x-text="label" :class="{ 'text-gray-400': !value }"></span>
            <svg class="h-5 w-5 text-gray-400 group-hover:text-accent-500 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Menu -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
             class="absolute left-0 right-0 z-[1000] mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 overflow-hidden transform origin-top"
             style="display: none; position: absolute !important;">
            <div class="max-h-60 overflow-y-auto custom-scrollbar">
                <template x-for="option in options" :key="option.value">
                    <button type="button" 
                            @click="select(option)" 
                            class="w-full text-left px-5 py-3.5 text-sm transition-all duration-200 flex items-center justify-between group"
                            :class="{ 
                                'bg-accent-50 text-accent-700 font-bold': value == option.value,
                                'text-gray-600 hover:bg-gray-50 hover:text-gray-900': value != option.value 
                            }">
                        <span x-text="option.label"></span>
                        <svg x-show="value == option.value" class="h-4 w-4 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </template>
            </div>
        </div>
    </div>
</div>
