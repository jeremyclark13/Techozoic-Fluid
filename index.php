<?php 	get_header(); 
get_tech_options();
global $tech;

	$tech_ii = 1;
	$tech_i = 0;	
	if (!empty($tech['header_ad_code'])) { ?>
		<div class="aligncenter">
<?php 		echo stripslashes ($tech['header_ad_code']); ?>
		</div>
<?php 		$tech_ii++; 
	}
	if ($tech['column'] == 3 &&  $tech['home_sidebar'] == "Yes" && $tech['sidebar_pos'] == "Sidebar - Content - Sidebar") {
		include (TEMPLATEPATH . '/l_sidebar.php'); 
	}
?>

	&nbsp;<div id="content" class="<?php if ($tech['home_sidebar'] == "Yes") { echo "narrow"; }else {echo "wide";}?>column">
	<div class="navigation">
	<div class="alignleft"><?php posts_nav_link(' ',' ',__('&laquo; Older Entries' , 'techozoic')) ?></div>
	<div class="alignright"><?php posts_nav_link(' ',__('Newer Entries &raquo;' , 'techozoic'),' ') ?></div>
	</div>
	<div style="clear:both;width:100%;margin:-20px;"></div>
<?php 	if (have_posts()) {
		while (have_posts()) { 
			the_post();

?>
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<div class="heading"><div class="post_date">
			<div class="date_post"><?php the_time('j') ?></div>
			<div class="month_post"><?php the_time('M') ?></div></div>
			<div class="commentdiv"><h2><?php comments_popup_link('0', '1', '%'); ?></h2></div>	
			<h2 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','techozoic'), get_the_title()); ?>"><?php the_title(); ?></a></h2>	
			<small><?php _e('By') ?> <?php the_author() ?>&nbsp;|&nbsp;<?php printf(__('Filed in %s' , 'techozoic'), get_the_category_list(', ')) ?><?php edit_post_link(__('&nbsp;|&nbsp; Edit.','techozoic'), '', ''); ?></small>
			</div><div style="clear:both"></div>
			<div class="entry">
<?php 			if(function_exists('the_post_thumbnail')) { the_post_thumbnail(); }?>
<?php 			the_content(__('Read the remainder of this entry &raquo;') , 'techozoic'); ?>
<?php 			if ( comments_open() ) { ?>
				<p>
<?php 			comments_popup_link(__('Be the first to comment' ,'techozoic'), __('1 Comment. Join the Conversation' ,'techozoic'), __ngettext('% Comment so far. Join the Conversation' , '% Comments so far. Join the Conversation',get_comments_number(),'techozoic'), 'comments-link', __('Comments Closed' ,'techozoic')); ?>
				</p>
<?php			tech_comment_preview($post->ID,3); ?>				
<?php			} 

 			$posttags = get_the_tags();
			if (!empty($posttags)) { ?>
				<div class="tags"><small><?php the_tags(); ?></small></div><?php 
			} 
?>
			</div>
			<div class="top">
			<a href="http://digg.com/submit?phase=2&amp;url=<?php echo get_permalink() ?>&amp;title=<?php print rawurlencode(the_title('', '', false)); ?>">
			<img src="<?php bloginfo('template_directory'); ?>/images/digg.gif" title="<?php _e('DIGG this!' , 'techozoic') ?>" alt="digg" /></a>&nbsp;
			<a href="http://del.icio.us/post?url=<?php echo get_permalink() ?>"><img src="<?php bloginfo('template_directory'); ?>/images/delicious.gif" title="<?php _e('del.icio.us this!' , techozoic) ?>" alt="del.icio.us" /></a>&nbsp;
<?php 			if ('open' == $post->ping_status) { 
?>				<a href="<?php trackback_url(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','techozoic'), get_the_title()); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/trackback.gif" title="<?php _e('Trackback' , 'techozoic'); ?>" alt="TRACK" /></a>&nbsp;
<?php 			} 
?>			<a href="#top"><img src="<?php bloginfo('template_directory'); ?>/images/top.gif" border="0" alt="TOP" title="<?php _e('To the top' , 'techozoic') ?>" /></a></div>
			</div>
			<div class="entry_spacer"></div>

<?php 		if (!empty($tech['ad_code']) && $tech_ii <= 3) {
				$tech_i++;
				if($tech_i == $tech['ad_int']) { ?>
					<div class="aligncenter">
<?php 					echo stripslashes ($tech['ad_code']); ?>
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
<?php 	if ($tech['column'] != 1 && $tech['home_sidebar'] == "Yes")  get_sidebar(); ?>
<?php 	if ($tech['column'] == 3 && $tech['home_sidebar'] == "Yes" && $tech['sidebar_pos'] =="Content - Sidebar - Sidebar") {
		include (TEMPLATEPATH . '/l_sidebar.php');
	}
	get_footer(); 
?>
