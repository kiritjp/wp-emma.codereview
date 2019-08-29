<?php 
/***
* Template Name: Product Category
***/ 

get_header(); 
?>

<div id="main-body">
	<div id="content">
		<div class="container">
			<article class="entry">
				<div class="entry-title">
					<p class="pre-title">Choose Your</p>
					<h1 class="primary-title"><?php the_title(); ?></h1>
					<p class="secondary-title"><?php the_subtitle(); ?></p>
				</div>
				<div class="entry-content clearfix">
					<div class="product-category">
						<?php
						$args = array(
							'taxonomy' => 'product_cat',
							'orderby'      => 'name',
							'hide_empty'   => '0',
						);
						$product_categories = get_categories($args);
						?>
						<?php if( !empty($product_categories) ) : ?>
						
							<?php 
							$i = 0;
							foreach ($product_categories as $product_category) : 
							?>
							
								<div class="item clearfix">
									<div class="image <?php if($i % 2 == 0 ) { echo 'fl'; } else { echo 'fr'; } ?>">
										<a href="<?php echo get_term_link($product_category); ?>">
											<?php 
												$thumbnail_id = get_woocommerce_term_meta( $product_category->term_id, 'thumbnail_id', true );
												
												echo wp_get_attachment_image($thumbnail_id, 'full');
											?>
										</a>
									</div>
									<div class="description <?php if($i % 2 == 0 ) { echo 'fr'; } else { echo 'fl'; } ?> ">
										<h3><?php echo $product_category->name; ?></h3>
										<p><?php echo $product_category->description; ?></p>
										<a href="<?php echo get_term_link($product_category); ?>" class="btn">Select</a>
									</div>
								</div>
							
							<?php $i++; endforeach; ?>
						<?php endif; ?>
					</div>
					<div class="product-category-overview">
						<?php
						while ( have_posts() ) : the_post();
							
							the_content();
							
						endwhile;
						?>
					</div>
				</div>
			</article>
		</div>
	</div>
</div><!-- end #main-body -->
 
<?php get_footer(); ?>
