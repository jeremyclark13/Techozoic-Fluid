<?php get_header(); 	
$date_format = get_option('date_format');	
if (of_get_option('home_sidebar','1') == "1")  tech_show_sidebar("l");
?>

	<div id="content" class="<?php if (of_get_option('home_sidebar','1') != "1" || of_get_option('sidebar_pos','3-col') == '1-col') { echo "wide"; }else {echo "narrow";}?>column">

		<?php if (have_posts()) { ?>

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

<?php           } 
           }?>		
<div class="navigation">
<div class="alignleft"><?php posts_nav_link(' ',' ',__('&laquo; Older Entries' , 'techozoic')) ?></div>
<div class="alignright"><?php posts_nav_link(' ',__('Newer Entries &raquo;' , 'techozoic'),' ') ?></div>
	</div>
<?php get_template_part( 'loop' , 'archive'); ?>		
		
	</div>
<?php 	if (of_get_option('home_sidebar','1') == "1")  tech_show_sidebar("r");
	get_footer(); ?>