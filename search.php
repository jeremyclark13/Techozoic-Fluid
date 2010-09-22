<?php 	get_header(); 
get_tech_options();
global $tech;
	if ($tech['column'] == 3 && $tech['sidebar_pos'] == "Sidebar - Content - Sidebar" && $tech['single_sidebar'] == "Yes") {
		include (TEMPLATEPATH . '/l_sidebar.php'); 
	}
?>
	<div id="content" class="<?php if ($tech['single_sidebar'] == "Yes") { echo "narrow"; }else {echo "wide";}?>column">
<?php 	if (have_posts()) { ?>
		<h2 class="pagetitle"><?php _e('Search Results for ' ,techozoic);?><span class="search-terms">
<?php	/* Search Count */ 
		$allsearch = &new WP_Query("s=$s&showposts=-1"); 
		$key = wp_specialchars($s, 1); 
		$count = $allsearch->post_count; 
		echo $key; 
?>
		</span> &mdash;
<?php	echo $count . ' ';
		_e('articles','techozoic'); 
		wp_reset_query(); ?>
		</h2>
		<div class="navigation">
	<div class="alignleft"><?php posts_nav_link(' ',' ',__('&laquo; Older Entries' , 'techozoic')) ?></div>
	<div class="alignright"><?php posts_nav_link(' ',__('Newer Entries &raquo;' , 'techozoic'),' ') ?></div>
		</div>
<?php 		while (have_posts()) { 
			the_post(); 
			$title = get_the_title();
			$excerpt = get_the_excerpt();
			$keys= explode(" ",$s);
			$title = preg_replace('/('.implode('|', $keys) .')/iu','<strong class="search-excerpt">\0</strong>',$title);
			$excerpt = preg_replace('/('.implode('|', $keys) .')/iu','<strong class="search-excerpt">\0</strong>',$excerpt);
?>
			<div class="post">
			<h3 id="post-<?php the_ID(); ?>" class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','techozoic'), get_the_title()); ?>"><?php echo $title; ?></a></h3>
			<div class="entry">
			<?php echo $excerpt;?>
			</div>
			<small><?php the_time('l, F jS, Y') ?>
<?php			if (function_exists('get_the_tags')) {
				$tag = get_the_tags();
			}
			if ( function_exists('the_tags') ) { 
				if (strlen($tag)>0) {
?>
				<p><?php the_tags(); ?></p>
<?php 				} 
			} 
?>			</small>
			<p class="postmetadata"><?php printf(__('Posted in %s' ,'techozoic'),get_the_category_list(', '));?> | <?php edit_post_link(__('Edit' ,'techozoic'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments &#187;' ,'techozoic'), __('1 Comment &#187;' ,'techozoic'), __ngettext('% Comment &#187;' , '%Comments &#187',get_comments_number(),'techozoic')); ?></p> 
			</div>
<?php 		} //End While Loop ?>

		<div class="navigation">
	<div class="alignleft"><?php posts_nav_link(' ',' ',__('&laquo; Older Entries' , 'techozoic')) ?></div>
	<div class="alignright"><?php posts_nav_link(' ',__('Newer Entries &raquo;' , 'techozoic'),' ') ?></div>
		</div>
<?php 	} else { ?>
		<h2 class="center"><?php _e('No posts found. Try a different search?' ,'techozoic')?></h2>
<?php 	} //End If Loop
?>
	</div>
<?php 	get_sidebar(); 
	if ($tech['column'] == 3 && $tech['sidebar_pos'] =="Content - Sidebar - Sidebar" && $tech['single_sidebar'] == "Yes") {
		include (TEMPLATEPATH . '/l_sidebar.php'); 
	}
	get_footer(); 
?>
