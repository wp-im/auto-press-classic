<?php
/**
 * Archive template.
 *
 * @package Auto_Press_Classic
 */

get_header();
?>

<header class="ap-archive-header">
	<h1 class="ap-archive-title"><?php if ( is_category() || is_tag() ) { single_term_title(); } else { the_archive_title(); } ?></h1>
	<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
	<p class="ap-result-count"><?php global $wp_query; printf( esc_html( _n( '%s story', '%s stories', $wp_query->found_posts, 'auto-press-classic' ) ), esc_html( number_format_i18n( $wp_query->found_posts ) ) ); ?></p>
</header>

<?php if ( have_posts() ) : ?>
	<section class="ap-section-grid" aria-label="<?php esc_attr_e( 'Archive posts', 'auto-press-classic' ); ?>">
		<div class="ap-section-label"><?php esc_html_e( 'Archive', 'auto-press-classic' ); ?></div>
		<div>
			<ul class="ap-card-grid<?php echo 'grid' === get_theme_mod( 'auto_press_archive_layout', 'list' ) ? '' : ' ap-list-grid'; ?>">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/card-post', null, array( 'heading_level' => 2 ) );
				endwhile;
				?>
			</ul>
		</div>
	</section>

	<nav class="ap-pagination" aria-label="<?php esc_attr_e( 'Archive pagination', 'auto-press-classic' ); ?>">
		<?php the_posts_pagination(); ?>
	</nav>
<?php else : ?>
	<p class="ap-empty"><?php esc_html_e( 'No posts found.', 'auto-press-classic' ); ?></p>
<?php endif; ?>

<?php
get_footer();
