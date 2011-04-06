<? /** page.php **/ ?>
<?php get_header(); ?>
<?
/**
 * header.php lässt drei DIVs offen:
 * #body > .content > .col1
 **/
?>
<div class="blog module">
<ul><li>		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content('<p class="serif">' . __('Read the rest of this page &raquo;', 'kubrick') . '</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'kubrick') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			</div>
		</div>
		<?php endwhile; endif; ?>
</li></ul>
<?php edit_post_link(__('Edit this entry.', 'kubrick'), '<p>', '</p>'); ?>
	</div>
</div><!-- .col1 -->
               <div id="col2">
                        <?php get_sidebar(1); ?>
                        <?php get_sidebar(2); ?>
               </div>

<?php get_footer(); ?>
