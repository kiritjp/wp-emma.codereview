<?php
/**
 * The default template for displaying content
 */
?>

<article class="entry">
	<div class="entry-title">
		<h1 class="primary-title"><?php the_title(); ?></h1>
		<p class="secondary-title"><?php the_subtitle(); ?></p>
	</div>
	<div class="entry-meta">
		<span class="entry-date">Written on <?php echo get_the_date(); ?></span>
		<span class="entry-author">by <?php the_author_posts_link(); ?></span>
	</div>
	<div class="entry-content">
		<?php
			the_content();
		?>
	</div>
</article>
