<?php 
/**
 * File used to output html and functions for migrating options from previous
 * option panel into options framework.
 */
function tech_export(){
	$settings = get_option('techozoic_options');
	$file_out = serialize($settings);
	header("Cache-Control: public, must-revalidate");
	header("Pragma: hack"); 
	header("Content-type: text/plain; charset=ISO-8859-1");
	header('Content-Disposition: attachment; filename="techozoic-options-'.date("Ymd").'.dat"');
	echo $file_out;
	exit;
}
?>
<div class="wrap">
    
</div>    
<?php ?>