<?php 	get_header(); 
	$tech_ii = 1;
	$tech_i = 0;
        $tech_head_ad_code = of_get_option('header_ad_code','');
	if (!empty($tech_head_ad_code)) { ?>
		<div class="aligncenter">
<?php 		$tech_header_ad_code = stripslashes (of_get_option('header_ad_code',''));
                echo do_shortcode($tech_header_ad_code);?>
		</div>
<?php 		$tech_ii++; 
	}
	if (of_get_option('home_sidebar','1') == "1")  tech_show_sidebar("l");
?>

	<div id="content" class="<?php if (of_get_option('home_sidebar','1') != "1" || of_get_option('sidebar_pos','3-col') == '1-col') { echo "wide"; }else {echo "narrow";}?>column">
	<div class="navigation">
	<div class="alignleft"><?php posts_nav_link(' ',' ',__('&laquo; Older Entries' , 'techozoic')) ?></div>
	<div class="alignright"><?php posts_nav_link(' ',__('Newer Entries &raquo;' , 'techozoic'),' ') ?></div>
	</div>
<?php   get_template_part( 'loop', 'index'); ?>
	<div class="navigation">
	<div class="alignleft"><?php posts_nav_link(' ',' ',__('&laquo; Older Entries' , 'techozoic')) ?></div>
	<div class="alignright"><?php posts_nav_link(' ',__('Newer Entries &raquo;' , 'techozoic'),' ') ?></div>
		</div>
	</div>
<?php 	if (of_get_option('home_sidebar','1') == "1")  tech_show_sidebar("r");
	get_footer(); 
?>