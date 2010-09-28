<?php    	
	global $themename, $shortname, $options, $tech_error;
?>
	<div class="tech_head">
		<?php techozoic_top_menu(); ?>
		<img src="<?php echo get_bloginfo('template_directory')?>/images/techozoic-logo.png" alt="Techozoic Fluid Logo" class="alignleft" style="margin-right:5px;"><h2><?php printf(__("%s Delete Settings","techozoic"),$themename);?></h2>
		<div style="clear:both;"></div>
			<?php techozoic_links_box();?>
		<div class="tech_form_wrap">
			<h3><?php _e('Delete Settings','techozoic') ?></h3>
			<p><?php _e('Clicking this button below will remove all theme settings from database and deactivate the theme.  <strong>This is irreversible.</strong>','techozoic') ?></p>
			<form method="post" onsubmit="return delsettings()">
				<span class="tech_submit submit save">
					<input name="delete" type="submit" value="<?php _e('Delete Settings','techozoic') ?>" style="color:#b00;"/>
					<input type="hidden" name="action" value="delete-settings" />
				</span>
			</form>	
		</div>
	</div>