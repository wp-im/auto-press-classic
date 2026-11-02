<?php
/**
 * 404 template.
 *
 * @package Auto_Press_Classic
 */

get_header();
?>

<section class="ap-archive-header">
	<h1 class="ap-archive-title"><?php esc_html_e( 'Page Not Found', 'auto-press-classic' ); ?></h1>
	<p><?php esc_html_e( 'The page you requested could not be found. Search the site or return to the top page.', 'auto-press-classic' ); ?></p>
	<?php get_search_form(); ?>
	<p><a class="ap-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Top page', 'auto-press-classic' ); ?></a></p>
	<?php if ( is_active_sidebar( 'home-intro' ) ) : ?>
		<div class="ap-widget-note"><?php dynamic_sidebar( 'home-intro' ); ?></div>
	<?php endif; ?>
</section>

<?php
get_footer();
