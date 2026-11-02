<?php
/**
 * Main fallback template.
 *
 * @package Auto_Press_Classic
 */

get_header();
?>

<header class="ap-archive-header">
	<h1 class="ap-archive-title"><?php esc_html_e( 'Latest Stories', 'auto-press-classic' ); ?></h1>
</header>

<?php if ( have_posts() ) : ?>
	<section class="ap-section-grid" aria-label="<?php esc_attr_e( 'Posts', 'auto-press-classic' ); ?>">
		<div class="ap-section-label"><?php esc_html_e( 'New', 'auto-press-classic' ); ?></div>
		<div>
			<ul class="ap-card-grid ap-list-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/card-post', null, array( 'heading_level' => 2 ) );
				endwhile;
				?>
			</ul>
		</div>
	</section>

	<nav class="ap-pagination" aria-label="<?php esc_attr_e( 'Posts pagination', 'auto-press-classic' ); ?>">
		<?php the_posts_pagination(); ?>
	</nav>
<?php else : ?>
	<p class="ap-empty"><?php esc_html_e( 'No posts found.', 'auto-press-classic' ); ?></p>
<?php endif; ?>

<?php
get_footer();
