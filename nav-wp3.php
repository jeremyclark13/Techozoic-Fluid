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
        </div>
        <?php
        if ( $tech_nav == "on" ) {
            if ( of_get_option( 'dashboard_link', '1' ) == "1" ) {
                if ( is_user_logged_in() ) {
                    ?>
                    <ul id="admin"><li><a href="<?php echo site_url(); ?>/wp-admin" title="<?php _e( 'Dashboard', 'techozoic' ) ?>"><?php _e( 'Dashboard', 'techozoic' ) ?></a></li>
                        <li><a href="<?php echo wp_logout_url(); ?>" title="<?php _e( 'Log Out', 'techozoic' ) ?>"><?php _e( 'Log Out', 'techozoic' ) ?></a></li></ul>
                <?php } else {
                    ?>
                    <ul id="admin"><li>
                            <?php if ( of_get_option( 'thickbox', '0' ) == '1' ) {
                                ?>
                                <a href="#TB_inline?height=120&amp;width=120&amp;inlineId=loginthick" class="thickbox" title="Login"><?php _e( 'Login', 'techozoic' ) ?></a>
                            <?php } else {
                                ?>			<a href="<?php echo wp_login_url(); ?>" title="<?php _e( 'Login', 'techozoic' ) ?>"><?php _e( 'Login', 'techozoic' ) ?></a>
                            <?php }
                            ?>
                        </li></ul>
                    <div id="loginthick" style="display:none">
                        <div class="aligncenter">
                            <form action="<?php echo site_url(); ?>/wp-login.php" method="post" id="loginform">
                                <label><?php _e( 'Username: ', 'techozoic' ) ?><br /><input type="text" id="user_login" class="text" name="log"/></label><br />
                                <label><?php _e( 'Password: ', 'techozoic' ) ?><br /><input type="password" id="user_pass" class="text" name="pwd"/></label><br />
                                <input type="submit" id="wp-submit" value="<?php _e( 'Log in', 'techozoic' ) ?>" />
                                <input type="hidden" name="redirect_to" value="<?php echo "http://" . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI']; ?>" />
                                <input type="hidden" name="testcookie" value="1" />
                            </form>
                        </div><!--end aligncenter-->
                    </div><!--end loginthick-->
                    <?php
                }
            }
            ?>
        </div><!--end navmenu-->
        <?php
    }
}
if ( of_get_option( 'breadcrumbs', '0' ) == '1' ) {
    tech_breadcrumbs();
}