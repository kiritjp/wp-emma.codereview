<?php
/**
 * The template part for displaying results in search pages
 */
?>

<article class="entry">
	<div class="entry-title">
		<h1 class="primary-title"><?php the_title(); ?></h1>
	</div>
	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>
</article>
