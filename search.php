<?php
/**
 * The template for displaying search results pages.
 */
get_header(); ?>
<div id="main-body">
	<div id="content">
	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'theme-name' ), get_search_query() ); ?></h1>
		</header><!-- end .page-header -->
		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content', 'search' );
		endwhile;
		the_posts_pagination( array(
			'prev_text'          => __( 'Previous page', 'theme-name' ),
			'next_text'          => __( 'Next page', 'theme-name' )
		) );
	else :
		get_template_part( 'template-parts/content', 'none' );
	endif;
	?>
	</div><!-- end #content -->
</div><!-- end #main-body -->
<?php get_footer(); ?>
