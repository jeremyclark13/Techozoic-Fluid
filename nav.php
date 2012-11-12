<?php
global $tech_nav;
if ( ($tech_nav == "on") && (of_get_option( 'nav_menu', '1' ) == '1') ) {
    ?>
    <div id="navmenu" class="<?php echo of_get_option( 'nav_type', 'square' ); ?> <?php echo of_get_option( 'nav_type', 'square' ); ?>-<?php echo of_get_option( 'nav_location', 'below' ); ?>">
        <div id="navwrap">
            <?php
            wp_nav_menu( array( 'container' => '', 'theme_location' => 'primary', 'menu_class' => 'top-menu', 'fallback_cb' => 'tech_menu_fallback', 'walker' => new techozoic_menu_walker() ) );
            if ( of_get_option( 'search_box', '1' ) == '1' ) {
                get_search_form();
            }
            ?>
        </div><!--end navwrap-->
        </div><!--end navmenu-->
        <?php
}
if ( of_get_option( 'breadcrumbs', '0' ) == '1' ) {
    tech_breadcrumbs();
}