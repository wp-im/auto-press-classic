<?php
/**
 * Single post template.
 *
 * @package Auto_Press_Classic
 */

get_header();
?>

<?php
while ( have_posts() ) :
	the_post();
	$post_id        = get_the_ID();
	$hero_image_url = auto_press_classic_post_image_url( $post_id );
	?>

	<section class="ap-single-hero" aria-labelledby="ap-single-title">
		<div class="ap-single-hero__inner">
			<div class="ap-single-hero__copy">
				<?php $category = auto_press_classic_primary_category( $post_id ); ?>
				<?php if ( $category ) : ?>
					<a class="ap-kicker" href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
				<?php endif; ?>
				<h1 id="ap-single-title" class="ap-single-hero__title"><?php echo esc_html( get_the_title() ); ?></h1>
				<?php auto_press_classic_post_meta( $post_id, false, true ); ?>
				<?php if ( get_theme_mod( 'auto_press_show_updated', true ) && get_post_modified_time( 'U', true ) > get_post_time( 'U', true ) + DAY_IN_SECONDS ) : ?>
					<p class="ap-updated"><?php esc_html_e( 'Updated', 'auto-press-classic' ); ?> <time datetime="<?php echo esc_attr( get_the_modified_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_modified_date( get_option( 'date_format' ) ) ); ?></time></p>
				<?php endif; ?>
				<?php if ( has_excerpt() ) : ?>
					<div class="ap-single-lead"><p><?php echo esc_html( get_the_excerpt() ); ?></p></div>
				<?php endif; ?>
			</div>
			<?php if ( $hero_image_url ) : ?>
			<div class="ap-single-hero__media">
				<?php auto_press_classic_single_hero_image( $post_id ); ?>
			</div>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/content-single' ); ?>
	<?php if ( is_active_sidebar( 'single-after-content' ) ) : ?>
		<div class="ap-single-widgets"><?php dynamic_sidebar( 'single-after-content' ); ?></div>
	<?php endif; ?>

	<?php
	$related_links = get_theme_mod( 'auto_press_show_related', true ) && ! get_theme_mod( 'auto_press_show_recommend', true ) ? auto_press_classic_related_posts( $post_id, 3 ) : null;
	if ( $related_links && $related_links->have_posts() ) :
		?>
		<section class="ap-link-panel" aria-labelledby="ap-related-links-title">
			<h2 id="ap-related-links-title"><?php echo esc_html( get_theme_mod( 'auto_press_related_title', __( 'Related Links', 'auto-press-classic' ) ) ); ?></h2>
			<ul>
				<?php
				while ( $related_links->have_posts() ) :
					$related_links->the_post();
					?>
					<li><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></li>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</ul>
		</section>
	<?php endif; ?>

	<?php $tags = get_the_tags(); ?>
	<?php if ( $tags ) : ?>
		<nav class="ap-tags" aria-label="<?php esc_attr_e( 'Post tags', 'auto-press-classic' ); ?>">
			<ul>
				<?php foreach ( $tags as $tag ) : ?>
					<li>
						<a class="ap-tag" href="<?php echo esc_url( get_tag_link( $tag ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'auto_press_show_recommend', true ) ) : ?>
	<section class="ap-recommend ap-section-grid" aria-labelledby="ap-recommend-title">
		<h2 class="ap-section-label" id="ap-recommend-title"><?php echo esc_html( get_theme_mod( 'auto_press_recommend_title', __( 'Recommended', 'auto-press-classic' ) ) ); ?></h2>
		<div>
			<?php if ( is_active_sidebar( 'single-recommend' ) ) : ?>
				<?php dynamic_sidebar( 'single-recommend' ); ?>
			<?php else : ?>
			<?php
			$recommend_query = auto_press_classic_related_posts( $post_id, 3 );
			if ( ! $recommend_query->have_posts() ) {
				$recommend_query = auto_press_classic_post_query(
					array(
						'posts_per_page' => 3,
						'post__not_in'   => array( $post_id ),
					)
				);
			}
			?>

			<?php if ( $recommend_query->have_posts() ) : ?>
				<ul class="ap-card-grid">
					<?php
					while ( $recommend_query->have_posts() ) :
						$recommend_query->the_post();
						get_template_part( 'template-parts/card-post' );
					endwhile;
					wp_reset_postdata();
					?>
				</ul>
			<?php endif; ?>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<nav class="ap-post-nav" aria-label="<?php esc_attr_e( 'Post navigation', 'auto-press-classic' ); ?>">
		<?php if ( $category ) : ?>
			<a class="ap-back-link" href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php printf( esc_html__( 'More in %s', 'auto-press-classic' ), esc_html( $category->name ) ); ?> <span aria-hidden="true">&rarr;</span></a>
		<?php else : ?>
			<a class="ap-back-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to top page', 'auto-press-classic' ); ?></a>
		<?php endif; ?>
	</nav>

	<?php
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endwhile;
?>

<?php
get_footer();
