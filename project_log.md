NLM Project Log
Date: 2025-09-09

Summary of actions
- Scanned repo structure and verified frontend views at `public_html/frontend/views/site`.
- Located Hyper template package at `public_html/Hyper_v5.5.0` (Admin + Starter-Kit + Documentation).
- Reviewed history/context: `public_html/nlm.help.md`, `public_html/222.md`, `public_html/111.md`.
- Inspected language URL configuration: `public_html/frontend/config/_urlManager.php` using `codemix\localeurls\UrlManager`.

Key findings
- Views location: Frontend site views remain in `public_html/frontend/views/site` (e.g., `about_uk.php`, `index_uk.php` present).
- Language URLs: Current URL format is prefix-first (e.g., `/uk/about`) because of `codemix\localeurls\UrlManager` with `languages` set. Previously expected format was suffix-first (e.g., `/about/uk`).
- Potential mis-map: In `_urlManager.php`, `'uk' => 'ru'` maps the `uk` URL prefix to internal language `ru` — likely unintended.
  File ref: `public_html/frontend/config/_urlManager.php:5`
- Hyper assets: Backend layout `hyper.php` and `HyperAsset` are installed and used in admin; Hyper docs list layouts, themes, widgets, and plugins available for integration.
  File refs: `public_html/backend/views/layouts/hyper.php:1`, `public_html/backend/assets/HyperAsset.php:1`, `public_html/Hyper_v5.5.0/Documentation/pages-themes.html:82`.
- Composer context: Production server logs show Composer 2 plugin API mismatch and PHP 8 constraints for some packages. See `public_html/222.md:1` for details.

Decisions/notes
- Do not move frontend views; they are in the expected folder. The design template (Hyper) is a static package under `public_html/Hyper_v5.5.0` and is integrated for backend via assets/layout.
- To preserve old URLs (`/about/uk`), we should support and 301-redirect them to the new canonical (`/uk/about`) or implement custom trailing-language parsing. LocaleUrls natively supports prefix (`/uk/...`), so redirecting is the simplest and most robust.
- Fix the `'uk' => 'ru'` mapping. If Ukrainian is a separate language, list it explicitly (`'uk'`) without remapping.

Proposed next steps
1) Correct language config:
   - Update `public_html/frontend/config/_urlManager.php` languages to: `['uk', 'ru', 'en', 'de']` (no remap), ensure `params['availableLocales']` matches.
2) Backward URL support:
   - Add top URL rules to detect `/site-action/<lang>` (e.g., `about`, `donate`, `contacts`, etc.) and redirect to `/<lang>/site-action` (301). Alternatively, implement a single catch rule `<action:[\w\-]+>/<language:(uk|ru|en|de)>` to a redirect action.
3) Validate language switchers:
   - Ensure links built with `Url::to([...,'language'=>$code])` generate the desired URLs with LocaleUrls (prefix). Update hardcoded links if needed.
4) Composer/env cleanup (server):
   - Upgrade to Composer 2 and resolve `facebook/graph-sdk` PHP constraint or pin compatible version; then install `yiisoft/yii2-bootstrap5` as noted in `nlm.help.md`.
5) Hyper integration (frontend, optional):
   - If desired, port specific Hyper components to frontend by creating a dedicated AssetBundle and layout, then refactor views incrementally.

Open issues checklist
- [ ] Fix `_urlManager.php` language list (`'uk' => 'ru'` -> separate languages).
- [ ] Decide on canonical language URL style (prefix vs suffix); recommend prefix.
- [ ] Add redirect rules for legacy `/about/uk` URLs.
- [ ] Confirm `availableLocales` in `params` and align with i18n message catalogs.
- [ ] Install `yiisoft/yii2-bootstrap5` on server (Composer 2 configured).
- [ ] Re-test admin forms: tabs, Select2, datepickers under Hyper.
- [ ] Inventory Hyper components for potential frontend usage.

Appendix: References
- UrlManager config: `public_html/frontend/config/_urlManager.php:1`
- Site views: `public_html/frontend/views/site/index_uk.php:1`, `public_html/frontend/views/site/about_uk.php:1`
- Backend Hyper layout: `public_html/backend/views/layouts/hyper.php:1`
- Hyper docs (themes): `public_html/Hyper_v5.5.0/Documentation/pages-themes.html:82`
- Hyper docs (widgets): `public_html/Hyper_v5.5.0/Documentation/pages-demo-widget.html:80`
- Server terminal log: `public_html/222.md:1`

---

Date: 2025-09-09 12:35

Actions performed
- Read history/context files: `public_html/nlm.help.md`, `public_html/222.md`, `public_html/111.md`.
- Verified current frontend views location at `public_html/frontend/views/site` (language-specific files like `about_uk.php`, `index_uk.php` exist and are used).
- Reviewed language routing config `public_html/frontend/config/_urlManager.php` using `codemix\\localeurls\\UrlManager` with prefix-style language URLs.
- Scanned `public_html/Hyper_v5.5.0` to inventory available layouts, widgets, and components from Admin and Documentation packages.

Results/notes
- Language URLs currently resolve as `/<lang>/<route>` (e.g., `/uk/about`). This behavior is expected with `codemix/localeurls`.
- Legacy pattern (`/about/uk`) is not natively supported by `localeurls`. To preserve SEO and user bookmarks, consider 301 redirects from `/about/uk` to `/uk/about` or implement custom parsing + redirect.
- The mapping `'uk' => 'ru'` in `languages` likely causes Ukrainian prefix to load Russian content. This should be corrected if unintended.
- Frontend designs/views are still located under `public_html/frontend/views/site` (not moved elsewhere). The `design/` folder contains brand assets (icons, logos), not PHP views.

Hyper v5.5.0 inventory (Admin package)
- Layouts/themes:
  - Vertical (default), Horizontal (top navigation), Detached sidebar, Full/Fullscreen, Compact, Hover, Icon-view
  - Light/Dark modes, custom color palettes, RTL stylesheet support
- Dashboards/Apps:
  - Dashboards: Analytics, CRM, Projects, Wallet
  - Apps: Calendar, Chat, Email (Inbox/Read), File Manager, Kanban
  - E‑commerce: Products, Product Details, Orders, Order Details, Customers, Sellers, Checkout
  - Projects: List, Details, Gantt, Add Project; Tasks (+ details); Social Feed; CRM (Clients, Management, Orders List, Projects)
- UI components:
  - Alerts, Avatars, Badges, Breadcrumb, Buttons, Cards, Carousel, Dropdowns, Grid, List Group, Modals, Offcanvas, Pagination, Popovers, Progress, Ribbons, Spinners, Tabs, Tooltips, Typography, Utilities, Widgets
- Forms:
  - Elements, Advanced (switches, masks, colorpicker, etc.), Editors, File Uploads, Validation, Wizard/Steps
- Tables:
  - Basic tables, DataTables integration
- Charts & maps:
  - ApexCharts (area, bar, boxplot, bubble, candlestick, column, heatmap, line, mixed, pie, polar area, radar, radialbar, scatter, sparkline, timeline, treemap)
  - Chart.js (area, bar, line, others)
  - Google Maps, Vector Maps
- Icons:
  - Lucide, Material Design Icons, Remix Icon, Unicons
- Extensions/utilities:
  - Dragula drag‑and‑drop, Range Slider, Ratings, Custom Scrollbar, Scrollspy, Treeview, Sparkline, Preloader

Checklist (updated)
- [ ] Decide canonical language URL scheme (prefix recommended). If keeping suffix, design redirect/parsing strategy.
- [ ] Implement 301 redirects from legacy `/about/uk` style to `/<lang>/about` (server or Yii rule).
- [ ] Correct `languages` in `_urlManager.php` (remove `'uk' => 'ru'` remap if unintended; list: `['uk','ru','en','de']`).
- [ ] Align `params['availableLocales']` and translation catalogs with active languages.
- [ ] Install `yiisoft/yii2-bootstrap5` and resolve Composer/PHP constraints on server (Composer 2).
- [ ] Re-test admin widgets (Select2, tabs) under Hyper after bootstrap5 install.
- [ ] Optionally, create frontend AssetBundle to reuse select Hyper components.

End of entry.

Date: 2025-09-09 12:58

Actions performed
- Fixed frontend About page error: replaced Bootstrap 3 widgets with Bootstrap 5 equivalents in `public_html/frontend/views/site/about.php`.
  - `use yii\bootstrap\Nav;` → `use yii\bootstrap5\Nav;`
  - `use yii\bootstrap\Tabs;` → `use yii\bootstrap5\Tabs;`

Result
- Error "Class \"yii\\bootstrap\\Tabs\" not found" resolved; About page renders using Bootstrap 5 widgets consistently with the layout.

Notes
- Other localized About views (`about_ru.php`, `about_uk.php`) already avoid Yii Bootstrap widgets and are unaffected.

Date: 2025-09-09 13:20

Action
- Figma design analysis requested: https://www.figma.com/design/2OpVcwEgnpZWTxpuKBZ1RE/New--Copy-?node-id=181-4094&m=dev

Status / blockers
- Direct access requires public view permission or an invite; without credentials the file is not accessible for automated inspection.

Requested access
- Please set the Figma file to “Anyone with the link – can view” and enable Dev Mode for the link, or invite our service email and provide a temporary access token if API-based export is preferred.

What we will extract once access is granted
- Colors: palettes, semantic aliases, gradients.
- Typography: font families, sizes, line-heights, weights, letter-spacing.
- Spacing grid: 4/8px scale, container widths, gutters, columns, breakpoints.
- Components: buttons, inputs, tabs, cards, navbars, alerts, badges, tables, sliders.
- States: hover/active/focus, disabled, validation.
- Icons: sets in use and sizing rules.
- Elevation: shadows, radii, borders.
- Variables: Figma Variables mapping to CSS custom properties.

Implementation plan
- Create `public_html/css/theme.tokens.css` with CSS variables extracted from Figma.
- Map Bootstrap 5 variables/components to tokens (override via custom CSS or SCSS build if available).
- Refactor key views (home, about, donate, projects) to use tokens and shared components.
- Add dark mode (if defined) via `data-theme` switch and variable overrides.

Checklist (Figma)
- [ ] Grant public view (Dev Mode) or invite + token.
- [ ] Export color styles and text styles (names + values).
- [ ] Provide breakpoints, grid specs, container widths.
- [ ] Confirm components to prioritize (Home, About, Donate, Projects, Articles).
- [ ] Approve tokens file location and naming.

Date: 2025-09-09 13:38

Actions performed
- Figma access: used provided token (masked) to fetch file `2OpVcwEgnpZWTxpuKBZ1RE` via Figma API.
  - Saved raw JSON to `public_html/design/figma.api.file.json`.
- Extracted basic tokens (colors, fonts, font sizes, radii) from the document tree and appended CSS variables to `public_html/css/aboutnlm.tokens.css`.

Results
- New variables added under `:root` in `aboutnlm.tokens.css` (e.g., `--nlm-color-1..10`, `--nlm-font-1..`, `--nlm-font-size-*`, `--nlm-radius-*`) to complement existing `.aboutnlm-page` scoped tokens.
- File `aboutnlm.tokens.css` is already included by about pages, so tokens are available immediately for further styling.

Security note
- Token received from user was used only for API download in this session and not stored in VCS; mention in this log is masked and not persisted elsewhere.

Next steps
- [ ] Map Bootstrap 5 variables to tokens (buttons, nav, tabs, cards) and adjust component styles.
- [ ] Extend extraction to text/paint styles and variables collections (if present) for richer token set.
- [ ] Apply tokens to Home, Donate, Projects views incrementally.

Date: 2025-09-09 13:55

Actions performed
- Initialized local git repository and created snapshot commit including recent changes (Bootstrap 5 Tabs fix, Figma tokens import, log updates).
  - Commands: `git init -b main`, `git add -A`, `git commit -m "chore: initial snapshot + recent fixes (BS5 Tabs on about page, Figma tokens import, project log updates)"`.
- Added root `.gitignore` to exclude vendor/runtime/node_modules and temp assets from VCS.

Result
- Local commit created on branch `main`. No remote configured yet.

Next steps to push to GitHub
- Provide remote URL (HTTPS or SSH), e.g.:
  - `git remote add origin https://github.com/<USER>/<REPO>.git`
  - `git push -u origin main`
- If using HTTPS with PAT: set a Git credential helper or use `GITHUB_TOKEN` when prompted.
- If using SSH: ensure the SSH key is added to GitHub (`ssh -T git@github.com`).

Date: 2025-09-09 14:05

Actions performed
- Set remote to `git@github.com:vaoferi/nlm.help.git` and attempted push.
- Added GitHub host key to `~/.ssh/known_hosts`.

Result
- Push failed: `Permission denied (publickey)`. SSH key for this machine is not authorized on GitHub.

How to resolve
- Option A (SSH):
  1) Generate or use existing SSH key: `ssh-keygen -t ed25519 -C "your_email@example.com"`
  2) Add public key to GitHub: copy `~/.ssh/id_ed25519.pub` → GitHub → Settings → SSH and GPG keys → New SSH key
  3) Test: `ssh -T git@github.com`
  4) Push: `git push -u origin main`
- Option B (HTTPS + PAT):
  1) `git remote set-url origin https://github.com/vaoferi/nlm.help.git`
  2) Create a GitHub Personal Access Token (classic) with `repo` scope
  3) Push: `git push -u origin main` and enter username + PAT when prompted

Date: 2025-09-09 14:12

Actions performed
- Verified local SSH key exists and printed public part for GitHub:
  ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIIC0hnE2BT96RcpbHwugCbkeO7TIdCFgDLtOvyJZ/Tf8 vaoferi@gmail.com
- Checked SSH to GitHub: currently `Permission denied (publickey)` — key not yet added to GitHub account.

Next steps
- Add the public key above to GitHub → Settings → SSH and GPG keys → New SSH key.
- Verify: `ssh -T git@github.com` (expect greeting/username).
- Push again: `git push -u origin main`.

Date: 2025-09-09 14:20

Observation
- SSH push still denied. Local key requires a passphrase; ssh-agent is not loaded with the key.

Required local step (once per session)
- Load the key into ssh-agent: `ssh-add ~/.ssh/id_ed25519` and enter your passphrase (you mentioned `7192`).
- Re-test: `ssh -T git@github.com` (should greet your account).
- Then: `git push -u origin main`.

Date: 2025-09-09 17:20

Task
- Stabilize the About/Team page, stop regressions, and define a clean, minimal implementation aligned to Figma. Analyze current code, critique issues, compare to design, and propose a precise plan. No destructive changes yet.

Findings (code audit)
- Excessive inline CSS/JS inside the view leads to ordering fights and hard-to-reason overrides:
  - Inline CSS blocks redefine the same areas multiple times (tabs, team cards, timeline), e.g. `public_html/frontend/views/site/about_ru.php:880`, `public_html/frontend/views/site/about_ru.php:1045`, `public_html/frontend/views/site/about_ru.php:1088`.
  - Mobile/desktop styles duplicated with slightly different breakpoints (`768`, `767`, `767.98`, `991`), making the cascade brittle.
- Legacy Masonry styles/scripts conflict with CSS Grid:
  - Global theme CSS attaches `.articles__item-link` overlays and Masonry positioning; we then try to undo it per-section.
  - Our ad-hoc JS tries to destroy Masonry on the Team tab (race-prone).
- RU/UA views diverge and duplicate large swaths of CSS/JS, increasing drift risk:
  - `about_ru.php` vs `about_uk.php` carry near-identical inline blocks with subtle differences.
- Asset ordering/regressions:
  - Visual regressions happened when we changed `registerCssFile` `depends`, and when server-side deployed an older copy that loaded different CSS order.
  - A recent escaping bug (`'depends' => [\\yii\\web\\YiiAsset::class]`) broke the page in production.
- Team card markup mixes presentational structure and content:
  - Both `.team-info-desktop` and `.team-info-mobile` exist; visibility toggled via scattered CSS/inline rules.
  - The legacy "read more" button overlay from global CSS rendered white squares in mobile cards.

Figma comparison (link in log; plus provided screenshot)
- Mobile Team card intent:
  - Fixed card box: 164x324, image ~129.32x162 top-aligned, dark info panel 147px docked bottom; name → position → socials centered; socials on white tiles with dark icon.
  - One column, centered cards, consistent vertical rhythm.
- Desktop intent:
  - 3-column grid with equal-height cards; clean shadows; no Masonry effects.
- Current gaps observed:
  - Residual overlay button squares (from `.articles__item-link`).
  - Mobile info panel not consistently showing due to cascade order and mixed breakpoints.
  - Grid sometimes reverts to Masonry behavior (positioned items), causing gaps.

Proposed solution (minimal, maintainable, Figma-first)
- Define a small external CSS layer and lean markup; stop in-view style bloat.
  1) Extract Team styles to `public_html/css/about.team.css` (desktop + mobile), mobile-first; remove inline CSS for Team.
  2) Keep shared tokens in `public_html/css/aboutnlm.tokens.css`; use variables for color/spacing/typography.
  3) Remove Masonry for `#aboutnlm-team` entirely; use CSS Grid with `grid-auto-rows: 1fr` for equal heights. Neutralize legacy `.articles__item-link` only within `#aboutnlm-team`.
  4) Create reusable partials `_team_card.php` (single card) and `_team_director.php` (director). RU/UA/EN render the same partials to prevent drift.
  5) Keep tabs JS minimal (activate tab + scrollIntoView). No layout JS.
  6) Standardize breakpoints: ≤767 mobile, 768–1139 tablet, ≥1140 desktop.

Migration plan (safe, reversible)
- Phase 1 (no risk to markup):
  - Add `about.team.css`, scope to `#aboutnlm-team`, implement Figma mobile + desktop. Wire into RU/UA views after main assets; cache-bust.
  - Neutralize legacy overlay and Masonry only inside Team.
- Phase 2 (cleanup):
  - Introduce `_team_card.php` and switch RU/UA to use it. Delete Team inline CSS/JS blocks from views.
- Phase 3 (consolidation):
  - Extract tabs/timeline CSS to small files; unify between locales.
  - Optional: move helper functions (role grouping, cert parsing) to a helper/ViewModel.

Notes
- Desktop visuals remain unchanged while mobile matches Figma exactly.
- All new CSS is strictly scoped to `#aboutnlm-team` to avoid side effects.

Next steps (pending approval)
- Implement Phase 1, validate on staging/mobile. Then proceed to Phase 2–3 to return the view to a compact (~70-line) markup with partials.

Date: 2025-09-09 17:45

Phase 1 – Implemented (non-destructive)
- Added external, scoped Team CSS: `public_html/css/about.team.css` (desktop+mobile, Figma-aligned).
- Wired into RU/UA views after app assets with cache-busting:
  - `public_html/frontend/views/site/about_ru.php`
  - `public_html/frontend/views/site/about_uk.php`
- CSS strictly targets `#aboutnlm-team`, neutralizes legacy Masonry/overlay only inside Team.
- No markup changes yet; inline Team CSS/JS still present and will be removed in Phase 2.

Validation to do
- Hard refresh on staging/mobile. If any inline rules still win, Phase 2 removes those blocks. The external CSS already uses scoped selectors and `!important` where needed to override safely.

Date: 2025-09-09 18:05

Action: Rollback to previous look (user request)
- Removed linking of new Team CSS from RU/UA views to restore the exact prior appearance:
  - Updated `public_html/frontend/views/site/about_ru.php` (removed `/css/about.team.css` include)
  - Updated `public_html/frontend/views/site/about_uk.php` (removed `/css/about.team.css` include)
- Left the new CSS files in repo but not referenced (`about.team.css`, `team.cards.mobile.css`) for later controlled rollout.

Deployment note
- Upload only the two updated view files to the server and clear caches (browser hard refresh and PHP opcache if enabled) to immediately restore prior UI.
