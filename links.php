<?php
/*
Template Name: Links
*/
?>

<?php get_header(); ?>

<div " id="content" class="widecolumn">

<h2><?php _e('Links:', 'kubrick'); ?></h2>

<ul style="align:right;">
<?php wp_list_bookmarks(); ?> 
</div>
</ul>


</div>

<?php get_footer(); ?>
