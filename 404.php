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
	if ($tech['single_sidebar'] == "Yes")  tech_show_sidebar("l");
?>

	<div id="content" class="<?php if ($tech['single_sidebar'] == "Yes") { echo "narrow"; }else {echo "wide";}?>column">

		<h2 class="aligncenter"><?php _e('Error 404 - Not Found' ,'techozoic') ?></h2>

<h3><?php _e('Browse Archives' ,'techozoic')?></h3>
  <ul>
<?php 	wp_get_archives('type=monthly'); ?>
  </ul>
	</div>

<?php 	if ($tech['single_sidebar'] == "Yes")  tech_show_sidebar("r");
	get_footer(); ?>
