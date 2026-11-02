<?php
/**
 * Post card template part.
 *
 * @package Auto_Press_Classic
 */

$post_id = get_the_ID();
$has_image = empty( $args['hide_image'] ) && (bool) auto_press_classic_post_image_url( $post_id );
$show_excerpt = ! empty( $args['show_excerpt'] );
$heading_level = isset( $args['heading_level'] ) ? (int) $args['heading_level'] : 3;

if ( ! in_array( $heading_level, array( 2, 3, 4 ), true ) ) {
	$heading_level = 3;
}
?>
<li class="ap-card<?php echo $has_image ? '' : ' ap-card--text'; ?>">
	<article id="<?php echo esc_attr( wp_unique_id( 'ap-post-' . $post_id . '-' ) ); ?>" <?php post_class( 'ap-card__article' ); ?>>
		<?php if ( $has_image ) : ?>
		<a class="ap-card__media" href="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>" tabindex="-1">
			<?php auto_press_classic_post_image( $post_id, 'auto-press-card' ); ?>
		</a>
		<?php endif; ?>
		<div class="ap-card__body">
			<?php printf( '<h%d class="ap-card__title">', $heading_level ); ?>
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
			<?php printf( '</h%d>', $heading_level ); ?>
			<?php if ( $show_excerpt ) : ?>
				<p class="ap-card__excerpt"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 28 ) ); ?></p>
			<?php endif; ?>
			<?php auto_press_classic_post_meta( $post_id, ! is_category() ); ?>
		</div>
	</article>
</li>
