<!DOCTYPE HTML>
<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]--> 
<!--[if lt IE 7 ]><html class="no-js ie6" lang="en"><![endif]--> 
<!--[if IE 7 ]><html class="no-js ie7" lang="en"><![endif]--> 
<!--[if IE 8 ]><html class="no-js ie8" lang="en"><![endif]--> 
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" lang="en"><!--<![endif]-->
	<head>
		<title><?php bloginfo( 'name' ); ?><?php wp_title( '|' ); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
	  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Remove if you're not building a responsive site. (But then why would you do such a thing?) -->
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/js/shadowbox/shadowbox.css">
		
		<!--Links to custom fonts--> 
		<script type="text/javascript" src="//use.typekit.net/cmq4qzh.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
		
		
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.ico"/>
		
		<?php wp_enqueue_script("jquery"); ?>

		<?php wp_head(); ?>
		
		<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/jquery-1.8.2-min.js"></script>
		<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/jquery.cycle.all.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/jquery.easing.1.3.js"></script>
		
		<!--js for loading div-->
		<script type="text/javascript">
		jQuery(document).ready(function( $ ) {
		jQuery(window).load(function(){
			jQuery("#loading").fadeOut(1000, function () {
				jQuery(this).remove()
			});
		})
		});
		</script><!--END js for loading div-->
		
	</head>
	
	<body <?php body_class(); ?>>
		
		
		
		
