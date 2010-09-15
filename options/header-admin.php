<?php
    	global $themename, $shortname, $options, $tech_error;
    	if ( isset($_REQUEST['saved']) && $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    	if ( isset($_REQUEST['reset']) && $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong> </p></div>';
		if ( isset($_REQUEST['message']) && $_REQUEST['message'] ) {
			if ($_REQUEST['error']) {
				echo '<div id="message" class="updated fade"><p><strong>'. $tech_error[$_REQUEST['error']] .' </strong> </p></div>';
				} else { 
				echo '<div id="message" class="updated fade"><p><strong>Image Uploaded</strong> </p></div>';
				}
			}
	$tech = get_option('techozoic_options');
	$header_folder = TEMPLATEPATH. "/uploads/images/headers";
?>
	<div class="tech_head">
	<?php techozoic_top_menu();?>
	<img src="<?php echo get_bloginfo('template_directory')?>/images/techozoic-logo.png" alt="Techozoic Fluid Logo" class="alignleft" style="margin-right:5px;"><h2><?php echo $themename;?> Header Settings</h2>
	<div style="clear:both;"></div>
		<?php techozoic_links_box();?>
	<div class="tech_form_wrap">
		<h3>Upload Header Image</h3>
		<p>Max Dimensions: 1000 px wide X 200 px high<br />
		Supported format: jpg, jpeg, gif, png <br />
		<em>Recommend format:</em> jpg, jpeg, png<br />
		After image is uploaded it will appear in the list below and can be selected in the list below to be used as the Header Image.</p>
<?php
	$dir = TEMPLATEPATH. "/uploads/images/headers/";
		if (is_writable($dir)) {
?>
			<form enctype="multipart/form-data" encoding="multipart/form-data" method="post">
				<input type="file" name="file" /><br />
				<span class="tech_submit submit save">
				<input type="submit" name="submit" value="Upload" />
				</span><br /><br />
			</form>
<?php 		} else { 
			echo "<div class=\"updated fade\">Please make sure <strong>". $dir . "</strong> is writable to enable upload of headers.</div>"; 
	}?>
		<h3>Header Image Settings</h3>
		<form method="post" name="tech_header_height">
		<table>
		<tr><td>Height of Container: </td><td><input name="header_height" id="header_height_2" type="text" value="<?php echo stripslashes($tech['header_height']);?>" size="5" />px</td></tr>
		<tr><td>Header Image Alignment: </td><td><select name="header_align" id="header_align_2">
                <option <?php if ( $tech['header_align']  == "Left") { echo ' selected="selected"'; }?>>Left</option>
				<option <?php if ( $tech['header_align']  == "Right") { echo ' selected="selected"'; }?>>Right</option>
				<option <?php if ( $tech['header_align']  == "Center") { echo ' selected="selected"'; }?>>Center</option>
            </select>
			</td></tr>
		</table>
		<span class="tech_submit submit save">
		<input name="tech_header_height" type="submit" value="Save Settings" />
		</span>
		</form>
		<br />
		<br />
		</div>
			<div style="clear:both;"></div>
		<div id="headerimgs">
		<h3>Header Images:</h3>
		<div id="header_imgs">
			<div class="filediv small">
				<h3>Rotate Through All Headers</h3>
				<div id="rotate" class="current"><?php if(tech_check_header("Rotate.jpg","rotate")){ echo "<h3><span>" . tech_check_header("Rotate.jpg","rotate") . "</span></h3>" ;}?></div>
				<form method="post" name="tech_header_select" >
				<span class="tech_submit submit save">
				<input name="tech_header_select" type="submit" value="Rotate" />
				<input type="hidden" name="header_select" value="Rotate.jpg" />
				</span>
				</form>
				<br />
			</div>
			<div class="filediv filealt small">
				<h3>No Header Image</h3>
				<div id="none" class="current"><?php if(tech_check_header("none.jpg","none")){ echo "<h3><span>" . tech_check_header("none.jpg","none") . "</span></h3>" ;}?></div>
				<form method="post" name="tech_header_select" >
				<span class="tech_submit submit save">
				<input name="tech_header_select" type="submit" value="No Header Image" />
				<input type="hidden" name="header_select" value="none.jpg" />
				</span>
				</form>
				<br />
			</div>
		
<?php 
	if (file_exists($header_folder)){
		$path = TEMPLATEPATH. "/uploads/images/headers/";
	} else {
		$path = TEMPLATEPATH . "/images/headers/";
	}
	$dir_handle = @opendir($path) or die("Unable to open $path");
	$i = 1;
	$delvars = array();
	function tech_check_header($file , $file_path){
		global $tech;
		$default_headers = array ("Rotate.jpg" , "Random_Lines_1.jpg", "Random_Lines_2.jpg", "Landscape.jpg", "Technology.jpg", "Grunge.jpg","none.jpg");
		if (in_array($file, $default_headers) ){
			$file = substr($file, 0,strrpos($file,'.'));
			if ($tech['header'] == $file){
				return " - Current Selected Header";
			}	
		}
		if ($tech['header_image_url'] == $file_path) {
			return " - Current Selected Header";
		}
	}
	while ($file = readdir($dir_handle)) {
		if($file == "." || $file == ".." || $file == "index.php" || $file == ".svn" )
			continue;
			$img_full_path = $path . '/' . $file;
			$img_info = getimagesize($img_full_path);
			$delvars [] = $file;
			if(($i % 2)==0)
				$alt = "filealt";
			else 
				$alt = "";
			$divid = substr($file, 0,strrpos($file,'.'));
			if (file_exists($header_folder)){
				$file_path = get_bloginfo('template_directory') . "/uploads/images/headers/" . $file;
			} else {
				$file_path = get_bloginfo('template_directory') . "/images/headers/" . $file;
			}

			
?>				<div class="filediv <?php echo $alt; ?>">
				<div id="<?php echo $divid; ?>" class="current">
					<?php if(tech_check_header($file,$file_path)){ echo "<h3><span>" . tech_check_header($file,$file_path) . "</span></h3>" ;}?>
				</div> 
				<h3> <?php echo $file; ?> </h3>
				<a href="<?php echo $file_path; ?>" class="thickbox" rel="headers" title="<?php echo $file; echo tech_check_header($file,$file_path);?>">		<img src="<?php echo $file_path;?>" alt="Click for full size preview of <?php echo $file;?>" />
				</a>
				<br />
				<span class="img_meta">Width: <?php echo $img_info[0];?>px &nbsp;| Height: <?php echo $img_info[1];?>px</span>
				<br /><div class="header_buttons">
				<form method="post" name="tech_header_select" >
				<span class="tech_submit submit save">
				<input name="tech_header_select" type="submit" value="Select This Header" />
				<input type="hidden" name="header_select" value="<?php echo $file ;?>" />
				</span>
				</form>
				<form method="post" name="tech_header_delete" onsubmit="return delverify()">
				<span class="tech_submit submit reset">
				<input name="tech_header_delete" type="submit" value="Delete This Header" /> 
				<input type="hidden" name="header_delete" value="<?php echo $file ;?>" />
				</span>
				</form>
				</div>
				</div>
<?php 	$i++;
	} //End While Loop
	closedir($dir_handle); 
?>

			</div>
			</div>
			</div>
			</div>