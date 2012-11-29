<?php
global $tech_nav;
if ( ($tech_nav == "on") && (of_get_option( 'nav_menu', '1' ) == '1') ) {
    ?>
    <div id="menu-icon"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></div>
    <div id="navmenu" class="site-navigation <?php echo of_get_option( 'nav_type', 'square' ); ?> <?php echo of_get_option( 'nav_type', 'square' ); ?>-<?php echo of_get_option( 'nav_location', 'below' ); ?>">
            <?php
            wp_nav_menu( array( 'container' => 'div', 'container_id' => 'navwrap', 'theme_location' => 'primary', 'menu_class' => 'top-menu', 'fallback_cb' => 'tech_menu_fallback', 'walker' => new techozoic_menu_walker() ) );
            if ( of_get_option( 'search_box', '1' ) == '1' ) {
                get_search_form();
            }
            ?>
        </div><!--end navmenu-->
        <?php
}
if ( of_get_option( 'breadcrumbs', '0' ) == '1' ) {
    tech_breadcrumbs();
}