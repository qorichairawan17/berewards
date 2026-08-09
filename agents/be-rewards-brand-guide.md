# BeRewards Brand and UI Guide

## Brand identity

- **Product name:** BeRewards
- **Official descriptor:** Determining the Rewards for Judges and Employees of the Lubuk Pakam District Court With TOPSIS Method
- Use `BeRewards` as the primary application name in page titles, navigation, authentication screens, and user-facing copy.
- Use the official descriptor in contextual copy, login supporting text, report headers, and formal-facing views where space permits.

## Persistent visual direction

Every new or modified interface must preserve the visual system established by `application/views/auth/signin.php` and `assets/css/spk-reward.css`.

- Keep the experience light; never introduce a dark theme or dark page surfaces.
- Use indigo `#4F46E5` as the primary color and cyan `#06B6D4` only as a supporting accent.
- Reserve the indigo-to-cyan gradient for focused accents such as primary actions, brand marks, active indicators, and small highlights.
- Use `#F7F9FC` page backgrounds, white surfaces, soft `#E2E8F0` borders, generous spacing, rounded corners, and restrained shadows.
- Use clean, modern typography with strong hierarchy, compact labels, and muted supporting copy.
- Use the existing Tabler icon set consistently; do not introduce a second icon library.
- Prefer subtle transitions and purposeful visual detail over decorative effects, neon glows, or dense layouts.

## Implementation rules

- Put every new custom stylesheet in `assets/css/` and keep it consistent with `assets/css/spk-reward.css`.
- Reuse the shared view partials in `application/views/templates/` for authenticated pages.
- Keep authentication views visually aligned with `application/views/auth/signin.php`.
- Use `BeRewards` instead of legacy product labels in all newly created or modified user-facing views.
- Preserve responsive behavior for desktop, tablet, and mobile widths.
- Do not add business logic to views; views remain presentation-only.

## Before completing UI work

- Check that branding, color, spacing, icons, and component styling match this guide.
- Check that new CSS belongs in `assets/css/` and does not conflict with the existing light theme.
- Check that user-facing headings and metadata use the BeRewards name where appropriate.
