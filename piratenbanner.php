<?php
/**
 * Pirate SMS
 * @param mixed $args
 */
function pirateWidgetBanner($args) {
        extract($args);
        $options = get_option('widget_pirate_banner');
i?>
        <div id="sidebarbanner">
        <a href="<?php _e($options['link']); ?>"><img style="width:100%;" src="<?php _e($options['picture']); ?>"></a>
        </div>
<?php
}

function pirateWidgetBannerControl() {
        $options = $newoptions = get_option('widget_pirate_banner');

        if ( isset($_POST['BannerSubmit']) ) {
                $newoptions['title'] = strip_tags(stripslashes($_POST['BannerTitle']));
		$newoptions['picture'] = strip_tags(stripslashes($_POST['BannerImage']));
		$newoptions['link'] = strip_tags(stripslashes($_POST['BannerLink']));
        }

        if ( $options != $newoptions ) {
                $options = $newoptions;
                update_option('widget_pirate_banner', $options);
        }

        $title = attribute_escape( $options['title'] );
?>
        <p><label for="BannerTitle">
        <?php _e('Title:') ?> <input type="text" class="widefat" id="BannerTitle" name="BannerTitle" value="<?php echo $title ?>" /></label>
        </p>
<?php

 	$picture = attribute_escape( $options['picture'] );
?>
        <p><label for="BannerImage">
        <?php _e('Image url:') ?> <input type="text" class="widefat" id="BannerImage" name="BannerImage" value="<?php echo $picture ?>" /></label>
        </p>
        <input type="hidden" name="BannerSubmit" id="BannerSubmit" value="1" />
<?php

        $link = attribute_escape( $options['link'] );
?>
        <p><label for="BannerLink">
        <?php _e('link url:') ?> <input type="text" class="widefat" id="BannerLink" name="BannerLink" value="<?php echo $link ?>" /></label>
        </p>
        <input type="hidden" name="BannerSubmit" id="BannerSubmit" value="1" />
<?php
}

wp_register_sidebar_widget('piratenbanner', 'Banner', 'pirateWidgetBanner');
wp_register_widget_control('piratenbanner', 'Banner', 'pirateWidgetBannerControl' );

