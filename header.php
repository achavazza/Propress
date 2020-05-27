<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">

	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" />
	<?php } ?>
	<title>
		   <?php
			    if (function_exists('is_tag') && is_tag()) {
		        	single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      	elseif (is_archive()) {
		         	wp_title(''); echo ' - '; }
		      	elseif (is_search()) {
		         	echo __('Buscar', 'tnb'); echo ' - ';
				 	//echo sprintf(__('Búsqueda para &quot;%s&quot; - ','tnb'), wp_specialchars($s)); echo ' - ';
			  	}
		      	elseif (!(is_404()) && (is_single()) || (is_page() && !is_front_page())) {
		         	wp_title(''); echo ' - '; }
		      	elseif (is_404()) {
		         	echo __('Not Found', 'tnb'); echo ' - '; }
		      	if (is_home()) {
		         	bloginfo('name'); }
		      	else {
				  	if(get_bloginfo('description')){
		          		bloginfo('name'); echo ' - '; bloginfo('description');
			  		}else{
				  		bloginfo('name');
			  		}
			  	}
		      	if ($paged>1) {
		         	echo ' - page '. $paged; }
		   ?>
	</title>

	<link rel="shortcut icon" href="<?php echo get_bloginfo('template_url').'/favicon.ico'; ?>" type="image/x-icon" />

    <?php /*
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Muli:400,300"  type="text/css">
    <link rel="stylesheet" href="<?php echo get_bloginfo('template_url').'/css/quickstarter-min.css'; ?>"   type="text/css" />
    */ ?>


	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<div id="page-wrap">
		<div id="header">
		<div class="grid">
			<div class="head">
			<a id="logo" href="<?php echo get_option('home').'/'; ?>">
				<img class="visible-md"   src="<?php echo get_template_directory_uri().'/img/logo.png' ?>" title="<?php bloginfo('name'); ?>"     alt="<?php bloginfo('name'); ?>" />
				<img class="invisible-md" src="<?php echo get_template_directory_uri().'/img/logo-min.png' ?>" title="<?php bloginfo('name'); ?>" alt="<?php bloginfo('name'); ?>" />
			</a>
			<?php
			/*
			<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
			<div class="description"><?php bloginfo('description'); ?></div>

			$social = '';
			if(isset($facebook) && !empty($facebook)):
				$social .= '<li><a class="social-icon" href="'.$facebook.'"><i class="icon-facebook"></i></a></li>';
			endif;
			if(isset($twitter) && !empty($twitter)):
				$social .= '<li><a class="social-icon" href="'.$twitter.'"><i class="icon-twitter"></i></a></li>';
			endif;
			*/
			$mobile = '<li class="invisible-md"><a href="#" class="menu-trigger"><i class="icon cofasa-linear icon-l icon-hamburger"></i></a></li>';
			wp_nav_menu( array(
						'theme_location'  => 'header-menu',
						'container'       => false,
						'menu_class'      => 'menu',
						'fallback_cb'     => false,
						'items_wrap'      => '<div class="menu-mobile"><ul class="flush %2$s"><li><ul id="%1$s" class="flush-md visible-md">%3$s</ul>'.$mobile.'</ul></div>'
						//'items_wrap'      => '<div class="menu-mobile float-right-md"><ul class="flush %2$s"><li><ul id="%1$s" class="flush-md visible-md">%3$s</ul>'.$social.$mobile.'</ul></div>'
			));
			?>
			</div>
		</div>
		</div>
