# Haven Real Estate - Mobile App Theme Guide

## 🎨 Brand Identity

**Brand Name**: Haven  
**Tagline**: Premium Real Estate Management & Listings  
**Design Philosophy**: Minimalist architectural luxury with sophisticated spacing and typography

---

## 📐 Logo

**Primary Logo**: Architectural "H" with building structure  
**File Location**: `public/images/haven-logo.png`  
**Style**: White logo on black background (or transparent)  
**Usage**: 
- Navigation headers
- Splash screens
- Loading states
- Authentication screens

---

## 🎨 Color Palette

### Primary Colors (Blue Tones)
```
Primary 50:  #f0f9ff  (Very light blue - backgrounds)
Primary 100: #e0f2fe  (Light blue)
Primary 200: #bae6fd  (Soft blue)
Primary 300: #7dd3fc  (Medium light blue)
Primary 400: #38bdf8  (Medium blue)
Primary 500: #0ea5e9  (Base blue)
Primary 600: #0284c7  (Strong blue)
Primary 700: #0369a1  (Dark blue)
Primary 800: #075985  (Darker blue)
Primary 900: #0c4a6e  (Very dark blue - headers, text)
Primary 950: #082f49  (Darkest blue - navigation, footers)
```

### Accent Colors (Teal Tones)
```
Accent 50:  #f0fdfa  (Very light teal)
Accent 100: #ccfbf1  (Light teal)
Accent 200: #99f6e4  (Soft teal)
Accent 300: #5eead4  (Medium light teal)
Accent 400: #2dd4bf  (Medium teal)
Accent 500: #14b8a6  (Base teal)
Accent 600: #0d9488  (Main accent - buttons, highlights) ⭐ PRIMARY ACCENT
Accent 700: #0f766e  (Dark teal)
Accent 800: #115e59  (Darker teal)
Accent 900: #134e4a  (Very dark teal)
Accent 950: #042f2e  (Darkest teal)
```

### Neutral Colors
```
White:       #ffffff
Black:       #000000
Gray 50:     #f9fafb  (Backgrounds)
Gray 100:    #f3f4f6  (Light backgrounds)
Gray 200:    #e5e7eb  (Borders)
Gray 300:    #d1d5db  (Disabled states)
Gray 400:    #9ca3af  (Placeholder text)
Gray 500:    #6b7280  (Secondary text)
Gray 600:    #4b5563  (Body text)
Gray 700:    #374151  (Dark text)
Gray 800:    #1f2937  (Headings)
Gray 900:    #111827  (Primary text)
Gray 950:    #030712  (Darkest)
```

### Semantic Colors
```
Success: #10b981  (Green)
Warning: #f59e0b  (Amber)
Error:   #ef4444  (Red)
Info:    #3b82f6  (Blue)
```

---

## 🔤 Typography

### Font Families

**Primary Font (Body Text)**: Inter  
- Weights: 300 (Light), 400 (Regular), 500 (Medium), 600 (Semi-Bold), 700 (Bold)
- Usage: Body text, descriptions, labels, forms
- Google Fonts: `https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap`

**Heading Font**: Outfit  
- Weights: 300 (Light), 400 (Regular), 500 (Medium), 600 (Semi-Bold), 700 (Bold), 800 (Extra-Bold)
- Usage: Headings, titles, navigation, buttons
- Google Fonts: `https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap`

### Font Sizes (Mobile Optimized)

```
Heading 1:    32-40px  (font-black, uppercase, tracking-tighter)
Heading 2:    28-32px  (font-black, uppercase)
Heading 3:    24-28px  (font-bold, uppercase)
Heading 4:    20-24px  (font-semibold)
Heading 5:    18-20px  (font-semibold)
Heading 6:    16-18px  (font-medium)

Body Large:   18px     (font-light, leading-relaxed)
Body Regular: 16px     (font-normal)
Body Small:   14px     (font-normal)
Caption:      12px     (font-medium)
Tiny:         10-11px  (font-black, uppercase, tracking-wide)
```

### Letter Spacing (Tracking)
```
Tightest:  -0.05em  (tracking-tighter)
Tight:     -0.025em (tracking-tight)
Normal:     0em     (tracking-normal)
Wide:       0.025em (tracking-wide)
Wider:      0.05em  (tracking-wider)
Widest:     0.1em   (tracking-widest)
Extra Wide: 0.3-0.5em (tracking-[0.3em] to tracking-[0.5em])
```

### Font Weights
```
Light:      300
Regular:    400
Medium:     500
Semi-Bold:  600
Bold:       700
Extra-Bold: 800
Black:      900
```

---

## 📏 Spacing System

### Base Unit: 4px

```
0:    0px
1:    4px
2:    8px
3:    12px
4:    16px
5:    20px
6:    24px
8:    32px
10:   40px
12:   48px
16:   64px
20:   80px
24:   96px
32:   128px
40:   160px
```

### Common Spacing Patterns
```
Card Padding:        16-24px (p-4 to p-6)
Section Padding:     32-48px (p-8 to p-12)
Button Padding:      12px 24px (py-3 px-6)
Input Padding:       12px 16px (py-3 px-4)
List Item Spacing:   12-16px (gap-3 to gap-4)
Section Margins:     32-64px (my-8 to my-16)
```

---

## 🔘 Border Radius

```
None:     0px      (rounded-none)
Small:    4px      (rounded-sm)
Default:  8px      (rounded)
Medium:   12px     (rounded-lg)
Large:    16px     (rounded-xl)
XL:       20px     (rounded-2xl)
2XL:      24px     (rounded-3xl)
Full:     9999px   (rounded-full) - for circles
```

### Component-Specific Radius
```
Buttons:       12px (rounded-xl)
Cards:         16-20px (rounded-xl to rounded-2xl)
Inputs:        8-12px (rounded-lg)
Modals:        24px (rounded-3xl)
Images:        12-16px (rounded-xl)
Avatars:       9999px (rounded-full)
Badges:        9999px (rounded-full)
```

---

## 🎭 Shadows

```
Small:    0 1px 2px rgba(0,0,0,0.05)
Default:  0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06)
Medium:   0 4px 6px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.06)
Large:    0 10px 15px rgba(0,0,0,0.1), 0 4px 6px rgba(0,0,0,0.05)
XL:       0 20px 25px rgba(0,0,0,0.1), 0 10px 10px rgba(0,0,0,0.04)
2XL:      0 25px 50px rgba(0,0,0,0.25)

Exceptional: 0 50px 100px -20px rgba(0,0,0,0.12), 0 30px 60px -30px rgba(0,0,0,0.15)
```

### Colored Shadows
```
Accent Shadow:  0 10px 25px rgba(13,148,136,0.2)  (accent-600 with 20% opacity)
Primary Shadow: 0 10px 25px rgba(8,47,73,0.2)     (primary-950 with 20% opacity)
```

---

## 🎨 Component Styles

### Buttons

#### Primary Button
```
Background:     accent-600 (#0d9488)
Text:           white
Padding:        12px 24px
Border Radius:  12px
Font:           font-semibold, text-sm, uppercase, tracking-wide
Shadow:         Large shadow with accent color
Hover:          accent-500, translate-y(-2px)
```

#### Secondary Button
```
Background:     white
Text:           primary-700
Border:         1px solid gray-200
Padding:        12px 24px
Border Radius:  12px
Font:           font-semibold, text-sm
Hover:          bg-gray-50, border-gray-300
```

#### Danger Button
```
Background:     red-600
Text:           white
Padding:        12px 24px
Border Radius:  12px
Font:           font-semibold, text-sm
Shadow:         Large shadow with red color
```

### Cards

```
Background:     white
Border:         1px solid gray-100
Border Radius:  16-20px
Padding:        24px
Shadow:         Small to medium
Hover:          shadow-lg, scale-105 (subtle)
```

### Inputs

```
Background:     gray-50
Border:         1px solid gray-200
Border Radius:  8-12px
Padding:        12px 16px
Font:           text-sm
Focus:          ring-2 ring-accent-500, border-accent-500, bg-white
```

### Navigation Bar

```
Background:     primary-950 (#082f49) or white (when scrolled)
Height:         64-72px
Padding:        16px 24px
Border Radius:  0 0 30px 30px (bottom rounded when scrolled)
Shadow:         Large shadow when scrolled
Logo Size:      40x40px
```

### Bottom Navigation (Mobile)

```
Background:     white
Height:         64px
Border Top:     1px solid gray-100
Shadow:         Reverse shadow (top)
Icon Size:      24x24px
Active Color:   accent-600
Inactive Color: gray-400
```

---

## 🎬 Animations & Transitions

### Timing Functions
```
Ease:           cubic-bezier(0.4, 0, 0.2, 1)
Ease-In:        cubic-bezier(0.4, 0, 1, 1)
Ease-Out:       cubic-bezier(0, 0, 0.2, 1)
Ease-In-Out:    cubic-bezier(0.4, 0, 0.2, 1)
```

### Duration
```
Fast:    150ms
Normal:  300ms
Slow:    500ms
Slower:  700ms
```

### Common Animations
```
Fade In:        opacity 0 → 1, duration 300ms
Slide Up:       translateY(20px) → 0, duration 400ms
Scale:          scale(0.95) → 1, duration 200ms
Bounce:         Custom keyframe animation
Pulse:          scale(1) → 1.05 → 1, duration 2s infinite
```

---

## 📱 Mobile-Specific Guidelines

### Screen Breakpoints
```
Small:    320px - 640px   (Mobile portrait)
Medium:   641px - 768px   (Mobile landscape, small tablets)
Large:    769px - 1024px  (Tablets)
XL:       1025px+         (Desktop)
```

### Touch Targets
```
Minimum Size:   44x44px (iOS) / 48x48px (Android)
Buttons:        48px height minimum
List Items:     56-64px height
Icons:          24x24px (with 44x44px touch area)
```

### Safe Areas
```
Top Padding:    Safe area + 16px
Bottom Padding: Safe area + 16px
Side Padding:   16-24px
```

---

## 🖼️ Image Guidelines

### Property Images
```
Aspect Ratio:   4:3 or 16:9
Border Radius:  12-16px
Quality:        High (80-90%)
Loading:        Progressive with blur placeholder
```

### Profile Images
```
Size:           40x40px (small), 64x64px (medium), 96x96px (large)
Shape:          Circle (rounded-full)
Border:         Optional 2px white border
Fallback:       First letter of name on accent-600 background
```

### Logo
```
Size:           40x40px (navigation), 64x64px (splash)
Format:         PNG with transparency
Background:     Transparent or black
```

---

## 🎯 UI Patterns

### Loading States
```
Spinner:        Circular, accent-600 color
Skeleton:       gray-200 background with shimmer animation
Progress Bar:   accent-600 fill, gray-200 background
```

### Empty States
```
Icon:           Large (64x64px), gray-300 color
Title:          text-xl, font-bold, gray-900
Description:    text-sm, gray-500
Action Button:  Primary button
```

### Error States
```
Icon:           Red-500 color
Message:        text-sm, red-600
Background:     red-50
Border:         red-200
```

### Success States
```
Icon:           Green-500 color
Message:        text-sm, green-600
Background:     green-50
Border:         green-200
```

---

## 📋 Common Screens

### Authentication Screens
```
Background:     primary-950 with architectural image overlay
Card:           primary-950/80 with backdrop blur
Logo:           64x64px, centered, white background
Inputs:         Dark theme with white/10 borders
Buttons:        accent-600, full width
```

### Home/Dashboard
```
Header:         primary-950 with gradient
Cards:          white with shadows
Spacing:        32-48px between sections
Grid:           2 columns on mobile, 3-4 on tablet
```

### Property Listing
```
Card Height:    Auto (image + content)
Image:          aspect-4/3
Price:          text-2xl, font-black, accent-600
Title:          text-lg, font-bold, gray-900
Location:       text-sm, gray-500
```

### Property Detail
```
Image Gallery:  Full width carousel
Price:          text-3xl, font-black, accent-600
Features:       Grid layout with icons
CTA Button:     Fixed bottom, accent-600
```

---

## 🎨 Design Tokens (JSON Format)

```json
{
  "colors": {
    "primary": {
      "50": "#f0f9ff",
      "500": "#0ea5e9",
      "950": "#082f49"
    },
    "accent": {
      "50": "#f0fdfa",
      "600": "#0d9488",
      "950": "#042f2e"
    }
  },
  "spacing": {
    "xs": 4,
    "sm": 8,
    "md": 16,
    "lg": 24,
    "xl": 32
  },
  "borderRadius": {
    "sm": 8,
    "md": 12,
    "lg": 16,
    "xl": 20,
    "full": 9999
  },
  "typography": {
    "fontFamily": {
      "body": "Inter",
      "heading": "Outfit"
    },
    "fontSize": {
      "xs": 12,
      "sm": 14,
      "base": 16,
      "lg": 18,
      "xl": 20,
      "2xl": 24,
      "3xl": 32
    }
  }
}
```

---

## 🔗 Resources

### Fonts
- Inter: https://fonts.google.com/specimen/Inter
- Outfit: https://fonts.google.com/specimen/Outfit

### Icons
- Heroicons (recommended): https://heroicons.com/
- Style: Outline for inactive, Solid for active states
- Size: 24x24px standard

### Images
- Unsplash (architectural/luxury properties)
- High quality, professional photography
- Consistent color grading

---

## 📝 Notes

1. **Consistency**: Maintain exact color values across platforms
2. **Accessibility**: Ensure minimum contrast ratio of 4.5:1 for text
3. **Performance**: Optimize images and use appropriate formats
4. **Dark Mode**: Consider implementing with primary-950 as base
5. **Localization**: Support RTL layouts if needed

---

**Last Updated**: January 2026  
**Version**: 1.0  
**Platform**: iOS & Android Mobile Apps
