<?php
/**
 * The template for displaying pages
 */

get_header(); ?>

<div id="main-body">
	<div id="content">
		<div class="container">
			<?php
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/content', 'page' );
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			endwhile;
			?>
		</div>
	</div>
</div><!-- end #main-body -->

<?php get_footer(); ?>
