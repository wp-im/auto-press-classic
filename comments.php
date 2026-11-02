<?php
/**
 * Comments template.
 *
 * @package Auto_Press_Classic
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="ap-comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="ap-comments__title">
			<?php
			printf(
				/* translators: %s: number of comments. */
				esc_html( _nx( '%s Comment', '%s Comments', get_comments_number(), 'comments title', 'auto-press-classic' ) ),
				esc_html( number_format_i18n( get_comments_number() ) )
			);
			?>
		</h2>

		<ol class="ap-comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol>

		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php
	if ( ! comments_open() && get_comments_number() ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'auto-press-classic' ); ?></p>
		<?php
	endif;

	comment_form();
	?>
</section>
