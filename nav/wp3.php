<?php 
	if(function_exists('wp_nav_menu')){
		echo '<div id="navwrap">';
		wp_nav_menu( array('container' =>'','theme_location'=>'primary')); 
		echo '</div>';
	} else {
		include (TEMPLATEPATH . "/nav/dropdown.php");
	}
?>