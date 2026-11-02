<?php
/**
 * Page template.
 *
 * @package Auto_Press_Classic
 */

get_header();
?>

<?php
while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'ap-page' ); ?>>
		<header class="ap-archive-header">
			<h1 class="ap-archive-title"><?php echo esc_html( get_the_title() ); ?></h1>
		</header>
		<div class="ap-article-body">
			<?php
			the_content();
			wp_link_pages(
				array(
					'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page sections', 'auto-press-classic' ) . '">',
					'after'  => '</nav>',
				)
			);
			?>
		</div>
	</article>
	<?php
endwhile;
?>

<?php
get_footer();
