<?php
/**
 * The template used for displaying page content
 */
?>
<article class="entry">
	<div class="entry-title">
		<h1 class="primary-title"><?php the_title(); ?></h1>
		<p class="secondary-title"><?php the_subtitle(); ?></p>
	</div>
	<div class="entry-content clearfix">
		<?php the_content(); ?>
	</div>
</article>