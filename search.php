<?php
/**
 * Search template.
 *
 * @package Auto_Press_Classic
 */

get_header();
?>

<header class="ap-archive-header">
	<h1 class="ap-archive-title">
		<?php esc_html_e( 'Search', 'auto-press-classic' ); ?>
	</h1>
	<?php get_search_form(); ?>
	<p class="ap-result-count"><?php global $wp_query; printf( esc_html( _n( '%1$s result for "%2$s"', '%1$s results for "%2$s"', $wp_query->found_posts, 'auto-press-classic' ) ), esc_html( number_format_i18n( $wp_query->found_posts ) ), esc_html( get_search_query() ) ); ?></p>
</header>

<?php if ( have_posts() ) : ?>
	<section class="ap-section-grid" aria-label="<?php esc_attr_e( 'Search results', 'auto-press-classic' ); ?>">
		<div class="ap-section-label"><?php esc_html_e( 'Results', 'auto-press-classic' ); ?></div>
		<div>
			<ul class="ap-card-grid ap-list-grid ap-search-results">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/card-post', null, array( 'heading_level' => 2, 'show_excerpt' => true ) );
				endwhile;
				?>
			</ul>
		</div>
	</section>

	<nav class="ap-pagination" aria-label="<?php esc_attr_e( 'Search pagination', 'auto-press-classic' ); ?>">
		<?php the_posts_pagination(); ?>
	</nav>
<?php else : ?>
	<p class="ap-empty"><?php esc_html_e( 'No results found. Try another search.', 'auto-press-classic' ); ?></p>
	<div class="ap-empty-actions"><a class="ap-back-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Browse latest stories', 'auto-press-classic' ); ?> <span aria-hidden="true">&rarr;</span></a></div>
<?php endif; ?>

<?php
get_footer();
