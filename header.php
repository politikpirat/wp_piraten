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
	<div id="background"></div>
	<div id="body">
			<div id="headerBox">
				<div id="sitetitle"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></div>
				<div id="sitedescription"><?php bloginfo('description'); ?></div>
				<span id="werdePirat">&nbsp;</span>
			<?php wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => 'primary' ) ); ?>

		</div>
		<div style="clear:both"></div>
		<div id="content">
			<div id="col1">
				<?
				/**
				 * header.php lässt drei DIVs offen:
				 * #body > .content > .col1
				 **/
				?>
