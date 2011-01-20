<?php get_header(); ?>
<?
/**
 * header.php lässt drei DIVs offen:
 * #body > .content > .col1
 **/
?>
	<div class="blog module">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<ul>
			<li <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="navigation">
					<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
					<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
				</div>
				
				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h1>
				<strong>von <?php the_author() ?> um <?php the_time(__('H\hh', 'kubrick')) ?> am <?php the_time(__('F jS, Y', 'kubrick')) ?></strong>
				<!--von Svn um 23h42 am Donnerstag, 5. März 2009-->
				<div class="entry">
					<?php the_content(__('Read the rest of this entry &raquo;', 'kubrick')); ?>
				</div>
				<? /*
				<div class="antexter">
				Es bleibt weiter spannend &hellip;
				</div>
				<h4 class="blogLink"><a href="#">weiter lesen</a></h4>
				*/ ?>
				<div class="entryFooter">
					<div><?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'kubrick') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?></div>
					<div class="postmetadata tags">
						getaggt mit: <?php the_tags(__('', 'kubrick') . ' ', ', ', '<br />'); ?>
					</div>
					<div class="postmetadata">
						abgelegt in: <?php printf(__('%s', 'kubrick'), get_the_category_list(', ')); ?>
					</div>
					<div class="blogArticleLinks">
						<?php comments_popup_link(__('Keine Kommentare &#187;', 'kubrick'), __('Ein Kommentar &#187;', 'kubrick'), __('% Kommentare &#187;', 'kubrick'), '', __('Kommentare nicht zugelassen', 'kubrick') ); ?>
					</div>
					<div><?php printf(__("Kommentare als <a href='%s'>RSS 2.0</a> feed.", "kubrick"), get_post_comments_feed_link()); ?></div>
					<div>
						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							<?php printf(__('Du kannst einen <a href="#respond">Kommentar hinterlassen</a> oder <a href="%s" rel="trackback">einen Trackback</a> von der eigenen Seite.', 'kubrick'), trackback_url(false)); ?>

						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							<?php printf(__('Kommentare sind hier nicht gestattet aber du kannst einen <a href="%s" rel="trackback">Trackback</a> von der eigenen Seite aus hinterlassen.', 'kubrick'), trackback_url(false)); ?>

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.', 'kubrick'); ?>

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							<?php _e('Both comments and pings are currently closed.', 'kubrick'); ?>

						<?php } edit_post_link(__('Edit this entry', 'kubrick'),'','.'); ?>
					</div>
				</div>
			</li>
			<li><?php comments_template(); ?></li>
		</ul>

	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no posts matched your criteria.', 'kubrick'); ?></p>

<?php endif; ?>
				</div><!-- .blog.module -->
			<!-- .col1 -->
			<?
			/**
			 * an dieser Stelle sind noch zwei DIVs offen:
			 * #body > .content
			 **/
			?>
<?php get_sidebar(); ?>
		<?
		/**
		 * Jetzt ist nur noch ein DIV offen:
		 * #body
		 **/
		?>
<?php get_footer(); ?>

