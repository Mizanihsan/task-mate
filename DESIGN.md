---
name: Academic Precision
colors:
  surface: '#FFFFFF'
  surface-dim: '#d9dade'
  surface-bright: '#f8f9fd'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f3f7'
  surface-container: '#edeef2'
  surface-container-high: '#e7e8ec'
  surface-container-highest: '#e1e2e6'
  on-surface: '#191c1f'
  on-surface-variant: '#444651'
  inverse-surface: '#2e3134'
  inverse-on-surface: '#eff1f5'
  outline: '#757682'
  outline-variant: '#c5c5d3'
  surface-tint: '#4459a8'
  primary: '#233a87'
  on-primary: '#ffffff'
  primary-container: '#3d52a0'
  on-primary-container: '#c0cbff'
  inverse-primary: '#b7c4ff'
  secondary: '#385bac'
  on-secondary: '#ffffff'
  secondary-container: '#88a9ff'
  on-secondary-container: '#0e3a8b'
  tertiary: '#2e3f66'
  on-tertiary: '#ffffff'
  tertiary-container: '#45567f'
  on-tertiary-container: '#bbccfc'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dce1ff'
  primary-fixed-dim: '#b7c4ff'
  on-primary-fixed: '#001552'
  on-primary-fixed-variant: '#2b418e'
  secondary-fixed: '#dae2ff'
  secondary-fixed-dim: '#b2c5ff'
  on-secondary-fixed: '#001847'
  on-secondary-fixed-variant: '#1a4293'
  tertiary-fixed: '#d9e2ff'
  tertiary-fixed-dim: '#b5c6f5'
  on-tertiary-fixed: '#051a40'
  on-tertiary-fixed-variant: '#35466e'
  background: '#f8f9fd'
  on-background: '#191c1f'
  surface-variant: '#e1e2e6'
  text-primary: '#1E2235'
  text-secondary: '#6B7280'
  success: '#22C55E'
  warning: '#F59E0B'
  danger: '#EF4444'
  border: '#E5E7EB'
typography:
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '600'
    lineHeight: '1.2'
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: '1.3'
  headline-sm:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '500'
    lineHeight: '1.4'
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.6'
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: '1.5'
  label-md:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: '1'
    letterSpacing: 0.05em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 26px
    fontWeight: '600'
    lineHeight: '1.2'
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 4px
  xs: 8px
  sm: 16px
  md: 24px
  lg: 32px
  xl: 48px
  gutter: 20px
  margin-mobile: 16px
  margin-desktop: 32px
---

## Brand & Style

The design system is engineered for the modern academic environment, focusing on clarity, focus, and organization. The target audience—students and educators—requires a UI that minimizes cognitive load while maintaining an authoritative and trustworthy feel.

The chosen style is **Corporate / Modern** with a focus on institutional reliability. It utilizes a structured layout, generous whitespace to prevent "study fatigue," and a clear hierarchy that mirrors academic rigor. The aesthetic is clean and professional, using a "Paper & Ink" philosophy where content sits on clear, elevated surfaces against a calm, expansive background.

## Colors

The palette is anchored by **Deep Indigo**, providing a sense of stability and academic authority. **Slate Blue** and **Soft Lavender** function as structural accents to guide the eye toward interactive elements and secondary information.

**Ghost White** is the foundation for the background to reduce screen glare during long study sessions, while **Pure White** is reserved for functional surfaces (cards, modals) to create a clear "layering" effect. Semantic colors for success, warning, and danger are slightly desaturated to maintain the professional tone while remaining high-contrast for accessibility.

## Typography

This design system relies exclusively on **Inter** to ensure maximum legibility across all digital interfaces. The type scale is utilitarian, prioritizing scanning efficiency. 

- **Headlines** utilize semi-bold weights with slight negative letter-spacing for a compact, authoritative appearance.
- **Body text** uses a generous line height (1.6) to improve readability of task descriptions and notes.
- **Labels** are rendered in medium weight with increased letter-spacing to distinguish them from interactive text.
- On mobile, large headings scale down to maintain vertical rhythm without overwhelming the viewport.

## Layout & Spacing

The design system employs a **Fixed Grid** philosophy for desktop (1280px max-width) and a **Fluid Grid** for mobile. A 12-column system is used for the main content area, while a fixed 240px sidebar contains primary navigation.

The spacing rhythm is based on a **4px baseline**, ensuring that all margins and paddings are multiples of 4 or 8. 
- **Desktop:** 32px outer margins, 20px gutters. 
- **Mobile:** 16px outer margins. The sidebar collapses into a bottom navigation bar or a hamburger menu to prioritize screen real estate for task lists. 
- **Vertical Rhythm:** Sections are separated by `lg` (32px) or `xl` (48px) units to create a sense of organized, un-cluttered space.

## Elevation & Depth

Visual hierarchy is established through **Tonal Layers** combined with **Ambient Shadows**. This design avoids heavy borders in favor of depth-based separation.

- **Level 0 (Background):** Ghost White `#F5F6FA`. No shadow.
- **Level 1 (Cards/Sidebar):** Pure White or Deep Indigo. Subtle, highly diffused shadow: `0 4px 12px rgba(0, 0, 0, 0.05)`.
- **Level 2 (Interactive/Hover):** When a task card is hovered, the shadow intensifies to `0 8px 20px rgba(0, 0, 0, 0.08)` and the element shifts 2px upward.
- **Level 3 (Modals/Popovers):** Elevated with a deep shadow and a semi-transparent overlay to dim the background, focusing attention entirely on the task at hand.

## Shapes

The shape language is **Rounded**, utilizing a consistent 10-12px radius (`0.75rem`) for main components. This softening of the "academic" corners makes the tool feel more approachable and modern without losing its professional edge.

- **Standard Buttons/Inputs:** 8px (`rounded-md`).
- **Cards/Containers:** 12px (`rounded-lg`).
- **Status Pills/Badges:** Full rounding (999px) to create a distinct visual "token" that is easily distinguishable from square-ish buttons.
- **Form Focus:** Input fields use a 2px solid Slate Blue outline when active to provide high-contrast focus states.

## Components

### Buttons
- **Primary:** Deep Indigo background, white text. No border. High-impact for "Save" or "Add Task".
- **Secondary:** Slate Blue background, white text. Used for secondary actions in a flow.
- **Ghost/Outline:** Transparent background, `border` color, Text-Secondary color. Used for "Cancel" or "Go Back".

### Inputs & Forms
- Inputs feature a light gray border and 8px rounding. Focus states must trigger the Slate Blue ring. 
- Labels sit above the field in `label-md` style.

### Task Cards
- White background, 12px rounding, subtle shadow.
- Must include a **Vertical Accent Stripe** on the left edge (4px width) colored by priority or status (Green/Amber/Red).

### Status Pills
- Compact, fully rounded elements. Use soft background tints (e.g., Soft Red background with Dark Red text) to ensure legibility while maintaining a calm aesthetic.

### Sidebar
- Fixed 240px width. Deep Indigo background. Active states should use a "Pill Highlight" (white with low opacity) or a white vertical bar on the leading edge to indicate the current section.