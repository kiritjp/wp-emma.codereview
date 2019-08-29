<?php
/**
 * The default template for displaying content
 */
?>

<article class="entry">
	<div class="entry-title">
		<h2 class="primary-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<p class="secondary-title"><?php the_subtitle(); ?></p>
	</div>
	<div class="entry-meta">
		<span class="entry-date">Written on <?php echo get_the_date(); ?></span>
		<span class="entry-author">by <?php the_author_posts_link(); ?></span>
	</div>
	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>
</article>
