<div id="l_sidebar" class="sidebar"> 
<ul>
<?php 	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('Left Sidebar','techozoic')) ) {
		global $user_ID; 
		if( $user_ID ) {
			if( current_user_can('edit_themes') ) { ?>
			<li><h2 class="widgettitle"><?php _e('Default Widgets' ,'techozoic')?></h2>
				<?php printf(__('Widgets below are default.  These will be replaced when customizing using %s Widget Admin</a>','techozoic'),'<a href="' . get_bloginfo('wpurl') . '/wp-admin/widgets.php" title="' . __('Widgets','techozoic') . '">'); ?>
			</li>
<?php		}
		}
?>
		<li><h2 class="widgettitle"><?php _e('Meta','techozoic')?></h2>
			<ul><?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional' ,'techozoic')?>"><?php _e('Valid XHTML' ,'techozoic')?></a></li>
				<li><a href="http://jigsaw.w3.org/css-validator/check/referer"><?php _e('Valid CSS' ,'techozoic')?></a></li>
				<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.' ,'techozoic')?>">WordPress</a></li>
				<?php wp_meta(); ?>
			</ul>
		</li>
	
<?php	 	if ( function_exists('wp_tag_cloud') ) {
			if (function_exists('wp_count_terms')) {
				$numtags = wp_count_terms('post_tag', 'ignore_empty=false');
				if ($numtags>0) {
?>						<li><h2 class="widgettitle"><?php _e('Tags','techozoic')?></h2>
<?php	 						wp_tag_cloud('format=list&largest=8&order=DESC&orderby=count&number=5'); ?>
						</li>
<?php	 			} 
			} 
		} 
	} 
?>
</ul>
</div>
