<?php    	
	global $themename, $shortname, $options, $tech_error;
?>
	<div class="tech_head tech_wrap">
		<?php techozoic_admin_tabs('delete'); ?>
		<h2 style="border:none"><?php printf(__("%s Delete Settings","techozoic"),$themename);?></h2>
		<div style="clear:both;"></div>
			<?php techozoic_links_box();?>
		<div class="tech_form_wrap">
			<h3><?php _e('Delete Settings','techozoic') ?></h3>
			<p><?php _e('Clicking this button below will remove all theme settings from database and deactivate the theme.  <strong>This is irreversible.</strong>','techozoic') ?></p>
			<form method="post" onsubmit="return delsettings()">
				<span class="tech_submit submit save">
					<input name="delete" class="button-primary" type="submit" value="<?php _e('Delete Settings','techozoic') ?>"/>
					<input type="hidden" name="action" value="delete-settings" />
					<?php wp_nonce_field('techozoic_form_delete','techozioc_nonce_field_delete'); ?>
				</span>
			</form>	
		</div>
	</div>