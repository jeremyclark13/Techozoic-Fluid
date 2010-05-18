<?php
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
	<div class="tech_head">
	<?php techozoic_top_menu(); ?>
	<img src="<?php echo get_bloginfo('template_directory')?>/images/techozoic-logo.png" alt="Techozoic Fluid Logo" class="alignleft" style="margin-right:5px;"><h2><?php echo $themename;?> Style Settings</h2></div>
	<div id="style">
<form method="post" enctype="multipart/form-data" id="tech_main" name="tech_options_style">
<table class="optiontable">
<?php 
	$settings = get_option('techozoic_options');
	foreach ($options as $value) {
		if ($value['display'] == "style"){
			$id = $value['id'];
			$std = $value['std'];
			if ($value['type'] == "text") { 
				echo $value['before'] ?>        
				<tr valign="top"> 
					<th scope="row"><?php echo $value['name']; ?></th>
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
					<td style="width:50%;text-align:center;" valign="top"><small><?php echo $value['desc']?></small></td>
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
		} else {}
	}//End foreach loop 
?>
</table>
	<div id="tech_buttons" style="display:block">
	<div class="tech_bottom">
	</div>
	<div class="tech_bottom2">
		<a name="submit"></a>
		<span class="tech_submit submit save">
			<input name="save" type="submit" value="Save changes" />    
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
<?php		

function get_include_contents($filename) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    return false;
}
$string = get_include_contents(TEMPLATEPATH .'/style.php');
?>
<h2>Static CSS</h2>
<p> If you have set the Static CSS option to Static you may chose to either copy and paste this code from here to the style.css file using the WordPress code editor or use the button below to automatically overwrite the style.css with the contents below. </p>
<p>A backup file is created as style.css.bu if any errors occur.  Also the original style.css can be restored by clicking Reset Style.css. <strong>-Use at your own risk</strong>.<br /><small>All changes made to style.css file are overwritten with theme updates</small>
</p>

<form method="post" onsubmit="return stylecopy()">
<?php
$dir = TEMPLATEPATH;
	if (is_writable($dir)) {
?>
<span class="tech_submit submit save">
<input name="tech_style_copy" type="submit" value="Copy to Style.css" />
<input name="tech_style_restore" type="submit" value="Restore Style.css backup" /> 
<input name="tech_style_copy_reset" type="submit" value="Reset Style.css" />	
</span>
<?php 	} else {
		echo "<div class=\"updated fade\">Please make sure <strong>". TEMPLATEPATH . "</strong> is writable to enable automatic copying of stylesheet.</div>"; 
	}?>
<textarea cols="100" rows="20" onclick="javascript:select();" name="style" readonly="readonly"><?php echo $string;?></textarea>
</form>
<div style="clear:both"></div>
</div>
		<?php techozoic_footer(); ?>
		</div>