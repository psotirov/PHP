<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <section id="main"> / <div id="main">
 *
 * @package ProjectOne
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php bloginfo('name'); ?><?php wp_title('-'); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class($class); ?>>
<div id="wrapper"><!-- #wrapper -->
	<header><!-- header -->
		<h1><a href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<h2><?php bloginfo( 'description' ); ?></h2>
		<?php if ( !is_page() ) : ?>
		<img src="<?php echo get_template_directory_uri(); ?>/images/headerimg.jpg" alt="Header Image"><!-- header image -->
		<?php endif; ?>
	</header><!-- end of header -->
	
	<nav><!-- top nav -->
		<div class="menu">
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
				<?php wp_list_pages(array(
									'depth'    => 2,
									'title_li' => ''
									)); ?>
				<!--li><a href="#">This is long navigation 1</a></li>
				<li><a href="#">Navigation 2</a></li>
				<li><a href="#">Navigation 3</a></li>
				<li><a href="#">Navigation 4</a></li>
				<li><a href="#">Navigation 5</a></li>
				<li><a href="#">Navigation 6</a></li>
				<li><a href="#">Navigation 7</a></li>
				<li><a href="#">Navigation 8</a></li>
				<li><a href="#">Navigation 9</a></li>
				<li><a href="#">Navigation 10</a></li>
				<li><a href="#">Navigation 11</a></li>
				<li><a href="#">Navigation 12</a></li>
				<li><a href="#">Navigation 13</a></li>
				<li><a href="#">Navigation 14</a></li>
				<li><a href="#">Navigation 15</a></li-->
			</ul>
		</div>
	</nav><!-- end of top nav -->
