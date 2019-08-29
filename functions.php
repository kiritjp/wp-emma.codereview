<?php

/***
* Set the content width based on the theme's design and stylesheet.
***/
if ( ! isset( $content_width ) )
    $content_width = 1170; /* pixels */

/***
* Sets up theme defaults and registers support for various WordPress features.
*
* Note that this function is hooked into the after_setup_theme hook, which runs
* before the init hook. The init hook is too late for some features, such as indicating
* support post thumbnails.
***/
	
if ( ! function_exists( 'emmacustom_setup' ) ):
function emmacustom_setup() {
 
    //Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );
	
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
 
	//Enable Featured Thumbnail
	add_theme_support( 'post-thumbnails' );    set_post_thumbnail_size( 150, 150 );

 	//Register area for custom menu
    register_nav_menus( array(
        'top-menu' => __( 'Top Menu', 'emmacustom' ),
		'header-menu' => __( 'Header Menu', 'emmacustom' ),
		'mobile-menu' => __( 'Mobile Menu', 'emmacustom' ),
		'footer-menu-1' => __( 'Footer Menu 1', 'emmacustom' ),
		'footer-menu-2' => __( 'Footer Menu 2', 'emmacustom' ),
    ) );
	
	//Enable support for the Aside Post Format
    //add_theme_support( 'post-formats', array( 'aside' ) );
}
endif;
add_action( 'after_setup_theme', 'emmacustom_setup' );
	
/***
* Register Widget Area
***/
function emmacustom_widgets_init() {
	register_sidebar(array(
		'name'			=> 'Sidebar Widgets',
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the sidebar section of the site.', 'emmacustom' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));	
}
add_action( 'widgets_init', 'emmacustom_widgets_init' );

/***
* Enqueue scripts and styles
***/
function emmacustom_scripts_styles() {
	wp_enqueue_style('font-Parisienne', 'https://fonts.googleapis.com/css?family=Parisienne');
	wp_enqueue_style('font-nato-sans-tc', 'https://fonts.googleapis.com/css?family=Noto+Sans+TC:300,400');
	wp_enqueue_style('effects', get_template_directory_uri() . '/css/effects.css');
	wp_enqueue_style('woocommerce', get_template_directory_uri() . '/css/woocommerce.css');
	wp_enqueue_style( 'style', get_stylesheet_uri(), array(),'1.0.1' );
	wp_enqueue_style('responsive', get_template_directory_uri() . '/css/responsive.css');
	wp_enqueue_style('magnific-css', get_template_directory_uri() . '/css/magnific-popup.css');
	wp_enqueue_style('custom-css', get_template_directory_uri() . '/css/custom.css');
	
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
	
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-1.12.1.min.js');
	wp_enqueue_script('cycle', get_template_directory_uri() . '/js/jquery.cycle2.min.js');
	wp_enqueue_script('site', get_template_directory_uri() . '/js/site.js');
	wp_enqueue_script('magnific-js', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js');
	global $post;
	wp_localize_script( 'site', 'custom_params', array(
        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX,
        'posts' => json_encode( $post ),
    ) );
    wp_enqueue_script( 'site' );
	
	
 
}
add_action( 'wp_enqueue_scripts', 'emmacustom_scripts_styles' );


/*** 
 * Add page slug as body class. also include the page parent 
***/
function emmacustom_body_classes($classes, $class='') {
	global $wp_query;
	if(isset($wp_query->post)){
		$post_id = $wp_query->post->ID; 
		if(is_page($post_id )){
			$page = get_page($post_id);
			if($page->post_parent>0){
				$parent = get_page($page->post_parent);
				$classes[] = 'page-'.sanitize_title($parent->post_title);
			}
			$classes[] = 'page-'.sanitize_title($page->post_title);
		}
	}
	return $classes;
}
add_filter('body_class','emmacustom_body_classes');

// set the title attribute on images inserted via the editor, and then those created as featured images
function inserted_image_titles( $html, $id ) {
	$attachment = get_post($id);
	$thetitle = $attachment->post_title;
	return str_replace('<img', '<img title="' . $thetitle . '" '  , $html);
}
add_filter( 'media_send_to_editor', 'inserted_image_titles', 15, 2 );

function featured_image_titles($attr, $attachment = null){
	$attr['title'] = get_post($attachment->ID)->post_title;
	return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'featured_image_titles', 10, 2);

function emmacustom_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	
	return $fields;
}
  
add_filter( 'comment_form_fields', 'emmacustom_move_comment_field_to_bottom');


function my_wp_subtitle_page_part_support() {
    add_post_type_support( 'product', 'wps_subtitle' );
}
add_action( 'init', 'my_wp_subtitle_page_part_support' );


require get_template_directory() . '/includes/cpt-testimonials.php';
require get_template_directory() . '/includes/woocommerce-overrides.php';
require get_template_directory() . '/includes/woocommerce-custom-attributes.php';
