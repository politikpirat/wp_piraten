<?
/**
 * An dieser Stelle noch zwei DIVs offen:
 * #body > .content
 **/
?>
			<div class="sidebar">
				<? /* Widgetized sidebar, if you have the plugin installed. */
				if (function_exists('dynamic_sidebar') ) {
					//print('<ul>');
					dynamic_sidebar(1, true);
					//print('</ul>');
				} else {
		 			?>
					<div>
						<div class="content"><?php include (TEMPLATEPATH . '/searchform.php'); ?></div>
					</div>

					<? /* Author information is disabled per default. Uncomment and fill in your details if you want to use it.
					<li><h2><?php _e('Author', 'kubrick'); ?></h2>
					<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
					</li>
					-*/ ?>

					<?
					if ( is_404() || is_category() || is_day() || is_month() || is_year() || is_search() || is_paged() ) {
						?>
						<?php /* If this is a 404 page */ 
						if (is_404()) { ?>
						<?php /* If this is a category archive */ } elseif (is_category()) { ?>
							<p><?php printf(__('You are currently browsing the archives for the %s category.', 'kubrick'), single_cat_title('', false)); ?></p>

						<?php /* If this is a yearly archive */ 
						} elseif (is_day()) { ?>
							<p><?php printf(__('You are currently browsing the <a href="%1$s/">%2$s</a> blog archives for the day %3$s.', 'kubrick'), get_bloginfo('url'), get_bloginfo('name'), get_the_time(__('l, F jS, Y', 'kubrick'))); ?></p>

						<?php /* If this is a monthly archive */ 
						} elseif (is_month()) { ?>
							<p><?php printf(__('You are currently browsing the <a href="%1$s/">%2$s</a> blog archives for %3$s.', 'kubrick'), get_bloginfo('url'), get_bloginfo('name'), get_the_time(__('F, Y', 'kubrick'))); ?></p>

						<?php /* If this is a yearly archive */ 
						} elseif (is_year()) { ?>
							<p><?php printf(__('You are currently browsing the <a href="%1$s/">%2$s</a> blog archives for the year %3$s.', 'kubrick'), get_bloginfo('url'), get_bloginfo('name'), get_the_time('Y')); ?></p>

						<?php /* If this is a monthly archive */ 
						} elseif (is_search()) { ?>
							<p><?php printf(__('You have searched the <a href="%1$s/">%2$s</a> blog archives for <strong>&#8216;%3$s&#8217;</strong>. If you are unable to find anything in these search results, you can try one of these links.', 'kubrick'), get_bloginfo('url'), get_bloginfo('name'), wp_specialchars(get_search_query(), true)); ?></p>

						<?php /* If this is a monthly archive */ 
						} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
							<p><?php printf(__('You are currently browsing the <a href="%1$s/">%2$s</a> blog archives.', 'kubrick'), get_bloginfo('url'), get_bloginfo('name')); ?></p>

						<?php 
						} ?>
					<?
					}
					?>
					<div id="boxVote" class="box info">
						<h2>Piraten in den Bundestag</h2>
						<div class="content">
							<a href="http://www.ich.waehlepiraten.de">Mit Deiner Unterschrift in den Bundestag!</a>
							<div class="box boxBarometer">
								<div class="progressbar"><div class="progress" style="width:25%"></div></div>
								Stand: <span class="boxBarometerCurrent">600</span> von
								<span class="boxBarometerTarget">2400</span>. Noch <strong>42</strong> Tage!
							</div>
						</div>
						<script type="text/javascript" charset="utf-8">
							var progressEl = document.getElementsByClassName('progress')[0];
							var currentWidth = progressEl.style.width;
							progressEl.style.width = 0;
							console.log('currentWidth', currentWidth);
							 window.setTimeout(function() {
									progressEl.style.width = currentWidth;
							}, 600);

						</script>
					</div>

					<? /* <div class="box info" id="boxBecomePirateSms">
						<a href="#"><strong>Werde SMS Pirat!</strong><span>Sende <q>PIRAT</q> an 11825</span></a>
					</div>
					*/ ?>

					<div class="box">
						<h2>Seiten</h2>
						<div class="content">
							<ul>
								<?php wp_list_pages('title_li=' ); ?>
							</ul>
						</div>
					</div>
		
					<div class="box">
						<h2>Archiv</h2>
						<div class="content">
						<ul>
						<?php wp_get_archives('type=monthly'); ?>
						</ul>
						</div>
					</div>

					<div class="box">
						<h2>Kategorien</h2>
						<div class="content"><ul><?php wp_list_categories('show_count=1&title_li='); ?></ul></div>
					</div>

					<div class="box boxPirateCommunities" id="">
						<h2>Piraten Überall</h2>
						<div class="content linklist">
							<table id="linkTable"><tr><td>
								<div id="twitterLink"><a href="http://twitter.com/piratenberlin">Twitter</a></div>
								<div id="thepiratebayLink"><a href="#">The Pirate Bay</a></div>
								<div id="myspaceLink"><a href="http://www.myspace.com/piratenparteiberlin">MySpace</a></div>
								<div id="youtubeLink"><a href="#">YouTube</a></div>
								<div id="flickrLink"><a href="http://www.flickr.com/search/?q=piratenpartei&amp;w=all">Flickr</a></div>
								<div id="diggLink"><a href="http://digg.com/search?s=piratenpartei">Digg</a></div>
							</td><td>
								<div id="facebookLink"><a href="http://facebook.com/piratenpartei">Facebook</a></div>
								<div id="meinvzLink">MeinVZ</div>
								<div id="schuelervzLink">SchülerVZ</div>
								<div id="studivzLink">StudiVZ</div>
								<div id="werkenntwenLink">Wer kennt wen</div>
								<? /* <div id="Link"><a href="#"></a></div>
								<div id="eventfulLink"><a href="#">Eventful</a></div>
								<div id="linkedInLink"><a href="#">LinkedIn</a></div>
								<div id="Link"><a href="#">BlackPlanet</a></div>
								<div id="Link"><a href="#">Faithbase</a></div>
								<div id="Link"><a href="#">Eons</a></div>
								<div id="Link"><a href="#">Glee</a></div>
								<div id="Link"><a href="#">MiGente</a></div>
								<div id="Link"><a href="#">MyBatanga</a></div>
								<div id="Link"><a href="#">DNC Partybuilder</a></div> */ ?>
								<div id="gayromeoLink"><a href="http://www.gayromeo.com/PIRATEN">GayRomeo</a></div>
							</td></tr></table>
						</div>
					</div>

					<? /* If this is the frontpage */
					if ( is_home() || is_page() ) { ?>
						<div class="box">
							<?php wp_list_bookmarks(); ?>
						</div>

						<div class="box">
							<h2><?php _e('Meta', 'kubrick'); ?></h2>
							<div class="content">
								<ul>
									<?php wp_register(); ?>
									<li><?php wp_loginout(); ?></li>
									<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional', 'kubrick'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>', 'kubrick'); ?></a></li>
									<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network', 'kubrick'); ?>"><?php _e('XFN', 'kubrick'); ?></abbr></a></li>
									<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.', 'kubrick'); ?>">WordPress</a></li>
									<?php wp_meta(); ?>
								</ul>
							</div>
						</div>
					<? } // is_home ?>
				<?php } // !function_exists('dynamic_sidebar') ?>
			</div><!-- .sidebar -->