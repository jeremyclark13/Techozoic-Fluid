<div id="navwrap">
<ul id="nav">
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
	<li class="<?php if (is_home()) echo'current_page_item' ?>"><a href="<?php echo home_url(); ?>" title="<?php echo $home_text;?>"><?php echo $home_text;?></a></li>
<?php 
echo tech_nav_link("Before");
}
if (!$tech['nav_exclude_list']){
	wp_list_pages('title_li=&depth=1'); 
} else {
	$nav_exclude = $tech['nav_exclude_list'];
	wp_list_pages("title_li=&exclude=".$nav_exclude."&depth=1");
}
echo tech_nav_link("After");
?>
</ul>
</div>
