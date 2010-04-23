<?php /*
Template Name: Tag Archive
This is an example tag archive page.  If you add this to your theme,  and create a page using the "Tag Archive" template (it'll be there in the list)
you'll get a tag cloud displaying on a page.
*/ ?>
<?php get_header(); ?>

	<div id="content" class="widecolumn">
<div class="post">	
<h2 class="center">Tag Archive</h2><br />
	<?php wp_tag_cloud(''); ?>
<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
<div style="clear:both"></div>
<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
<div class="tagcont">
			<h2 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>

			<div class="entry">
				<?php the_excerpt(); ?>
			</div>
</div>
	<?php endwhile; ?>
	<?php endif; ?>
<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>


</div>
</div>	
<?php get_footer(); ?>
