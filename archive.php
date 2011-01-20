<?php get_header(); ?>
<?
/**
 * header.php lässt drei DIVs offen:
 * #body > .content > .col1
 **/
?>
	<div class="blog module">

		<?php if (have_posts()) : ?>

			<ul>
<li>
 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle"><?php printf(__('Archive for the &#8216;%s&#8217; Category', 'kubrick'), single_cat_title('', false)); ?></h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="pagetitle"><?php printf(__('Posts Tagged &#8216;%s&#8217;', 'kubrick'), single_tag_title('', false) ); ?></h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Daily archive page', 'kubrick'), get_the_time(__('F jS, Y', 'kubrick'))); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Monthly archive page', 'kubrick'), get_the_time(__('F, Y', 'kubrick'))); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Yearly archive page', 'kubrick'), get_the_time(__('Y', 'kubrick'))); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php _e('Author Archive', 'kubrick'); ?></h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><?php _e('Blog Archives', 'kubrick'); ?></h2>
 	  <?php } ?>
</li>

<li>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries', 'kubrick')); ?></div>
			<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;', 'kubrick')); ?></div>
		</div>
		</li>
			<?php while (have_posts()) : the_post(); ?>
				<li <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h3>
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
						<div class="postmetadata tags">
							getaggt mit: <?php the_tags(__('Tags:', 'kubrick') . ' ', ', ', '<br />'); ?>
						</div>
						<div class="postmetadata">
							abgelegt in: <?php printf(__('Posted in %s', 'kubrick'), get_the_category_list(', ')); ?>
						</div>
						<div class="blogArticleLinks">
							<?php edit_post_link(__('Edit', 'kubrick'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments &#187;', 'kubrick'), __('1 Comment &#187;', 'kubrick'), __('% Comments &#187;', 'kubrick'), '', __('Comments Closed', 'kubrick') ); ?>
						</div>
					</div>
				</li>
			<?php endwhile; ?>
				<li class="navigation">
					<h4 class="blogLink"><?php next_posts_link(__('&laquo; Older Entries', 'kubrick')) ?></h4>
				</li>
				<li class="navigation">
					<h4 class="blogLink"><?php previous_posts_link(__('Newer Entries &raquo;', 'kubrick')) ?></h4>
				</li>
			</ul>
	<?php else :
		if ( is_category() ) { // If this is a category archive
			printf("<h2 class='center'>".__("Sorry, but there aren't any posts in the %s category yet.", 'kubrick').'</h2>', single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo('<h2>'.__("Sorry, but there aren't any posts with this date.", 'kubrick').'</h2>');
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2 class='center'>".__("Sorry, but there aren't any posts by %s yet.", 'kubrick')."</h2>", $userdata->display_name);
		} else {
			echo("<h2 class='center'>".__('No posts found.', 'kubrick').'</h2>');
		}
	  get_search_form();
	endif;
?>
				</div><!-- .blog.module -->
			</div><!-- .col1 -->
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
