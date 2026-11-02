<?php
/**
 * Site header.
 *
 * @package Auto_Press_Classic
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'auto-press-classic' ); ?></a>

	<header class="ap-site-header" role="banner">
		<div class="ap-header-inner">
			<div class="ap-brand">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					?>
					<a class="ap-brand__text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					<?php
				}
				?>
			</div>

			<div class="ap-header-tools">
				<nav id="site-navigation" class="ap-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'auto-press-classic' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'fallback_cb'    => false,
							'depth'          => 2,
						)
					);
					?>
				</nav>

				<button class="ap-search-toggle" type="button" aria-controls="header-search" aria-expanded="false">
					<span class="ap-search-toggle__icon" aria-hidden="true"></span>
					<span class="screen-reader-text"><?php esc_html_e( 'Search', 'auto-press-classic' ); ?></span>
				</button>

				<button class="ap-menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false">
					<span></span>
					<span></span>
					<span></span>
					<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'auto-press-classic' ); ?></span>
				</button>
			</div>
		</div>

		<button class="ap-menu-backdrop" type="button" tabindex="-1" aria-label="<?php esc_attr_e( 'Close navigation', 'auto-press-classic' ); ?>"></button>
		<div id="header-search" class="ap-header-search" aria-hidden="true">
			<div class="ap-header-search__inner">
				<?php get_search_form(); ?>
			</div>
		</div>
	</header>

	<main id="primary" class="ap-main">
