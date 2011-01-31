<?php    	
	global $themename, $shortname, $options, $tech_error;
    if ( isset($_REQUEST['import']) && $_REQUEST['import'] ) echo '<div id="message" class="updated fade"><p><strong>'. sprintf(__("%s settings imported.","techozoic"),$themename) . '</strong></p></div>';
?>
	<div class="tech_head tech_wrap">
	<?php techozoic_admin_tabs('export'); ?>
	<h2 style="border:none;"><?php printf(__("%s Export/Import Settings","techozoic"),$themename);?></h2>
	<div style="clear:both;"></div>
		<?php techozoic_links_box();?>
		<div class="tech_form_wrap">
	<h3><?php _e('Export Settings','techozoic')?></h3>
	<p><?php _e('Here you can export your current Techozoic settings, this is useful if you plan on copying your current layout to another blog using Techozoic.','techozoic')?></p>
	<form method="post">
		<span class="tech_submit submit save">
			<input name="export" class="button-primary" type="submit" value="<?php _e('Export Settings','techozoic')?>" />
			<input type="hidden" name="action" value="export" />
			<?php wp_nonce_field('techozoic_form_export','techozioc_nonce_field_export'); ?>
		</span>
	</form>	
	<div style="clear:both"></div>
	<h3> <?php _e('Import Settings','techozoic')?></h3>
	<p><?php _e('If you have an export file from Techozoic you can upload it here.  (This will overwrite any current changes)','techozoic')?></p>
	<form enctype="multipart/form-data" encoding="multipart/form-data" method="post">
		<input type="file" name="settings" /><br />
		<span class="tech_submit submit save">
			<input type="submit" name="submit" class="button-primary" value="<?php _e('Import Settings','techozoic')?>" />
			<?php wp_nonce_field('techozoic_form_import','techozioc_nonce_field_import'); ?>
		</span><br /><br />
	</form>
	</div>
</div>