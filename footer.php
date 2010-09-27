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

	<?php	do_action('tech_footer'); ?>
	</p>
</div><!--footer-->
</div><!--footercont"-->
</div><!--pager-->
</div><!--pagel-->
</div><!--page-->
<?php	wp_footer(); ?>
</body>
</html>
