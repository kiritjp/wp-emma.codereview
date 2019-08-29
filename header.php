<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>


<a href="#" class="mobile-menu-toggle">
	<span></span>
	<span></span>
	<span></span>
	<span></span>
</a>
<nav class="mobile-menu-list clearfix">
	<?php 
		wp_nav_menu( array( 
			'menu_class' => 'clearfix',
			'theme_location' => 'mobile-menu',
		) ); 
	?>
</nav>

<div id="wrapper">
	<div id="top">
		<div class="container">
			<?php if ( has_nav_menu( 'top-menu' ) ) : ?>
			<nav class="menu">
				<?php 
					wp_nav_menu( array( 
						'menu_class' => 'clearfix',
						'theme_location' => 'top-menu',
					) ); 
				?>
			</nav><!-- end .menu -->
			<?php endif; ?>
		</div>
	</div><!-- end #top -->
	<header id="header">
		<div class="container clearfix">
			<h1 class="logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.jpg" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" width="308" height="75" /></a>
			</h1>
			<?php if ( has_nav_menu( 'header-menu' ) ) : ?>
			<nav class="menu">
				<?php 
					wp_nav_menu( array( 
						'menu_class' => 'clearfix',
						'theme_location' => 'header-menu',
					) ); 
				?>
			</nav><!-- end .menu -->
			<?php endif; ?>
			<p class="cart">
				<a href="<?php bloginfo('url'); ?>/cart">Cart</a>
			</p>
		</div>
	</header><!-- end #header -->
