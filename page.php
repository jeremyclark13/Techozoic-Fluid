<?php 	get_header(); 
get_tech_options();
global $tech;
$tech_disable_sidebar = get_post_meta($post->ID, "Sidebar_value", $single = true);
if ($tech['single_sidebar'] == "Yes" && $tech_disable_sidebar != "on") { tech_show_sidebar("l");} 
?>
	<div id="content" class="<?php if ($tech['single_sidebar'] == "Yes" && $tech_disable_sidebar != "on") { echo "narrow"; }else {echo "wide";}?>column">
<?php	if (strlen(wp_title('', false))>0) {
?>		<h1 class="post_title">
		<?php wp_title('', 'display'); 
?>		</h1>
<?php 	}
	if (have_posts()) { 
		while (have_posts()) { 
			the_post(); 
?>
			<div class="post" id="post-<?php the_ID(); ?>">
			<div class="singlepost entry">
<?php 			if(function_exists('the_post_thumbnail')) the_post_thumbnail(); 
 			the_content('<p class="serif">'.__('Read the rest of this page','techozoic'). '&raquo;</p>'); 
			wp_link_pages('<p><strong>'.__('Pages:','techozoic').'</strong> ', '</p>', 'number'); 
?>
			</div>
			</div>
<?php 		} //End While Loop
	} //End If have_posts
	edit_post_link(__('Edit this page.' ,'techozoic'), '<p>', '</p>'); ?>
	<br />
<?php 	comments_template(); 
?>	</div>
<?php
	if ($tech['single_sidebar'] == "Yes"  && $tech_disable_sidebar != "on") { tech_show_sidebar("r"); }
	get_footer(); 
?>