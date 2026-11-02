<?php
/**
 * Single post content template part.
 *
 * @package Auto_Press_Classic
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ap-article' ); ?>>
	<div class="ap-article-body">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Post pages', 'auto-press-classic' ) . '">',
				'after'  => '</nav>',
			)
		);
		?>
	</div>
</article>
