<?php
/**
 * The template for displaying all single posts and attachments
 */

get_header(); ?>
<div id="main-body">
	<div id="content">
		<div class="container">
			<div id="content-main">
				
					<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/content-single', get_post_format() );
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					endwhile;
					?>
				
			</div>
			<?php get_sidebar(); ?>
			<div class="clear"></div>
		</div>
	</div>
</div><!-- end #main-body -->
<?php get_footer(); ?>


