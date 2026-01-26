# Haven Real Estate - Theme Colors & Typography Guide

## 🎨 Color Palette

### Primary Colors (Blue Tones)
Used for: Navigation, headers, dark backgrounds, main UI elements

| Shade | Hex Code | RGB | Usage |
|-------|----------|-----|-------|
| primary-50 | `#f0f9ff` | rgb(240, 249, 255) | Very light blue - backgrounds |
| primary-100 | `#e0f2fe` | rgb(224, 242, 254) | Light blue - subtle backgrounds |
| primary-200 | `#bae6fd` | rgb(186, 230, 253) | Lighter blue - hover states |
| primary-300 | `#7dd3fc` | rgb(125, 211, 252) | Medium light blue |
| primary-400 | `#38bdf8` | rgb(56, 189, 248) | Medium blue |
| primary-500 | `#0ea5e9` | rgb(14, 165, 233) | Base blue |
| primary-600 | `#0284c7` | rgb(2, 132, 199) | Darker blue |
| primary-700 | `#0369a1` | rgb(3, 105, 161) | Dark blue |
| primary-800 | `#075985` | rgb(7, 89, 133) | Very dark blue |
| **primary-900** | **`#0c4a6e`** | **rgb(12, 74, 110)** | **Main dark blue - sidebars, headers** |
| **primary-950** | **`#082f49`** | **rgb(8, 47, 73)** | **Darkest blue - main backgrounds, navigation** |

**Most Used:**
- `primary-950` (#082f49) - Main dark backgrounds, navigation bars
- `primary-900` (#0c4a6e) - Sidebar backgrounds, dark sections
- `primary-800` (#075985) - Gradient accents

---

### Accent Colors (Teal Tones)
Used for: Buttons, links, highlights, call-to-action elements

| Shade | Hex Code | RGB | Usage |
|-------|----------|-----|-------|
| accent-50 | `#f0fdfa` | rgb(240, 253, 250) | Very light teal - backgrounds |
| accent-100 | `#ccfbf1` | rgb(204, 251, 241) | Light teal - subtle backgrounds |
| accent-200 | `#99f6e4` | rgb(153, 246, 228) | Lighter teal |
| accent-300 | `#5eead4` | rgb(94, 234, 212) | Medium light teal |
| accent-400 | `#2dd4bf` | rgb(45, 212, 191) | Medium teal - active states |
| accent-500 | `#14b8a6` | rgb(20, 184, 166) | Base teal |
| **accent-600** | **`#0d9488`** | **rgb(13, 148, 136)** | **Main accent - buttons, links, highlights** |
| accent-700 | `#0f766e` | rgb(15, 118, 110) | Darker teal - hover states |
| accent-800 | `#115e59` | rgb(17, 94, 89) | Very dark teal |
| accent-900 | `#134e4a` | rgb(19, 78, 74) | Darkest teal |
| accent-950 | `#042f2e` | rgb(4, 47, 46) | Almost black teal |

**Most Used:**
- `accent-600` (#0d9488) - Primary buttons, links, active states
- `accent-500` (#14b8a6) - Hover effects, secondary highlights
- `accent-400` (#2dd4bf) - Bright accents, icons

---

### Neutral Colors (Gray Scale)
Standard Tailwind grays used throughout

| Color | Usage |
|-------|-------|
| `white` (#ffffff) | Backgrounds, cards, text on dark |
| `gray-50` | Very light backgrounds |
| `gray-100` | Light backgrounds, borders |
| `gray-200` | Borders, dividers |
| `gray-300` | Disabled states, placeholders |
| `gray-400` | Secondary text |
| `gray-500` | Muted text |
| `gray-600` | Body text |
| `gray-700` | Dark text |
| `gray-800` | Headings, important text |
| `gray-900` | Primary text |
| `black` (#000000) | Pure black (rarely used) |

---

## 🔤 Typography

### Font Families

#### 1. **Inter** (Body Font)
- **Usage**: Body text, paragraphs, form inputs, general content
- **Weights Available**: 300, 400, 500, 600, 700
- **CSS Class**: `font-sans`
- **Google Fonts**: `Inter:wght@300;400;500;600;700`

**Weight Usage:**
- `300` (Light) - Subtle text, descriptions
- `400` (Regular) - Body text, paragraphs
- `500` (Medium) - Emphasized text
- `600` (Semi-Bold) - Subheadings, labels
- `700` (Bold) - Strong emphasis

#### 2. **Outfit** (Heading Font)
- **Usage**: Headings (h1-h6), titles, hero text, brand elements
- **Weights Available**: 300, 400, 500, 600, 700, 800
- **CSS Class**: `font-heading`
- **Google Fonts**: `Outfit:wght@300;400;500;600;700;800`

**Weight Usage:**
- `300` (Light) - Elegant headings
- `400` (Regular) - Standard headings
- `500` (Medium) - Subheadings
- `600` (Semi-Bold) - Section titles
- `700` (Bold) - Main headings
- `800` (Extra Bold) - Hero text, large titles

---

### Font Sizes & Styles

#### Headings
```css
h1, h2, h3, h4, h5, h6 {
  font-family: 'Outfit', system-ui, sans-serif;
}
```

#### Body
```css
body {
  font-family: 'Inter', system-ui, sans-serif;
  color: #1f2937; /* gray-800 */
  -webkit-font-smoothing: antialiased;
}
```

#### Common Text Styles
- **Hero Text**: `text-5xl md:text-7xl font-black` (Outfit 800)
- **Page Titles**: `text-3xl font-black` (Outfit 800)
- **Section Headings**: `text-2xl font-bold` (Outfit 700)
- **Body Text**: `text-base font-normal` (Inter 400)
- **Small Text**: `text-sm font-medium` (Inter 500)
- **Tiny Text**: `text-xs font-bold` (Inter 700)

#### Special Typography Classes
- **Uppercase Tracking**: `uppercase tracking-[0.3em]` - Used for labels, buttons
- **Tight Tracking**: `tracking-tighter` - Used for large headings
- **Wide Tracking**: `tracking-[0.5em]` - Used for brand text

---

## 🎯 Usage Guidelines

### When to Use Primary Colors
- Main navigation bars
- Sidebar backgrounds
- Dark sections and hero backgrounds
- Footer backgrounds
- Card shadows and depth

### When to Use Accent Colors
- Call-to-action buttons
- Links and interactive elements
- Active/selected states
- Icons and badges
- Hover effects
- Progress indicators

### When to Use Fonts
- **Inter**: All body content, forms, tables, lists, descriptions
- **Outfit**: All headings, titles, hero text, brand elements, navigation labels

---

## 📋 Quick Reference

### Most Common Combinations

#### Primary Button
```html
<button class="bg-accent-600 hover:bg-accent-500 text-white font-bold uppercase tracking-[0.3em] text-xs rounded-xl px-6 py-3">
```

#### Secondary Button
```html
<button class="bg-white border border-gray-200 hover:bg-gray-50 text-primary-700 font-semibold text-sm rounded-lg px-6 py-3">
```

#### Hero Heading
```html
<h1 class="text-5xl md:text-7xl font-black text-primary-950 leading-none tracking-tighter font-heading">
```

#### Body Text
```html
<p class="text-base text-gray-600 font-light leading-relaxed">
```

#### Card
```html
<div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 p-6">
```

---

## 🎨 Color Psychology

### Primary Blue (#082f49, #0c4a6e)
- **Feeling**: Trust, professionalism, stability
- **Message**: Reliable, established, corporate
- **Perfect for**: Real estate, finance, professional services

### Accent Teal (#0d9488)
- **Feeling**: Modern, fresh, sophisticated
- **Message**: Innovation, growth, premium quality
- **Perfect for**: Luxury brands, tech, modern services

---

## 📱 Responsive Typography

### Mobile (< 640px)
- Hero: `text-3xl` (Outfit 800)
- Headings: `text-xl` (Outfit 700)
- Body: `text-sm` (Inter 400)

### Tablet (640px - 1024px)
- Hero: `text-5xl` (Outfit 800)
- Headings: `text-2xl` (Outfit 700)
- Body: `text-base` (Inter 400)

### Desktop (> 1024px)
- Hero: `text-7xl` (Outfit 800)
- Headings: `text-3xl` (Outfit 700)
- Body: `text-base` (Inter 400)

---

## 🔧 Implementation

### Tailwind Classes
```html
<!-- Primary Background -->
<div class="bg-primary-950">

<!-- Accent Button -->
<button class="bg-accent-600 hover:bg-accent-500">

<!-- Heading Font -->
<h1 class="font-heading font-black">

<!-- Body Font -->
<p class="font-sans font-normal">
```

### CSS Variables (if needed)
```css
:root {
  --color-primary: #082f49;
  --color-primary-light: #0c4a6e;
  --color-accent: #0d9488;
  --color-accent-light: #14b8a6;
  
  --font-body: 'Inter', system-ui, sans-serif;
  --font-heading: 'Outfit', system-ui, sans-serif;
}
```

---

## 📦 Export for Design Tools

### Figma/Sketch Color Palette
```
Primary-950: #082f49
Primary-900: #0c4a6e
Primary-800: #075985
Accent-600: #0d9488
Accent-500: #14b8a6
Accent-400: #2dd4bf
```

### Font Stack
```
Headings: Outfit (300, 400, 500, 600, 700, 800)
Body: Inter (300, 400, 500, 600, 700)
```

---

**Last Updated**: January 2026
**Project**: Haven Real Estate Management System
