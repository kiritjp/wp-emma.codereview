<?php
/**
 * The template part for displaying a message that posts cannot be found
 */
?>

<article class="entry">
	<div class="entry-title">
		<h1 class="primary-title"><?php _e( 'Nothing Found', 'emmacustom' ); ?></h1>
	</div>
	<div class="entry-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'emmacustom' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
		<?php elseif ( is_search() ) : ?>
			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'emmacustom' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'emmacustom' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</article>



