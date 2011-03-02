<?php 
    echo '<div id="navwrap">';
    wp_nav_menu( array('container' =>'','theme_location'=>'primary','fallback_cb' =>'tech_menu_fallback'));
    echo '</div>';
?>