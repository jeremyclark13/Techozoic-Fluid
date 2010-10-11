<?php 
	if(function_exists('wp_nav_menu')){
		echo '<div id="navwrap">';
		wp_nav_menu( array('container' =>'','theme_location'=>'primary','fallback_cb' =>'tech_menu_fallback')); 
		echo '</div>';
	} else {
		include (TEMPLATEPATH . "/nav/dropdown.php");
	}
?>