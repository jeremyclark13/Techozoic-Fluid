</div><!-- #main -->
<div id="footer">
    <div id="footerdivs">
        <?php dynamic_sidebar( 'Footer' ); ?>
    </div>
    <div style="clear:both"></div>
    <p class="credit">
        <?php echo tech_footer_text(); ?>
    </p>
    <?php
    if ( has_nav_menu( 'footer' ) ) {
        wp_nav_menu( array( 'container' => '', 'theme_location' => 'footer', 'menu_class' => 'footernav aligncenter', 'after' => ' | ', 'depth' => '1' ) );
    }
    ?>

</div><!-- footer -->
</div><!-- page -->
<?php wp_footer(); ?>
</body>
</html>
