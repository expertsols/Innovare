Solution product marks
======================

Drop product / brand logos here for solutions that declare a
`best_for_brand` block in inc/solutions-data.php (SkilledIM HRM and
Silver Accounting).

Expected files (paths are set in `best_for_brand.file`):

  - skilledim-logo.png
  - silver-accounting-logo.png

Use a horizontal wordmark (transparent PNG; ~360x80px works well). The
aside brand area shows the image at max ~44px height x 220px wide. SVG
is fine — update the `file` key in solutions-data.php to match.

If a file is missing, the detail page shows the `fallback` string as a
typographic wordmark instead, with `alt` used as the accessible name
(`aria-label` on the fallback). The `tagline` line (e.g. "by Andromeda
Links") appears under the logo or fallback.
