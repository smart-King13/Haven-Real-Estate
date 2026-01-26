/**
 * Haven Loading Spinner
 * Shows only on initial project startup
 */

class HavenLoader {
    constructor() {
        this.spinner = document.getElementById('haven-loading-spinner');
        this.minLoadTime = 2000; // 2 seconds for startup only
        this.startTime = Date.now();
        this.isVisible = false;
        this.hasShownStartup = false; // Track if startup spinner has been shown
        
        if (this.spinner) {
            this.init();
        }
    }

    init() {
        // Only show spinner on initial startup (first page load)
        if (!this.hasShownStartup && !sessionStorage.getItem('haven-startup-shown')) {
            this.showStartup();
        } else {
            // Hide spinner immediately if not startup
            this.hideImmediately();
        }
    }

    showStartup() {
        if (!this.spinner || this.isVisible) return;
        
        this.isVisible = true;
        this.hasShownStartup = true;
        this.startTime = Date.now();
        
        // Mark startup as shown in session
        sessionStorage.setItem('haven-startup-shown', 'true');
        
        // Show and fade in
        this.spinner.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Force reflow then ensure visibility
        this.spinner.offsetHeight;
        this.spinner.style.opacity = '1';
        
        // Hide after 2 seconds regardless of page load state
        setTimeout(() => {
            this.hide();
        }, this.minLoadTime);
    }

    show() {
        // Only allow manual show calls, no automatic navigation shows
        if (!this.spinner || this.isVisible) return;
        
        this.isVisible = true;
        this.startTime = Date.now();
        
        // Show and fade in
        this.spinner.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Force reflow then fade in
        this.spinner.offsetHeight;
        this.spinner.style.opacity = '1';
    }

    hide() {
        if (!this.spinner || !this.isVisible) return;
        
        // Fade out
        this.spinner.style.opacity = '0';
        
        setTimeout(() => {
            this.spinner.style.display = 'none';
            document.body.style.overflow = '';
            this.isVisible = false;
        }, 300);
    }

    hideImmediately() {
        if (!this.spinner) return;
        
        this.spinner.style.display = 'none';
        this.spinner.style.opacity = '0';
        document.body.style.overflow = '';
        this.isVisible = false;
    }

    // Static methods for manual control only
    static show(duration = 2000) {
        if (window.havenLoader) {
            window.havenLoader.minLoadTime = duration;
            window.havenLoader.show();
            
            // Auto hide after duration
            setTimeout(() => {
                window.havenLoader.hide();
            }, duration);
        }
    }

    static hide() {
        if (window.havenLoader) {
            window.havenLoader.hide();
        }
    }

    // Method to reset startup state (for testing)
    static resetStartup() {
        sessionStorage.removeItem('haven-startup-shown');
        if (window.havenLoader) {
            window.havenLoader.hasShownStartup = false;
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.havenLoader = new HavenLoader();
});

// Export for global access
window.HavenLoader = HavenLoader;