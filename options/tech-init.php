<?php
/*************************************************
Tech Init script creates upload folder and moves images.
Pulls options from existing Techozoic options table and adds defaults for new options .
*************************************************/
function tech_create_folders(){
	$tech_folders = array (
		TEMPLATEPATH . "/uploads",
		TEMPLATEPATH . "/uploads/images",
		TEMPLATEPATH . "/uploads/images/headers",
		TEMPLATEPATH . "/uploads/images/backgrounds"
		);
		
	function tech_loop_mkdir($dir_array){
		foreach ($dir_array as $dir) {
			if (!file_exists($dir)){
				mkdir($dir, 0775);
				chmod($dir, 0775);
			}
		}
		return true;
	}

	tech_loop_mkdir($tech_folders);

	function tech_move_images($type){
		$path = TEMPLATEPATH ."/images/".$type."/";
		$dir_handle = @opendir($path) or die("Unable to open $path");
			while ($tech_file = readdir($dir_handle)) {
				if($tech_file == "." || $tech_file == ".." || $tech_file == "index.php" || $tech_file == ".svn" )
					continue;
					$orig_file = TEMPLATEPATH ."/images/".$type."/".$tech_file;
					$dest_file = TEMPLATEPATH . "/uploads/images/".$type."/".$tech_file;
					if (!file_exists($dest_file)){
						copy($orig_file,$dest_file);
					}
			} //End While Loop
		closedir($dir_handle);
	}		
	tech_move_images('headers');
	tech_move_images('backgrounds');
	copy(TEMPLATEPATH.'/rotate.php', TEMPLATEPATH . '/uploads/rotate.php');
}
function tech_update_options(){
	global $themename, $options, $version;
	$themename = "Techozoic";
	$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
	$version = $theme_data['Version'];
	include (TEMPLATEPATH . "/options/option-array.php");
		if ($old_options = get_option('techozoic_options')) {
			foreach ($options as $value) {
				$old_options = get_option('techozoic_options');
				$k = "";
				$s = "";
				$old = "";
				if (isset($value['id'])) $k = $value['id'];
				if (isset($value['std'])) $s = $value['std'];
				if (isset($value['old_id'])) $old = $value['old_id'];
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
				$k = "";
				$v = "";
				$old = "";
				if (isset($value['id'])) $k = $value['id'];
				if (isset($value['std'])) $v = $value['std'];
				if (isset($value['old_id'])) $old = $value['old_id'];
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
	include(TEMPLATEPATH .'/options/css-build.php');
}
	
function tech_temp_options(){
	global $themename, $options, $version;
	$themename = "Techozoic";
	$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
	$version = $theme_data['Version'];
	include (TEMPLATEPATH . "/options/option-array.php");
		if ($old_options = get_option('techozoic_options')) {
			foreach ($options as $value) {
				$old_options = get_option('techozoic_options');
				$k = "";
				$s = "";
				$old = "";
				if (isset($value['id'])) $k = $value['id'];
				if (isset($value['std'])) $s = $value['std'];
				if (isset($value['old_id'])) $old = $value['old_id'];
				$v = $s;
				if (isset($old_options[$old])){
					$v = $old_options[$old];
				} elseif (isset($old_options[$k])){
					$v = $old_options[$k];
				}
				$tech[$k] = $v;		
			}
			$tech['test'] = "set";
			$tech['ver'] = $version;
		} else {	
			foreach ($options as $value) {
				$k = "";
				$v = "";
				$old = "";
				if (isset($value['id'])) $k = $value['id'];
				if (isset($value['std'])) $v = $value['std'];
				if (isset($value['old_id'])) $old = $value['old_id'];
				if( $existing = get_option($old)){
					$tech[$k] = $existing;
					delete_option($old);
				} else {
					$tech[$k] = $v;
					delete_option($old);
				}
			}
			$tech['test'] = "set";
			$tech['ver'] = $version;
		}
	return $tech;
}
?>