<?php header("HTTP/1.1 404 Not Found"); 
get_tech_options();
global $tech;
get_header(); 
	if(!empty($tech['header_ad_code'])) { ?>
		<div class="aligncenter">
<?php 		echo $tech['header_ad_code']; ?>
		</div>
<?php 
	}
	if ($tech['single_sidebar'] == "Yes") { 
		if ($tech['column'] == 3 && $tech['sidebar_pos'] == "Sidebar - Content - Sidebar" && $tech['single_sidebar'] == "Yes") {
			include (TEMPLATEPATH . '/l_sidebar.php'); 
		} 
	}
?>

	<div id="content" class="<?php if ($tech['single_sidebar'] == "Yes") { echo "narrow"; }else {echo "wide";}?>column">

		<h2 class="center"><?php _e('Error 404 - Not Found' ,'techozoic') ?></h2>

<h3><?php _e('Browse Archives' ,'techozoic')?></h3>
  <ul>
<?php 	wp_get_archives('type=monthly'); ?>
  </ul>
	</div>

<?php 	if ($tech['single_sidebar'] == "Yes" && $techcolumn != 1) {
		get_sidebar();
		if ($tech['column'] == 3 && $tech['sidebar_pos'] =="Content - Sidebar - Sidebar") {
			include (TEMPLATEPATH . '/l_sidebar.php'); 
		} 
	}
	get_footer(); ?>
