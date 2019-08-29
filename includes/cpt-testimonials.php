<?php
/*
* Custom Post Type - Testimonial
*/

add_action( 'init', 'create_testimonials' );
function create_testimonials() {
    register_post_type( 'testimonials',
        array(
            'labels' => array(
                'name' => 'Testimonials',
                'singular_name' => 'Testimonial',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Testimonial',
                'edit' => 'Edit',
                'edit_item' => 'Edit Testimonial',
                'new_item' => 'New Testimonial',
                'view' => 'View',
                'view_item' => 'View Testimonial',
                'search_items' => 'Search Testimonials',
                'not_found' => 'No Testimonials found',
                'not_found_in_trash' => 'No Testimonials found in Trash',
                'parent' => 'Parent Testimonial'
            ),
            'public' => true,
            'menu_position' => 20,
            'supports' => array( 'title', 'thumbnail', 'editor' ),
            'taxonomies' => array( '' ),
            'has_archive' => false,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'homepage-slides')
        )
    );
	flush_rewrite_rules();
}

function testimonials_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'image' => __( 'Image' ),
	);

	return $columns;
}
add_filter( 'manage_edit-testimonials_columns', 'testimonials_columns' ) ;

function testimonials_data_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case 'image' :
			
			echo the_post_thumbnail();
			
			break;
		default :
			break;
	}
}

add_action( 'manage_testimonials_posts_custom_column', 'testimonials_data_columns', 10, 2 );



?>