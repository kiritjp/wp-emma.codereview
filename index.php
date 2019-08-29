<?php
/**
 * The main template file
 */

get_header(); ?>

<div id="main-body" class="two-column">
	<div id="content">
		<div class="container">
			<div id="content-main">
				<?php if ( have_posts() ) : ?>
					<div class="entry-list">
					<?php
					while ( have_posts() ) : the_post(); 
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;
					?>
					</div>
					<?php
					the_posts_pagination( array(
						'prev_text'          => __( 'Previous page', 'theme-name' ),
						'next_text'          => __( 'Next page', 'theme-name' )
					) );
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
			</div>
			<?php get_sidebar(); ?>
			<div class="clear"></div>
		</div>
	</div>
</div><!-- end #main-body -->

<?php get_footer(); ?>
