<?php 	get_header(); 
get_tech_options();
global $tech;

	$tech_ii = 1;
	$tech_i = 0;	
	if (!empty($tech['header_ad_code'])) { ?>
		<div class="aligncenter">
<?php 		$tech_header_ad_code = stripslashes ($tech['header_ad_code']);
                echo do_shortcode($tech_header_ad_code);?>
		</div>
<?php 		$tech_ii++; 
	}
	if ($tech['home_sidebar'] == "Yes")  tech_show_sidebar("l");
?>

	<div id="content" class="<?php if ($tech['home_sidebar'] != "Yes" || $tech['column'] === 1) { echo "wide"; }else {echo "narrow";}?>column">
	<div class="navigation">
	<div class="alignleft"><?php posts_nav_link(' ',' ',__('&laquo; Older Entries' , 'techozoic')) ?></div>
	<div class="alignright"><?php posts_nav_link(' ',__('Newer Entries &raquo;' , 'techozoic'),' ') ?></div>
	</div>

<?php 	if (have_posts()) {
		while (have_posts()) { 
			the_post();

?>
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<div class="heading"><div class="post_date">
			<div class="date_post"><?php the_time('j') ?></div>
			<div class="month_post"><?php the_time('M') ?></div></div>
			<div class="commentdiv"><?php if ( comments_open() && empty($post->post_password) ) {comments_popup_link('0', '1', '%','comment_num',''); }?></div>	
			<h2 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','techozoic'), get_the_title()); ?>"><?php if( get_the_title() ) { the_title(); } else{ _e('Read More &hellip;','techozoic'); } ?></a></h2>	
			<small><?php _e('By' , 'techozoic') ?> <?php the_author() ?>&nbsp;|&nbsp;<?php printf(__('Filed in %s' , 'techozoic'), get_the_category_list(', ')) ?><?php edit_post_link(__('&nbsp;|&nbsp; Edit.','techozoic'), '', ''); ?></small>
			</div><div style="clear:both"></div>
			<div class="entry">
<?php 			if(function_exists('the_post_thumbnail')) { the_post_thumbnail('thumbnail'); }?>
<?php 			if (tech_excerpt('Main Page')){
					the_excerpt();
				} else {
					the_content(__('Read the remainder of this entry &raquo;'  , 'techozoic')); 
				}?>
<?php 			if ( comments_open()  && empty($post->post_password) ) { ?>
				<div class="post_comment_cont">
<?php 			comments_popup_link(__('Be the first to comment' ,'techozoic'), __('1 Comment. Join the Conversation' ,'techozoic'), _n('% Comment so far. Join the Conversation' , '% Comments so far. Join the Conversation',get_comments_number(),'techozoic'), 'comments-link', __('Comments Closed' ,'techozoic')); ?>
				</div>
<?php			tech_comment_preview($post->ID,3); ?>				
<?php			} 

 			$posttags = get_the_tags();
			if (!empty($posttags)) { ?>
				<div class="tags"><small><?php the_tags(); ?></small></div><?php 
			} 
?>
			</div>
<?php		if (tech_icons('Main Page')){	?>	
				<div class="top">
				<?php tech_social_icons($home=true); ?><a href="#top"><img src="<?php bloginfo('template_directory'); ?>/images/icons/top.png" border="0" alt="TOP" title="<?php _e('To the top' , 'techozoic') ?>" /></a>
				</div>
<?php		}?>
			</div>

<?php 		if (!empty($tech['ad_code']) && $tech_ii <= 3) {
				$tech_i++;
				if($tech_i == $tech['ad_int']) { ?>
					<div class="aligncenter">
<?php 					$tech_ad_code = stripslashes ($tech['ad_code']);
                                        echo do_shortcode($tech_ad_code); ?>
					</div>
<?php 				$tech_i = 0; 
					$tech_ii++; 
				}
			} //End Ad Loop
		} //End While Loop 
?>

		<div class="navigation">
	<div class="alignleft"><?php posts_nav_link(' ',' ',__('&laquo; Older Entries' , 'techozoic')) ?></div>
	<div class="alignright"><?php posts_nav_link(' ',__('Newer Entries &raquo;' , 'techozoic'),' ') ?></div>
		</div>
<?php 	} else { ?>
		<h2 class="center"><?php _e('Not Found' , techozoic) ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here' , 'techozoic') ?>.</p>
<?php 	} ?>

	</div>
<?php 	if ($tech['home_sidebar'] == "Yes")  tech_show_sidebar("r");
	get_footer(); 
?>