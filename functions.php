<?php
/**
 * Twenty Thirteen functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

/*
 * Set up the content width value based on the theme's design.
 *
 * @see twentythirteen_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) )
	$content_width = 604;

/**
 * Add support for a custom header image.
 */
/*require get_template_directory() . '/inc/custom-header.php';*/

/**
 * Twenty Thirteen only works in WordPress 3.6 or later.
 */

/*if ( version_compare( $GLOBALS['wp_version'], '3.6-alpha', '<' ) )
	require get_template_directory() . '/inc/back-compat.php';*/

/**
 * Twenty Thirteen setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Thirteen supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_setup() {
	/*
	 * Makes Twenty Thirteen available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Thirteen, use a find and
	 * replace to change 'twentythirteen' to the name of your theme in all
	 * template files.
	 */

    

	load_theme_textdomain( 'twentythirteen', get_template_directory() . '/languages' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentythirteen_fonts_url() ) );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Header Menu', 'twentythirteen' ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1600, 1200, true );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'twentythirteen_setup' );

/**
 * Return the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Bitter by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function twentythirteen_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'twentythirteen' );

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'twentythirteen' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_scripts_styles() {
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds Masonry to handle vertical alignment of footer widgets.
	if ( is_active_sidebar( 'sidebar-1' ) )
		wp_enqueue_script( 'jquery-masonry' );

	// Loads JavaScript file with functionality specific to Twenty Thirteen.
	wp_enqueue_script( 'twentythirteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '2014-06-08', true );

	// Add Source Sans Pro and Bitter fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentythirteen-fonts', twentythirteen_fonts_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.03' );

	// Loads our main stylesheet.
	wp_enqueue_style( 'twentythirteen-style', get_stylesheet_uri(), array(), '2013-07-18' );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentythirteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentythirteen-style' ), '2013-07-18' );
	wp_style_add_data( 'twentythirteen-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'twentythirteen_scripts_styles' );


/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */
function twentythirteen_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentythirteen' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentythirteen_wp_title', 10, 2 );

/**
 * Register two widget areas.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'twentythirteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site.', 'twentythirteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Widget Area', 'twentythirteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'About Us page Full Screen Image', 'twentythirteen' ),
		'id'            => 'toma1',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '',
		'after_widget'  => '',
		//'before_title'  => '',
		//'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => __( 'The Team page Full Screen Image', 'twentythirteen' ),
		'id'            => 'team',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '',
		'after_widget'  => '',
		//'before_title'  => '',
		//'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Contact Us page Full Screen Image', 'twentythirteen' ),
		'id'            => 'contact',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '',
		'after_widget'  => '',
		//'before_title'  => '',
		//'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Production page Full Screen Image', 'twentythirteen' ),
		'id'            => 'production',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '',
		'after_widget'  => '',
		//'before_title'  => '',
		//'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Contact Form', 'twentythirteen' ),
		'id'            => 'contact_form',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '',
		'after_widget'  => '',
		//'before_title'  => '',
		//'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Team1', 'twentythirteen' ),
		'id'            => 'team1',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<div class="team-text-bucket">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="team-names">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Team2', 'twentythirteen' ),
		'id'            => 'team2',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<div class="team-text-bucket">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="team-names">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Team3', 'twentythirteen' ),
		'id'            => 'team3',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<div class="team-text-bucket">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="team-names">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Production Film', 'twentythirteen' ),
		'id'            => 'pfilm',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<div class="sectionbucket">',
		'after_widget'  => '</div>',
		'before_title'  => ' <h1 class="about-heading">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Production TV', 'twentythirteen' ),
		'id'            => 'ptv',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<div class="sectionbucket">',
		'after_widget'  => '</div>',
		'before_title'  => ' <h1 class="about-heading">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Distribution Film', 'twentythirteen' ),
		'id'            => 'dfilm',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<div class="sectionbucket">',
		'after_widget'  => '</div>',
		'before_title'  => ' <h1 class="about-heading">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Distribution TV', 'twentythirteen' ),
		'id'            => 'dtv',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<div class="sectionbucket">',
		'after_widget'  => '</div>',
		'before_title'  => ' <h1 class="about-heading">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'twentythirteen_widgets_init' );

if ( ! function_exists( 'twentythirteen_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'twentythirteen_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
*
* @since Twenty Thirteen 1.0
*/
function twentythirteen_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'twentythirteen' ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'twentythirteen' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'twentythirteen_entry_meta' ) ) :
/**
 * Print HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own twentythirteen_entry_meta() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'twentythirteen' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		twentythirteen_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'twentythirteen' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'twentythirteen' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'twentythirteen' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
endif;

if ( ! function_exists( 'twentythirteen_entry_date' ) ) :
/**
 * Print HTML with date information for current post.
 *
 * Create your own twentythirteen_entry_date() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param boolean $echo (optional) Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function twentythirteen_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'twentythirteen' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'twentythirteen' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'twentythirteen_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_the_attached_image() {
	/**
	 * Filter the image attachment size to use.
	 *
	 * @since Twenty thirteen 1.0
	 *
	 * @param array $size {
	 *     @type int The attachment height in pixels.
	 *     @type int The attachment width in pixels.
	 * }
	 */
	$attachment_size     = apply_filters( 'twentythirteen_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();
	$post                = get_post();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return string The Link format URL.
 */
function twentythirteen_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function twentythirteen_body_class( $classes ) {
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	return $classes;
}
add_filter( 'body_class', 'twentythirteen_body_class' );

/**
 * Adjust content_width value for video post formats and attachment templates.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_content_width() {
	global $content_width;

	if ( is_attachment() )
		$content_width = 724;
	elseif ( has_post_format( 'audio' ) )
		$content_width = 484;
}
add_action( 'template_redirect', 'twentythirteen_content_width' );

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function twentythirteen_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'twentythirteen_customize_register' );

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JavaScript handlers to make the Customizer preview
 * reload changes asynchronously.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_customize_preview_js() {
	wp_enqueue_script( 'twentythirteen-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
}
add_action( 'customize_preview_init', 'twentythirteen_customize_preview_js' );


if ( !function_exists( 'of_get_option' ) ) {

function of_get_option($name, $default = false) {     

    $optionsframework_settings = get_option('optionsframework');     

    // Gets the unique option id

    $option_name = $optionsframework_settings['id'];   

    if ( get_option($option_name) ) {

        $options = get_option($option_name);

    }

    

    if ( isset($options[$name]) ) {

        return $options[$name];

    } else {

        return $default;

    }

}

}
add_theme_support( 'post-thumbnails' );
function create_west_news() {  
    register_post_type( 'sf-news-list',  
        array(  
            'labels' => array(  
                'name' => __( 'News List' , 'Studio'),  
                'singular_name' => __( 'News' , 'Studio'),  
                'add_new' => __('Add News', 'Studio'),  
                'edit_item' => __('Edit News', 'Studio'),  
                'new_item' => __('New News', 'Studio'),  
                'view_item' => __('View News', 'Studio'),  
                'search_items' => __('Search News', 'Studio'),  
                'not_found' => __('No News found', 'Studio'),  
                'not_found_in_trash' => __('No News found in Trash', 'Studio')  
            ),  
            'public' => true,  
            'menu_position' => 27,  
            //'rewrite' => array('slug' => 'events'),  
            'supports' => array('title','editor','author','thumbnail','comments')  ,
			//'register_meta_box_cb' => 'add_events_metaboxes'
            //'taxonomies' => array('category', 'post_tag')  
        )  
    );  
}  
add_action( 'init', 'create_west_news' );  


//********************** Start Rewrite Rules ************************************//

function add_rewrite_rules($aRules) 

{

    $aNewRules = array(
	'production/([^/]+)/([^/]+)/?$' => 'index.php?pagename=productions-details&pid=$matches[1]&ptitle=$matches[2]',
	
	'distributions/([^/]+)/([^/]+)/?$' => 'index.php?pagename=distribution-details&pid=$matches[1]&ptitle=$matches[2]',
	

	);

    

	$aRules = $aNewRules + $aRules;

    return $aRules;

}

add_filter('rewrite_rules_array', 'add_rewrite_rules');



function add_query_vars($aVars) {

	$aVars[] = "ptitle";

	$aVars[] = "pid";

    return $aVars;

}

add_filter('query_vars', 'add_query_vars');




function register_my_menu() {
  register_nav_menu('footer-menu',__( 'Footer Menu' ));
}
add_action( 'init', 'register_my_menu' );

add_action( 'edit_form_after_title', 'myprefix_edit_form_after_title' );
function myprefix_edit_form_after_title() {
 echo '<br><a class="button button-primary button-large" onclick=javascript:window.open("'.get_site_url()."/".get_the_title().'") href="#" >Use Easy Editor</a>';
}

/*add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
  return is_array($var) ? array() : '';
}*/

add_filter('nav_menu_css_class', 'css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'css_attributes_filter', 100, 1);
add_filter('page_css_class', 'css_attributes_filter', 100, 1);
function css_attributes_filter($var) {
       return is_array($var) ? array_intersect($var, array('current-menu-item','current-page-ancestor')) : '';
}


function clean_custom_menus($name) {
	$data="";
    global $post;
    $post_slug = '';
    if($post != ''){
    	$post_slug=$post->post_name;
    }
    

$menu_name = $name;
$locations = get_nav_menu_locations();
$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
$menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );

    $count = 0;
    $submenu = false;
	$data.="<ul class='nav navbar-nav navbar-right'>";

    foreach( (array) $menuitems as $item ):
        // get page id from using menu item object id
        $id = get_post_meta( $item->ID, '_menu_item_object_id', true );
        // set up a page object to retrieve page data
        $page = get_page( $id );
        $link = custom_get_page_link( $id );

        // item does not have a parent so menu_item_parent equals 0 (false)
        if ( !$item->menu_item_parent ):

        // save this id for later comparison with sub-menu items
        $parent_id = $item->ID;
	    
		$active="";
	     if($post_slug==$page->post_name){ $active="class='active'"; }

    endif; 
	
	
	 /*if ( $parent_id == $item->menu_item_parent ): 
	 if ( !$submenu ): $submenu = true; 
            <ul class="sub-menu">
             endif;*/

	 $data.="<li $active ><a href='$link' >$item->title</a></li>";
     
	/*if ( $menuitems[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ): 
             </ul>
    $submenu = false; endif; 

    endif; */
	/*if ( $menuitems[ $count + 1 ]->menu_item_parent != $parent_id ): 
     $data.="</ul>";                           
      $submenu = false; endif; */

     $count++; endforeach; 
	 
	 $data.="</ul>";
	 
	 return $data;
}


add_filter( 'custom_get_page_link' , 'custom_get_page_link' );

function custom_get_page_link( $id ) {
	$link="";
	global $wpdb;
	
	$custom=0;
	$table_name = $wpdb->prefix . 'postmeta';
	$sql = "SELECT meta_value FROM $table_name WHERE post_id=$id and  meta_key = '_menu_item_object' and meta_value = 'custom' ";
    $result = $wpdb->get_results($sql);
	 foreach( $result as $results ) {
		$custom=1; 
	 }
	
	if($custom==1){
    $table_name = $wpdb->prefix . 'postmeta';
	$sql = "SELECT meta_value FROM $table_name WHERE post_id=$id and meta_key = '_menu_item_url' ";
    $result = $wpdb->get_results($sql);
	   foreach( $result as $results ) {
	     $link=$results->meta_value;
	   }
	}else{
		$link=get_page_link( $id );
	}
	 
	 
 return $link;
}

$role_object = get_role( 'editor' );

// add $cap capability to this role object
$role_object->add_cap( 'edit_theme_options' );
$role_object->add_cap( 'coverage_plugin_menu' );


function get_the_content_with_formatting ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}



add_filter( 'custom_get_next_posts_link' , 'custom_get_next_posts_link' );

function custom_get_next_posts_link( $label = null, $max_page = 0 ) {
	global $paged, $wp_query;

	if ( !$max_page )
		$max_page = $wp_query->max_num_pages;

	if ( !$paged )
		$paged = 1;

	$nextpage = intval($paged) + 1;

	if ( null === $label )
		$label = __( 'Next Page &raquo;' );

	if ( !is_single() && ( $nextpage <= $max_page ) ) {
		/**
		 * Filter the anchor tag attributes for the next posts page link.
		 *
		 * @since 2.7.0
		 *
		 * @param string $attributes Attributes for the anchor tag.
		 */
		$attr = apply_filters( 'next_posts_link_attributes', '' );

		//return '<a href="' . next_posts( $max_page, false ) . "\" $attr>" . preg_replace('/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label) . '</a>';
		return next_posts( $max_page, false );
	}
}



add_filter( 'custom_paginate_links' , 'custom_paginate_links' );
function custom_paginate_links( $args = '' ) {
	global $wp_query, $wp_rewrite;

	// Setting up default values based on the current URL.
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$url_parts    = explode( '?', $pagenum_link );

	// Get max pages and current page out of the current query, if available.
	$total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
	$current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

	// Append the format placeholder to the base URL.
	$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

	// URL base depends on permalink settings.
	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	$defaults = array(
		'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
		'format' => $format, // ?page=%#% : %#% is replaced by the page number
		'total' => $total,
		'current' => $current,
		'show_all' => false,
		'prev_next' => true,
		'prev_text' => __('&laquo; Previous'),
		'next_text' => __('Next &raquo;'),
		'end_size' => 1,
		'mid_size' => 2,
		'type' => 'plain',
		'add_args' => array(), // array of query args to add
		'add_fragment' => '',
		'before_page_number' => '',
		'after_page_number' => ''
	);

	$args = wp_parse_args( $args, $defaults );

	if ( ! is_array( $args['add_args'] ) ) {
		$args['add_args'] = array();
	}
	
	
	
	
	
	/** Get Customq **/

	// Merge additional query vars found in the original URL into 'add_args' array.
	if ( isset( $url_parts[1] ) ) {
		// Find the format argument.
		$format_query = parse_url( str_replace( '%_%', $args['format'], $args['base'] ), PHP_URL_QUERY );
		wp_parse_str( $format_query, $format_arg );

		// Remove the format argument from the array of query arguments, to avoid overwriting custom format.
		wp_parse_str( remove_query_arg( array_keys( $format_arg ), $url_parts[1] ), $query_args );
		$args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $query_args ) );
	}
	
	


	// Who knows what else people pass in $args
	$total = (int) $args['total'];
	if ( $total < 2 ) {
		return;
	}
	$current  = (int) $args['current'];
	$end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
	if ( $end_size < 1 ) {
		$end_size = 1;
	}
	$mid_size = (int) $args['mid_size'];
	if ( $mid_size < 0 ) {
		$mid_size = 2;
	}
	$add_args = $args['add_args'];
	$r = '';
	$page_links = array();
	$dots = false;

	if ( $args['prev_next'] && $current && 1 < $current ) :
		$link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
		$link = str_replace( '%#%', $current - 1, $link );
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );
		$link .= $args['add_fragment'];

		/**
		 * Filter the paginated links for the given archive pages.
		 *
		 * @since 3.0.0
		 *
		 * @param string $link The paginated link URL.
		 */
		 
		$page_links[] = '<li class="page-item"><a class="page-link" href="' . esc_url( apply_filters( 'paginate_links', $link.'&q='.$args['customq'] ) ) . '">' . $args['prev_text'] . '</a></li>';
	endif;
	for ( $n = 1; $n <= $total; $n++ ) :
		if ( $n == $current ) :
			$page_links[] = "<li class='page-item active'><a href='#' class='page-link'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</a></li>"; 
			$dots = true;
		else :
			if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
				$link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
				$link = str_replace( '%#%', $n, $link );
				if ( $add_args )
					$link = add_query_arg( $add_args, $link );
				$link .= $args['add_fragment'];

				/** This filter is documented in wp-includes/general-template.php */
				$page_links[] = "<li class='page-item'><a class='page-link' href='" . esc_url( apply_filters( 'paginate_links', $link."&q=".$args['customq'] ) ) . "'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</a></li>"; 
				$dots = true;
			elseif ( $dots && ! $args['show_all'] ) :
				$page_links[] = '<li class="page-item"><a href="#"  class="page-link dots">' . __( '&hellip;' ) . '</a></li>';
				$dots = false;
			endif;
		endif;
	endfor;
	if ( $args['prev_next'] && $current && ( $current < $total || -1 == $total ) ) :
		$link = str_replace( '%_%', $args['format'], $args['base'] );
		$link = str_replace( '%#%', $current + 1, $link );
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );
		$link .= $args['add_fragment'];

		/** This filter is documented in wp-includes/general-template.php */
		$page_links[] = '<li class="page-item"><a class="next page-link" href="' . esc_url( apply_filters( 'paginate_links', $link.'&q='.$args['customq'] ) ) . '"">' . $args['next_text'] . '</a></li>';
	endif;
	switch ( $args['type'] ) {
		case 'array' :
			return $page_links;

		case 'list' :
			$r .= "<ul class='page-numbers'>\n\t<li>";
			$r .= join("</li>\n\t<li>", $page_links);
			$r .= "</li>\n</ul>\n";
			break;

		default :
			$r = join("\n", $page_links);
			break;
	}
//echo "<b style='color:#000'>thisme".$args['customq']."hello</b>" ; exit;


	return $r;
}

function register_session(){
	//if (session_status() == PHP_SESSION_NONE) {
    //if( !session_id() ){
        //session_start();
	//}
	
	if( !session_id() ){
    $ok = @session_start();
       if(!$ok){
       session_regenerate_id(true); // replace the Session ID
       session_start(); 
       }
    }
}
add_action('init','register_session');








add_filter( 'checkFile' , 'checkFile' );
function checkFile($movieName){
    
	$file=$_SERVER['DOCUMENT_ROOT']."/roksky/wp-content/customimages/".$movieName.".jpg";
    if (file_exists($file)) {
	    return get_site_url()."/wp-content/customimages/".$movieName.".jpg";	
	}else{
		return "";
	}
}


add_filter( 'send_email_after_registration' , 'send_email_after_registration' );
function send_email_after_registration($user_id){

$headers = 'From: Drinks.ng <hello@drinks.ng>';
$to = $email;
$message = "Thank you for registering,";
$message .= "\r\n\r\n";
$message .= "Regards";
$message .= "\r\n";
$message .= "Drinks.ng";
 
    if( wp_mail( $to, $subject, $message, $headers ) ){
        
    }

}


add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        //session_start();
    }
}


function myEndSession() {
    //session_destroy ();
}


add_filter( 'update_items_per_page' , 'update_items_per_page' );
function update_items_per_page($query){
	global $wpdb;
	$num = 0;
	$result = $wpdb->get_results($query);
	foreach($result as $res){ 
		$term_list = wp_get_post_terms($res->ID,'product_cat',array('fields'=>'names'));
        $catname = $term_list[0];
		if($catname == "other services"){
			$num++;
		}
	}
   return $num;
}

add_filter( 'remove_items_from_product' , 'remove_items_from_product' );
function remove_items_from_product($name, $budget){

	if(isset($_SESSION['product_basket'])){
		$products = array();
				for($i=0, $j=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
					$name = str_replace("-"," ", $name);
					$category_name = str_replace("-"," ", $_SESSION['product_basket']['product'][$i]['category_name']);
					if($name != $category_name){
						$products[$j] = @$_SESSION['product_basket']['product'][$i];
						$j++;
					}
				}
				$basket = array(
					"budget" => $budget,
					"balance" => 0,
					"product" => $products
				);
				$_SESSION['product_basket'] = $basket;
	}
}


add_filter( 'fetch_categories_ids' , 'fetch_categories_ids' );
function fetch_categories_ids(){	
	$args = array(
    	'number'     => @$number,
    	'orderby'    => @$orderby,
    	'order'      => @$order,
    	'hide_empty' => @$hide_empty,
    	'include'    => @$ids
	);

$product_categories = get_terms( 'product_cat', $args);

$category_ids = "";
$i=0;
foreach( $product_categories as $cat ) { 
	if($cat->name != "other services"){
		if($i!=0){ $category_ids .= ", "; }  
		$category_ids .= $cat->term_id; $i++; 
	}
}
return $category_ids;

}


add_filter( 'fetch_categories_ids_step' , 'fetch_categories_ids_step' );
function fetch_categories_ids_step(){	
	$args = array(
    	'number'     => @$number,
    	'orderby'    => @$orderby,
    	'order'      => @$order,
    	'hide_empty' => @$hide_empty,
    	'include'    => @$ids
	);

$product_categories = get_terms( 'product_cat', $args);

$category_ids = "";
$i=0;
foreach( $product_categories as $cat ) { 
	if($cat->name != "other services" && $cat->name != "vendors"){
		

		if(isset($_SESSION['basket'])){
			for($j=0; $j<sizeof($_SESSION['basket']['category']); $j++){
				$str = str_replace("-", " ", @$_SESSION['basket']['category'][$j]['name']);

				if(strtolower($cat->name) == strtolower($str)){

					if($i!=0){ $category_ids .= ", "; }  
					$category_ids .= $cat->term_id; 
					$i++; 
						
				}
			}

		} else {
					if($i!=0){ $category_ids .= ", "; }  
					$category_ids .= $cat->term_id; 
					$i++; 
		}
		
	}
}
return $category_ids;

}


add_filter( 'fetch_categories_ids_all' , 'fetch_categories_ids_all' );
function fetch_categories_ids_all(){	
	$args = array(
    	'number'     => @$number,
    	'orderby'    => @$orderby,
    	'order'      => @$order,
    	'hide_empty' => @$hide_empty,
    	'include'    => @$ids
	);

$product_categories = get_terms( 'product_cat', $args);

$category_ids = "";
$i=0;
foreach( $product_categories as $cat ) { 
	if($cat->name != "other services" && $cat->name != "vendors"){
		

		if(isset($_SESSION['product_basket'])){
			for($j=0; $j<sizeof($_SESSION['product_basket']['product']); $j++){
				$str = str_replace("-", " ", @$_SESSION['product_basket']['product'][$i]['category_name']);

				if(strtolower($cat->name) == strtolower($str)){

					if($i!=0){ $category_ids .= ", "; }  
					$category_ids .= $cat->term_id; 
					$i++; 
						
				}
			}
		} 
		
	}
}
return $category_ids;

}

//Product Cat Create page
function wh_taxonomy_add_new_meta_field() {
    ?>

    <div class="form-field">
        <label for="wh_meta_carton"><?php _e('Carton Number', 'wh'); ?></label>
        <input type="number" name="wh_meta_carton" id="wh_meta_carton" value="0" >
        <p class="description"><?php _e('How many of this Product make 1 Carton?', 'wh'); ?></p>
    </div>
    <div class="form-field">
        <label for="wh_meta_no_of_bottle"><?php _e('No of Bottle', 'wh'); ?></label>
        <input type="text" name="wh_meta_no_of_bottle" id="wh_meta_no_of_bottle" value="0">
        <p class="description"><?php _e('Enter number of bottle for this category', 'wh'); ?></p>
    </div>
    <div class="form-field">
        <label for="wh_meta_no_of_people"><?php _e('No of People', 'wh'); ?></label>
        <input type="text" name="wh_meta_no_of_people" id="wh_meta_no_of_people" value="0">
        <p class="description"><?php _e('nter number of People for this category', 'wh'); ?></p>
    </div>
    <?php
}

//Product Cat Edit page
function wh_taxonomy_edit_meta_field($term) {

    //getting term ID
    $term_id = $term->term_id;

    // retrieve the existing value(s) for this meta field.
    $wh_meta_carton = get_term_meta($term_id, 'wh_meta_carton', true);
    $wh_meta_no_of_bottle = get_term_meta($term_id, 'wh_meta_no_of_bottle', true);
    $wh_meta_no_of_people = get_term_meta($term_id, 'wh_meta_no_of_people', true);

    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_carton"><?php _e('Carton Number', 'wh'); ?></label></th>
        <td>
            <input type="number" name="wh_meta_carton" id="wh_meta_carton" value="<?php echo esc_attr($wh_meta_carton) ? esc_attr($wh_meta_carton) : '0'; ?>">
            <p class="description"><?php _e('How many number of this Product make 1 Carton?', 'wh'); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_no_of_bottle"><?php _e('No of Bottle', 'wh'); ?></label></th>
        <td>
            <input type="text" name="wh_meta_no_of_bottle" id="wh_meta_no_of_bottle" value="<?php echo esc_attr($wh_meta_no_of_bottle) ? esc_attr($wh_meta_no_of_bottle) : '0'; ?>">
            <p class="description"><?php _e('Enter number of bottle for this category', 'wh'); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="wh_meta_no_of_bottle"><?php _e('No of People', 'wh'); ?></label></th>
        <td>
            <input type="text" name="wh_meta_no_of_people" id="wh_meta_no_of_people" value="<?php echo esc_attr($wh_meta_no_of_people) ? esc_attr($wh_meta_no_of_people) : '0'; ?>">
            <p class="description"><?php _e('Enter number of People for this category', 'wh'); ?></p>
        </td>
    </tr>
    <?php
}

add_action('product_cat_add_form_fields', 'wh_taxonomy_add_new_meta_field', 10, 1);
add_action('product_cat_edit_form_fields', 'wh_taxonomy_edit_meta_field', 10, 1);

// Save extra taxonomy fields callback function.
function wh_save_taxonomy_custom_meta($term_id) {

    $wh_meta_carton = filter_input(INPUT_POST, 'wh_meta_carton');
    $wh_meta_no_of_bottle = filter_input(INPUT_POST, 'wh_meta_no_of_bottle');
    $wh_meta_no_of_people = filter_input(INPUT_POST, 'wh_meta_no_of_people');

    update_term_meta($term_id, 'wh_meta_carton', $wh_meta_carton);
    update_term_meta($term_id, 'wh_meta_no_of_bottle', $wh_meta_no_of_bottle);
    update_term_meta($term_id, 'wh_meta_no_of_people', $wh_meta_no_of_people);
}

add_action('edited_product_cat', 'wh_save_taxonomy_custom_meta', 10, 1);
add_action('create_product_cat', 'wh_save_taxonomy_custom_meta', 10, 1);


add_filter( 'getAllLocation' , 'getAllLocation' );
function getAllLocation(){
	global $wpdb;
	$query = "
     SHOW COLUMNS FROM wp_location_of_event
   ";
   $result = $wpdb->get_results($query);
   $data="";

   foreach($result as $res){
   		if($res->Field != "id"){
   			$column = str_replace("_"," ", $res->Field);
   			$value = strtolower($res->Field);
   			$data.="<option value='".$value."'>".ucwords($column)."</option>";
   		}
   }
   return $data;
}


add_filter( 'set_minimum_prices' , 'set_minimum_prices' );
function set_minimum_prices(){

	$args = array(
	    'number'     => @$number,
	    'orderby'    => 'title',
	    'order'      => 'ASC',
	    'hide_empty' => @$hide_empty,
	    'include'    => @$ids
	);
	$product_categories = get_terms( 'product_cat', $args );
	$count = count($product_categories);
	if ( $count > 0 ){
	    foreach ( $product_categories as $product_category ) {
	        if($product_category->slug != "other-services"){
	            $args = array(
	                'posts_per_page' => -1,
	                'tax_query' => array(
	                    'relation' => 'AND',
	                    array(
	                        'taxonomy' => 'product_cat',
	                        'field' => 'slug',
	                        'terms' => $product_category->slug
	                    )
	                ),
	                'post_type' => 'product',
	                'orderby' => 'title,'
	            );
	            $products = new WP_Query( $args );
	            $min_amount = 0;

	            $i = 0;
	            while ( $products->have_posts() ) {
	                $products->the_post();
	                global $product;
	                if($i == 0){
	                    $min_amount = $product->get_price();
	                } else {
	                    $min_amount = min($min_amount, $product->get_price());
	                }
	            }

	            $_SESSION[$product_category->slug . "-price"] = $min_amount;
	        }
	    }
	}
}


add_filter( 'set_party_calculations' , 'set_party_calculations' );
function set_party_calculations(){

		$args = array(
	    'number'     => @$number,
	    'orderby'    => 'title',
	    'order'      => 'ASC',
	    'hide_empty' => @$hide_empty,
	    'include'    => @$ids
		);
		$product_categories = get_terms( 'product_cat', $args );
		$count = count($product_categories);
		if ( $count > 0 ){
	    	foreach ( $product_categories as $cat ) {
	    			$no_of_bottle = get_term_meta($cat->term_id, 'wh_meta_no_of_bottle', true);
        			$no_of_people = get_term_meta($cat->term_id, 'wh_meta_no_of_people', true);

        			$arr = array();
        			$arr[0] = $no_of_bottle;
        			$arr[1] = $no_of_people;

        			$_SESSION[$cat->slug . "-calculation"] = $arr;
	    	}
	    }

}


add_filter( 'unset_register_data' , 'unset_register_data' );
function unset_register_data(){
	unset($_SESSION['agent_email']);
	unset($_SESSION['agent_first_name']);
	unset($_SESSION['agent_last_name']);
	unset($_SESSION['agent_phone']);
	unset($_SESSION['agent_company_name']);
	unset($_SESSION['agent_state_name']);
	unset($_SESSION['agent_state_name']);
	unset($_SESSION['agent_locals']);
	unset($_SESSION['agent_address']);
	unset($_SESSION['agent_about_you']);
}


add_filter( 'unset_all_data' , 'unset_all_data' );
function unset_all_data(){
	unset($_SESSION['product_basket']);
    unset($_SESSION['total_incur_other']);
    unset($_SESSION['total_incur_product']);
    unset($_SESSION['basket']);
    unset($_SESSION['event_type']);
    unset($_SESSION['no_of_guest']);
    unset($_SESSION['budget']);
    unset($_SESSION['state_name']);
    unset($_SESSION['state_name']);
    unset($_SESSION['locals']);
    unset($_SESSION['location_of_event']);
    unset($_SESSION['event_date']);
    unset($_SESSION['email']);
    unset($_SESSION['custom_wc_create_order']);
}

add_filter( 'get_avatar', 'slug_get_avatar', 10, 5 );
function slug_get_avatar( $avatar, $id_or_email, $size, $default, $alt ) {

    //If is email, try and find user ID
    if( ! is_numeric( $id_or_email ) && is_email( $id_or_email ) ){
        $user  =  get_user_by( 'email', $id_or_email );
        if( $user ){
            $id_or_email = $user->ID;
        }
    }

    //if not user ID, return
    if( ! is_numeric( $id_or_email ) ){
        return $avatar;
    }

    //Find URL of saved avatar in user meta
    $saved = get_user_meta( $id_or_email, 'field_with_custom_avatar', true );
    //check if it is a URL
    if( filter_var( $saved, FILTER_VALIDATE_URL ) ) {
        //return saved image
        return '<img src="'. $saved . '" alt="'. $alt . '" width="50" height="50" />';
    }

    //return normal
    return $avatar;
}


$role = add_role( 'vendors', 'Vendors', array(
    'read' => true, // True allows that capability
) );


function scrapeImage($text) {
    $pattern = '/src=[\'"]?([^\'" >]+)[\'" >]/';
    preg_match($pattern, $text, $link);
    $link = $link[1];
    $link = urldecode($link);
    return $link;
}

add_filter( 'get_proposal', 'get_proposal', 10, 5 );
function get_proposal($categories, $auto) {

	$budjet = 0;
    $budjet = (int) str_replace(",", "", @$_SESSION['budget']); 
    $no_of_guest = "0";
    if(isset($_SESSION['no_of_guest'])){ $no_of_guest = @$_SESSION['no_of_guest']; }
    $event_date = date("jS F Y", strtotime(@$_SESSION['event_date']));
    $vendor_name = "";
    $company_name = "";
    $company_color = "";
    $avatar = "";

    if(is_user_logged_in()){ 
        $user_id = get_current_user_id();
        $fname = get_user_meta( $user_id, 'first_name', true );
        $lname = get_user_meta( $user_id, 'last_name', true );
        $vendor_name = ucwords($fname . " " . $lname);
        $company_name = get_user_meta( $user_id, 'company_name', true );
        $company_color = get_user_meta( $user_id, 'company_color', true );
        
        if($company_color != ""){
        	$company_color = "style='background: $company_color' ";
        }

        // Get user avatar
        $avatar = get_user_meta( $user_id, 'field_with_custom_avatar', true );
        if($avatar == ""){
        	$avatar =  scrapeImage(get_wp_user_avatar($user_id));
        }
    }

    $data = "";
    // code to dislay here
    $grand_total = 0;

    if(isset($_SESSION['product_basket'])){

        $categories  = array(); 
        for($i=0,$j=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
            if(!in_array($_SESSION['product_basket']['product'][$i]['category_name'], $categories)){
                if($_SESSION['product_basket']['product'][$i]['category_name'] != "other services" && 
                    $_SESSION['product_basket']['product'][$i]['category_name'] != "vendors"){
                    $categories[$j] = $_SESSION['product_basket']['product'][$i]['category_name'];
                    $j++;
                }
            }
        }

        $basket = "";
        $incr = 0;
        
        for($i=0; $i<sizeof($categories); $i++){

                $basket .= "<div id='cat-id' class='pro-cat'>";

                $sub_total = 0;
                $carton_total = 0;
                $match = false;
                $inner_basket = "";
                $units = 0;
                

                for($j=sizeof($_SESSION['product_basket']['product'])-1; $j>=0; $j--){
                    if($categories[$i] == $_SESSION['product_basket']['product'][$j]['category_name'] && $_SESSION['product_basket']['product'][$j]['name'] != ""){

                        $match = true;
                        $btl = $_SESSION['product_basket']['product'][$j]['bottle']; if(!is_numeric($_SESSION['product_basket']['product'][$j]['bottle']) == true){ $btl = 0; }
                        $carton = $_SESSION['product_basket']['product'][$j]['carton']; if(!is_numeric($_SESSION['product_basket']['product'][$j]['carton']) == true){ $carton = 0; }
                        $carton = @intval($btl / $carton);
                        $carton_total += $carton;

                        $item_val = $_SESSION['product_basket']['product'][$j]['total'];
                        if(isset($_SESSION['updated_items'])){
                        	if(isset($_SESSION['updated_items'][$incr])){
                        		$item_val = $_SESSION['updated_items'][$incr];
                        	}
                        }

                        $inner_basket .= "<div class='pro-list'>";
                        $inner_basket .= "<p class='name'>". $_SESSION['product_basket']['product'][$j]['name'] ."</p>";
                        // $inner_basket .= "<p class='carton'>". $carton ."<small>cartons</small></p>";
                        $inner_basket .= "<p class='carton'>&nbsp;<small>&nbsp;</small></p>";
                        $inner_basket .= "<p class='unit'>". $_SESSION['product_basket']['product'][$j]['bottle'] ."<small>units</small></p>";
                        $inner_basket .= "<p class='unit-price unit'>". $_SESSION['product_basket']['product'][$j]['price'] ."<small>units price</small></p>";
                        $inner_basket .= "<p class='total unit'>". $item_val ."<small>Total</small></p>";
                        $inner_basket .= "</div>";
                        $sub_total += (int) $item_val;
                        $units += (int) $_SESSION['product_basket']['product'][$j]['bottle'];
                        $incr++;
                    }
                }
                // <span class='pull-right' style='opacity:0'>" . $carton_total . " CTN</span>
                // <span class='pull-right'>" . $carton_total . " Cartons</span>
                $units_text = ($units > 1) ? "Units" : "Unit";
                $basket .= "<h4 class='title sup-title'><span>". ucwords(str_replace("-", " ", $categories[$i])) ."</span>
                            <span class='pull-right'>₦" . $sub_total . " Total</span>
                            <span class='pull-right'>" . $units . " $units_text </span>
                            </h4>";

                if($match == true) $basket .= $inner_basket;
                $basket .= "</div><hr />";
                $grand_total += $sub_total;
        }


    // Other services
    $otherservices = "";
    $incr = 0;
        
        for($j=0; $j<sizeof($_SESSION['product_basket']['product']); $j++){
                if($_SESSION['product_basket']['product'][$j]['category_name'] == "other services"){

                	$item_val = $_SESSION['product_basket']['product'][$j]['total'];
                        if(isset($_SESSION['updated_others'])){
                        	if(isset($_SESSION['updated_others'][$incr])){
                        		$item_val = $_SESSION['updated_others'][$incr];
                        	}
                        }

                    $otherservices .= "<div class='pro-list'>";
                    $otherservices .= "<p class='name'>". $_SESSION['product_basket']['product'][$j]['name'] ."</p>";
                    $otherservices .= "<p class='unit'>". $_SESSION['product_basket']['product'][$j]['bottle'] ."</p>";
                    $otherservices .= "<p class='unit'>" . $item_val . "</p>";
                    $otherservices .= "</div>";
                    $grand_total += (int)$item_val;
                    $incr++;
                }
        }

    if(isset($_SESSION['selected_vendor'])){
        $otherservices .= "<div id='cat-id' class='pro-cat'>
        	<h4 class='title sup-title'>
            <h3 class='vendor-sel-title'>Vendor Selected </h3>
            <p class='vendor-sel'>" . $_SESSION['selected_vendor'] . "</p>
            </h4>
        </div>";
     }


    $data .= "<div class='brand-cont' ". $company_color . ">
          <div class='logo-cont'>
          <img src='" . $avatar . "' alt='' class='img-fluid' style='width: " . $auto . ";height: " . $auto . ";' />
          </div>
            <h3 class='title'>" . $company_name . "</h3>
          </div>
          
          <div class='main-pro-container main-price-table'>
              
                <div class='pro-content basket-cont'>
                    
                        <div class='col-12'>
                        <div class='basket'>
                
                    <div class='top-sec text-left'>
                    <div class='pull-left col'>
                        
                        <h3 class='title guest'>₦" . str_replace(".00", "", number_format((float)$budjet,2,".",",")) . "</h3>
                        <p><small>Budget</small></p>
                    </div>
                    <div class='pull-left col event-count'>
                        <h3 class='title guest'>". $no_of_guest . "</h3>
                        <p><small>Number of guests</small></p>
                        </div>
                        
                    <div class='pull-left col event-type'>
                        <h3 class='title guest'>" . @$_SESSION['event_type'] . "</h3>
                        <p><small>Event Type</small></p>
                    </div>
                        
                    <div class='pull-left col event-date'>
                        <h3 class='title guest'>" . $event_date . "</h3>
                        <p><small>Event date</small></p>
                    </div>
                    
                    </div>
                                
                        <div class='main-content '>
                            
                        <div class='row'>
                            <div class='col-xl-8 col-lg-8'>
                        
                               <h4 class='basket-label'>Drinks </h4>
                               " . $basket . "
                            </div>
                            
                             <div class='col-xl-4 col-lg-4'>
                        <div class='service-list'>
                    <h4 class='basket-label'>Other Services</h4>
                        
                    <div id='cat-id' class='pro-cat'>
                    <h4 class='title sup-title'>
                        <span>Service </span>
                        <span>Amount</span>
                        <span>Estimated Cost</span> 
                        
                        " . $otherservices . "
                        
                        
                        
                        </div>
                        </div>
                            </div>
                        </div>    
                        
                        
                        <div class='footer text-right'>
                            
                    <h3 class='title'>₦" . str_replace(".00", "", number_format((float)$grand_total,2,".",",")) . "</h3>
                        <h4>Total Spent</h4>
                    </div>
                            
                    </div>
                    </div>
                </div>
                 
            </div>
                 
            ";
    }

    return $data;

}


add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );
function extra_user_profile_fields( $user ) { ?>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() . '/css/spectrum.min.css'; ?>">

    <h3><?php _e("Extra Vendor profile information", "blank"); ?></h3>

    <table class="form-table">
    <tr>
        <th><label for="company_name"><?php _e("Company Name"); ?></label></th>
        <td>
            <input type="text" name="company_name" id="company_name" value="<?php echo esc_attr( get_the_author_meta( 'company_name', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your company name."); ?></span>
        </td>
    </tr>
    <tr>
        <th><label for="company_color"><?php _e("Company Color"); ?></label></th>
        <td>
            <input type="text" name="company_color" id="company_color" value="<?php echo esc_attr( get_the_author_meta( 'company_color', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your company color."); ?></span>
        </td>
    </tr>
    </table>

    <script src="<?php echo get_template_directory_uri() . "/js/spectrum.min.js"; ?>"></script>
    <script>
    $( document ).ready(function() {
    	var color = $("#company_color").val();
    	$("#company_color").spectrum({
        	color: "" + color + "",
        	preferredFormat: "hex",
        	showInput: true,
        	showPalette: true
    	});
    });
    </script>

<?php }


add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'company_name', $_POST['company_name'] );
    update_user_meta( $user_id, 'company_color', $_POST['company_color'] );
}


add_action( 'init', 'hide_shipping_details' );
function hide_shipping_details() { 
	global $pagenow;
	if( is_admin() && $pagenow == "user-edit.php") { ?>
	<style> #fieldset-shipping{ display: none !important } </style>
<?php } } 



add_filter( 'get_email_proposal', 'get_email_proposal', 10, 5 );
function get_email_proposal($categories) {

	$budjet = 0;
    $budjet = (int) str_replace(",", "", @$_SESSION['budget']); 
    $no_of_guest = "0";
    if(isset($_SESSION['no_of_guest'])){ $no_of_guest = @$_SESSION['no_of_guest']; }
    $event_date = date("jS F Y", strtotime(@$_SESSION['event_date']));
    $vendor_name = "";
    $company_name = "";
    $avatar = "";

    if(is_user_logged_in()){ 
        $user_id = get_current_user_id();
        $fname = get_user_meta( $user_id, 'first_name', true );
        $lname = get_user_meta( $user_id, 'last_name', true );
        $vendor_name = ucwords($fname . " " . $lname);
        $company_name = get_user_meta( $user_id, 'company_name', true );
        $company_color = get_user_meta( $user_id, 'company_color', true );
        
        if($company_color == ""){
        	$company_color = "#fa6333;";
        }

        // Get user avatar
        $avatar = get_user_meta( $user_id, 'field_with_custom_avatar', true );
        if($avatar == ""){
        	$avatar =  scrapeImage(get_wp_user_avatar($user_id));
        }
    }

    $data = "";
    // code to dislay here
    $grand_total = 0;

    if(isset($_SESSION['product_basket'])){

        $categories  = array(); 
        for($i=0,$j=0; $i<sizeof($_SESSION['product_basket']['product']); $i++){
            if(!in_array($_SESSION['product_basket']['product'][$i]['category_name'], $categories)){
                if($_SESSION['product_basket']['product'][$i]['category_name'] != "other services" && 
                    $_SESSION['product_basket']['product'][$i]['category_name'] != "vendors"){
                    $categories[$j] = $_SESSION['product_basket']['product'][$i]['category_name'];
                    $j++;
                }
            }
        }

        $basket = "";
        $incr = 0;
        
        $padding_top_bottom = "";

        for($i=0; $i<sizeof($categories); $i++){

        	if($i == 0){
        		$padding_top_bottom = "padding-bottom: 20px;";
        	} else {
        		$padding_top_bottom = "padding-top: 20px;";
        	}

                $basket .= "<tr>
          <td style=\"padding: 0px 15px; background: #fff; font-family: 'Open Sans', sans-serif; font-size: 13px; border-bottom: solid 1px rgba(0,0,0,0.1); $padding_top_bottom\">";

                $sub_total = 0;
                $carton_total = 0;
                $match = false;
                $inner_basket = "";
                $units = 0;
                

                for($j=sizeof($_SESSION['product_basket']['product'])-1; $j>=0; $j--){
                    if($categories[$i] == $_SESSION['product_basket']['product'][$j]['category_name'] && $_SESSION['product_basket']['product'][$j]['name'] != ""){

                        $match = true;
                        $btl = $_SESSION['product_basket']['product'][$j]['bottle']; if(!is_numeric($_SESSION['product_basket']['product'][$j]['bottle']) == true){ $btl = 0; }
                        $carton = $_SESSION['product_basket']['product'][$j]['carton']; if(!is_numeric($_SESSION['product_basket']['product'][$j]['carton']) == true){ $carton = 0; }
                        $carton = @intval($btl / $carton);
                        $carton_total += $carton;

                        $item_val = $_SESSION['product_basket']['product'][$j]['total'];
                        if(isset($_SESSION['updated_items'])){
                        	if(isset($_SESSION['updated_items'][$incr])){
                        		$item_val = $_SESSION['updated_items'][$incr];
                        	}
                        }

                        $inner_basket .= "<div style='width: 100%; float: left; margin-bottom: 15px;'>";
                        $inner_basket .= "<p style='font-size: 14px; padding-left: 10px; float:left; margin: 0px; width: 20%;'>". $_SESSION['product_basket']['product'][$j]['name'] ."</p>";
                        // $inner_basket .= "<p style='font-size: 14px; padding-left: 10px; float:left; margin: 0px; width: 13%; text-align: right;'>". $carton ."<small style='font-size: 10px; font-weight: 400; color: rgba(0, 0, 0, 0.5); display: block; text-transform: capitalize;'>cartons</small></p>";
                        $inner_basket .= "<p style='font-size: 14px; padding-left: 10px; float:left; margin: 0px; width: 13%; text-align: right;'>". $_SESSION['product_basket']['product'][$j]['bottle'] ."<small style='font-size: 10px; font-weight: 400; color: rgba(0, 0, 0, 0.5); display: block; text-transform: capitalize;'>units</small></p>";
                        $inner_basket .= "<p style='font-size: 14px; padding-left: 10px; float:left; margin: 0px; width: 13%; text-align: right;'>". $_SESSION['product_basket']['product'][$j]['price'] ."<small style='font-size: 10px; font-weight: 400; color: rgba(0, 0, 0, 0.5); display: block; text-transform: capitalize;'>units price</small></p>";
                        $inner_basket .= "<p style='font-size: 14px; padding-left: 10px; float:left; margin: 0px; width: 13%; text-align: right;'>". $item_val ."<small style='font-size: 10px; font-weight: 400; color: rgba(0, 0, 0, 0.5); display: block; text-transform: capitalize;'>Total</small></p>";
                        $inner_basket .= "</div>";
                        $sub_total += (int) $item_val;
                        $units += (int) $_SESSION['product_basket']['product'][$j]['bottle'];
                        $incr++;
                    }
                }

                // <span style='float: right; margin-right: 20px;'>" . $carton_total . " CTN</span>
                // <span style='float: right; margin-right: 20px;'>" . $carton_total . " Cartons</span>
				$units_text = ($units > 1) ? "Units" : "Unit";
                $basket .= "<h4 style='margin:0 0 20px; font-weight: 600;'><span>". ucwords(str_replace("-", " ", $categories[$i])) ."</span>
                            <span style='float: right; margin-right: 20px;'>₦" . $sub_total . " Total</span>
                            <span style='float: right; margin-right: 20px;'>" . $units . " $units_text  </span>
                            </h4>";

                if($match == true) $basket .= $inner_basket;
                $basket .= "</td></tr>";
                $grand_total += $sub_total;
        }


    // Other services
    $otherservices = "";
    $incr = 0;
        
        for($j=0; $j<sizeof($_SESSION['product_basket']['product']); $j++){
                if($_SESSION['product_basket']['product'][$j]['category_name'] == "other services"){

                	$item_val = $_SESSION['product_basket']['product'][$j]['total'];
                        if(isset($_SESSION['updated_others'])){
                        	if(isset($_SESSION['updated_others'][$incr])){
                        		$item_val = $_SESSION['updated_others'][$incr];
                        	}
                        }

                    $otherservices .= "<div style='float:left width:100%;'>";
                    $otherservices .= "<p style='float:left; width: 33.3333%; text-transform: capitalize'>". $_SESSION['product_basket']['product'][$j]['name'] ."</p>";
                    $otherservices .= "<p style='float:left; width: 33.3333%'>". $_SESSION['product_basket']['product'][$j]['bottle'] ."</p>";
                    $otherservices .= "<p style='float:left; width: 33.3333%'>" . $item_val . "</p>";
                    $otherservices .= "</div>";
                    $grand_total += (int)$item_val;
                    $incr++;
                }
        }

    if($otherservices != ""){
    	$otherservices = "<h4 class='title sup-title'>
                        <span style='float:left; width: 33.3333%'>Service </span>
                        <span style='float:left; width: 33.3333%'>Amount</span>
                        <span style='float:left; width: 33.3333%'>Estimated Cost</span> 
                    </h4>" . $otherservices;
    }

    if(isset($_SESSION['selected_vendor'])){
        $otherservices .= "<div style='float:left width:100%;'>
        	<h4>
            <p style='float:left; width: 100%'>Vendor Selected </p>
            <p style='float:left; width: 100%;margin-top: 0;font-weight: normal;'>" . $_SESSION['selected_vendor'] . "</p>
            </h4>
        </div>";
     }

     $header_otherservices = "<tr>
          <td style='padding: 0px 15px; background: #fff;'>
            
              <h4 style=\"font-family: 'Open Sans', sans-serif; padding-bottom: 10px; border-bottom: solid 1px rgba(0,0,0,0.1);\">Other Services </h4>
              
          </td>
        </tr>
        <tr><td style=\"padding: 0px 15px; background: #fff; font-family: 'Open Sans', sans-serif; font-size: 13px; border-bottom: solid 1px rgba(0,0,0,0.1); padding-bottom: 20px;\">
                <div style='background: #F8F6F6; padding: 20px; float: left; width: 93%;'>
                    ";

      if($otherservices != ""){
      	  $otherservices = $header_otherservices . $otherservices;
      }


     $data .= "<!DOCTYPE html>
<html lang='en'>
<head>
   
	<meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    
	<meta name='author' content='' />
	<meta name='description' content='' />
	
	<title>Drinks Calculator</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,800,900' rel='stylesheet'>
</head>
<body style='background: #F8F6F6; padding: 0px; margin: 0px;'>

    
    <table style='width: 600px; margin:0px auto; background: #fff; border-collapse: collapse;' border='0'>
    
        <tr>
          <td style='background: ". $company_color . "; width: 100%; padding-top: 30px; padding-bottom: 30px; text-align: center;' colspan='2'>
            
          <div style=' width: 150px; height: 80px; margin-left: 30px; margin-right: 30px; background: #111; float:left;'>
          <img src='" . $avatar . "' alt='' class='img-fluid' style='width: 100%;height: 100%;' />    
          </div>
            <h3 style=\"color:#fff; float:left; text-transform: uppercase; margin-top: 40px; font-family: 'Open Sans', sans-serif;\">" . $company_name . "</h3>
              
        </tr>
        <tr>
            <td style='padding:25px 15px; background: #F8F6F6;'>
            <div style='float: left; margin-right: 60px;'>
                <h3 style=\"font-family: 'Open Sans', sans-serif; margin: 0; font-size: 15px;\">₦" . str_replace(".00", "", number_format((float)$budjet,2,".",",")) . "</h3>
            <p style=\"margin: 0; font-family: 'Open Sans', sans-serif; font-size: 13px; color: rgba(0, 0, 0, 0.5);\"><small>Budget</small></p>
            </div>
                
            <div style='float: left; margin-right: 60px;'>
            <h3 style=\"font-family: 'Open Sans', sans-serif; margin: 0; font-size: 15px;\">". $no_of_guest . " People</h3>
            <p style=\"margin: 0; font-family: 'Open Sans', sans-serif; font-size: 13px; color: rgba(0, 0, 0, 0.5);\"><small>Number of guests</small></p>
            </div>
                
            <div style='float: left; margin-right: 60px;'>
            <h3 style=\"font-family: 'Open Sans', sans-serif; margin: 0; font-size: 15px;\">" . @$_SESSION['event_type'] . "</h3>
            <p style=\"margin: 0; font-family: 'Open Sans', sans-serif; font-size: 13px; color: rgba(0, 0, 0, 0.5);\"><small>Event Type</small></p>
            </div>
             
             <div style='float: left;'>
            <h3 style=\"font-family: 'Open Sans', sans-serif; margin:0; font-size: 15px;\">" . $event_date . "</h3>
            <p style=\"margin: 0; font-family: 'Open Sans', sans-serif; font-size: 13px; color: rgba(0, 0, 0, 0.5);\"><small>Event date</small></p>
            </div>
                
            
            </td>
        </tr>
        <tr>
          <td style='padding: 0px 15px; background: #fff;'>
            
              <h4 style=\"font-family: 'Open Sans', sans-serif; padding-bottom: 10px; border-bottom: solid 1px rgba(0,0,0,0.1);\">Drinks </h4>
              
          </td>
        </tr>
        ";

          $data .= $basket;

          $data .= "" . $otherservices . "

                    </div>
            </td>
        </tr>";



          $data .= "<tr>
           <td style='text-align: right; padding: 20px;'>
            <h3 style=\"font-size: 30px; font-family: 'Open Sans', sans-serif; margin: 0px; padding: 0px;\">₦" . str_replace(".00", "", number_format((float)$grand_total,2,".",",")) . "</h3>
               <h4 style=\"font-family: 'Open Sans', sans-serif; margin: 0px; font-weight: 400; padding: 0px;\">Total Spent</h4>
            </td>
        </tr>
        
        <tr>
        <td style='border-top: solid 1px rgba(0,0,0,0.1); padding-bottom: 20px; padding-top:20px; '>
            <p style=\"text-align: center; font-family: 'Open Sans', sans-serif; font-size: 12px;\">© copyright 2018 Drinks.ng all rights reserved</p>
            </td>
        </tr>
        
    </table>

</body>
</html>";


// check end of brace
}


    return $data;

}


add_action( 'subscribe_to_mailchimp', 'subscribe_to_mailchimp' );
function subscribe_to_mailchimp( $email ) {
    $api_key = "8f7941447dc911ec0a6a412ad632c140-us7"; //api key
    $list_id = "3a6fcf3067"; // list id for Master Newsletter Subscribers List

    $url = 'https://us7.api.mailchimp.com/2.0/lists/subscribe.json?apikey='.$api_key.'&id='.$list_id.'&email[email]='.$email.'&double_optin=false&send_welcome=false';
    if($email != ""){

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 2
        ));

        $result = curl_exec($ch);
        curl_close($ch);
        //return $result;
    }
}




// add_action( 'wp_enqueue_scripts', 'wptuts_add_color_picker' );
// function wptuts_add_color_picker( $hook ) {

//         // Add the color picker css file       
//         wp_enqueue_style( 'wp-color-picker' ); 
//         wp_enqueue_script( 'wp-color-picker');
// }

// add_action( 'wp_enqueue_scripts', 'wp_enqueue_color_picker' );
// function wp_enqueue_color_picker( $hook_suffix ) {
//     wp_enqueue_style( 'wp-color-picker' );
//     wp_enqueue_script( 'wp-color-picker');
//     wp_enqueue_script( 'wp-color-picker-script-handle', plugins_url('wp-color-picker-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
// }


// Register Scripts &amp; Styles in Admin panel
// function custom_color_picker_scripts() {
// wp_enqueue_style( 'wp-color-picker' );
// wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
// wp_enqueue_script( 'cp-active', plugins_url('/js/cp-active.js', __FILE__), array('jquery'), '', true );

// }
// add_action( 'wp_enqueue_scripts', 'custom_color_picker_scripts');

/** optional solution to menus
function add_menuclass( $ulclass ) {
  return preg_replace( '/<ul>/', '<ul id="nav" class="something-classy">', $ulclass, 1 );
}
add_filter( 'wp_page_menu', 'add_menuclass' );
*/



//********************** End Rewrite Rules ************************************//