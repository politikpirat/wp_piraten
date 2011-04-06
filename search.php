<?php get_header(); ?>
<?
/**
 * header.php lässt drei DIVs offen:
 * #body > .content > .col1
 **/
?>

	<div class="blog module">
	<?php if (have_posts()) : ?>
		
		<h2 style="padding-left:1em;"><?php _e('Suchergebnisse'); ?></h2>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Vorherige', 'kubrick')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Neuere &raquo;', 'kubrick')) ?></div>
		</div>

		<ul>
		<?php while (have_posts()) : the_post(); ?>
			<li  <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h3>
				<small><?php the_time('l, F jS, Y') ?></small>
				<p class="postmetadata"><?php the_tags(__('Schlagworte:', 'kubrick') . ' ', ', ', '<br />'); ?> <?php printf(__('Abgelegt unter %s', 'kubrick'), get_the_category_list(', ')); ?> | <?php edit_post_link(__('Bearbeiten', 'kubrick'), '', ' | '); ?>  <?php comments_popup_link(__('Keine Kommentare &#187;', 'kubrick'), __('1 Kommentar &#187;', 'kubrick'), __('% Kommentare &#187;', 'kubrick'), '', __('Kommentare geschlossen', 'kubrick') ); ?></p>
			</li>

		<?php endwhile; ?>
		</ul>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Vorherige', 'kubrick')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Neuere &raquo;', 'kubrick')) ?></div>
		</div>

	<?php else : ?>
		<ul>
		<li>
		<h2 class="center"><?php _e('Die Suche ergab keine Treffer.', 'kubrick'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		</li></ul>
	<?php endif; ?>
	</div><!--.blog.module-->
	</div><!--#col1-->
	        <div id="col2">
                        <?php get_sidebar(1); ?>
                        <?php get_sidebar(2); ?>
        	</div>


	<?php get_footer(); ?>
        



