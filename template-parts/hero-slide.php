<?php
/**
 * Homepage hero slide template part.
 *
 * @package Auto_Press_Classic
 */

$post_id  = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();
$index    = isset( $args['index'] ) ? (int) $args['index'] : 0;
$category = auto_press_classic_primary_category( $post_id );
$title    = get_the_title( $post_id );
$date     = get_the_date( 'Y.m.d D', $post_id );
$url      = get_permalink( $post_id );
$classes  = 'ap-hero__slide';

if ( 0 === $index ) {
	$classes .= ' is-active';
}
?>
<a
	class="<?php echo esc_attr( $classes ); ?>"
	href="<?php echo esc_url( $url ); ?>"
	data-title="<?php echo esc_attr( $title ); ?>"
	data-category="<?php echo esc_attr( $category ? $category->name : __( 'News', 'auto-press-classic' ) ); ?>"
	data-date="<?php echo esc_attr( $date ); ?>"
	data-url="<?php echo esc_url( $url ); ?>"
	aria-label="<?php echo esc_attr( $title ); ?>"
>
	<?php auto_press_classic_hero_image( $post_id, $index ); ?>
</a>
