<?php
/**
 * Site footer.
 *
 * @package Auto_Press_Classic
 */

$social_links = auto_press_classic_social_links();
?>
	</main>
	<footer class="ap-site-footer" role="contentinfo">
		<div class="ap-footer-inner">

	<?php if ( get_theme_mod( 'auto_press_show_follow', true ) && ( has_nav_menu( 'social' ) || $social_links ) ) : ?>
	<section class="ap-follow" aria-labelledby="ap-follow-title">
		<h2 id="ap-follow-title" class="ap-follow__title"><?php echo esc_html( get_theme_mod( 'auto_press_follow_title', __( 'Follow Us', 'auto-press-classic' ) ) ); ?></h2>

		<?php if ( has_nav_menu( 'social' ) ) : ?>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'social',
					'container'      => false,
					'menu_class'     => 'ap-follow__list',
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
			?>
		<?php elseif ( ! empty( $social_links ) ) : ?>
			<ul class="ap-follow__list">
				<?php foreach ( $social_links as $label => $url ) : ?>
					<li>
						<a class="ap-follow__link" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</section>
	<?php endif; ?>

			<a class="ap-page-top" href="#page"><?php esc_html_e( 'Page Top', 'auto-press-classic' ); ?></a>

			<p class="ap-footer-brand"><?php bloginfo( 'name' ); ?></p>

			<?php if ( get_theme_mod( 'auto_press_show_footer_menu', true ) && has_nav_menu( 'footer' ) ) : ?>
			<nav class="ap-footer-nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'auto-press-classic' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'fallback_cb'    => false,
						'depth'          => 1,
					)
				);
				?>
			</nav>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-brand' ) ) : ?>
				<div class="ap-footer-note">
					<?php dynamic_sidebar( 'footer-brand' ); ?>
				</div>
			<?php elseif ( get_theme_mod( 'auto_press_footer_tagline', '' ) ) : ?>
				<p class="ap-footer-note"><?php echo esc_html( get_theme_mod( 'auto_press_footer_tagline', '' ) ); ?></p>
			<?php endif; ?>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
