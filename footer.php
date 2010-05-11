<?php 
get_tech_options();
global $tech;
?>
<hr />
<div id="footermain">
<div id="footer">
<div id="footerdivs">
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar('Footer - Limit 3 Widgets') ) : ?>
<?php endif; ?>
</div>
<div style="clear:both"></div>
	<p class="credit">
<?php 	bloginfo('name'); ?> | Techozoic  
<?php	echo $tech['ver']. " ";
	_e('by' ,techozoic);?><a href="http://clark-technet.com/"> Jeremy Clark</a>. | <a href="#top"><?php _e('Top' ,techozoic)?></a><br /><small>
<?php printf(__('%1$d mySQL queries in %2$s seconds.','techozoic'), get_num_queries(),timer_stop(0)); ?>
</small>
<?php	wp_footer(); ?>
	</p>
</div><!--footer-->
</div><!--footercont"-->
</div><!--pager-->
</div><!--pagel-->
</div><!--page-->
</body>
</html>
