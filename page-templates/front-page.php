<?php 
/***
* Template Name: Home
***/ 

get_header(); 
?>

	<div id="main-body">
		<div class="banner">
			<div class="container">
				<h1>The new way to Buy <span>Affordable Custom Curtains</span></h1>
				<p>Design your custom curtains online. We do the rest.</p>
				<a href="<?php bloginfo('url'); ?>/headings" class="btn btn-white-trans">Shop Now</a>
			</div>
		</div><!-- end .banner -->
		<div class="benefits">
			<div class="container">
				<div class="title">
					<h2>Because Custom Curtains <span>Shouldn't Cost A Fortune</span></h2>
					<p>Beautiful, high-quality, custom designed curtains at a price you can afford. <br/> No strings attached.</p>
				</div>
				<div class="list">
					<div class="item clearfix">
						<div class="image fl">
							<img src="<?php echo get_template_directory_uri(); ?>/images/benefits/custom-curtains.jpg" alt="Custom Curtains" title="Custom Curtains" width="650" height="500" />
						</div>
						<div class="description fr">
							<h3>Specifically For You</h3>
							<p>We don't provide "one size fits all" curtains. We only sell custom curtains designed specifically to fit your home and lifestyle.</p>
						</div>
					</div>
					<div class="item clearfix">
						<div class="image fr">
							<img src="<?php echo get_template_directory_uri(); ?>/images/benefits/high-quality-curtains.jpg" alt="High Quality Curtains" title="High Quality Curtains" width="649" height="500" />
						</div>
						<div class="description fl">
							<h3>High Quality Curtains</h3>
							<p>Low cost does not mean low quality. As fashion designers, we understand the importance of quality fabrics for custom drapes. That's why we use only the best fabrics and materials, guaranteed. </p>
						</div>
					</div>
					<div class="item clearfix">
						<div class="image fl">
							<img src="<?php echo get_template_directory_uri(); ?>/images/benefits/low-cost-custom-curtains.jpg" alt="Low Cost Custom Curtains" title="Low Cost Custom Curtains" width="649" height="500" />
						</div>
						<div class="description fr">
							<h3>Low Cost Curtains</h3>
							<p>Our custom curtain prices are significantly lower than those of other similar providers - sometimes more than 50% less - without sacrificing quality.</p>
						</div>
					</div>
					<div class="item clearfix">
						<div class="image fr">
							<img src="<?php echo get_template_directory_uri(); ?>/images/benefits/benefits-1.jpg" alt="Family Owned & Operated" title="Family Owned & Operated" width="649" height="500" />
						</div>
						<div class="description fl">
							<h3>Family Owned & Operated</h3>
							<p>Emma Custom was <a href="<?php bloginfo('url'); ?>/about-us/">founded</a> by fashion designer Emma and her husband, David, after becoming frustrated with the process of finding affordable, high quality custom curtains for their home in Philadelphia, PA.</p>
						</div>
					</div>
				</div>
			</div>
		</div><!-- end .benefits -->
		<div class="how-it-works">
			<div class="container">
				<div class="title">
					<h2>How It Works</h2>
					<p>Ordering custom curtains has never been so easy.</p>
				</div>
				<ul class="list">
					<li class="item item-1">
						<p>Choose Your <span>HEADER STYLE</span></p>
						<div class="number">1</div>
					</li>
					<li class="item item-2">
						<p>Choose Your <span>Fabric & Color</span></p>
						<div class="number">2</div>
					</li>
					<li class="item item-3">
						<p>Enter Your <span>measurements</span></p>
						<div class="number">3</div>
					</li>
					<li class="item item-4">
						<p>Choose Your <span>Options</span></p>
						<div class="number">4</div>
					</li>
				</ul>
			</div>
		</div><!-- end .how-it-works -->
		<div class="header-style">
			<div class="container">
				<div class="title">
					<p><span>Get Started</span></p>
					<h2>Browse by Header Style</h2>
				</div>
				<div class="list clearfix">
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
						<div class="item">
							<div class="image">
								<a href="<?php echo get_term_link($product_category); ?>">
								<?php 
									$thumbnail_id = get_woocommerce_term_meta( $product_category->term_id, 'thumbnail_id', true );
									
									echo wp_get_attachment_image($thumbnail_id, 'full');
								?>
								</a>
							</div>
							<h3><a href="<?php echo get_term_link($product_category); ?>"><?php echo $product_category->name; ?></a></h3>
						</div>
						<?php $i++; endforeach; ?>
					<?php endif; ?>
					
				</div>
			</div>
		</div><!-- end .header-style -->
		<div class="testimonials">
			<div class="container">
				<div class="box">
					<h2>Don't Take Our Word For It</h2>
					<?php 
					 // The Query
					$testimonials_args = array(
						'post_type' => 'testimonials',
						'posts_per_page'=> 3,
						'order'=>'ASC',
						'orderby'=>'date',
					);

					$testimonials = new WP_Query( $testimonials_args );

					// The Loop
					if ( $testimonials->have_posts() ) :
					?>
						<ul class="cycle-slideshow" 
							data-cycle-fx="scrollHorz" 
							data-cycle-slides="> li"
							data-cycle-timeout=0
							data-cycle-pager="#no-template-pager"
							data-cycle-pager-template=""
						>
							<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
							<li>
								<div class="message">
									<?php the_content(); ?>
								</div>
								<p class="author"><?php the_title(); ?></p>
							</li>
							<?php endwhile; ?>
						</ul>
					<?php endif; ?>
					<div id="no-template-pager" class="authors cycle-pager external">
						<?php 
						$testimonials_args = array(
							'post_type' => 'testimonials',
							'posts_per_page'=> 3,
							'order'=>'ASC',
							'orderby'=>'date',
						);
						$testimonials = new WP_Query( $testimonials_args );
						if ( $testimonials->have_posts() ) :
						?>
							<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
								<span><?php the_post_thumbnail(); ?></span>
							<?php endwhile; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div><!-- end .testimonials -->
		<div class="blogfeed">
			<div class="container">
				<h2>Design Tips</h2>
				<div class="list clearfix">
					<?php 
					 // The Query
					$design_tips_args = array(
						'post_type' => 'post',
						'posts_per_page'=> 3,
						'order'=>'ASC',
						'orderby'=>'date',
					);

					$design_tips = new WP_Query( $design_tips_args );

					// The Loop
					if ( $design_tips->have_posts() ) :
						while ( $design_tips->have_posts() ) : $design_tips->the_post(); 
						?>
							<div class="item">
								<?php if( has_post_thumbnail() ): ?>
								<div class="image">
									<div class="image-shine">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail('full'); ?>
										</a>
									</div>
								</div>
								<?php endif; ?>
								<p class="date"><?php echo get_the_date(); ?></p>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php the_excerpt(); ?></p>
								<a href="<?php the_permalink(); ?>" class="btn">Read more</a>
							</div>
						<?php
						endwhile;
					endif;
					?>
				</div>
			</div>
		</div><!-- end .blogfeed -->
	</div><!-- end #main-body -->
 
<?php get_footer(); ?>