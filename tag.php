<?php /*
Template Name: Tag Archive
This is an example tag archive page.  If you add this to your theme,  and create a page using the "Tag Archive" template (it'll be there in the list)
you'll get a tag cloud displaying on a page.
*/ ?>
<?php get_header(); ?>

	<div id="content" class="widecolumn">
<div class="post">	
<h2 class="center"><?php _e("Tag Archive","techozoic");?></h2><br />
	<?php wp_tag_cloud(''); ?>
	<div class="navigation">
	<div class="alignleft"><?php posts_nav_link(' ',' ',__('&laquo; Older Entries' , 'techozoic')) ?></div>
	<div class="alignright"><?php posts_nav_link(' ',__('Newer Entries &raquo;' , 'techozoic'),' ') ?></div>
	</div>
<div style="clear:both"></div>
<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
<div class="tagcont">
			<h2 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','techozoic'), get_the_title()); ?>"><?php the_title(); ?></a></h2>

			<div class="entry">
<?php 			if (tech_excerpt('Tag Archive')){
					the_excerpt();
				} else {
					the_content(__('Read the remainder of this entry &raquo;'  , 'techozoic')); 
				}?>
			</div>
<?php		if (tech_icons('Tag Archive')){	?>	
				<div class="top">
				<?php tech_social_icons($home=true); ?><a href="#top"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/top.png" border="0" alt="TOP" title="<?php _e('To the top' , 'techozoic') ?>" /></a>
				</div>
<?php		}?>
</div>
	<?php endwhile; ?>
	<?php endif; ?>
	<div class="navigation">
	<div class="alignleft"><?php posts_nav_link(' ',' ',__('&laquo; Older Entries' , 'techozoic')) ?></div>
	<div class="alignright"><?php posts_nav_link(' ',__('Newer Entries &raquo;' , 'techozoic'),' ') ?></div>
	</div>


</div>
</div>	
<?php get_footer(); ?>
