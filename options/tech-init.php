<?php
global $themename, $options, $version;
$themename = "Techozoic";
$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
$version = $theme_data['Version'];
$header_folder = WP_CONTENT_DIR. "/techozoic/images/headers";
$background_folder = WP_CONTENT_DIR. "/techozoic/images/backgrounds";
if (!file_exists($header_folder)){
	mkdir($header_folder,0775, true);
}
if (!file_exists($background_folder)){
	mkdir($background_folder,0775, true);
}
function tech_move_images($type){
	$path = TEMPLATEPATH ."/images/".$type."/";
	$dir_handle = @opendir($path) or die("Unable to open $path");
		while ($tech_file = readdir($dir_handle)) {
			if($tech_file == "." || $tech_file == ".." || $tech_file == "index.php" )
				continue;
				$orig_file = TEMPLATEPATH ."/images/".$type."/".$tech_file;
				$dest_file = WP_CONTENT_DIR. "/techozoic/images/".$type."/".$tech_file;
				if (!file_exists($dest_file)){
					copy($orig_file,$dest_file);
				}
		} //End While Loop
	closedir($dir_handle);
}		
tech_move_images('headers');
tech_move_images('backgrounds');
copy(TEMPLATEPATH.'/rotate.php', WP_CONTENT_DIR.'/techozoic/rotate.php');
include (TEMPLATEPATH . "/options/option-array.php");
		if ($old_options = get_option('techozoic_options')) {
			foreach ($options as $value) {
				$old_options = get_option('techozoic_options');
				$k = $value['id'];
				$s = $value['std'];
				$old = $value['old_id'];
				$v = $s;
				if (isset($old_options[$old])){
					$v = $old_options[$old];
				} elseif (isset($old_options[$k])){
					$v = $old_options[$k];
				}
				$new_options[$k] = $v;		
			}
			$new_options['test'] = "set";
			$new_options['ver'] = $version;
			update_option('techozoic_options', $new_options);
		} else {	
			foreach ($options as $value) {
				$k = $value['id'];
				$v = $value['std'];
				$old = $value['old_id'];
				if( $existing = get_option($old)){
					$new_options[$k] = $existing;
					delete_option($old);
				} else {
					$new_options[$k] = $v;
					delete_option($old);
				}
			}
			$new_options['test'] = "set";
			$new_options['ver'] = $version;
			add_option( 'techozoic_options', $new_options );
		}
?>
