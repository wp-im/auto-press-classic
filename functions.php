<?php
/**
 * Auto Press Classic theme functions.
 *
 * @package Auto_Press_Classic
 */

if ( ! defined( 'AUTO_PRESS_CLASSIC_VERSION' ) ) {
	define( 'AUTO_PRESS_CLASSIC_VERSION', '0.5.0' );
}

if ( ! function_exists( 'auto_press_classic_setup' ) ) {
	/**
	 * Set up theme defaults and WordPress feature support.
	 */
	function auto_press_classic_setup() {
		load_theme_textdomain( 'auto-press-classic', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_editor_style( 'assets/css/editor.css' );
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 90,
				'width'       => 420,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		add_image_size( 'auto-press-hero', 1200, 630, true );
		add_image_size( 'auto-press-card', 560, 294, true );
		add_image_size( 'auto-press-wide', 1200, 675, true );

		register_nav_menus(
			array(
				'primary' => __( 'Primary navigation', 'auto-press-classic' ),
				'footer'  => __( 'Footer navigation', 'auto-press-classic' ),
				'social'  => __( 'Social links', 'auto-press-classic' ),
			)
		);
	}
}
add_action( 'after_setup_theme', 'auto_press_classic_setup' );

/**
 * Register widget areas.
 */
function auto_press_classic_widgets_init() {
	$areas = array(
		'home-intro' => __( 'Home Editorial Note', 'auto-press-classic' ),
		'home-contents' => __( 'Home Contents', 'auto-press-classic' ),
		'home-special' => __( 'Home Special', 'auto-press-classic' ),
		'single-after-content' => __( 'Article After Content', 'auto-press-classic' ),
		'single-recommend' => __( 'Article Recommendations', 'auto-press-classic' ),
	);
	foreach ( $areas as $id => $name ) {
		register_sidebar( array(
			'name' => $name,
			'id' => $id,
			'description' => 'home-intro' === $id ? __( 'Optional editorial note above featured stories.', 'auto-press-classic' ) : __( 'Add reusable content here. Homepage and recommendation widgets replace the automatic post grid.', 'auto-press-classic' ),
			'before_widget' => '<section id="%1$s" class="widget ap-widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="ap-widget-title">',
			'after_title' => '</h3>',
		) );
	}
	register_sidebar(
		array(
			'name'          => __( 'Home After Contents', 'auto-press-classic' ),
			'id'            => 'home-after-contents',
			'description'   => __( 'Optional editorial module after the homepage contents grid.', 'auto-press-classic' ),
			'before_widget' => '<section id="%1$s" class="widget ap-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="ap-section-heading">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Ranking Area', 'auto-press-classic' ),
			'id'            => 'ranking-area',
			'description'   => __( 'Optional replacement content for the selected stories or discussions section.', 'auto-press-classic' ),
			'before_widget' => '<section id="%1$s" class="widget ap-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="ap-section-heading">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Brand', 'auto-press-classic' ),
			'id'            => 'footer-brand',
			'description'   => __( 'Footer note, legal text, or brand message.', 'auto-press-classic' ),
			'before_widget' => '<section id="%1$s" class="widget ap-footer-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="screen-reader-text">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'auto_press_classic_widgets_init' );

/**
 * Enqueue front-end assets.
 */
function auto_press_classic_scripts() {
	wp_enqueue_style(
		'auto-press-classic-style',
		get_stylesheet_uri(),
		array(),
		AUTO_PRESS_CLASSIC_VERSION
	);
	$accent = sanitize_hex_color( get_theme_mod( 'auto_press_accent', '#398578' ) ) ?: '#398578';
	$line = sanitize_hex_color( get_theme_mod( 'auto_press_line', '#c6c6c8' ) ) ?: '#c6c6c8';
	$body_size = 'large' === get_theme_mod( 'auto_press_reading_size', 'standard' ) ? '1.1875rem' : '1.0625rem';
	wp_add_inline_style( 'auto-press-classic-style', ':root{--ap-accent:' . $accent . ';--ap-line:' . $line . ';--ap-body-size:' . $body_size . ';}' );
	wp_enqueue_style( 'auto-press-classic-press', get_template_directory_uri() . '/assets/css/press.css', array( 'auto-press-classic-style' ), AUTO_PRESS_CLASSIC_VERSION );
	$copy_width = 'wide' === get_theme_mod( 'auto_press_reading_width', 'comfortable' ) ? '760px' : '700px';
	wp_add_inline_style( 'auto-press-classic-press', ':root{--ap-copy:' . $copy_width . ';}' );
	if ( is_front_page() ) {
		wp_enqueue_style( 'auto-press-classic-rhythm', get_template_directory_uri() . '/assets/css/rhythm.css', array( 'auto-press-classic-press' ), AUTO_PRESS_CLASSIC_VERSION );
	}

	wp_enqueue_script(
		'auto-press-classic-theme',
		get_template_directory_uri() . '/assets/js/theme.js',
		array(),
		AUTO_PRESS_CLASSIC_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'auto_press_classic_scripts' );

/**
 * Sanitize checkbox-like Customizer values.
 *
 * @param mixed $checked Raw value.
 * @return bool
 */
function auto_press_classic_sanitize_checkbox( $checked ) {
	return (bool) $checked;
}

/**
 * Return category choices for Customizer controls.
 *
 * @return array
 */
function auto_press_classic_category_choices() {
	$choices    = array( 0 => __( 'Latest posts', 'auto-press-classic' ) );
	$categories = get_categories(
		array(
			'hide_empty' => false,
			'orderby'   => 'name',
		)
	);

	foreach ( $categories as $category ) {
		$choices[ (int) $category->term_id ] = $category->name;
	}

	return $choices;
}

/**
 * Register Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function auto_press_classic_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'auto_press_layout',
		array(
			'title'       => __( 'Auto Press Layout', 'auto-press-classic' ),
			'description' => __( 'Editorial homepage, special section, ranking, and social link settings.', 'auto-press-classic' ),
			'priority'    => 35,
		)
	);

	$wp_customize->add_setting(
		'auto_press_featured_category',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'auto_press_featured_category',
		array(
			'label'   => __( 'Featured hero category', 'auto-press-classic' ),
			'section' => 'auto_press_layout',
			'type'    => 'select',
			'choices' => auto_press_classic_category_choices(),
		)
	);

	$wp_customize->add_setting(
		'auto_press_special_category',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'auto_press_special_category',
		array(
			'label'   => __( 'Special section category', 'auto-press-classic' ),
			'section' => 'auto_press_layout',
			'type'    => 'select',
			'choices' => auto_press_classic_category_choices(),
		)
	);

	$wp_customize->add_setting(
		'auto_press_show_ranking',
		array(
			'default'           => true,
			'sanitize_callback' => 'auto_press_classic_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'auto_press_show_ranking',
		array(
			'label'   => __( 'Show selected stories or discussions section', 'auto-press-classic' ),
			'section' => 'auto_press_layout',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'auto_press_footer_tagline',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'auto_press_footer_tagline',
		array(
			'label'   => __( 'Footer tagline', 'auto-press-classic' ),
			'section' => 'auto_press_layout',
			'type'    => 'text',
		)
	);

	$social_controls = array(
		'auto_press_mail_news_url' => __( 'Mail News URL', 'auto-press-classic' ),
		'auto_press_instagram_url' => __( 'Instagram URL', 'auto-press-classic' ),
		'auto_press_x_url'         => __( 'X URL', 'auto-press-classic' ),
		'auto_press_facebook_url'  => __( 'Facebook URL', 'auto-press-classic' ),
		'auto_press_youtube_url'   => __( 'YouTube URL', 'auto-press-classic' ),
	);

	foreach ( $social_controls as $setting_id => $label ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			$setting_id,
			array(
				'label'   => $label,
				'section' => 'auto_press_layout',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'auto_press_classic_customize_register' );

/** Register presentation controls; editorial content stays in posts and widgets. */
function auto_press_classic_native_controls( $wp_customize ) {
	foreach ( array( 'auto_press_show_author' => __( 'Show article author', 'auto-press-classic' ), 'auto_press_show_updated' => __( 'Show meaningful article updates', 'auto-press-classic' ), 'auto_press_show_footer_menu' => __( 'Show footer navigation', 'auto-press-classic' ) ) as $id => $label ) {
		$wp_customize->add_setting( $id, array( 'default' => true, 'sanitize_callback' => 'auto_press_classic_sanitize_checkbox' ) );
		$wp_customize->add_control( $id, array( 'label' => $label, 'section' => 'auto_press_layout', 'type' => 'checkbox' ) );
	}
	$wp_customize->add_setting( 'auto_press_reading_width', array( 'default' => 'comfortable', 'sanitize_callback' => 'auto_press_classic_sanitize_reading_width' ) );
	$wp_customize->add_control( 'auto_press_reading_width', array( 'label' => __( 'Reading column', 'auto-press-classic' ), 'section' => 'auto_press_layout', 'type' => 'select', 'choices' => array( 'comfortable' => __( 'Comfortable', 'auto-press-classic' ), 'wide' => __( 'Wide', 'auto-press-classic' ) ) ) );
	$wp_customize->add_setting( 'auto_press_archive_layout', array( 'default' => 'list', 'sanitize_callback' => 'auto_press_classic_sanitize_archive_layout' ) );
	$wp_customize->add_control( 'auto_press_archive_layout', array( 'label' => __( 'Archive presentation', 'auto-press-classic' ), 'section' => 'auto_press_layout', 'type' => 'select', 'choices' => array( 'list' => __( 'Editorial list', 'auto-press-classic' ), 'grid' => __( 'Image grid', 'auto-press-classic' ) ) ) );
	$texts = array(
		'contents' => __( 'Contents', 'auto-press-classic' ),
		'ranking' => __( 'Popular Discussions', 'auto-press-classic' ),
		'special' => __( 'Special', 'auto-press-classic' ),
		'follow' => __( 'Follow Us', 'auto-press-classic' ),
		'related' => __( 'Related Links', 'auto-press-classic' ),
		'recommend' => __( 'Recommended', 'auto-press-classic' ),
	);
	foreach ( $texts as $key => $default ) {
		$id = 'auto_press_' . $key . '_title';
		$wp_customize->add_setting( $id, array( 'default' => $default, 'sanitize_callback' => 'auto_press_classic_sanitize_section_title' ) );
		$wp_customize->add_control( $id, array( 'label' => $default . ' - ' . __( 'Title', 'auto-press-classic' ), 'section' => 'auto_press_layout', 'type' => 'text' ) );
	}
	foreach ( array( 'hero', 'contents', 'special', 'follow', 'related', 'recommend' ) as $key ) {
		$id = 'auto_press_show_' . $key;
		$wp_customize->add_setting( $id, array( 'default' => true, 'sanitize_callback' => 'auto_press_classic_sanitize_checkbox' ) );
		$wp_customize->add_control( $id, array( 'label' => sprintf( __( 'Show %s section', 'auto-press-classic' ), $key ), 'section' => 'auto_press_layout', 'type' => 'checkbox' ) );
	}
	$choices = auto_press_classic_category_choices();
	$choices[0] = __( 'No category selected', 'auto-press-classic' );
	for ( $slot = 1; $slot <= 4; $slot++ ) {
		$id = 'auto_press_contents_category_' . $slot;
		$wp_customize->add_setting( $id, array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
		$wp_customize->add_control( $id, array( 'label' => sprintf( __( 'Contents category %d', 'auto-press-classic' ), $slot ), 'section' => 'auto_press_layout', 'type' => 'select', 'choices' => $choices ) );
		$id = 'auto_press_contents_label_' . $slot;
		$wp_customize->add_setting( $id, array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( $id, array( 'label' => sprintf( __( 'Category %d label (blank uses category name)', 'auto-press-classic' ), $slot ), 'section' => 'auto_press_layout', 'type' => 'text' ) );
		$id = 'auto_press_contents_layout_' . $slot;
		$defaults = array( 1 => 'image', 2 => 'mixed', 3 => 'image', 4 => 'brief' );
		$wp_customize->add_setting( $id, array( 'default' => $defaults[ $slot ], 'sanitize_callback' => 'auto_press_classic_sanitize_home_layout' ) );
		$wp_customize->add_control( $id, array( 'label' => sprintf( __( 'Category %d presentation', 'auto-press-classic' ), $slot ), 'section' => 'auto_press_layout', 'type' => 'select', 'choices' => array( 'image' => __( 'Image stories', 'auto-press-classic' ), 'mixed' => __( 'Lead story and supporting stories', 'auto-press-classic' ), 'brief' => __( 'Brief updates', 'auto-press-classic' ) ) ) );
	}
	$wp_customize->add_setting( 'auto_press_selection_source', array( 'default' => 'editorial', 'sanitize_callback' => 'auto_press_classic_sanitize_selection_source' ) );
	$wp_customize->add_control( 'auto_press_selection_source', array( 'label' => __( 'Dark section content', 'auto-press-classic' ), 'section' => 'auto_press_layout', 'type' => 'select', 'choices' => array( 'editorial' => __( 'Selected category stories', 'auto-press-classic' ), 'discussion' => __( 'Popular discussions', 'auto-press-classic' ) ) ) );
	$wp_customize->add_setting( 'auto_press_selection_category', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( 'auto_press_selection_category', array( 'label' => __( 'Selected stories category', 'auto-press-classic' ), 'section' => 'auto_press_layout', 'type' => 'select', 'choices' => $choices ) );
	$wp_customize->add_setting( 'auto_press_selection_title', array( 'default' => __( 'Selected Stories', 'auto-press-classic' ), 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'auto_press_selection_title', array( 'label' => __( 'Selected stories title', 'auto-press-classic' ), 'section' => 'auto_press_layout', 'type' => 'text' ) );
	foreach ( array( 'accent' => '#398578', 'line' => '#c6c6c8' ) as $key => $default ) {
		$id = 'auto_press_' . $key;
		$wp_customize->add_setting( $id, array( 'default' => $default, 'sanitize_callback' => 'sanitize_hex_color' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array( 'label' => ucfirst( $key ), 'section' => 'auto_press_layout' ) ) );
	}
	$wp_customize->add_setting( 'auto_press_reading_size', array( 'default' => 'standard', 'sanitize_callback' => 'auto_press_classic_sanitize_reading_size' ) );
	$wp_customize->add_control( 'auto_press_reading_size', array( 'label' => __( 'Article text size', 'auto-press-classic' ), 'section' => 'auto_press_layout', 'type' => 'select', 'choices' => array( 'standard' => __( 'Standard', 'auto-press-classic' ), 'large' => __( 'Large', 'auto-press-classic' ) ) ) );
}
add_action( 'customize_register', 'auto_press_classic_native_controls' );

function auto_press_classic_sanitize_reading_size( $value ) {
	return 'large' === $value ? 'large' : 'standard';
}

function auto_press_classic_sanitize_reading_width( $value ) {
	return 'wide' === $value ? 'wide' : 'comfortable';
}

function auto_press_classic_sanitize_archive_layout( $value ) {
	return 'grid' === $value ? 'grid' : 'list';
}

function auto_press_classic_sanitize_home_layout( $value ) {
	return in_array( $value, array( 'image', 'mixed', 'brief' ), true ) ? $value : 'image';
}

function auto_press_classic_sanitize_selection_source( $value ) {
	return 'discussion' === $value ? 'discussion' : 'editorial';
}

/** Native, localized publishing metadata shared by lists and articles. */
function auto_press_classic_post_meta( $post_id, $show_category = true, $show_author = false ) {
	echo '<div class="ap-publishing-meta">';
	if ( $show_category ) {
		$term = auto_press_classic_primary_category( $post_id );
		if ( $term ) {
			$url = get_category_link( $term );
			if ( ! is_wp_error( $url ) ) {
				printf( '<a class="ap-meta-category" href="%s">%s</a>', esc_url( $url ), esc_html( $term->name ) );
			}
		}
	}
	printf( '<time datetime="%s">%s</time>', esc_attr( get_the_date( DATE_W3C, $post_id ) ), esc_html( get_the_date( get_option( 'date_format' ), $post_id ) ) );
	if ( $show_author && get_theme_mod( 'auto_press_show_author', true ) ) {
		$author_id = (int) get_post_field( 'post_author', $post_id );
		$author_name = get_the_author_meta( 'display_name', $author_id );
		if ( $author_id && $author_name ) {
			printf( '<a rel="author" href="%s">%s</a>', esc_url( get_author_posts_url( $author_id ) ), esc_html( $author_name ) );
		}
	}
	echo '</div>';
}

/** Keep visible sections named when a title field is cleared. */
function auto_press_classic_sanitize_section_title( $value, $setting ) {
	$value = sanitize_text_field( $value );
	return '' !== $value ? $value : $setting->default;
}

/** Use configured categories, or a generic latest-posts section on first install. */
function auto_press_classic_content_groups() {
	$groups = array();
	for ( $slot = 1; $slot <= 4; $slot++ ) {
		$id = absint( get_theme_mod( 'auto_press_contents_category_' . $slot, 0 ) );
		$term = $id ? get_term( $id, 'category' ) : null;
		if ( ! $term || is_wp_error( $term ) ) {
			continue;
		}
		$groups[] = array( 'label' => get_theme_mod( 'auto_press_contents_label_' . $slot, '' ) ?: $term->name, 'category' => $id, 'slot' => $slot );
	}
	return $groups ?: array( array( 'label' => __( 'Latest Posts', 'auto-press-classic' ), 'category' => 0, 'slot' => 1 ) );
}

/**
 * Build a bounded post query.
 *
 * @param array $args Query overrides.
 * @return WP_Query
 */
function auto_press_classic_post_query( $args = array() ) {
	$defaults = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	return new WP_Query( wp_parse_args( $args, $defaults ) );
}

/**
 * Get the primary category-like term for a post.
 *
 * @param int|null $post_id Post ID.
 * @return WP_Term|null
 */
function auto_press_classic_primary_category( $post_id = null ) {
	$post_id    = $post_id ? (int) $post_id : get_the_ID();
	$categories = get_the_category( $post_id );

	return ! empty( $categories ) ? $categories[0] : null;
}

/**
 * Print the primary category label.
 *
 * @param int|null $post_id Post ID.
 */
function auto_press_classic_category_label( $post_id = null ) {
	$category = auto_press_classic_primary_category( $post_id );

	if ( $category ) {
		echo esc_html( $category->name );
		return;
	}

	esc_html_e( 'News', 'auto-press-classic' );
}

/**
 * Get a bounded related post query.
 *
 * @param int $post_id Post ID.
 * @param int $limit Number of posts.
 * @return WP_Query
 */
function auto_press_classic_related_posts( $post_id, $limit = 4 ) {
	$category_ids = wp_get_post_categories( $post_id );
	$args         = array(
		'posts_per_page' => max( 1, min( 8, (int) $limit ) ),
		'post__not_in'   => array( (int) $post_id ),
	);

	if ( ! empty( $category_ids ) ) {
		$args['category__in'] = $category_ids;
	}

	return auto_press_classic_post_query( $args );
}

/**
 * Get Customizer social URL settings.
 *
 * @return array
 */
function auto_press_classic_social_links() {
	return array_filter(
		array(
			'Mail News' => get_theme_mod( 'auto_press_mail_news_url', '' ),
			'Instagram' => get_theme_mod( 'auto_press_instagram_url', '' ),
			'X'         => get_theme_mod( 'auto_press_x_url', '' ),
			'Facebook'  => get_theme_mod( 'auto_press_facebook_url', '' ),
			'YouTube'   => get_theme_mod( 'auto_press_youtube_url', '' ),
		)
	);
}

/**
 * Get the presentation image URL for a post.
 *
 * @param int    $post_id Post ID.
 * @param string $size Registered image size.
 * @return string
 */
function auto_press_classic_post_image_url( $post_id, $size = 'auto-press-hero' ) {
	if ( has_post_thumbnail( $post_id ) ) {
		$image_url = get_the_post_thumbnail_url( $post_id, $size );

		return $image_url ? $image_url : '';
	}

	$remote_image = get_post_meta( $post_id, '_auto_press_remote_image', true );

	return $remote_image ? esc_url_raw( $remote_image ) : '';
}

/**
 * Render an image or fallback block for a post card.
 *
 * @param int    $post_id Post ID.
 * @param string $size Image size.
 */
function auto_press_classic_post_image( $post_id, $size = 'auto-press-card' ) {
	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$post_id,
			$size,
			array(
				'class'   => 'ap-card__image',
				'loading' => 'lazy',
			)
		);
		return;
	}

	$remote_image = get_post_meta( $post_id, '_auto_press_remote_image', true );
	if ( $remote_image ) {
		printf(
			'<img class="ap-card__image" src="%1$s" alt="%2$s" loading="lazy">',
			esc_url( $remote_image ),
			esc_attr( get_the_title( $post_id ) )
		);
		return;
	}

	echo '<div class="ap-card__image" aria-hidden="true"></div>';
}

/**
 * Render single hero image or a fallback.
 *
 * @param int $post_id Post ID.
 */
function auto_press_classic_single_hero_image( $post_id ) {
	if ( has_post_thumbnail( $post_id ) ) {
			echo get_the_post_thumbnail( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$post_id,
				'auto-press-hero',
				array(
					'class'         => 'ap-single-hero__image',
					'loading'       => 'eager',
					'decoding'      => 'async',
					'fetchpriority' => 'high',
				)
			);
		return;
	}

	$remote_image = get_post_meta( $post_id, '_auto_press_remote_image', true );
	if ( $remote_image ) {
		printf(
			'<img class="ap-single-hero__image" src="%1$s" alt="%2$s" loading="eager" decoding="async" fetchpriority="high">',
			esc_url( $remote_image ),
			esc_attr( get_the_title( $post_id ) )
		);
		return;
	}

	echo '<div class="ap-single-hero__image" aria-hidden="true"></div>';
}

/**
 * Render homepage hero image or fallback.
 *
 * @param int $post_id Post ID.
 * @param int $index Slide index.
 */
function auto_press_classic_hero_image( $post_id, $index = 0 ) {
	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$post_id,
			'auto-press-hero',
			array(
				'class'   => 'ap-hero__image',
				'loading' => 0 === (int) $index ? 'eager' : 'lazy',
			)
		);
		return;
	}

	$remote_image = get_post_meta( $post_id, '_auto_press_remote_image', true );
	if ( $remote_image ) {
		printf(
			'<img class="ap-hero__image" src="%1$s" alt="%2$s" loading="%3$s">',
			esc_url( $remote_image ),
			esc_attr( get_the_title( $post_id ) ),
			esc_attr( 0 === (int) $index ? 'eager' : 'lazy' )
		);
		return;
	}

	echo '<div class="ap-hero__image" aria-hidden="true"></div>';
}
