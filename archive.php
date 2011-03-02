<?php get_header(); 	
get_tech_options();
global $tech;
$date_format = get_option('date_format');	
	if ($tech['home_sidebar'] == "Yes")  tech_show_sidebar("l");?>

	<div id="content" class="<?php if ($tech['home_sidebar'] == "Yes") { echo "narrow"; }else {echo "wide";}?>column">

		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>				
		<h2 class="pagetitle"><?php printf(__('Archive for the %s Category','techozoic'), single_cat_title('',false)); ?></h2>
		
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php printf(__('Archive for %s' ,'techozoic'), get_the_time('F jS, Y')); ?></h2>
		
	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php printf(__('Archive for %s' ,'techozoic'), get_the_time('F, Y')); ?></h2>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php printf(__('Archive for %s' ,'techozoic'), get_the_time('Y')); ?></h2>
		
	  <?php /* If this is a search */ } elseif (is_search()) { ?>
		<h2 class="pagetitle"><?php _e('Search Results' ,'techozoic')?></h2>
		
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php _e('Author Archive' ,'techozoic')?></h2>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><?php _e('Blog Archives' ,'techozoic')?></h2>

		<?php } ?>		
<div class="navigation">
<div class="alignleft"><?php posts_nav_link(' ',' ',__('&laquo; Older Entries' , 'techozoic')) ?></div>
<div class="alignright"><?php posts_nav_link(' ',__('Newer Entries &raquo;' , 'techozoic'),' ') ?></div>
	</div>
		<?php while (have_posts()) : the_post(); ?>
		<div class="post">
				<h2 id="post-<?php the_ID(); ?>" class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','techozoic'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
				<small><?php the_time($date_format) ?></small>
				
				<div class="entry">
<?php 			if ( ( is_category() && tech_excerpt('Category Archive') ) || ( is_year() && tech_excerpt('Yearly Archive') ) || ( is_month() && tech_excerpt('Monthly Archive') ) ){
					the_excerpt();
				} else {
					the_content(__('Read the remainder of this entry &raquo;'  , 'techozoic')); 
				}
				$posttags = get_the_tags();
				if (!empty($posttags)) { ?>
					<div class="tags"><small><?php the_tags(); ?></small></div>
				<?php 
				}  ?>
				</div>
<?php			if ( ( is_category() && tech_icons('Category Archive') ) || ( is_year() && tech_icons('Yearly Archive') ) || ( is_month() && tech_icons('Monthly Archive') ) ){?>
				<div class="top">
				<?php tech_social_icons($home=true); ?><a href="#top"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/top.png" border="0" alt="TOP" title="<?php _e('To the top' , 'techozoic') ?>" /></a>
				</div>
<?php			}?>
				<p class="postmetadata"><?php printf(__('Posted in %s' ,'techozoic'), get_the_category_list(', '));?> | <?php edit_post_link(__('Edit' ,'techozoic'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments &#187;' ,'techozoic'), __('1 Comment &#187;' ,'techozoic'), _n('% Comment &#187;' , '% Comments &#187',get_comments_number(),'techozoic')); ?></p> 

			</div>
	
		<?php endwhile; ?>
<div class="navigation">
<div class="alignleft"><?php posts_nav_link(' ',' ',__('&laquo; Older Entries' , 'techozoic')) ?></div>
<div class="alignright"><?php posts_nav_link(' ',__('Newer Entries &raquo;' , 'techozoic'),' ') ?></div>
</div>
	
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found' ,'techozoic')?></h2>
	<?php endif; ?>
		
	</div>
<?php 	if ($tech['home_sidebar'] == "Yes")  tech_show_sidebar("r");
	get_footer(); ?>