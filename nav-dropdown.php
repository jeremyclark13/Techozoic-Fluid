<div id="navwrap">
<ul id="dropdown"> 
<?php
get_tech_options();
global $tech;
if ($tech['nav_home_text']) { 
			$home_text = $tech['nav_home_text'] ;
		} else {
			$home_text =  __('Home','techozoic');
		}
$home_link = get_option('show_on_front');
if ($home_link == "posts" && $tech['nav_home_link'] == "Yes") {?>
	<li class="<?php if (is_home()) echo'current_page_item' ?>"><a href="<?php if (function_exists('home_url')) { echo home_url(); } else { bloginfo('url'); } ?>" title="<?php echo $home_text;?>"><?php echo $home_text;?></a></li>
<?php 
echo tech_nav_link("Before");
}
if (!$tech['nav_exclude_list']){
	$clean_page_list = wp_list_pages('sort_column=menu_order&title_li=&echo=0');
	$clean_page_list = preg_replace('/title=\"(.*?)\"/','',$clean_page_list);
	echo $clean_page_list;
} else {
	$nav_exclude = $tech['nav_exclude_list'];
	$clean_page_list = wp_list_pages("sort_column=menu_order&exclude=".$nav_exclude."&title_li=&echo=0");
	$clean_page_list = preg_replace('/title=\"(.*?)\"/','',$clean_page_list);
	echo $clean_page_list;
}
echo tech_nav_link("After");
?>
</ul>
</div>
