<?php
/** Editorial front page. @package Auto_Press_Classic */
get_header();

if ( is_active_sidebar( 'home-intro' ) ) : ?>
	<div class="ap-shell ap-home-intro"><?php dynamic_sidebar( 'home-intro' ); ?></div>
<?php endif;

$hero_args = array( 'posts_per_page' => 3 );
$featured_category = absint( get_theme_mod( 'auto_press_featured_category', 0 ) );
if ( $featured_category ) {
	$hero_args['cat'] = $featured_category;
}
$hero_query = get_theme_mod( 'auto_press_show_hero', true ) ? auto_press_classic_post_query( $hero_args ) : null;
if ( $hero_query && $hero_query->have_posts() ) :
	$hero_query->the_post();
	$featured_id = get_the_ID();
	?>
	<section class="ap-hero" aria-label="<?php esc_attr_e( 'Featured stories', 'auto-press-classic' ); ?>">
		<div class="ap-hero__stage<?php echo auto_press_classic_post_image_url( $featured_id ) ? '' : ' ap-hero--text'; ?>">
			<div class="ap-hero__copy">
				<?php auto_press_classic_post_meta( $featured_id ); ?>
				<h1 class="ap-hero__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<?php if ( has_excerpt() ) : ?><p class="ap-hero__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p><?php endif; ?>
			</div>
			<?php if ( auto_press_classic_post_image_url( $featured_id ) ) : ?>
				<a class="ap-hero__media" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>" tabindex="-1"><?php auto_press_classic_hero_image( $featured_id ); ?></a>
			<?php endif; ?>
		</div>
		<?php if ( $hero_query->current_post + 1 < $hero_query->post_count ) : ?>
			<ul class="ap-featured-secondary">
			<?php while ( $hero_query->have_posts() ) : $hero_query->the_post(); ?>
				<li><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php auto_press_classic_post_meta( get_the_ID() ); ?></li>
			<?php endwhile; ?>
			</ul>
		<?php endif; ?>
	</section>
	<?php wp_reset_postdata(); ?>
<?php else : ?>
	<h1 class="screen-reader-text"><?php bloginfo( 'name' ); ?></h1>
<?php endif; ?>

<?php if ( get_theme_mod( 'auto_press_show_contents', true ) ) : ?>
<section class="ap-section ap-contents" id="contents" aria-labelledby="ap-contents-title">
	<div class="ap-contents-frame">
		<h2 class="ap-section-label" id="ap-contents-title"><?php echo esc_html( get_theme_mod( 'auto_press_contents_title', __( 'Contents', 'auto-press-classic' ) ) ); ?></h2>
		<div class="ap-content-groups">
		<?php if ( is_active_sidebar( 'home-contents' ) ) : ?>
			<?php dynamic_sidebar( 'home-contents' ); ?>
		<?php else : ?>
			<?php foreach ( auto_press_classic_content_groups() as $index => $group ) :
				$query = auto_press_classic_post_query( array( 'posts_per_page' => 4, 'cat' => $group['category'] ) );
				if ( ! $query->have_posts() ) { continue; }
				$posts_page = absint( get_option( 'page_for_posts' ) );
				$archive_url = $group['category'] ? get_category_link( $group['category'] ) : ( $posts_page ? get_permalink( $posts_page ) : false );
				$layout_defaults = array( 'image', 'mixed', 'image', 'brief' );
				$slot = $group['slot'];
				$layout = auto_press_classic_sanitize_home_layout( get_theme_mod( 'auto_press_contents_layout_' . $slot, $layout_defaults[ $slot - 1 ] ) );
				?>
				<section class="ap-content-group ap-home-group ap-home-group--<?php echo esc_attr( $layout ); ?> ap-home-group--slot-<?php echo (int) $slot; ?>" data-ap-layout="<?php echo esc_attr( $layout ); ?>" aria-labelledby="ap-content-group-<?php echo (int) $index; ?>">
					<div class="ap-group-heading">
						<h3 class="ap-content-group__title" id="ap-content-group-<?php echo (int) $index; ?>"><?php echo esc_html( $group['label'] ); ?></h3>
						<?php if ( $archive_url && ! is_wp_error( $archive_url ) ) : ?>
							<a class="ap-content-group__more" href="<?php echo esc_url( $archive_url ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'More in %s', 'auto-press-classic' ), $group['label'] ) ); ?>"><span aria-hidden="true">&rarr;</span></a>
						<?php endif; ?>
					</div>
					<ul class="ap-card-grid">
					<?php while ( $query->have_posts() ) : $query->the_post();
						get_template_part( 'template-parts/card-post', null, array( 'heading_level' => 4, 'show_excerpt' => 'mixed' === $layout && 0 === $query->current_post, 'hide_image' => 'brief' === $layout ) );
					endwhile; wp_reset_postdata(); ?>
					</ul>
				</section>
			<?php endforeach; ?>
		<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( is_active_sidebar( 'home-after-contents' ) ) : ?>
	<div class="ap-shell ap-section"><?php dynamic_sidebar( 'home-after-contents' ); ?></div>
<?php endif; ?>

<?php
$selection_source = auto_press_classic_sanitize_selection_source( get_theme_mod( 'auto_press_selection_source', 'editorial' ) );
$selection_category = absint( get_theme_mod( 'auto_press_selection_category', 0 ) );
$ranking_query = null;
if ( get_theme_mod( 'auto_press_show_ranking', true ) && ! is_active_sidebar( 'ranking-area' ) ) {
	if ( 'discussion' === $selection_source ) {
		$ranking_query = auto_press_classic_post_query( array( 'posts_per_page' => 4, 'orderby' => 'comment_count', 'comment_count' => array( 'value' => 0, 'compare' => '>' ) ) );
	} elseif ( $selection_category ) {
		$ranking_query = auto_press_classic_post_query( array( 'posts_per_page' => 4, 'cat' => $selection_category ) );
	}
}
if ( get_theme_mod( 'auto_press_show_ranking', true ) && ( is_active_sidebar( 'ranking-area' ) || ( $ranking_query && $ranking_query->have_posts() ) ) ) : ?>
	<section class="ap-section ap-ranking ap-selection" aria-labelledby="ap-ranking-title">
		<div class="ap-section-grid ap-selection__inner">
		<h2 id="ap-ranking-title" class="ap-section-label"><?php echo esc_html( 'discussion' === $selection_source ? get_theme_mod( 'auto_press_ranking_title', __( 'Popular Discussions', 'auto-press-classic' ) ) : get_theme_mod( 'auto_press_selection_title', __( 'Selected Stories', 'auto-press-classic' ) ) ); ?></h2>
		<div class="ap-selection__content">
		<?php if ( is_active_sidebar( 'ranking-area' ) ) : dynamic_sidebar( 'ranking-area' ); else : ?>
			<ul class="ap-card-grid">
			<?php while ( $ranking_query->have_posts() ) : $ranking_query->the_post(); get_template_part( 'template-parts/card-post', null, array( 'show_excerpt' => 0 === $ranking_query->current_post ) ); endwhile; wp_reset_postdata(); ?>
			</ul>
		<?php endif; ?>
		</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( get_theme_mod( 'auto_press_show_special', true ) ) : ?>
	<section class="ap-section ap-special ap-series" aria-labelledby="ap-special-title">
	<div class="ap-section-grid ap-series__inner">
		<h2 class="ap-section-label" id="ap-special-title"><?php echo esc_html( get_theme_mod( 'auto_press_special_title', __( 'Special', 'auto-press-classic' ) ) ); ?></h2>
		<div>
		<?php if ( is_active_sidebar( 'home-special' ) ) : dynamic_sidebar( 'home-special' ); else :
			$args = array( 'posts_per_page' => 3 );
			$category = absint( get_theme_mod( 'auto_press_special_category', 0 ) );
			if ( $category ) { $args['cat'] = $category; }
			$query = auto_press_classic_post_query( $args ); ?>
			<ul class="ap-card-grid ap-series-shelf" tabindex="0" aria-label="<?php esc_attr_e( 'Special stories', 'auto-press-classic' ); ?>">
			<?php while ( $query->have_posts() ) : $query->the_post(); get_template_part( 'template-parts/card-post' ); endwhile; wp_reset_postdata(); ?>
			</ul>
		<?php endif; ?>
		</div>
	</div>
	</section>
<?php endif;
get_footer();
