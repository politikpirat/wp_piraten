<?php if ( is_active_sidebar(1) ) : ?>
        <div class="sidebar">
                <?php if ( !dynamic_sidebar(1) ) : ?>
                <?php endif; ?>
        </div><!--// left -->
<?php endif; ?>

<?php if ( is_active_sidebar(2) ) : ?>
        <div class="sidebar">
                <?php if ( !dynamic_sidebar(2) ) : ?>
                <?php endif; ?>
        </div><!--// right -->
<?php endif; ?>

