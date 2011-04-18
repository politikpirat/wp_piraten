<?php get_header(); ?>
<?
/**
 * header.php lässt drei DIVs offen:
 * #body > .content > .col1
 **/
?>
	</div><!--.col1-->
	<div class="cat module">
	<?php if (have_posts()) : ?>
		<?php if (is_category()) : ?>		
		<ul>
		<?php $query = new WP_Query('title=single_cat_title()'); ?>
		<?php if ($query->have_posts()) : $query->the_post();  ?>
			<li  class="master" id="master">
                                 <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
                                <div class="entry">
						<?php the_content(); ?>
                                </div>

                        </li>
		<?php  endif; ?>
		<?php wp_reset_postdata(); ?>
		<?php while (have_posts()) : the_post(); ?>
			<li  <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
                                <div class="entry">
                                               <?php the_content(); ?>
                                </div>

			</li>
		<?php endwhile; ?>
		</ul>
		<?php endif; ?>
	<?php endif; ?>
	</div><!--.cat.module-->
	        <div id="col2">
                        <?php get_sidebar(1); ?>
                        <?php get_sidebar(2); ?>
        	</div>

			<?
                        /**
                         * an dieser Stelle sind noch zwei DIVs offen:
                         * #body > .content
                         **/
                        ?>

	<?php get_footer(); ?>


