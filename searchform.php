<?php
/**
 * Search form template.
 *
 * @package Auto_Press_Classic
 */

 $search_id = wp_unique_id( 'ap-search-' );
?>
<form role="search" method="get" class="ap-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $search_id ); ?>"><?php esc_html_e( 'Search for:', 'auto-press-classic' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $search_id ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search', 'auto-press-classic' ); ?>">
	<button type="submit" aria-label="<?php esc_attr_e( 'Search', 'auto-press-classic' ); ?>"><span class="ap-search-toggle__icon" aria-hidden="true"></span></button>
</form>
