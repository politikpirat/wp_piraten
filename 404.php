<?php get_header(); ?>

	<div class="blog module">

		<div id="error">
			<h2><?php _e('Error 404 - Die Seite existiert leider nicht.', 'kubrick'); ?></h2>
			<p> 
				Die abgefragte Seite ist leider nicht mehr oder noch nicht online. Das ist kein Problem und sicher unser Fehler. Wenn du unsere Seiten weiter durchstöbern möchest, kannst du einfach unter <a href="<?php echo get_option('home'); ?>/">unserer Startseite</a> weitermachen.
			</p>
			<p> Viel Spass!</a>
		</div> <!--404-->
	</div> <!-- blog module -->
	</div> <!-- col1 -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
