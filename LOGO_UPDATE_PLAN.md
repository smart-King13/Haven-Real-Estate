# Logo Replacement Plan

## Your New Logo
- **File**: The architectural "H" logo with building design (black background, white logo)
- **Location**: Should be saved to `public/images/haven-logo.png`

## Locations to Update

### 1. Main Navigation (Public Pages)
**File**: `resources/views/layouts/navigation.blade.php` (Line ~13)
- Currently: Uses `haven-logo.png` (already correct path!)
- Status: ✅ Already configured correctly

### 2. Admin Sidebar Logo
**File**: `resources/views/layouts/admin.blade.php` (Lines 29-34)
- Currently: SVG house icon
- Will replace with: `<img src="{{ asset('images/haven-logo.png') }}" alt="Haven Logo" class="h-6 w-6 object-contain">`

### 3. User Dashboard Sidebar Logo  
**File**: `resources/views/layouts/user.blade.php` (Lines 29-34)
- Currently: SVG house icon
- Will replace with: `<img src="{{ asset('images/haven-logo.png') }}" alt="Haven Logo" class="h-6 w-6 object-contain">`

### 4. Auth Pages (Login/Register)
**File**: `resources/views/auth/login.blade.php` and `register.blade.php`
- Need to check if they have logos

### 5. Email Templates (if any)
- Need to check email notification templates

## Steps to Complete

1. ✅ Create `public/images/` directory
2. ⏳ **YOU NEED TO DO**: Save your logo image as `public/images/haven-logo.png`
3. ⏳ Update all layout files to use the new logo
4. ⏳ Test all pages to ensure logo displays correctly

## Logo Specifications

Your logo appears to be:
- **Style**: Minimalist architectural design
- **Colors**: White on black (will need transparent PNG or white version for light backgrounds)
- **Design**: Letter "H" integrated with building/house structure
- **Format**: PNG recommended for web use

## Important Notes

- The logo has a **black background** in the image you showed
- For the navigation (which has white/light backgrounds when scrolled), you may need:
  - A **transparent PNG** version, OR
  - A **white background** version, OR  
  - CSS to invert colors based on background

Would you like me to create both light and dark versions of the logo placement?
