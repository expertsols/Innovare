# Innovate — WordPress theme

A modern, lightweight **standalone** WordPress theme for **Innovate** — positioning the business as a **Managed IT & Business Technology Partner**.

Built with **Bootstrap 5.3**, custom page templates, reusable template parts, and Gutenberg-friendly markup. No Elementor, no page builders, no parent theme.

> The theme deliberately avoids product-store / ecommerce visual language. Hardware is referenced as **Technology Procurement & Deployment** inside Services — not as a catalogue page.

---

## What you get

- **No parent theme** — activate **Innovate** only
- Sticky responsive Bootstrap 5 navbar with **Get a Quote** CTA
- Custom **front-page** assembled from modular sections
- Page templates for **Services, Solutions, solution detail pages, Insights, Company, Contact**, plus **Privacy / Terms / Sitemap** helpers
- Blog posts use **`/insights/{post-slug}/`** URLs (Insights landing stays at **`/insights/`**)
- Single post, archive, search, 404, comments
- Footer with 4 widget areas + meta strip
- Baseline **Open Graph + Twitter Card + Organization JSON-LD** (auto-disabled when Rank Math / Yoast / AIOSEO is active)
- Customizer panels for contact details and social links
- Editor styles so Gutenberg matches the front-end
- Mobile-first responsive layout, accessible focus states, reduced-motion support

---

## Theme folder and slug

WordPress derives the theme **slug** from the **directory name** under `wp-content/themes/`. The folder may be named **`Innovare`** (or `innovare`); the **Appearance → Themes** label comes from `style.css` (**Theme Name: Innovate**).

Constants in `functions.php`:

- **`INNOVARE_VERSION`** — asset cache-busting
- **`INNOVARE_DIR`** / **`INNOVARE_URI`** — `get_template_directory()` / `get_template_directory_uri()` (standalone theme paths)

---

## Site structure

```
Home
Services
Solutions   (+ child pages per solution, e.g. /solutions/microsoft-365/)
Insights    (+ blog posts under /insights/post-name/)
Company
Contact
Privacy     (/privacy/)
Terms, Sitemap (footer + sitemap page)
```

- **Industries** appears on the homepage and on the Company page — there is no separate Industries page in the navbar.
- **Hardware procurement** is on the Services page — there is no Products page.

---

## File structure

```
innovare/   (or your theme directory name)
├── style.css                              # Theme header (Theme Name: Innovare)
├── functions.php                          # INNOVARE_* constants; loads /inc
├── README.md
├── header.php
├── footer.php
├── index.php
├── front-page.php
├── page.php
├── single.php
├── archive.php
├── search.php
├── searchform.php
├── 404.php
├── comments.php
│
├── scripts/
│   ├── seed-insights-demo-posts.php       # CLI: demo posts for Insights layout
│   └── migrate-company-to-about-page.php  # CLI: legacy About slug fixes
│
├── inc/
│   ├── theme-setup.php
│   ├── enqueue.php                        # Bootstrap 5.3 + fonts + custom CSS/JS
│   ├── menus.php
│   ├── seo.php
│   ├── helpers.php
│   ├── insights-rewrites.php              # /insights/{slug}/ + innovare_insights_rewrite_ver
│   ├── legal-pages.php
│   ├── customizer.php
│   └── solutions-data.php
│
├── page-templates/
│   ├── template-services.php
│   ├── template-solutions.php
│   ├── template-solution-detail.php
│   ├── template-insights.php
│   ├── template-company.php
│   ├── template-contact.php
│   ├── template-legal-document.php
│   └── template-sitemap.php
│
├── template-parts/home/
│   └── …
│
└── assets/
    ├── css/
    ├── js/
    └── vendor/bootstrap/   (optional local Bootstrap — see below)
```

---

## Prerequisites

| Requirement | Notes |
| ----------- | ----- |
| **WordPress** | 6.0+ (use a current supported release in production) |
| **PHP** | 7.4+ per `style.css`; 8.x recommended |
| **Parent theme** | **None** |
| **Permalinks** | **Pretty permalinks** (not “Plain”) — required for `/insights/post/`, `/solutions/child/`, and clean page URLs |

---

## Fresh install checklist

### 1. Install the theme

Copy the theme folder into `wp-content/themes/` and activate **Innovate** under **Appearance → Themes**.

**Automatic site setup** runs on theme activation, when the bootstrap version is bumped on deploy, and on each request (`inc/site-bootstrap.php`, currently **v2**):

- Creates core pages: **Home**, **Services**, **Solutions**, **Insights**, **Company** (`about`), **Contact**
- Assigns **Innovate** page templates and syncs solution detail pages under `/solutions/`
- Ensures **Privacy**, **Terms**, and **Sitemap** pages
- Sets **Settings → Reading** to a static front page (**Home**) when unset
- Creates and assigns **Primary Navigation** when no menu is assigned
- Seeds **Customizer** contact, WhatsApp, address, map, and social URLs when empty
- Stores **solution content** (modules, outcomes, engagement, summaries) in **`wp_options`** and syncs from theme defaults
- Runs phone migrations (**+92 333 4106911**) and legacy About slug fixes (`company`, `about-andromeda-links` → **`about`**)

**Manual re-run after deploy:** **Appearance → Site Setup**, or CLI:

```bash
php wp-content/themes/Innovare/scripts/bootstrap-site-content.php
```

### 2. Core pages (auto-created — manual table for reference)

| Page title (example) | Slug | Template |
| -------------------- | ---- | -------- |
| Home | `home` | Default (`front-page.php` is used for the front page) |
| Services | `services` | **Innovate — Services** |
| Solutions | `solutions` | **Innovate — Solutions** |
| Insights | `insights` | **Innovate — Insights** |
| Company | `about` | **Innovate — Company** |
| Contact | `contact` | **Innovate — Contact** |

**Settings → Reading**

- **Your homepage displays** → **A static page**
- **Homepage** → your **Home** page
- **Posts page** — **Recommended:** do **not** point “Posts page” at the same URL as the Insights page. Use the **Insights** page (`/insights/`) with the Innovate template for the blog experience.

### 3. First load — automatic bootstrap

On **`init`**, `inc/legal-pages.php`:

1. Migrates legacy **`privacy-policy`** → **`privacy`** once (option `andromeda_privacy_slug_migrated_v1`).
2. Ensures **published** pages: **`privacy`**, **`terms`**, **`sitemap`** (legal / sitemap templates).
3. Syncs **Settings → Privacy** when needed.
4. Under **Solutions**, creates **child pages** from `inc/solutions-data.php` (template **Innovate — Solution Detail**) so `/solutions/{slug}/` works.

The **`solutions`** parent page must exist and be **published** before children are created. Load any front-end or admin URL once after creating **Solutions**.

### 4. Permalinks & Insights URLs

- `inc/insights-rewrites.php` registers **`/insights/{post-name}/`** and stores **`innovare_insights_rewrite_ver`** to know when to flush rewrite rules (tied to **`INNOVARE_INSIGHTS_REWRITE_VERSION`** in that file).
- After deploy or if posts 404: **Settings → Permalinks** → **Save** once.

### 5. Menu

**Appearance → Menus** — assign **Primary Navigation**. Fallback in `inc/menus.php` mirrors the main items if no menu is set.

### 6. Customizer

**Appearance → Customize**

- **Innovate — Contact** — phone, email, WhatsApp, hours, address, map embed URL  
- **Innovate — Social Links** — social URLs  

(Internal setting IDs may still use the `andromeda_` prefix for backward compatibility.)

### 7. Footer widgets (optional)

**Appearance → Widgets** — footer columns 1–4. If empty, `footer.php` defaults apply.

### 8. (Optional) Demo posts for Insights

From the WordPress root (adjust paths):

```bash
php wp-content/themes/innovare/scripts/seed-insights-demo-posts.php
```

Windows (XAMPP) example:

```text
d:\xampp\php\php.exe d:\path\to\wordpress\wp-content\themes\innovare\scripts\seed-insights-demo-posts.php
```

Re-run removes posts tagged `_andromeda_insights_demo` and recreates them.

---

## Migrating from the old Astra child theme

1. **Export / note** Customizer values and menus from the old site if needed.
2. Install this theme (new folder, e.g. **`innovare`**), **activate Innovare**, deactivate/remove the old child theme when you no longer need it.
3. **Astra** can be deleted if nothing else uses it.
4. **Settings → Permalinks** → **Save** once (new rewrite option `innovare_insights_rewrite_ver`).
5. Re-check **Reading** (static front page), **Menus**, and **page templates** on key pages (template names now show **Innovare —** …).

---

## Moving hosting or cloning the site

1. Copy files (at minimum `wp-content/themes/<your-innovare-folder>/` and uploads as needed).
2. Import the database; use a **serialized-safe** URL replace (WP-CLI `wp search-replace` or a trusted migration tool).
3. Set `WP_HOME` / `WP_SITEURL` in `wp-config.php` if you lock URLs by environment.
4. **Settings → Permalinks** → **Save** once.
5. Re-check Customizer and hard-coded URLs in content.
6. If **`/insights/...`** 404s, save Permalinks again; developers can bump **`INNOVARE_INSIGHTS_REWRITE_VERSION`** in `inc/insights-rewrites.php` to force another flush on deploy.
7. Clear caches after URL or SSL changes.

---

## `wp-config.php` (optional)

```php
define( 'INNOVARE_USE_LOCAL_BOOTSTRAP', true );
```

When `true`, Bootstrap loads from `assets/vendor/bootstrap/` instead of the CDN (see `inc/enqueue.php`). Bootstrap Icons may still use the CDN unless you change the enqueue.

---

## Filters (developers)

| Filter | File | Purpose |
| ------ | ---- | ------- |
| `andromeda_insights_url_base` | `inc/insights-rewrites.php` | Change the URL prefix for posts (default `insights`; should match the Insights **page** slug). |

Many PHP functions and CSS classes still use the **`andromeda_*`** prefix for stability; only user-facing strings and the text domain **`innovare`** were aligned to the new brand where updated.

---

## Important PHP helpers

| Function | Location | Purpose |
| -------- | -------- | ------- |
| `andromeda_page_url( $slug )` | `inc/helpers.php` | Permalink for a page by slug, or constructed URL if missing. |
| `andromeda_privacy_policy_url()` | `inc/helpers.php` | Privacy URL (prefers **`/privacy/`**). |
| `andromeda_about_page_slug()` | `inc/helpers.php` | Company page slug (`about`). Legacy slugs (e.g. **`/company/`**, **`/about-andromeda-links/`**) redirect. |
| `andromeda_solution_page_url( $slug )` | `inc/solutions-data.php` | Detail URL or fallback. |
| `andromeda_get_solutions()` / `andromeda_get_solution()` | `inc/solutions-data.php` | Solution listing + detail data. |

---

## CLI utility scripts

| Script | Purpose |
| ------ | ------- |
| `scripts/seed-insights-demo-posts.php` | Demo posts for Insights layout testing. |
| `scripts/migrate-company-to-about-page.php` | One-off: legacy About slug and menu fixes. |

---

## Editing content

- **Insights** (`/insights/`): hero uses sticky posts; masonry uses **`andromeda-thumb`** (image size in `inc/theme-setup.php`).
- **Services**: `page-templates/template-services.php` (`$groups`, `$vendor_partners`, etc.).
- **Solutions**: listing in `template-solutions.php` / `page-templates/template-solutions.php`; shared data in **`inc/solutions-data.php`**.
- **Company**: `page-templates/template-company.php` — pillars, industries, **`$core_team`**, etc.
- **ACF**: optional — replace arrays with `get_field()` for editor-managed fields.

---

## Get a Quote CTA

Navbar CTA → `/contact/?type=quote`. Contact template reads query args and adjusts copy / dropdown where applicable.

---

## Recommended plugins (minimal stack)

| Purpose | Plugin | Notes |
| ------- | ------ | ----- |
| SEO | Rank Math or Yoast | Theme OG/JSON-LD disables when detected. |
| Forms | Fluent Forms or Contact Form 7 | Shortcode on Contact replaces fallback form. |
| Caching | LiteSpeed Cache / WP Super Cache | No theme dependency. |
| Email | WP Mail SMTP | Typical on shared hosting. |
| Custom fields | ACF | Optional. |

---

## Bootstrap: CDN vs local

Default: Bootstrap **5.3.3** from jsDelivr (`inc/enqueue.php`).

Self-host: add `bootstrap.min.css` and `bootstrap.bundle.min.js` under `assets/vendor/bootstrap/`, then set **`INNOVARE_USE_LOCAL_BOOTSTRAP`** to `true` in `wp-config.php`.

---

## Performance & accessibility

- No Node build step.
- Image sizes: `andromeda-hero`, `andromeda-card`, `andromeda-thumb` in `inc/theme-setup.php`.
- Reduced-motion support in `assets/css/custom.css`.
- Skip link, keyboard-friendly nav, form labels and invalid feedback, meaningful `aria-label`s where icons are decorative.

---

## Logo asset

Default logo path references **`assets/images/andromedalinks-logo.png`** (legacy filename). Replace that file with your Innovate logo or point `inc/helpers.php` / `inc/seo.php` at your own filename under `assets/images/`.

---

## License

GPL v2 or later — same as WordPress.
