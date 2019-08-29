	<?php if(!is_front_page()): ?>
	<div id="sub-footer">
		<div class="container">
			<div class="box">
				<h2>CUSTOM CURTAINS <span>SHOULDN'T COST A FORTUNE</span></h2>
				<p>Beautiful, high-quality, custom designed curtains at a price you can afford. <br/> No strings attached.</p>
				<a href="<?php bloginfo('url'); ?>/choose-your-curtain-header-style" class="btn btn-white-trans">Shop Now</a>
			</div>
		</div>
	</div><!-- end #sub-footer -->
	<?php endif; ?>

	<footer id="footer">
		<div class="container clearfix">
			<div class="logo">
				<img src="<?php echo get_template_directory_uri(); ?>/images/logo-footer.png" alt="Emma Custom" title="Emma Custom" width="160" height="160" />
			</div>
			<div class="links">
				<div class="item">
					<?php if ( has_nav_menu( 'footer-menu-1' ) ) : ?>
					<nav class="menu">
						<?php 
							wp_nav_menu( array( 
								'menu_class' => 'clearfix',
								'theme_location' => 'footer-menu-1',
							) ); 
						?>
					</nav><!-- end .menu -->
					<?php endif; ?>
				</div>
				<div class="item">
					<?php if ( has_nav_menu( 'footer-menu-2' ) ) : ?>
					<nav class="menu">
						<?php 
							wp_nav_menu( array( 
								'menu_class' => 'clearfix',
								'theme_location' => 'footer-menu-2',
							) ); 
						?>
					</nav><!-- end .menu -->
					<?php endif; ?>
				</div>
			</div>
			<div class="socials">
				<h4>Find us on social</h4>
				<ul>
					<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/icon-facebook.jpg" alt="Facebook" title="Facebook" width="52" height="52" /></a></li>
					<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/icon-instagram.jpg" alt="Instagram" title="Instagram" width="52" height="52" /></a></li>
					<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/icon-twitter.jpg" alt="Twitter" title="Twitter" width="52" height="52" /></a></li>
					<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/icon-pinterest.jpg" alt="Pinterest" title="Pinterest" width="52" height="52" /></a></li>
				</ul>
			</div>
		</div>
	</footer><!-- end #footer -->
	<div id="bottom">
		<div class="container">
			<p>Emma Custom &copy; 2018. All Rights Reserved. <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.</p>
		</div>
	</div><!-- end #bottom -->
</div><!-- end #wrapper -->
<?php wp_footer(); ?>

</body>
</html>