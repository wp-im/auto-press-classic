# Auto Press Classic

The local QA record below describes the original Studio site as of October 2026. It is historical evidence; the new wordpress.im installation requires its own verification.

Auto Press Classic 0.5.0 is an independent editorial WordPress classic theme. Its homepage combines image-led stories, mixed/brief sections, a dark selection band and a light Special shelf; article/search surfaces keep their reading-first behavior.

It is built for editorial automotive publishing:

- sticky magazine header;
- visible featured stories and compact mobile lists;
- editorial card grids;
- clear single-post cover, title and summary in one reading column;
- narrow article copy with wide images;
- recommend, ranking, follow, and footer modules;
- WordPress-native menus, widgets, Customizer settings, posts, categories, and tags.

## Editable Areas

- Primary navigation: Appearance > Menus.
- Footer navigation: Appearance > Menus.
- Social navigation: Appearance > Menus, or Customizer social URL fallbacks.
- Homepage hero source: Customizer > Auto Press Layout.
- Homepage editorial groups: Customizer > Auto Press Layout, select up to four categories and optional labels. With none selected, latest posts appear.
- Special category: Customizer > Auto Press Layout.
- Ranking override: Widgets > Ranking Area.
- Footer note: Widgets > Footer Brand or Customizer footer tagline.
- Section titles and visibility: Customizer > Auto Press Layout.
- Accent, separator color and article text size: Customizer > Auto Press Layout.
- Reading column (700px/760px), archive list/grid, author/update visibility and footer navigation visibility: Customizer > Auto Press Layout.
- Homepage editorial note: Widgets > Home Editorial Note.
- Category presentation: Customizer > Auto Press Layout > Category1-4 presentation. Choose Image stories, Lead story and supporting stories, or Brief updates.
- Dark section source/category/title: Customizer > Auto Press Layout. Selected category stories are not fabricated popularity rankings; discussions mode only shows genuinely commented posts.
- Special uses its existing category/widget source. Multiple stories can scroll horizontally; one story adapts to a full-track feature. No autoplay.
- Homepage content replacement: Widgets > Home Contents / Home Special.
- Article additions: Widgets > Article After Content / Article Recommendations.
- Homepage extra modules: Widgets > Home After Contents.
- Logo and site name: Customizer > Site Identity.

An active replacement widget area replaces its generated grid. Hide a module with its Customizer checkbox. Post bodies, excerpts, featured images, categories and tags stay in the WordPress editor. Menus remain native menus, available through Customize > Menus or Appearance > Menus.

## Local QA Target

Version 0.5.0 is installed and verified in the original WordPress Studio site:

- Site: `auto-press`
- URL: `http://auto-press.local`
- Runtime response: PHP 8.3.32 (HTTP header).
- WordPress: 7.1.3; active theme: Auto Press Classic 0.5.0.
- Classic Editor 1.7.0 and Classic Widgets 0.3 are active.

Customizer reading width and text size were saved, reloaded and measured on the front end. Final defaults are Comfortable/Standard. A Home Editorial Note was saved through Classic Widgets and verified on the homepage. Existing footer widgets override the footer tagline fallback. Existing articles and menus are preserved; replace old sample editorial content through WordPress, not templates.

Front page, page, single, archive, search and404 were checked at320/390/430/768/1024/1440px with no document overflow or duplicate IDs. Category presentation changes were saved/reloaded/front-end verified. Special multi-story keyboard scrolling, one-story adaptation, no-image card rendering and empty selection source were checked. PHPCS/WPCS and Theme Check remain unavailable; this local delivery does not claim WordPress.org certification. Full screen-reader, true200% browser zoom and comprehensive table/comment fixtures remain unchecked.

## Design Notes

Keep left-side vertical region labels on desktop and mobile. Use system fonts, rem typography, subtle separators, and 44px main controls. Article titles are 32px desktop / 28px mobile. Mobile navigation slides from the right, at most 320px and 85vw; outside click and Escape close it, with inert background and a keyboard focus loop. Empty comment rankings are hidden and related-story duplication is avoided. Article contents lists remain editor-owned rather than automatically parsed.

Existing post metadata may reference remote images; prefer native featured images for new content. The theme adds no font downloads, tracking, or remote content API.

## License

GNU General Public License v2 or later.
