<?php
/**
 * @package WordPress
 * @subpackage Piraten_Theme
 */

print('<?xml version="1.0" encoding="UTF-8"?>');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= get_bloginfo('language') ?>">
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<style type="text/css" media="screen"> @import url("<?php bloginfo('stylesheet_url'); ?>"); </style>
	<link rel="alternate" type="application/rss+xml" title="<?php printf(__('%s RSS Feed', 'kubrick'), get_bloginfo('name')); ?>" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php printf(__('%s Atom Feed', 'kubrick'), get_bloginfo('name')); ?>" href="<?php bloginfo('atom_url'); ?>" /> 
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?  if ( 0 and is_home() ) { ?>
*	<script type="text/javascript" src="/wp-content/themes/piraten/vdl/vdl.js"></script>
	<script type="text/javascript"><!--
		VDL.hardcore = false;	// Hundebabys!!!
		VDL.pos.pic.x = -26;	// Abstand in Pixel vom linken Fensterrand
		VDL.pos.pic.y = -26;	// Abstand in Pixel vom oberen Fensterrand
	-->
	</script>
	<? } ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?> 
	<?php wp_head(); ?>
</head>
<body class="home">
	<div id="body">
		<h1><div id="logoCrop"><a href="<?php echo get_option('home'); ?>/"><img src="<?= piratenImageUri() ?>/piratenturm_v2.png" alt="Piratenpartei Berlin" height="230" width="106" id="logo" /></a></div></h1>
		
			<div id="headerBox">
			<!--div id="headerSideBox"></div><div id="headerMainBox">--><a href="<?php echo get_option('home'); ?>/mitglied-werden"><span id="werdePirat">&nbsp;</span></a><!--</div-->
			<!--<div class="menu">-->

			<div><?php wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => 'primary' ) ); ?></div>

				<? /* Widgetized sidebar, if you have the plugin installed. */
				if (function_exists('dynamic_sidebar') ) {
					dynamic_sidebar(2, false);
				} else {
					wp_widget_pages(array( 'classname' => '', 
									'description' => '', 
									'before_widget' => '',
									'before_title' => '',
									'after_title' => '',
									'after_widget' => ''
				));
				}
				?>
			<!--</div>-->
		</div>
		<div style="clear:both"></div>

		<div id="content">
			<div id="col1">
				<!--<div id="pageHeader">
					<h2>
						<a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a>
						div class="description"><?php bloginfo('description'); ?></div>
					</h2>
				</div>-->	
				<?
				/**
				 * header.php lässt drei DIVs offen:
				 * #body > .content > .col1
				 **/
				?>
