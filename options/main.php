<?php
//Please Do NOT edit this page.
$themename = "Techozoic";
$shortname = "tech";
$tech_error = array ( __("Return Error","techozoic"), __("File Already Exists","techozoic"), __("Incorrect File Type / File Size Limit exceeded","techozoic"),sprintf(__("Folder isn't writable please check folder that upload path exists and is writable." ,"techozoic")), __("File Doesn't exist.","techozoic"), sprintf(__("Folder isn't writable please check folder image upload folder Permissions.","techozoic")),__("Please only use .ico format for Fav Icon Images","techozoic"));
$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
$version = $theme_data['Version'];
function techozoic_add_admin() {
	global $themename, $shortname, $options, $version, $wp_version;
	$tabs = array( 'general' => 'General', 'header' => 'Header', 'style' =>'Style', 'export' =>'Import/Export', 'delete'=>'Delete' );
	if (isset($_GET['tab'])){
		$current_title = $tabs[ $_GET['tab'] ];
	} else {
		$current_title = 'General';
	}
	$settings = get_option('techozoic_options');
	if ( isset($_GET['tab']) && $_GET['tab'] == "export"  && tech_can_edit() ) {
		if ( isset($_POST['action']) && $_POST['action'] == 'export' && check_admin_referer('techozoic_form_export','techozioc_nonce_field_export') ) {
			tech_export();
		}
		if (isset($_FILES['settings']) && check_admin_referer('techozoic_form_import','techozioc_nonce_field_import') && tech_can_edit() ){
			if ($_FILES["settings"]["error"] > 0){
				echo "Error: " . $_FILES["settings"]["error"] . "<br />";
			  } else{
				$rawdata = file_get_contents($_FILES["settings"]["tmp_name"]);
				$tech_options = unserialize($rawdata);
				update_option('techozoic_options', $tech_options);
				header("Location: themes.php?page=techozoic&tab=export&import=true");
			  }
		}
	}
	if ( isset($_GET['tab']) && $_GET['tab'] == "delete" ) {
		if( isset($_POST['action']) && 'delete-settings' == $_REQUEST['action'] && check_admin_referer('techozoic_form_delete','techozioc_nonce_field_delete')  && tech_can_edit() ) {
			delete_option('techozoic_options');
			delete_option('techozoic_activation_check');
			delete_option('tech_styles');
			update_option('template', 'default');
			update_option('stylesheet', 'default');
			delete_option('current_theme');
			do_action('switch_theme', 'default');
			header("Location: themes.php");
			die;
		}
	}
	if ( isset($_GET['tab']) &&$_GET['tab'] == "header" ) {
		if (isset($_FILES['file']) && check_admin_referer('techozoic_form_upload','techozioc_nonce_field_upload')  && tech_can_edit() ){
			if ($settings['image_location'] == 'theme'){
				$dir = TEMPLATEPATH. "/uploads/images/headers/";
			} else {
				$dir = WP_CONTENT_DIR . "/techozoic/images/headers/";
			}
			if (is_writable($dir)) {
				if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 1048576)) {
						if ($_FILES["file"]["error"] > 0){
								header("Location: themes.php?page=techozoic&tab=header&message=true&error=0");
							} else {
							$_FILES["file"]["name"] = str_replace(' ', '_' , $_FILES["file"]["name"]);
								if (file_exists($dir . $_FILES["file"]["name"])) {
									header("Location: themes.php?page=techozoic&tab=header&message=true&error=1");
								} else {
									move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $_FILES["file"]["name"]);
									chmod($dir . $_FILES["file"]["name"], 0775);
									header("Location: themes.php?page=techozoic&tab=header&message=true");
								}
							}
					} else {
						header("Location: themes.php?page=techozoic&tab=header&message=true&error=2");
					}
				} else {
				header("Location: themes.php?page=techozoic&tab=header&message=true&error=3");
				}
			}
			if (isset($_POST['tech_header_select']) && wp_verify_nonce($_POST['techozioc_nonce_field_header_select'], 'header-select')  && tech_can_edit() ){
				$default_headers = array ("Rotate.jpg" ,"none.jpg", "Random_Lines_1.jpg", "Random_Lines_2.jpg", "Landscape.jpg", "Technology.jpg", "Grunge.jpg");
				if (in_array($_POST['header_select'], $default_headers)){
					$_POST['header_select'] = substr($_POST['header_select'], 0,strrpos($_POST['header_select'],'.'));
					$settings['header'] = $_POST['header_select'];
					$settings['header_image_url'] = '';
				} else {
					$settings['header'] = 'Defined Here';
					if ($settings['image_location'] == 'theme'){
						$settings['header_image_url'] = get_bloginfo('template_directory') . "/uploads/images/headers/" . $_POST['header_select'];
					} else {
						$settings['header_image_url'] = WP_CONTENT_URL . "/techozoic/images/headers/" . $_POST['header_select'];
					}
				}
			update_option('techozoic_options', $settings);
			include(TEMPLATEPATH .'/options/css-build.php');
			header("Location: themes.php?page=techozoic&tab=header&saved=true");	
			} elseif(isset($_POST['tech_header_delete']) && wp_verify_nonce($_POST['techozioc_nonce_field_header_delete'], 'header-delete')  && tech_can_edit() ) {
				if ($settings['image_location'] == 'theme'){
					$path = TEMPLATEPATH. "/uploads/images/headers/";
				} else {
					$path = WP_CONTENT_DIR . "/techozoic/images/headers/";
				}
				$dir_handle = @opendir($path) or die("Unable to open $path");
				$delvars = array();
				while ($file = readdir($dir_handle)) {
					if($file == "." || $file == ".." || $file == "index.php" )
					continue;
					$delvars [] = $file;
				}
				closedir($dir_handle);
				$header = $path . $_POST['header_delete'];
				if (in_array($_POST['header_delete'],$delvars)){
					unlink($header);
				} else {
					header("Location: themes.php?page=techozoic&tab=header&message=true&error=4");
				}
			header("Location: themes.php?page=techozoic&tab=header");
			}  elseif (isset($_POST['tech_header_height']) && check_admin_referer('techozoic_form_submit','techozioc_nonce_field_submit')  && tech_can_edit() ){
				$settings['header_height'] = preg_replace('/[^0-9.]/', '', $_POST['header_height']);
				$settings['header_align'] = $_POST['header_align'];
				$settings['header_v_align'] = $_POST['header_v_align'];
				update_option('techozoic_options', $settings);
				include(TEMPLATEPATH .'/options/css-build.php');
			header("Location: themes.php?page=techozoic&tab=header");
			}  elseif (isset($_POST['tech_image_location']) && check_admin_referer('techozoic_form_submit','techozioc_nonce_field_submit')  && tech_can_edit() ){
				$settings['image_location'] = $_POST['image_location'];
				include_once(TEMPLATEPATH . '/options/tech-init.php');
				if ($_POST['image_location'] == 'theme') {
					tech_create_folders(TEMPLATEPATH . '/uploads');
				} else {
					tech_create_folders(WP_CONTENT_DIR . '/techozoic');
				}
				update_option('techozoic_options', $settings);
				include(TEMPLATEPATH .'/options/css-build.php');
			header("Location: themes.php?page=techozoic&tab=header");
			}
		}
	if ( isset($_GET['tab']) && $_GET['tab'] == "style" ) {		
		if(isset($_POST['style']) && check_admin_referer('techozoic_form_style','techozioc_nonce_field_style')  && tech_can_edit() ){
			$file_name = TEMPLATEPATH ."/style.css";
			$orig_file = TEMPLATEPATH ."/reset-style.css";
			$bu_file = TEMPLATEPATH ."/style.css.bu";
			if (is_writable($file_name)) {
				if ($_POST['tech_style_copy']){
					copy($file_name, $bu_file);
					$file_open = fopen($file_name,"w");
					$_POST['style'] = "/*  
Theme Name: Techozoic Fluid
Theme URI: http://clark-technet.com/theme-support
Description: Advanced, fluid width 2 or 3 column theme with widgetized sidebar, footer, and header areas.  Theme option pages to adjust everything from layout settings, color scheme, typography, ad placement, and custom headers.  SEO optimized titles and meta description and keyword fields.  Builtin social bookmarking, choose from 10 different popular social network and bookmarking sites to include.  Visit the <a href=\"themes.php?page=techozoic\">theme options</a> page to setup Techozoic.  
Version: " . $version . "
Author: Jeremy Clark
Author URI: http://clark-technet.com
Tags: blue, light, two-columns, three-columns, flexible-width, custom-colors, custom-header, theme-options ,left-sidebar, right-sidebar, threaded-comments, translation-ready, sticky-post
*/\n" . $_POST['style'];
					$_POST['style'] = stripslashes($_POST['style']);
					fwrite($file_open, $_POST['style']);
					fclose($file_open);
				} elseif ($_POST['tech_style_copy_reset']){
					copy($orig_file, $file_name);
				} elseif ($_POST['tech_style_restore']){
					copy($bu_file, $file_name);
				}
				header("Location: themes.php?page=techozoic&tab=style&saved=true");
			} else {
				header("Location: themes.php?page=techozoic&tab=style&message=true&error=5");
			}
		}
	}	
	if ( isset($_GET['page']) && ($_GET['page'] == "techozoic" or (isset($_GET['tab']) && $_GET['tab'] == "style") ) ) {
			if ( isset( $_GET['tab'] ) ){
				$location = '&tab=' . $_GET['tab'];
			} else {
				$location = '';
			}
		   	if ( isset($_POST['action']) && $_POST['action'] == 'save' && check_admin_referer('techozoic_form_submit','techozioc_nonce_field_submit')  && tech_can_edit() ) {
				foreach ($options as $value) {
					$id = "";
					$st = "";
					$type = "";
					$reset = "";
					$select ="";
					if (isset($value['id'])) $id = $value['id'];
					if (isset($value['string'])) $st = $value['string'];
					if (isset($value['type'])) $type = $value['type'];
					if (isset($value['reset'])) $reset = $value['reset'];
					if (isset($value['select'])) $select = $value['select'];
					$v = "";
					if (($type != 'header') && (isset($_POST[$id]) or isset($_REQUEST[$reset]) or isset($_REQUEST[$select]) or $_FILES[$id]['size'] > 0 )){
						if($type == "wp_list"){
							if (is_array($_POST[$id])){ 
								$_POST[$id] = implode(',',$_POST[$id]); //This will take from the array and make one string
								$v = $_POST[$id];
							} elseif (!empty($_POST[$id])){
								$v = $POST[$id];
							}
						} elseif($type == "checkbox") {
							if (is_array($_POST[$id])){ 
								$_POST[$id] = implode(',',$_POST[$id]); //This will take from the array and make one string
								$v = $_POST[$id];
							} elseif (!empty($_POST[$id])){
								$v = $_POST[$id];
							}
						} elseif ($type == 'text') {
							if ($st == 'num') {
								$_POST[$id] = trim($_POST[$id]);
								$v = preg_replace('/[^0-9.]/', '', $_POST[$id]);
							} elseif ($st == 'navlist'){
								$_POST[$id] = trim($_POST[$id]);
								$v = preg_replace('/[^0-9,]/', '', $_POST[$id]);
							} else {
								$_POST[$id] = preg_replace('/<(.|\n)*?>/i', '', $_POST[$id]);
								$v = trim($_POST[$id]);
							} 
						} elseif ($type == 'textarea'){
							if ($st =='nohtml'){
								$_POST[$id] = preg_replace('/<(.|\n)*?>/i', '', $_POST[$id]);
								$v = trim($_POST[$id]);
							} else {
								$v = trim($_POST[$id]);
							}
						} elseif (($type == 'select') || ($type == 'radio')) {
							$array = $value['options'];
							if (isset($_POST[$id])){
								if (in_array($_POST[$id], $array)){
									$v = $_POST[$id];
								} else {
									$v = $value['std'];
								}
								if ($id == 'image_location'){
									include_once(TEMPLATEPATH . '/options/tech-init.php');
									if ($_POST['image_location'] == 'theme') {
										tech_create_folders(TEMPLATEPATH . '/uploads');
									} else {
										tech_create_folders(WP_CONTENT_DIR . '/techozoic');
									}
								}
							}
						} elseif ($type == "upload") {
							unset($v);
							$image_url = $settings[$id];
							if (isset($_REQUEST[$value['reset']])){
								$image_url = "";
							} elseif ($_REQUEST[$value['select']] != "Select Image"){
								if ($settings['image_location'] == 'theme'){
									$image_url =  get_bloginfo('template_directory'). "/uploads/images/backgrounds/" . $_REQUEST[$value['select']];
								} else {
									$image_url = WP_CONTENT_URL . "/techozoic/images/backgrounds/" . $_REQUEST[$value['select']];
								}
							} elseif ($_FILES[$value['id']]['size'] > 0){
								$file_id = $value['id']; // Acts as the name
								if ($settings['image_location'] == 'theme'){
									$dir = TEMPLATEPATH . "/uploads/images/backgrounds/";
								} else {
									$dir = WP_CONTENT_DIR . "/techozoic/images/backgrounds/";
								}
								if (is_writable($dir)) {
									if ((($_FILES[$file_id]["type"] == "image/gif") || ($_FILES[$file_id]["type"] == "image/jpeg") || ($_FILES[$file_id]["type"] == "image/png") || ($_FILES[$file_id]["type"] == "image/x-ico") || ($_FILES[$file_id]["type"] == "image/x-icon") || ($_FILES[$file_id]["type"] == "image/pjpeg"))) {
										if ($_FILES[$file_id]["error"] > 0){
											$error = "0";
										} else {
											$_FILES[$file_id]["name"] = str_replace(' ', '_' , $_FILES[$file_id]["name"]);
											if (file_exists($dir . $_FILES[$file_id]["name"])) {
												$error = "1";
											} else {
												move_uploaded_file($_FILES[$file_id]["tmp_name"], 
												$dir . $_FILES[$file_id]["name"]);
												chmod($dir . $_FILES[$file_id]["name"], 0775);
											}
										}
									} else {
										$error = "2";
									}
								} else {
									$error = "3";
								}
								if ($settings['image_location'] == 'theme'){
									$image_url =  get_bloginfo('template_directory'). "/uploads/images/backgrounds/" . $_FILES[$file_id]['name'];
								} else {
									$image_url = WP_CONTENT_URL . "/techozoic/images/backgrounds/" . $_FILES[$file_id]['name'];
								}
							}
						} 
					
						if (isset($image_url)){
							$settings[$id] = $image_url;
							unset($image_url);
						} else {
						$settings[$id] = $v;
						}
					} elseif ($_GET['page'] == "techozoic"){
						if ($type == "wp_list" || $type == "checkbox"){
                                                    $settings[$id] = "";
						}
					}
				} //End foreach loop
				$settings['test'] = "set";
				$settings['head_css'] = "no";
				$settings['ver'] = $version;
				$settings['total'] = $settings['main_column_width'] + ($settings['l_sidebar_width'] + $settings['r_sidebar_width']);
				update_option('techozoic_options', $settings);
				include(TEMPLATEPATH .'/options/css-build.php');
				if (isset($error)){
					header("Location: themes.php?page=techozoic{$location}&message=true&error=".$error."");
					die;
				} else {
					header("Location: themes.php?page=techozoic{$location}&saved=true");
					die;
				}
        	} else if( isset($_POST['action']) && 'reset' == $_POST['action'] && check_admin_referer('techozoic_form_reset','techozioc_nonce_field_reset')  && tech_can_edit() ) {
				foreach ($options as $value) {
				$id = $value['id'];
				$v = $value['std'];
				$new_options[$id] = $v;
				}
				$new_options['test'] = "set";
				$new_options['head_css'] = "no";
				$new_options['ver'] = $version;
				update_option('techozoic_options', $new_options);
				include(TEMPLATEPATH .'/options/css-build.php');
				header("Location: themes.php?page=techozoic{$location}&reset=true");
				die;
			}
    	}
		
/*		
	if($wp_version >= 3){ 
		$techozoic_menu_hook[0] = add_menu_page( sprintf(__("%s Options", "techozoic"),$themename), $themename, 'edit_theme_options', 'techozoic_main_admin','','',61);
		$techozoic_menu_hook[1] = add_submenu_page('techozoic_main_admin' ,sprintf(__("%s General Settings","techozoic"),$themename), __("General Settings","techozoic"), 'edit_theme_options', 'techozoic_main_admin', 'techozoic_admin');
		$techozoic_menu_hook[2] = add_submenu_page('techozoic_main_admin' ,sprintf(__("%s Header Settings","techozoic"),$themename), __("Header Settings","techozoic"), 'edit_theme_options', 'techozoic_header_admin', 'techozoic_header_admin');
		$techozoic_menu_hook[3] = add_submenu_page('techozoic_main_admin' ,sprintf(__("%s Style Settings","techozoic"),$themename), __("CSS Settings","techozoic"), 'edit_theme_options', 'techozoic_style_admin', 'techozoic_style_admin');
		$techozoic_menu_hook[4] = add_submenu_page('techozoic_main_admin' ,sprintf(__("%s Export/Import Settings","techozoic"),$themename), __("Export/Import Settings","techozoic"), 'edit_theme_options', 'techozoic_export_admin', 'techozoic_export_admin');
		$techozoic_menu_hook[5] = add_submenu_page('techozoic_main_admin' ,sprintf(__("%s Delete Settings","techozoic"),$themename), __("Delete Theme Settings","techozoic"), 'edit_theme_options', 'techozoic_delete_admin', 'techozoic_delete_admin');
	} else {
		$techozoic_menu_hook[0] = add_menu_page( sprintf(__("%s Options", "techozoic"),$themename), $themename, 'edit_themes', 'techozoic_main_admin','','',61);
		$techozoic_menu_hook[1] = add_submenu_page('techozoic_main_admin' ,sprintf(__("%s General Settings","techozoic"),$themename), __("General Settings","techozoic"), 'edit_themes', 'techozoic_main_admin', 'techozoic_admin');
		$techozoic_menu_hook[2] = add_submenu_page('techozoic_main_admin' ,sprintf(__("%s Header Settings","techozoic"),$themename), __("Header Settings","techozoic"), 'edit_themes', 'techozoic_header_admin', 'techozoic_header_admin');
		$techozoic_menu_hook[3] = add_submenu_page('techozoic_main_admin' ,sprintf(__("%s Style Settings","techozoic"),$themename), __("CSS Settings","techozoic"), 'edit_themes', 'techozoic_style_admin', 'techozoic_style_admin');
		$techozoic_menu_hook[4] = add_submenu_page('techozoic_main_admin' ,sprintf(__("%s Export/Import Settings","techozoic"),$themename), __("Export/Import Settings","techozoic"), 'edit_themes', 'techozoic_export_admin', 'techozoic_export_admin');
		$techozoic_menu_hook[5] = add_submenu_page('techozoic_main_admin' ,sprintf(__("%s Delete Settings","techozoic"),$themename), __("Delete Theme Settings","techozoic"), 'edit_themes', 'techozoic_delete_admin', 'techozoic_delete_admin');
	}
*/
		add_theme_page(sprintf(__('Techozoic %s Settings','techozoic'), $current_title),__('Techozoic Settings','techozoic'),'edit_theme_options','techozoic','techozoic_admin_page');

	}//End Function
function techozoic_admin_page(){
	global $pagenow;
	if ( $pagenow == 'themes.php' && $_GET['page'] == 'techozoic' ) {
		if ( isset ( $_GET['tab'] ) ) {
			$tab = $_GET['tab'];
		} else {
			$tab = 'general';
		}
		switch ( $tab ) {
			case 'general' :
				techozoic_general_admin();
				break;
			case 'header' :
				techozoic_header_admin();
				break;
			case 'style' :
				techozoic_style_admin();
				break;
			case 'export' :
				techozoic_export_admin();
				break;
			case 'delete' :
				techozoic_delete_admin();
				break;
		}
	}
}
	
function techozoic_general_admin() {
    	global $themename, $shortname, $options, $tech_error;
    	if ( isset($_REQUEST['saved']) && $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'. sprintf(__("%s settings saved","techozoic"), $themename) . '</strong></p></div>';
    	if ( isset($_REQUEST['reset']) && $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'. sprintf(__("%s settings reset","techozoic"), $themename) . '</strong> </p></div>';
		if ( isset($_REQUEST['message']) && $_REQUEST['message'] ) {
			if ($_REQUEST['error']) {
				echo '<div id="message" class="updated fade"><p><strong>'. $tech_error[$_REQUEST['error']] .' </strong> </p></div>';
				} else { 
				echo '<div id="message" class="updated fade"><p><strong>' . __("Image Uploaded","techozoic") . '</strong> </p></div>';
				}
			}
		?>
	<div class="tech_wrap"><a name="top"></a>
	<?php echo techozoic_admin_tabs(); ?>
	<div class="alignright">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick" />
			<input type="hidden" name="hosted_button_id" value="10999960" />
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" />
			<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
		</form>
	</div>
	<div class="tech_head">
	<img src="<?php echo get_bloginfo('template_directory')?>/images/techozoic-logo.png" alt="Techozoic Fluid Logo" class="alignleft" style="margin-right:5px;"><h2 style="border:none;"><?php printf(__("%s General Settings","techozoic"),$themename);?></h2>
	<ul id="themetabs" class="tabs">
		<li><a href="#layout" rel="layout" rev="tech_buttons"><?php _e("Layout","techozoic");?></a></li>
		<li><a href="#post" rel="post" rev="tech_buttons"><?php _e("Post","techozoic");?></a></li>
		<li><a href="#nav" rel="nav" rev="tech_buttons"><?php _e("Navigation","techozoic");?></a></li>
		<li><a href="#social" rel="social" rev="tech_buttons"><?php _e("Social Networks","techozoic");?></a></li>
		<li><a href="#font" rel="font" rev="tech_buttons"><?php _e("Typography","techozoic");?></a></li>
		<li><a href="#color" rel="color" rev="tech_buttons"><?php _e("Color Options","techozoic");?></a></li>
		<li><a href="#background" rel="background" rev="tech_buttons"><?php _e("Backgrounds","techozoic");?></a></li>
		<li><a href="#tab4" rel="tab4" rev="tech_buttons"><?php _e("Ad Placement","techozoic");?></a></li>
		<li id="headersettab"><a href="#headerset" rel="headerset" rev="tech_buttons"><?php _e("Manual Header Settings","techozoic");?></a></li>
	</ul>
	<?php techozoic_links_box();?>
	<div class="tech_form_wrap">
	<form method="post" enctype="multipart/form-data" id="tech_main" name="tech_options">
<?php 
	$settings = get_option('techozoic_options');
	foreach ($options as $value) {
		if (isset($value['display']) && $value['display'] == "style"){ }
		else {
			if (isset($value['id'])) $id = $value['id'];
			if (isset($value['std'])) $std = $value['std'];
			if ($value['type'] == "header") { 
				if (isset($value['position']) && $value['position'] == "1") { ?>
					<div id="<?php if (isset($value['tab_id'])) echo $value['tab_id']; ?>" class="tabbercontent">
					<table class="optiontable">
	<?php 			} else { ?>
					</table>
					</div>
					<div id="<?php if (isset($value['tab_id'])) echo $value['tab_id']; ?>" class="tabbercontent">
					<table class="optiontable">
	<?php 			} ?>
				<tr valign="middle"><td colspan="2"><h3><a name="<?php if (isset($value['anchor'])) echo $value['anchor']; ?>"></a><?php echo $value['name']; ?></h3></td></tr>
	<?php 		} 
			if ($value['type'] == "text") { 
				if(isset($value['before'])) echo $value['before'] ?>        
				<tr valign="top"> 
					<th scope="top"><?php echo $value['name']; ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="width:50%;text-align:justify;" valign="top"><small><?php echo $value['desc']?></small></td>
	<?php 		} ?>
					<td>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if( $settings[$id]  != "") { echo stripslashes($settings[$id]); } else { echo $value['std']; } ?>" size="<?php echo $value['size']; ?>" <?php if(isset($value['java'])) echo $value['java']; ?>/>
	<?php 			if (isset($value['text'])) echo $value['text'];
				if(isset($value['tooltip'])) echo $value['tooltip']; ?>    
				</td>
				</tr>
				<tr><td colspan="2"><hr /></td></tr>
	<?php 			if(isset($value['after'])) echo $value['after']; 
				if(isset($value['last'])) echo $value['last']; 
			} elseif ($value['type'] == "select") { ?>
				<tr valign="middle"> 
					<th scope="row"><?php echo $value['name']; ?><?php if (isset($value['image'])){ ?>
				<br /><img src="<?php bloginfo('template_directory') ?>/<?php echo $value['image']; ?>" alt="<?php echo $value['name']; ?>" /><?php } ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="width:50%;text-align:justify;" valign="top"><small><?php echo $value['desc']?></small></td>
	<?php 		} ?>
					<td>
						<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" <?php if(isset($value['java'])) echo $value['java']; ?>>
	<?php 			foreach ($value['options'] as $option) { ?>
							<option<?php if ( $settings[$id]  == $option) { echo ' selected="selected"'; }?>><?php echo $option; ?></option>
	<?php 			} ?>
						</select>
					</td>
					</tr>
				<tr><td colspan="2"><hr /></td></tr>
	<?php 			if(isset($value['after'])) echo $value['after'];
				if(isset($value['last'])) echo $value['last'];

			} elseif ($value['type'] == "checkbox") { ?>
				<tr valign="middle"> 
					<th scope="row"><?php echo $value['name']; ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="width:50%;text-align:justify;" valign="top"><small><?php echo $value['desc']?></small></td>
	<?php 		} ?>
						<td>
		<ul>						
		<?php 
		$ch_values=explode(',',$settings[$id]);
		foreach ($value['options'] as $option) { 
?>
		<li>
		<input name="<?php echo $value['id']; ?>[]" type="<?php echo $value['type']; ?>" value="<?php echo $option; ?>" <?php if ( in_array($option,$ch_values)) { echo 'checked'; } ?>/> <?php	echo $option; ?> </li>
<?php 		} ?>
		</ul>
			</td>
		</tr>
	<tr><td colspan=2><hr /></td></tr>
	
	<?php 			if (isset($value['after'])) echo $value['after']; 
				if (isset($value['last'])) echo $value['last'];

			} elseif ($value['type'] == "wp_list") { ?>
				<tr valign="middle"> 
					<th scope="row"><?php echo $value['name']; ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="width:50%;text-align:justify;" valign="top"><small><?php echo $value['desc']?></small></td>
	<?php 		} ?>
						<td>		
							<select  multiple="multiple" size="8" name="<?php echo $value['id']; ?>[]" id="<?php echo $value['id']; ?>" style="height:100px;">
	<?php 					if ($value['list'] == "pages"){			
					$pages = get_pages(); 
							$ch_values=explode(',',$settings[$id]); foreach ($pages as $pagg) { ?>
								<option<?php if ( in_array($pagg->ID,$ch_values)) { echo ' selected="selected"'; }?> value="<?php echo $pagg->ID; ?>"><?php echo $pagg->post_title; ?></option>
	<?php 				} //End foreach loop
				} else {
					$cats = get_categories(); 
							$ch_values=explode(',',$settings[$id]); foreach ($cats as $cat) { ?>
					<option<?php if ( in_array($cat->cat_name,$ch_values)) { echo ' selected="selected"'; }?> value="<?php echo $cat->cat_name; ?>"><?php echo $cat->category_nicename; ?></option>
	<?php 				} // End For each loop
				}
					?>
				</select>		
			</td>
		</tr>
	<tr><td colspan=2><hr /></td></tr>

	<?php
				
		 } elseif ($value['type'] == "upload") { 
		 if ($settings['image_location'] == 'theme'){
			$url_path = get_bloginfo('template_directory') . "/uploads/images/backgrounds/";
		} else {
			$url_path = WP_CONTENT_URL . "/techozoic/images/backgrounds/";
		}?>
				<tr valign="middle"> 
					<th scope="row"><?php echo $value['name']; ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="width:50%;text-align:justify;" valign="top"><small><?php echo $value['desc']?></small></td>
	<?php 		} ?>
					 <td>
			<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id'];?>" type="file" <?php if(isset($value['java'])) echo $value['java']; ?>/>
			</td>
		</tr>
	<?php			if ($settings[$id] != "") { ?>
		<tr valign="middle">
					<th scope="row">Selected:</th><td>
	<span id ="<?php echo $value['id'];?>_selected_bg" style="display:block;width:100px;height:100px;background-image:url(<?php echo $settings[$id];?>)" />
		</td></tr>
		<?php				} ?>
				<tr valign="middle"> 
					<th scope="row">Choose Existing</th><td>
		<select name="<?php echo $value['id']; ?>_select" id="<?php echo $value['id']; ?>_select" onchange="image_preview('<?php echo $url_path ?>','<?php echo $value['id']?>')">
		<option>Select Image</option>
	<?php
		if ($settings['image_location'] == 'theme'){
			$path = TEMPLATEPATH. "/uploads/images/backgrounds/";
		} else {
			$path = WP_CONTENT_DIR . "/techozoic/images/backgrounds/";
		}

		if (file_exists($path)){
			$dir_handle = @opendir($path);
			while ($tech_file = readdir($dir_handle)) {
				if($tech_file == "." || $tech_file == ".." || $tech_file == "index.php" || $tech_file == ".svn" || ($value['id'] == "favicon_image" && !preg_match('/\.ico$/i', $tech_file))) {
					continue;
				}
	?>
				<option><?php echo $tech_file; ?></option>
	<?php
			}	 //End While Loop
			closedir($dir_handle); 
		} //End if folder eixists check
	?></select>
	</td></tr>
				<tr valign="middle" id="<?php echo $value['id']?>_preview">
					<th scope="row"><?php _e("Preview:","techozoic");?></th><td>
					<span id="<?php echo $value['id']?>_preview_image"></span>
		</td></tr>

			<tr valign="middle"> 
					<th scope="row"><?php _e("Reset - Check and Save Options to Clear","techozoic") ?></th><td><input name="<?php echo $value['id'];?>_reset" type="checkbox" /></td></tr>
				<tr><td colspan="2"><hr /></td></tr>
	<?php 			if (isset($value['after'])) echo $value['after']; 
				if (isset($value['last'])) echo $value['last'];
		
			} elseif ($value['type'] == "radio") { ?>
				<tr valign="middle"> 
					<th scope="row"><?php echo $value['name']; ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="width:50%;text-align:justify;" valign="top"><small><?php echo $value['desc']?></small></td>
	<?php 		} ?>
					<td>
	<?php 			foreach ($value['options'] as $option) { 
					echo $option; ?><input name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php echo $option; ?>" <?php if (  $settings[$id]  == $option) { echo 'checked="checked"'; } ?> <?php if(isset($value['java'])) echo $value['java']; ?>/>|
	<?php 			} ?>
					</td>
					</tr>
				<tr><td colspan="2"><hr /></td></tr>
	<?php 			if (isset($value['after'])) echo $value['after']; 
				if (isset($value['last'])) echo $value['last'];
			} elseif ($value['type'] == "textarea") { ?>

					<tr valign="top"> 
					<th scope="row"><?php echo $value['name']; ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="width:50%;text-align:justify;" valign="top"><small><?php echo $value['desc']?></small></td>
	<?php 		} ?>
					<td>
						<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="40" rows="10"><?php if (  $settings[$id]  != "") { echo stripslashes($settings[$id]) ; } else { echo $value['std']; } ?>
	</textarea>

					</td>
					</tr>
				<tr><td colspan="2"><hr /></td></tr>
	<?php 			if (isset($value['after'])) echo $value['after']; 
				if (isset($value['last'])) echo $value['last'];
			} 
		}//End If
	}//End foreach loop 
?>
</div>
	<div id="tech_buttons">
	<div class="tech_bottom">
	</div>
	<div class="tech_bottom2">
		<a name="submit"></a>
		<span class="tech_submit submit save">
			<input class="button-primary" name="save" id="save_button" type="submit" value="<?php _e("Save changes","techozoic");?>" />    
			<input type="hidden" name="action" value="save" />
			<?php wp_nonce_field('techozoic_form_submit','techozioc_nonce_field_submit'); ?>
		</span>
		</form>
		<form method="post" onsubmit="return verify()">
			<span class="tech_submit submit reset">
				<input name="reset" type="submit" value="<?php _e("Reset","techozoic");?>" />
				<input type="hidden" name="action" value="reset" />
				<?php wp_nonce_field('techozoic_form_reset','techozioc_nonce_field_reset'); ?>
			</span>
		</form>
	</div>
	</div>
	</div>
		<script type="text/javascript">
			tabsetup();
		</script>
		
		</div>
		<div style="height:50px;clear:both"></div>
<?php
} //End function mytheme_admin()

function techozoic_admin_tabs( $current = 'general' ) {
    $tabs = array( 'general' => 'General Settings', 'header' => 'Header Settings', 'style' =>'Style Settings', 'export' =>'Import/Export Settings', 'delete'=>'Delete Settings' );
    $links = array();
    foreach( $tabs as $tab => $name ) :
        if ( $tab == $current ) :
            $links[] = "<a class='nav-tab nav-tab-active' href='?page=techozoic&tab=$tab'>$name</a>";
        else :
            $links[] = "<a class='nav-tab' href='?page=techozoic&tab=$tab'>$name</a>";
        endif;
    endforeach;
	echo '<img src="' . get_bloginfo('template_directory') . '/images/techozoic-logo-small.png" alt="Techozoic Fluid Logo" class="alignleft" style="margin-right:5px;">';
    echo '<h2>';
    foreach ( $links as $link )
        echo $link;
    echo '</h2>';
}

function techozoic_header_admin() {
	include_once(TEMPLATEPATH . '/options/header-admin.php');
}
function techozoic_style_admin() {
	include_once(TEMPLATEPATH . '/options/style-admin.php');
}
function techozoic_export_admin() {
	include_once(TEMPLATEPATH . '/options/export-admin.php');
}
function techozoic_delete_admin() {
	include_once(TEMPLATEPATH . '/options/delete-admin.php');
}
function tech_can_edit() {
	global $user_id, $wp_version;
	if($wp_version >= 3){
		if (!current_user_can('edit_theme_options') ){
			die(__('You do not have permission to edit these options.  Please go back','techozoic'));
		}
	} else {
		if (!current_user_can('edit_theme') ){
			die(__('You do not have permission to edit these options.  Please go back','techozoic'));
		}
	}
	return true;
}	

function techozoic_help($contextual_help, $screen_id, $screen) {
	global $techozoic_menu_hook;
	if (in_array($screen_id , $techozoic_menu_hook) ) {
		$tech_changelog = get_bloginfo('template_directory') . '/changelog.php';
		$contextual_help = "
		<p>" . __('Help for Techozoic can be obtained in a number of ways.  Please use the links below for help.','techozoic') . "</p>
<p> <a href='http://clark-technet.com/theme-support/techozoic'>" . __('Support Forum','techozoic') . "</a> |
<a href='http://techozoic.clark-technet.com/documentation/'>" . __('Documentation','techozoic') . "</a> |
<a href='http://techozoic.clark-technet.com/documentation/faq/'>" . __('FAQ','techozoic') . "</a>
</p>
";
	}
	return $contextual_help;
}


function techozoic_top_menu() {
	echo '<ul class="subsubsub">
		<li><a href="themes.php?page=techozoic">' . __("General Settings","techozoic") . '</a> | </li>
		<li><a href="themes.php?page=techozoic&tab=header">' . __("Header Settings","techozoic") . '</a> | </li>
		<li><a href="themes.php?page=techozoic&tab=style">' . __("CSS Settings","techozoic") . '</a> | </li>
		<li><a href="themes.php?page=techozoic&tab=export">' . __("Export/Import Settings","techozoic") . '</a></li>
	</ul>
	<div style="clear:both"></div>';
}
function techozoic_links_box($class="tech_links_box") {
	$output ='	<div class="' . $class . '">';
		// Get RSS Feed(s)
		$feed_address = "http://techozoic.clark-technet.com/category/news/feed";
		$feed_items = 5;
		$tech_changelog = get_bloginfo('template_directory') . '/changelog.php';
		$output .= "<h3>" . __('Techozoic News','techozoic') . "</h3>";
		include_once(ABSPATH . WPINC . '/feed.php');
		// Get a SimplePie feed object from the specified feed source.
		$rss = fetch_feed($feed_address);
		if (!is_wp_error( $rss ) ) {
			// Checks that the object is created correctly 
			// Figure out how many total items there are, but limit it to $feed_items. 
			 $maxitems = $rss->get_item_quantity($feed_items); 

			// Build an array of all the items, starting with element 0 (first element).
			$rss_items = $rss->get_items(0, $maxitems); 
			$output .='<ul>';
			if (isset($maxitems) && $maxitems == 0) {
				$output .= '<li>' . __("No News.","techozoic") . '</li>';
			} else {
				// Loop through each feed item and display each item as a hyperlink.
				foreach ( $rss_items as $item ) { 
					$output .= "<li>
						<a href='{$item->get_permalink()}' target='_blank' title='{$item->get_title()}'>
						{$item->get_title()}</a>
					</li>";
				}
				$output.='</ul>';
			}
		}
	$output .="<h3>" . __('Techozoic Links','techozoic') . "</h3>
	<ul>
		<li>
			<a href='http://clark-technet.com/theme-support/techozoic'>" . __('Support Forum','techozoic') . "</a>
		</li>
		<li>
			<a href='http://techozoic.clark-technet.com/documentation/'>" . __('Documentation','techozoic') . "</a>
		</li>
		<li>
			<a href='http://techozoic.clark-technet.com/documentation/faq/'>" . __('FAQ','techozoic') . "</a>
		</li>
		<li>
			<a href='$tech_changelog' onclick='return changelog(\"$tech_changelog\")'>" . __('Change Log','techozoic') . "</a>
		</li>
	</div>";
	echo $output;
}
function techozoic_footer() {
	global $themename;
	echo  __("Theme Option page for","techozoic") . " " . $themename .'&nbsp;|&nbsp; ' . __("Framework by","techozoic") . ' <a href="http://clark-technet.com/" title="Jeremy Clark">Jeremy Clark</a> | ';
	echo __("Social Network Icons provided by","techozoic") . ' <a href="http://komodomedia.com" target="_blank">komodomedia.com</a>';
}

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

function tech_admin_thickbox() {
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
}

function tech_menu_button_css() {
	$path = get_bloginfo('template_directory');
	$output ="<style type=\"text/css\">
#adminmenu #toplevel_page_techozoic_main_admin div.wp-menu-image {	background: transparent url('{$path}/images/tech_menu.png') no-repeat scroll -1px -33px;}
#adminmenu #toplevel_page_techozoic_main_admin div.wp-menu-image img{display:none;}
#adminmenu #toplevel_page_techozoic_main_admin:hover div.wp-menu-image,
#adminmenu #toplevel_page_techozoic_main_admin.wp-has-current-submenu div.wp-menu-image,
#adminmenu #toplevel_page_techozoic_main_admin.current div.wp-menu-image {	background: transparent url('{$path}/images/tech_menu.png') no-repeat scroll -1px -1px;}
</style>
";
print $output;
}

function tech_admin_js() {
	wp_enqueue_script('controlpanel', get_bloginfo('template_directory') . '/js/controlpanel.js');
	wp_enqueue_script('tabcontent', get_bloginfo('template_directory') . '/js/tabcontent.js');
	wp_enqueue_script('jscolor', get_bloginfo('template_directory') . '/js/jscolor/jscolor.js');
}

function tech_admin_css(){
	wp_enqueue_style('options', get_bloginfo('template_directory') . '/options/options.css');
}

function tech_controlpanel_head_css() {
$path = get_bloginfo('template_directory');
	$head = "<script type='text/javascript'>\n";
	$head .= "document.write('<style type=\"text/css\"> #tech_buttons{display:none}</style>');\n</script>\n";
	$head .= "<!--[if IE 8]>\n";
	$head .= "<style type=\"text/css\">\n";
	$head .= ".reset {float: left; margin-right: 2px;}\n";
	$head .= "</style>\n";
	$head .= "<![endif]-->\n";
	$head .= "<!--[if IE 7]>\n";
	$head .= "<style type=\"text/css\">\n";
	$head .= ".submit INPUT {padding: 0 !important;}\n";
	$head .= "</style>\n";
	$head .= "<![endif]-->\n";
	print $head;
} //End Function controlpanel_css
if (isset($_GET['page'])){
	if ($_GET['page'] == "techozoic"){
		add_action('admin_head', 'tech_controlpanel_head_css');
		add_action('admin_print_styles', 'tech_admin_js');		
		add_action('admin_print_styles','tech_admin_thickbox');
		add_filter('admin_footer_text','techozoic_footer');
	}
}
add_action('contextual_help', 'techozoic_help', 10, 3);
add_action('admin_print_styles', 'tech_admin_css');	
add_action('admin_menu', 'techozoic_add_admin'); 
add_action('admin_head','tech_menu_button_css');
?>