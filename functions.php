<?php
/**
 * Functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, live_it_up_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'live_it_up_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 *
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 630;
}

/** Tell WordPress to run live_it_up_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'live_it_up_setup' );

if ( ! function_exists( 'live_it_up_setup' ) ):
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 *
	 * To override live_it_up_setup() in a child theme, add your own live_it_up_setup to your child theme's
	 * functions.php file.
	 *
	 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
	 * @uses register_nav_menus() To add support for navigation menus.
	 * @uses add_editor_style() To style the visual editor.
	 * @uses load_theme_textdomain() For translation/localization support.
	 * @uses add_custom_image_header() To add support for a custom header.
	 * @uses register_default_headers() To register the default custom header images provided with the theme.
	 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
	 *
	 * @since Live it up 1.0
	 */
	function live_it_up_setup() {

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style( 'editor-style.css?=' . time() );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'live_it_up_custom_background_args', array(
			'default-color' => 'f3f3f3',
			'default-image' => '',
		) ) );

		add_theme_support( 'custom-header', apply_filters( 'live_it_up_custom_header_args', array(
			'default-image'      => '',
			'default-text-color' => '000000',
			'width'              => 1000,
			'height'             => 250,
			'flex-height'        => true,
			'wp-head-callback'   => 'live_it_up_header_style',
		) ) );

		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain( 'live-it-up', get_template_directory_uri() . '/languages' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Navigation', 'live-it-up' ),
		) );

		// Don't support text inside the header image.
		define( 'NO_HEADER_TEXT', true );

		// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
		register_default_headers( array(
			'berries'       => array(
				'url'           => '%s/images/headers/berries.jpg',
				'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
				'description'   => esc_html__( 'Berries', 'live-it-up' )
			),
			'cherryblossom' => array(
				'url'           => '%s/images/headers/cherryblossoms.jpg',
				'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
				'description'   => esc_html__( 'Cherry Blossoms', 'live-it-up' )
			),
			'concave'       => array(
				'url'           => '%s/images/headers/concave.jpg',
				'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
				'description'   => esc_html__( 'Concave', 'live-it-up' )
			),
			'fern'          => array(
				'url'           => '%s/images/headers/fern.jpg',
				'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
				'description'   => esc_html__( 'Fern', 'live-it-up' )
			),
			'forestfloor'   => array(
				'url'           => '%s/images/headers/forestfloor.jpg',
				'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
				'description'   => esc_html__( 'Forest Floor', 'live-it-up' )
			),
			'inkwell'       => array(
				'url'           => '%s/images/headers/inkwell.jpg',
				'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
				'description'   => esc_html__( 'Inkwell', 'live-it-up' )
			),
			'path'          => array(
				'url'           => '%s/images/headers/path.jpg',
				'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
				'description'   => esc_html__( 'Path', 'live-it-up' )
			),
			'sunset'        => array(
				'url'           => '%s/images/headers/sunset.jpg',
				'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
				'description'   => esc_html__( 'Sunset', 'live-it-up' )
			)
		) );
	}
endif;

if ( ! function_exists( 'live_it_up_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see live_it_up_custom_header_setup().
	 */
	function live_it_up_header_style() {
		$header_text_color = get_header_textcolor();
		// If we get this far, we have custom styles. Let's do this.
		?>
        <style id="custom-header-styles" type="text/css">
            <?php if( get_header_image() ) : ?>
            #header {
                background: url(<?php header_image(); ?>) no-repeat center bottom;
            }

            <?php endif; ?>
            <?php
				// Has the text been hidden?
				if ( 'blank' === $header_text_color ) :
			?>
            .site-title,
            .site-description {
                position: absolute;
                clip: rect(1px, 1px, 1px, 1px);
            }

            <?php
				// If the user has set a custom color for the text use that.
				else :
			?>
            .site-title a,
            .site-description {
                color: #<?php echo esc_attr( $header_text_color ); ?>;
            }

            <?php endif; ?>
        </style>
		<?php
	}
endif;

if ( ! function_exists( 'live_it_up_admin_header_style' ) ) :
	/**
	 * Styles the header image displayed on the Appearance > Header admin panel.
	 *
	 * Referenced via add_custom_image_header() in live_it_up_setup().
	 *
	 * @since Live it up 1.0
	 */
	function live_it_up_admin_header_style() {
		?>
        <style type="text/css">
            /* Shows the same border as on front end */
            #headimg {
                border-bottom: 1px solid #000;
                border-top: 4px solid #000;
            }

            /* If NO_HEADER_TEXT is false, you would style the text with these selectors:
				#headimg #name { }
				#headimg #desc { }
			*/
        </style>
		<?php
	}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Live it up 1.0
 */
function live_it_up_page_menu_args( $args ) {
	$args['show_home'] = true;

	return $args;
}

add_filter( 'wp_page_menu_args', 'live_it_up_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Live it up 1.0
 * @return int
 */
function live_it_up_excerpt_length( $length ) {
	return 40;
}

add_filter( 'excerpt_length', 'live_it_up_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Live it up 1.0
 * @return string "Continue Reading" link
 */
function live_it_up_continue_reading_link() {
	return ' <a href="' . esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'live-it-up' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and live_it_up_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Live it up 1.0
 * @return string An ellipsis
 */
function live_it_up_auto_excerpt_more( $more ) {
	return ' &hellip;' . live_it_up_continue_reading_link();
}

add_filter( 'excerpt_more', 'live_it_up_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Live it up 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function live_it_up_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= live_it_up_continue_reading_link();
	}

	return $output;
}

add_filter( 'get_the_excerpt', 'live_it_up_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Live it up's style.css.
 *
 * @since Live it up 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function live_it_up_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}

add_filter( 'gallery_style', 'live_it_up_remove_gallery_css' );

if ( ! function_exists( 'live_it_up_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own live_it_up_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Live it up 1.0
	 */
	function live_it_up_comment( $comment, $args, $depth ) {
		switch ( $comment->comment_type ) :
			case '' :
				?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <div id="comment-<?php comment_ID(); ?>">
                    <div class="comment-author vcard">
						<?php echo get_avatar( $comment, 40 ); ?>
						<?php sprintf( __( '%s <span class="says">says:</span>', 'live-it-up' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
                    </div><!-- .comment-author .vcard -->
					<?php if ( '0' === $comment->comment_approved ) : ?>
                        <em><?php esc_html_e( 'Your comment is awaiting moderation.', 'live-it-up' ); ?></em>
                        <br/>
					<?php endif; ?>

                    <div class="comment-meta commentmetadata">
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<?php
							/* translators: 1: date, 2: time */
							printf( esc_html__( '%1$s at %2$s', 'live-it-up' ), esc_html( get_comment_date() ), esc_html( get_comment_time() ) ); ?>
                        </a>
						<?php edit_comment_link( esc_html__( '(Edit)', 'live-it-up' ), ' ' ); ?>
                    </div><!-- .comment-meta .commentmetadata -->

                    <div class="comment-body"><?php comment_text(); ?></div>

                    <div class="reply">
						<?php comment_reply_link( array_merge( $args, array(
							'depth'     => $depth,
							'max_depth' => $args['max_depth']
						) ) ); ?>
                    </div><!-- .reply -->
                </div><!-- #comment-##  -->

				<?php
				break;
			case 'pingback'  :
			case 'trackback' :
				?>
                <li class="post pingback">
                <p><?php esc_html_e( 'Pingback:', 'live-it-up' ); ?><?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'live-it-up' ), ' ' ); ?></p>
				<?php
				break;
		endswitch;
	}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override live_it_up_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Live it up 1.0
 * @uses register_sidebar
 */
function live_it_up_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Widget Area', 'live-it-up' ),
		'id'            => 'primary-widget-area',
		'description'   => esc_html__( 'The primary widget area', 'live-it-up' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget'  => '</li><div class="widget-footer"></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name'          => esc_html__( 'Secondary Widget Area', 'live-it-up' ),
		'id'            => 'secondary-widget-area',
		'description'   => esc_html__( 'The secondary widget area', 'live-it-up' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget'  => '</li><div class="widget-footer"></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name'          => esc_html__( 'First Footer Widget Area', 'live-it-up' ),
		'id'            => 'first-footer-widget-area',
		'description'   => esc_html__( 'The first footer widget area', 'live-it-up' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget'  => '</li><div class="widget-footer"></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name'          => esc_html__( 'Second Footer Widget Area', 'live-it-up' ),
		'id'            => 'second-footer-widget-area',
		'description'   => esc_html__( 'The second footer widget area', 'live-it-up' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget'  => '</li><div class="widget-footer"></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name'          => esc_html__( 'Third Footer Widget Area', 'live-it-up' ),
		'id'            => 'third-footer-widget-area',
		'description'   => esc_html__( 'The third footer widget area', 'live-it-up' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget'  => '</li><div class="widget-footer"></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name'          => esc_html__( 'Fourth Footer Widget Area', 'live-it-up' ),
		'id'            => 'fourth-footer-widget-area',
		'description'   => esc_html__( 'The fourth footer widget area', 'live-it-up' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget'  => '</li><div class="widget-footer"></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

/** Register sidebars by running live_it_up_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'live_it_up_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since Live it up 1.0
 */
function live_it_up_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array(
		$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
		'recent_comments_style'
	) );
}

add_action( 'widgets_init', 'live_it_up_remove_recent_comments_style' );

if ( ! function_exists( 'live_it_up_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post—date/time and author.
	 *
	 * @since Live it up 1.0
	 */
	function live_it_up_posted_on() {
		?>
        <span class="meta-prep meta-prep-author">Posted on</span>
        <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_time() ); ?>" rel="bookmark">
            <span class="entry-date"><?php echo get_the_date(); ?></span>
        </a>
        <span class="meta-sep">by</span>
        <span class="author vcard">
            <a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo sprintf( esc_attr__( 'View all posts by %s', 'live-it-up' ), get_the_author() ); ?>">
                <?php echo get_the_author(); ?>
            </a>
        </span>
		<?php
	}
endif;

if ( ! function_exists( 'live_it_up_posted_in' ) ) :
	/**
	 * Prints HTML with meta information for the current post (category, tags and permalink).
	 *
	 * @since Live it up 1.0
	 */
	function live_it_up_posted_in() {
		// Retrieves tag list of current post, separated by commas.
		$tag_list = get_the_tag_list( '', ', ' );
		if ( $tag_list ) {
			$posted_in = esc_html__( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'live-it-up' );
		} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
			$posted_in = esc_html__( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'live-it-up' );
		} else {
			$posted_in = esc_html__( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'live-it-up' );
		}
		// Prints the string, replacing the placeholders.
		printf(
			esc_html( $posted_in ),
			esc_html( get_the_category_list( esc_html__( ', ', 'live-it-up' ) ) ),
			esc_html( $tag_list ),
			esc_url( get_permalink() ),
			the_title_attribute( 'echo=0' )
		);
	}
endif;

/**
 * By default, if a widget doesn't have a title, Wordpress doesn't show the widget header
 * To fix this, this function adds a space if no title is set.
 *
 *
 */

function live_it_up_fix_widget_title( $title ) {
	if ( ! $title ) {
		$title = '&nbsp;';
	}

	return $title;
}

add_filter( 'widget_title', 'live_it_up_fix_widget_title' );

/**
 * Enqueue scripts and styles.
 */
function live_it_up_scripts() {
	wp_enqueue_style( 'live_it_up-style', get_stylesheet_uri() );

	$fonts_url = 'https://fonts.googleapis.com/css?family=Arimo|Armata';
	if ( ! empty( $fonts_url ) ) {
		wp_enqueue_style( 'live_it_up-font-name', esc_url_raw( $fonts_url ), array(), null );
	}

}

add_action( 'wp_enqueue_scripts', 'live_it_up_scripts' );