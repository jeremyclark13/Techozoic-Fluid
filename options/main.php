<?php
//Please Do NOT edit this page.
$themename = "Techozoic";
$shortname = "tech";
$tech_error = array ( "Return Error", "File Already Exists", "Incorrect File Type / File Size Limit exceeded","Folder isn't writable please check folder that<code>" .WP_CONTENT_URL . "/techozoic/</code> exists and is writable." , "File Doesn't exist.", "Folder isn't writable please check folder<code>" .TEMPLATEPATH ."</code> Permissions.","Please only use .ico format for Fav Icon Images");
$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
$version = $theme_data['Version'];
function techozoic_add_admin() {
	global $themename, $shortname, $options, $version;
	$settings = get_option('techozoic_options');
	if ( $_GET['page'] == "techozoic_export_admin" ) {
		if ( 'export' == $_POST['action']) {
			tech_export();
		}
		if (isset($_FILES['settings'])){
			if ($_FILES["settings"]["error"] > 0){
				echo "Error: " . $_FILES["settings"]["error"] . "<br />";
			  } else{
				$rawdata = file_get_contents($_FILES["settings"]["tmp_name"]);
				$tech_options = unserialize($rawdata);
				update_option('techozoic_options', $tech_options);
				header("Location: admin.php?page=techozoic_export_admin&import=true");
			  }
		}
	}
	if ( $_GET['page'] == "techozoic_header_admin" ) {
			if (isset($_FILES['file'])){
			$dir = WP_CONTENT_DIR. "/techozoic/images/headers/";
			if (is_writable($dir)) {
				if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 1048576)) {
						if ($_FILES["file"]["error"] > 0){
								header("Location: admin.php?page=techozoic_header_admin&message=true&error=0");
							} else {
							$_FILES["file"]["name"] = str_replace(' ', '_' , $_FILES["file"]["name"]);
								if (file_exists($dir . $_FILES["file"]["name"])) {
									header("Location: admin.php?page=techozoic_header_admin&message=true&error=1");
								} else {
									move_uploaded_file($_FILES["file"]["tmp_name"], 
									$dir . $_FILES["file"]["name"]);
									header("Location: admin.php?page=techozoic_header_admin&message=true");
								}
							}
					} else {
						header("Location: admin.php?page=techozoic_header_admin&message=true&error=2");
					}
				} else {
				header("Location: admin.php?page=techozoic_header_admin&message=true&error=3");
				}
			}
			if (isset($_POST['tech_header_select'])){
				$default_headers = array ("Rotate.jpg" ,"none.jpg", "Random_Lines_1.jpg", "Random_Lines_2.jpg", "Landscape.jpg", "Technology.jpg", "Grunge.jpg");
				if (in_array($_POST['header_select'], $default_headers)){
					$_POST['header_select'] = substr($_POST['header_select'], 0,strrpos($_POST['header_select'],'.'));
					$settings['header'] = $_POST['header_select'];
					$settings['header_image_url'] = '';
				} else {
					$settings['header'] = 'Defined Here';
					$settings['header_image_url'] = WP_CONTENT_URL . "/techozoic/images/headers/" . $_POST['header_select'];
				}
			update_option('techozoic_options', $settings);
			header("Location: admin.php?page=techozoic_header_admin&saved=true");	
			} elseif(isset($_POST['tech_header_delete'])) {
				$path = WP_CONTENT_DIR. "/techozoic/images/headers/";
				$dir_handle = @opendir($path) or die("Unable to open $path");
				$delvars = array();
				while ($file = readdir($dir_handle)) {
					if($file == "." || $file == ".." || $file == "index.php" )
					continue;
					$delvars [] = $file;
				}
				closedir($dir_handle);
				$header= WP_CONTENT_DIR. "/techozoic/images/headers/" . $_POST['header_delete'];
				if (in_array($_POST['header_delete'],$delvars)){
					unlink($header);
				} else {
					header("Location: admin.php?page=techozoic_header_admin&message=true&error=4");
				}
			header("Location: admin.php?page=techozoic_header_admin");
			}  elseif (isset($_POST['tech_header_height'])){
				$settings['header_height'] = preg_replace('/[^0-9.]/', '', $_POST['header_height']);
				$settings['header_align'] = $_POST['header_align'];
				update_option('techozoic_options', $settings);
			header("Location: admin.php?page=techozoic_header_admin");
			}
		}
	if ( $_GET['page'] == "techozoic_style_admin" ) {		
		if(isset($_POST['style'])){
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
Description: Simple, fluid width, widget-ready, 2 or 3 column tech theme.  Theme Option panel with over 40 options to adjust column settings, color scheme, font, ad placement, and custom headers.  SEO optimized titles and meta information. Released under GPL License.  Visit the <a href=\"?page=controlpanel.php\">theme options</a> page to setup Techozoic.  
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
				header("Location: admin.php?page=techozoic_style_admin&saved=true");
			} else {
				header("Location: admin.php?page=techozoic_style_admin&message=true&error=5");
			}
		}
	}	
	if ( $_GET['page'] == "techozoic_main_admin" or $_GET['page'] == "techozoic_style_admin") {
			$location = $_GET['page'];
		   	if ( 'save' == $_POST['action'] ) {
				foreach ($options as $value) {
					$k = $value['id'];
					$st = $value['string'];
					$type = $value['type'];
					$v = "";
					if (isset($_POST[$k]) or isset($_REQUEST[$value['reset']]) or isset($_REQUEST[$value['select']]) or $_FILES[$value['id']]['size'] > 0 ){
						if(($type == "wp_list") and is_array($_POST[$k])){ 
							$_POST[$k] = implode(',',$_POST[$k]); //This will take from the array and make one string
							$v = $_POST[$k];
						} elseif($type == "checkbox") {
							if (is_array($_POST[$k])){ 
								$_POST[$k] = implode(',',$_POST[$k]); //This will take from the array and make one string
								$v = $_POST[$k];
							} else {
								$v = $_POST[$k];
							}
						} elseif ($type == 'text') {
							if ($st == 'num') {
								$_POST[$k] = trim($_POST[$k]);
								$v = preg_replace('/[^0-9.]/', '', $_POST[$k]);
							} elseif ($st == 'navlist'){
								$_POST[$k] = trim($_POST[$k]);
								$v = preg_replace('/[^0-9,]/', '', $_POST[$k]);
							} else {
								$_POST[$k] = preg_replace('/<(.|\n)*?>/i', '', $_POST[$k]);
								$v = trim($_POST[$k]);
							} 
						} elseif ($type == 'textarea'){
							if ($st =='nohtml'){
								$_POST[$k] = preg_replace('/<(.|\n)*?>/i', '', $_POST[$k]);
								$v = trim($_POST[$k]);
							} else {
								$v = trim($_POST[$k]);
							}
						} elseif (($type == 'select') || ($type == 'radio')) {
							$array = $value['options'];
							if (in_array($_POST[$k], $array)){
								$v = $_POST[$k];
							} else {
								$v = $value['std'];
							}
						} elseif ($type == "upload") {
							unset($v);
							$image_url = $settings[$k];
							if (isset($_REQUEST[$value['reset']])){
								$image_url = "";
							} elseif ($_REQUEST[$value['select']] != "Select Image"){
								$image_url =  WP_CONTENT_URL . "/techozoic/images/backgrounds/".$_REQUEST[$value['select']];
							} elseif ($_FILES[$value['id']]['size'] > 0){
								$ID = $value['id']; // Acts as the name
								$dir = WP_CONTENT_DIR. "/techozoic/images/backgrounds/";
								if (is_writable($dir)) {
									if ((($_FILES[$ID]["type"] == "image/gif") || ($_FILES[$ID]["type"] == "image/jpeg") || ($_FILES[$ID]["type"] == "image/png") || ($_FILES[$ID]["type"] == "image/x-ico") || ($_FILES[$ID]["type"] == "image/x-icon") || ($_FILES[$ID]["type"] == "image/pjpeg")) && ($_FILES[$ID]["size"] < 1048576)) {
										if ($ID = "favicon_image"){
											if (($_FILES[$ID]["type"] != "image/x-ico") || ($_FILES[$ID]["type"] != "image/x-icon")){
												$error = "6";
												break 1;
											}
										}
										if ($_FILES[$ID]["error"] > 0){
											$error = "0";
										} else {
											$_FILES[$ID]["name"] = str_replace(' ', '_' , $_FILES[$ID]["name"]);
											if (file_exists($dir . $_FILES[$ID]["name"])) {
												$error = "1";
											} else {
												move_uploaded_file($_FILES[$ID]["tmp_name"], 
												$dir . $_FILES[$ID]["name"]);
											}
										}
									} else {
										$error = "2";
									}
								} else {
									$error = "3";
								}
								$image_url =  WP_CONTENT_URL . "/techozoic/images/backgrounds/".$_FILES[$ID]['name'];
							}
						} 
					
						if (isset($image_url)){
							$settings[$k] = $image_url;
							unset($image_url);
						} else {
						$settings[$k] = $v;
						}
					} elseif ($_GET['page'] == "techozoic_main_admin"){
						if ($type == "wp_list" || $type == "checkbox"){
							$settings[$k] = "";
						}
					}
				}
				$settings['test'] = "set";
				$settings['head_css'] = "no";
				$settings['ver'] = $version;
				$settings['total'] = $settings['main_column_width'] + (($settings['column'] - 1) * $settings['sidebar_width']);
				update_option('techozoic_options', $settings);
				if (isset($error)){
					header("Location: admin.php?page=$location&message=true&error=".$error."");
					die;
				} else {
					header("Location: admin.php?page=$location&saved=true");
					die;
				}
        	} else if( 'reset' == $_POST['action'] ) {
				foreach ($options as $value) {
				$k = $value['id'];
				$v = $value['std'];
				$new_options[$k] = $v;
				}
				$new_options['test'] = "set";
				$new_options['head_css'] = "no";
				$new_options['ver'] = $version;
				update_option('techozoic_options', $new_options);
				header("Location: admin.php?page=$location&reset=true");
				die;
			}
    	}
	add_menu_page($themename." Options", "Techozoic", 'edit_themes', 'techozoic_main_admin','','',61);
	add_submenu_page('techozoic_main_admin' ,$themename." General Settings", "General Settings", 'edit_themes', 'techozoic_main_admin', 'techozoic_admin');
	add_submenu_page('techozoic_main_admin' ,$themename." Header Settings", "Header Settings", 'edit_themes', 'techozoic_header_admin', 'techozoic_header_admin');
	add_submenu_page('techozoic_main_admin' ,$themename." Style Settings", "CSS Settings", 'edit_themes', 'techozoic_style_admin', 'techozoic_style_admin');
	add_submenu_page('techozoic_main_admin' ,$themename." Export/Import Settings", "Export/Import Settings", 'edit_themes', 'techozoic_export_admin', 'techozoic_export_admin');
	}//End Function
function techozoic_admin() {
    	global $themename, $shortname, $options, $tech_error;
    	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong> </p></div>';
		if ( $_REQUEST['message'] ) {
			if ($_REQUEST['error']) {
				echo '<div id="message" class="updated fade"><p><strong>'. $tech_error[$_REQUEST['error']] .' </strong> </p></div>';
				} else { 
				echo '<div id="message" class="updated fade"><p><strong>Image Uploaded</strong> </p></div>';
				}
			}
		?>
	<div class="tech_wrap"><a name="top"></a>
	<div class="alignright">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick" />
			<input type="hidden" name="hosted_button_id" value="10999960" />
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" />
			<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
		</form>
	</div>
	<div class="tech_head">
	<?php techozoic_top_menu();?>
	<img src="<?php echo get_bloginfo('template_directory')?>/images/techozoic-logo.png" alt="Techozoic Fluid Logo" class="alignleft" style="margin-right:5px;"><h2><?php echo $themename;?> General settings</h2>
	<ul id="themetabs" class="tabs">
		<li><a href="#layout" rel="layout" rev="tech_buttons">Layout</a></li>
		<li><a href="#nav" rel="nav" rev="tech_buttons">Navigation</a></li>
		<li><a href="#social" rel="social" rev="tech_buttons">Social Networks</a></li>
		<li><a href="#font" rel="font" rev="tech_buttons">Typography</a></li>
		<li><a href="#color" rel="color" rev="tech_buttons">Color Options</a></li>
		<li><a href="#background" rel="background" rev="tech_buttons">Backgrounds</a></li>
		<li><a href="#tab4" rel="tab4" rev="tech_buttons">Ad Placement</a></li>
		<li id="headersettab"><a href="#headerset" rel="headerset" rev="tech_buttons">Manual Header Settings</a></li>
		<li><a href="#notes" rel="note" onclick="togglebuttons('hide')">Notes</a></li>
	</ul>
	<form method="post" enctype="multipart/form-data" id="tech_main" name="tech_options">
<?php 
	$settings = get_option('techozoic_options');
	foreach ($options as $value) {
		if ($value['display'] != "style"){
			$id = $value['id'];
			$std = $value['std'];
			if ($value['type'] == "header") { 
				if ($value['position'] == "1") { ?>
					<div id="<?php echo $value['tab_id']; ?>" class="tabbercontent">
					<table class="optiontable">
	<?php 			} else { ?>
					</table>
					</div>
					<div id="<?php echo $value['tab_id']; ?>" class="tabbercontent">
					<table class="optiontable">
	<?php 			} ?>
				<tr valign="middle"><td colspan="2"><h3><a name="<?php echo $value['anchor']; ?>"></a><?php echo $value['name']; ?></h3></td></tr>
	<?php 		} 
			if ($value['type'] == "text") { 
				echo $value['before'] ?>        
				<tr valign="top"> 
					<th scope="top"><?php echo $value['name']; ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="width:50%;text-align:center;" valign="top"><small><?php echo $value['desc']?></small></td>
	<?php 		} ?>
					<td>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if( $settings[$id]  != "") { echo stripslashes($settings[$id]); } else { echo $value['std']; } ?>" size="<?php echo $value['size']; ?>" <?php echo $value['java']; ?>/>
	<?php 			echo $value['text'];
				echo $value['tooltip']; ?>    
				</td>
				</tr>
				<tr><td colspan="2"><hr /></td></tr>
	<?php 			echo $value['after']; 
				echo $value['last']; 
			} elseif ($value['type'] == "select") { ?>
				<tr valign="middle"> 
					<th scope="row"><?php echo $value['name']; ?><?php if (isset($value['image'])){ ?>
				<br /><img src="<?php bloginfo('template_directory') ?>/<?php echo $value['image']; ?>" alt="<?php echo $value['name']; ?>" /><?php } ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="50%;text-align:center;" valign="top"><small><?php echo $value['desc']?></small></td>
	<?php 		} ?>
					<td>
						<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" <?php echo $value['java']; ?>>
	<?php 			foreach ($value['options'] as $option) { ?>
							<option<?php if ( $settings[$id]  == $option) { echo ' selected="selected"'; }?>><?php echo $option; ?></option>
	<?php 			} ?>
						</select>
					</td>
					</tr>
				<tr><td colspan="2"><hr /></td></tr>
	<?php 			echo $value['after'];
				echo $value['last'];

			} elseif ($value['type'] == "checkbox") { ?>
				<tr valign="middle"> 
					<th scope="row"><?php echo $value['name']; ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="50%;text-align:center;" valign="top"><small><?php echo $value['desc']?></small></td>
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
	
	<?php 			echo $value['after'];
				echo $value['last'];

			} elseif ($value['type'] == "wp_list") { ?>
				<tr valign="middle"> 
					<th scope="row"><?php echo $value['name']; ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="width:50%;text-align:center;" valign="top"><small><?php echo $value['desc']?></small></td>
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
				
		 } elseif ($value['type'] == "upload") { ?>
				<tr valign="middle"> 
					<th scope="row"><?php echo $value['name']; ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="width:50%;text-align:center;" valign="top"><small><?php echo $value['desc']?></small></td>
	<?php 		} ?>
					 <td>
			<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id'];?>" type="file" <?php echo $value['java']; ?>/>
			</td>
		</tr>
	<?php			if ($settings[$id] != "") { ?>
		<tr valign="middle">
					<th scope="row">Selected:</th><td>
	<span id ="<?php echo $value['id'];?>_selected_bg" style="display:block;width:100px;height:100px;background-image:url(<?php echo $settings[$id];?>)">
		</td></tr>
		<?php				} ?>
				<tr valign="middle"> 
					<th scope="row">Choose Existing</th><td>
		<select name="<?php echo $value['id']; ?>_select" id="<?php echo $value['id']; ?>_select" onchange="image_preview('<?php echo WP_CONTENT_URL ?>','<?php echo $value['id']?>')">
		<option>Select Image</option>
	<?php
		$path = WP_CONTENT_DIR. "/techozoic/images/backgrounds/";
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
					<th scope="row">Preview:</th><td>
					<span id="<?php echo $value['id']?>_preview_image"></span>
		</td></tr>

			<tr valign="middle"> 
					<th scope="row">Reset - Check and Save Options to Clear</th><td><input name="<?php echo $value['id'];?>_reset" type="checkbox" /></td></tr>
				<tr><td colspan="2"><hr /></td></tr>
	<?php 			echo $value['after'];
				echo $value['last'];
		
			} elseif ($value['type'] == "radio") { ?>
				<tr valign="middle"> 
					<th scope="row"><?php echo $value['name']; ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="width:50%;text-align:center;" valign="top"><small><?php echo $value['desc']?></small></td>
	<?php 		} ?>
					<td>
	<?php 			foreach ($value['options'] as $option) { 
					echo $option; ?><input name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php echo $option; ?>" <?php if (  $settings[$id]  == $option) { echo 'checked="checked"'; } ?> <?php echo $value['java']; ?>/>|
	<?php 			} ?>
					</td>
					</tr>
				<tr><td colspan="2"><hr /></td></tr>
	<?php 			echo $value['after']; 
				echo $value['last'];
			} elseif ($value['type'] == "textarea") { ?>

					<tr valign="top"> 
					<th scope="row"><?php echo $value['name']; ?></th>
	<?php	if(isset($value['desc'])){?>
				</tr>
				<tr valign="middle"> 
					<td style="width:50%;text-align:center;" valign="top"><small><?php echo $value['desc']?></small></td>
	<?php 		} ?>
					<td>
						<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="40" rows="10"><?php if (  $settings[$id]  != "") { echo stripslashes($settings[$id]) ; } else { echo $value['std']; } ?>
	</textarea>

					</td>
					</tr>
				<tr><td colspan="2"><hr /></td></tr>
	<?php 			echo $value['after']; 
				echo $value['last'];
			} 
		}//End If
	}//End foreach loop 
?>
	<div id="tech_buttons">
	<div class="tech_bottom">
	</div>
	<div class="tech_bottom2">
		<a name="submit"></a>
		<span class="tech_submit submit save">
			<input name="save" id="save_button" type="submit" value="Save changes" />    
			<input type="hidden" name="action" value="save" />
		</span>
		</form>
		<form method="post" onsubmit="return verify()">
			<span class="tech_submit submit reset">
				<input name="reset" type="submit" value="Reset" />
				<input type="hidden" name="action" value="reset" />
			</span>
		</form>
	</div>
	</div>
		<div id="note" class="tabbercontent">
		<a name="note"></a>
		<h2>Notes</h2>
		<a name="3"></a><h3>SEO Features:</h3>
		<p>Duplicate Content Fix - for comment pagination <br />Meta Keywords include tags and categories<br /> Meta Description from post excerpt on single page view</p>
		<a name="1"></a><h3>Rotating through all header images:</h3>
		<p>You may also add your own images to have them displayed randomly.  If you place your images in the <em>wp-content/themes/techozoic-fluid/images/headers/</em> folder they will be displayed along with the other images at random.  The best dimensions for your images are 1000px Wide X 200px High.</p>
		<a name="2"></a><h3>Header Images</h3>
		<p><strong><a href="admin.php?page=techozoic_header_admin">New Header Image selection and uploading</a></strong>.  <br/>You can now upload your custom headers and select them from this page.  You just need to upload using the form and then select the header from the list.  <br />You can display your own header image permanently by specifying the full url to the image.  Please remember it is bad practice to <a href="http://en.wikipedia.org/wiki/Inline_linking">hotlink</a> to an image, so please upload the image before linking.</p>
		<a name="4"></a><h3>Proper CSS Structure</h3>
		<p><code>#id {color:#ffffff;}</code><br />
		<code>.class {color:#ffffff;}</code><br />
		<a href="http://www.w3schools.com/Css/default.asp">W3Schools Resource</a></p>
		<h3>Having Problems</h3>
		<p>Feel free to visit my <a href="http://clark-technet.com/theme-support/techozoic">support forum</a>.</p>
		<h2>Change log</h2>
		<a href="<?php echo get_bloginfo('template_directory')?>/changelog.php" onclick="return changelog('<?php echo get_bloginfo('template_directory')?>/changelog.php')">View Change Log</a>
		</div>
		<?php techozoic_footer(); ?>
		</div>
		<script type="text/javascript">
			tabsetup();
		</script>
		
		</div>
		
<?php
} //End function mytheme_admin()
function techozoic_header_admin() {
	include_once(TEMPLATEPATH . '/options/header-admin.php');
}
function techozoic_style_admin() {
	include_once(TEMPLATEPATH . '/options/style-admin.php');
}
function techozoic_export_admin() {
	include_once(TEMPLATEPATH . '/options/export-admin.php');
}
function techozoic_top_menu() {
	echo '<ul class="subsubsub">
		<li><a href="admin.php?page=techozoic_main_admin">General Settings</a> | </li>
		<li><a href="admin.php?page=techozoic_header_admin">Header Settings</a> | </li>
		<li><a href="admin.php?page=techozoic_style_admin">CSS Settings</a> | </li>
		<li><a href="admin.php?page=techozoic_export_admin">Export/Import Settings</a></li>
	</ul>
	<div style="clear:both"></div>';
}
function techozoic_footer() {
	echo '<h4>Theme Option page for '. $themename .'&nbsp; | &nbsp; Framework by <a href="http://clark-technet.com/" title="Jeremy Clark">Jeremy Clark</a></h4>';
	echo '<small>Social Network Icons provided by <a href="http://komodomedia.com" target="_blank">komodomedia.com</a>';
}
add_action('admin_menu', 'techozoic_add_admin'); 

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

function controlpanel_css() {
$path = get_bloginfo('template_directory');
	$head = "<link rel='stylesheet' type='text/css' href='" . $path . "/options/options.css'/>\n";
	$head .= "<script type='text/javascript' src='" . $path . "/js/controlpanel.js'></script>\n";
	$head .= "<script type='text/javascript' src='" . $path . "/js/tabcontent.js'></script>\n";
	$head .= "<script type='text/javascript' src='" . $path . "/js/jscolor/jscolor.js'></script>\n";
	$head .= "<script type='text/javascript'>\n";
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
	if ($_GET['page'] == "techozoic_main_admin" || $_GET['page'] == "techozoic_header_admin" || $_GET['page'] == "techozoic_style_admin" || $_GET['page'] == "techozoic_export_admin") {
		add_action('admin_head', 'controlpanel_css');
		add_action('admin_print_styles','tech_admin_thickbox');
	}
}
add_action('admin_head','tech_menu_button_css');
?>