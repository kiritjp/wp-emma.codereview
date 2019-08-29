<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header(); ?>
<div id="main-body">
	<div id="content">
		<article class="entry">
			<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'theme-name' ); ?></h1>
			<div class="entry-content clearfix">
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'theme-name' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</article>
	</div><!-- end #content -->
</div><!-- end #main-body -->
<?php get_footer(); ?>