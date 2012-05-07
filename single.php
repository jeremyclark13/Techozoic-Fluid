<?php get_header();
$date_format = get_option('date_format');
$tech_sidebar = get_post_meta($post->ID, "Sidebar_value", $single = true);
if (empty($tech_sidebar)){
    $tech_sidebar = "unset";
}
if ((of_get_option('single_sidebar','0') == "1" && $tech_sidebar == "unset") || $tech_sidebar == "on") { tech_show_sidebar("l");} ?>
<div id="content" class="<?php if ((of_get_option('single_sidebar','0') == "1" && $tech_sidebar == "unset") || $tech_sidebar == "on") { echo "narrow"; }else {echo "wide";}?>column">
<?php
    $tech_sing_ad_code = of_get_option('sing_ad_code','');
    if (!empty($tech_sing_ad_code) && of_get_option('sing_ad_pos','above') == "above") { ?>
        <div class="aligncenter">
            <?php $tech_sing_ad_code = stripslashes ($tech_sing_ad_code);
            echo do_shortcode($tech_sing_ad_code);?>
        </div>
<?php }
if (have_posts()) {
	while (have_posts()) {
		the_post(); ?>
		<div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
		</div>
		<div style="clear:both"></div>
		<div class="post" id="post-<?php the_ID(); ?>">
                <div class="toppost">
		<a href="<?php echo home_url(); ?>" title="<?php printf(__('Go back to %s','techozoic'), get_bloginfo('name')); ?>" class="social homelink"></a>&nbsp;<?php if (tech_icons('single')){ tech_social_icons($home=false); } ?>
		</div>
		<h1 class="post_title">
                    <?php if (get_the_title() != ""){ ?>
                        <?php the_title(); ?>
                    <?php } else {
                        echo get_the_date();
                        echo ' ';
                        the_time();
                    }?>
                </h1>
<?php do_action('tech_before_sing_content');?>	
		<div class="singlepost entry">
<?php 		if(function_exists('the_post_thumbnail')) { the_post_thumbnail('single-post-thunbnail'); }?>
<?php 		the_content('<p class="serif">'.__('Read the rest of this entry','techozoic'). '&raquo;</p>'); 
		wp_link_pages(); 
?>
		<div class="postmetadata alt">
                <?php if (get_the_author_meta('description', get_the_author_meta('ID')) != ''){ ?>
                <div class="author-info">
                    <div class="alignleft"><?php echo get_avatar(get_the_author_meta('ID'),64); ?></div>
                    <h5><?php _e('About','techozoic'); ?> <?php the_author_posts_link();?></h5>
                    <?php echo wpautop(get_the_author_meta('description', get_the_author_meta('ID'))); ?>
                </div>
                <?php } ?>
                <div class="single-time"><?php echo get_the_time($date_format); ?> @ <?php echo get_the_time(); ?></div>
                <div class="single-category"><?php echo get_the_category_list(', ');?></div>
                <?php the_tags(__('<div class="single-tags">','techozoic'),', ', '</div>'); ?>
                <div class="clear"></div>
                <?php edit_post_link(__('Edit this page.' ,'techozoic'), '<br /><p>', '</p>'); ?>
		</div>
		</div>
<?php do_action('tech_after_sing_content');?>
		</div>
<?php
    $tech_sing_ad_code = of_get_option('sing_ad_code','');
    if (!empty($tech_sing_ad_code) && of_get_option('sing_ad_pos','above') == "below") { ?>
        <div class="aligncenter">
            <?php $tech_sing_ad_code = stripslashes ($tech_sing_ad_code);
            echo do_shortcode($tech_sing_ad_code);?>
        </div>
<?php }
	comments_template(); 
		} //End While Loop 
} else { 
?>
	<p><?php _e('Sorry, no posts matched your criteria.','techozoic')?></p>
<?php
} //End If loop
?>	</div>
<?php 
if ((of_get_option('single_sidebar','0') == "1" && $tech_sidebar == "unset") || $tech_sidebar == "on") { tech_show_sidebar("r"); }
get_footer(); ?>