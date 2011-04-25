<?php
if ( function_exists('register_sidebar') ) {
    register_sidebar(array(1,
	'name'          => __('Sidebar') . ' 1',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(2,
	'name'          => __('Sidebar') . ' 2',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
}


// This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
                'primary' => __( 'Primary Navigation', 'piraten' ),
        	'secondary' => __( 'Secondary Navigation', 'piraten' ),
	) );
/**

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function piraten_page_menu_args( $args ) {
        $args['container'] = false;
	//$args['show_home'] = true;
        return $args;
}
add_filter( 'wp_page_menu_args', 'piraten_page_menu_args' );


include 'pirateWidgets.php';
include 'bannerwidget.php';

load_theme_textdomain('piraten');
?>
