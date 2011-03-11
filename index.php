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
						<?php while (have_posts()) : the_post(); ?>
							<li <?php post_class(); ?> id="post-<?php the_ID(); ?>">
								<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h3>
								<div class="entry">
									<?php the_content(__('Read the rest of this entry &raquo;', 'kubrick')); ?>
								</div>
								<? /*
								<div class="antexter">
								Es bleibt weiter spannend &hellip;
								</div>
								<h4 class="blogLink"><a href="#">weiter lesen</a></h4>
								*/ ?>
							</li>
						<?php endwhile; ?>
							<li class="navigation">
								<h4 class="blogLink"><?php next_posts_link(__('&laquo; ALT', 'kubrick')) ?></h4>
							</li>
							<li class="navigation">
								<h4 class="blogLink"><?php previous_posts_link(__('NEU&raquo;', 'kubrick')) ?></h4>
							</li>
						</ul>
					<?php else : ?>

						<h2 class="center"><?php _e('Not Found', 'kubrick'); ?></h2>
						<p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.', 'kubrick'); ?></p>
						<?php include (TEMPLATEPATH . "/searchform.php"); ?>

					<?php endif; ?>
				</div><!-- .blog.module -->
			</div><!-- .col1 -->
			<?
			/**
			 * an dieser Stelle sind noch zwei DIVs offen:
			 * #body > .content
			 **/
			?>
		<div id="col2">
			<?php get_sidebar(1); ?>
			<?php get_sidebar(2); ?>
		</div>
		<?
		/**
		 * Jetzt ist nur noch ein DIV offen:
		 * #body
		 **/
		?>
<?php get_footer(); ?>
