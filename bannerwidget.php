<?php
/**
 * BannerWidget Class
 */
class BannerWidget extends WP_Widget {
    /** constructor */
    function BannerWidget() {
        parent::WP_Widget(false, $name = 'BannerWidget');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        ?>
              <?php echo '<div id="sidebarbanner">'; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
   			<a href="<?php _e($instance['link']); ?>"><img style="width:100%;" src="<?php _e($instance['picture']); ?>"></a> 
                  <?php echo '</div>'; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['picture'] = strip_tags($new_instance['picture']);
        $instance['link'] = strip_tags($new_instance['link']);
	return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php
        $picture = attribute_escape( $instance['picture'] );
?>
        <p><label for="<?php echo $this->get_field_id('picture'); ?>">
        <?php _e('Image url:') ?> <input class="widefat" id="<?php echo $this->get_field_id('picture'); ?>" name="<?php echo $this->get_field_name('picture'); ?>" type="text" value="<?php echo $picture ?>" /></label>
        </p>
<?php   

	$link = attribute_escape( $instance['link'] );
?>
        <p><label for="<?php echo $this->get_field_id('link'); ?>">
        <?php _e('Link url:') ?> <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link ?>" /></label>
        </p>
<?php
}

} // class BannerWidget

// register BannerWidget widget
add_action('widgets_init', create_function('', 'return register_widget("BannerWidget");'));

