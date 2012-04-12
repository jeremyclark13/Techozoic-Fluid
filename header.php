<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php get_bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<?php 
global $cpage, $tech_nav;
if ( is_singular() ){
	$tech_nav = get_post_meta($post->ID, "Nav_value", $single = true);
        if(empty($tech_nav)){
            $tech_nav = "on";
        }
} else {
    $tech_nav = "on";
}
if(of_get_option('seo','1') == '1') { 
	if(is_single()) { 
		if ( have_posts() ) { 
			while ( have_posts() ) { 
				the_post(); ?>
<meta name="description" content="<?php $excerpt = strip_tags(get_the_excerpt()); echo $excerpt; if ( $cpage < 1 ) {} else { echo (' - comment page '); if ( isset($cpage)) {echo ($cpage);}} ?>" />
<meta name="keywords" content="<?php foreach((get_the_category()) as $category) { echo $category->cat_name . ','; } $posttags = get_the_tags();if ($posttags) {foreach($posttags as $tag) {echo $tag->name . ','; } } ?>" />
<?php 			} 
		} 
	} elseif(is_home()) { ?>
<meta name="description" content="<?php bloginfo('description'); ?>" />
<?php 	} ?>
<title>
<?php 
	if (is_day() || is_month() || is_year()) { 
		_e('Archive for ' ,'techozoic');
	}		
	 	wp_title(' - ','true','right'); 
		if ( $cpage < 1 ) {} 
		else { 
			echo (' - comment page '); 
			if ( isset($cpage)){ 
				echo $cpage;
			}
			echo " | ";
		} 
	bloginfo('name'); 
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
	if ($paged > 1) { 
		echo " - Page $paged"; 
	} ?>
</title>
<?php 
}//End tech_seo
else { ?>
<title><?php wp_title(' - ','true','right') . bloginfo('name'); ?></title>
<?php 
} ?>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_uri(); ?>" />

<!--[if IE 6]>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_template_directory_uri() ?>/ie6.css" />
<![endif]-->
<!--[if IE]>
	<style type="text/css">
	#headerimg{ filter:alpha(opacity=80);}
	.top img{ filter:alpha(opacity=60);}
	.top img:hover{ filter:alpha(opacity=100);}
	ul.comment-preview li{ filter:alpha(opacity=70);}
	ul.comment-preview li:hover{ filter:alpha(opacity=100);}
        #commentform input[type="text"],#commentform .comment-form-author .required, 
        #commentform .comment-form-email .required{padding-left: 65px !important;}
        .top:hover{bottom: -30px;}
        .top a {position: relative;top: 2px;}
	</style>
<![endif]-->
<!--[if IE 7]>
	<style type="text/css">
	#headerimgwrap{ position:absolute;left:20%}
	.hleft{position:absolute;}
	.hright{position:absolute; right:0;}
	
	</style>
<![endif]-->
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if ( of_get_option( 'favicon_image' ) ) {?>
	<link rel="icon" href="<?php echo of_get_option( 'favicon_image' );?>" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo of_get_option( 'favicon_image' );?>" type="image/x-icon" />
<?php } 
wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<a name="top"></a>
<div id="page">
<?php if(of_get_option('nav_location','below') == 'above') {
    get_template_part('nav','wp3'); 
}?>    
<div id="header">
<?php if ( function_exists('dynamic_sidebar') && is_active_sidebar( 'left_header' ) ){
	echo '<div class="hleft">'. "\n";
	dynamic_sidebar( 'left_header' );
	echo '</div>' . "\n";
}	
if ( function_exists('dynamic_sidebar') && is_active_sidebar( 'right_header' ) ){
	echo '<div class="hright">' . "\n";
	dynamic_sidebar( 'right_header' );
	echo '</div>' . "\n";
}
?>
  
<div id="headerimgwrap">
    <?php if(of_get_option('header_logo','') != ''){ ?>
    <div id="header-logo">
        <a class="header-logo-link" href="<?php echo home_url() ?>"><img src="<?php echo of_get_option('header_logo'); ?>" /></a>
    </div>
<?php }?>  
<div id="headerimg">
<?php if(is_single() || is_page()) { 
	echo "<span class=\"blog_title\">";
} else { 
	echo "<h1 class=\"blog_title\">";
} 
if ( is_single() & of_get_option('blog_title_text','single') == "single") { ?>
	<a><?php if (get_the_title() != ""){ 
                the_title(); 
            } else {
                the_date();
                echo ' ';
                the_time();
            }
?>
</a><?php 
} else { ?>
	<a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a>
<?php 
} 
if(is_single() || is_page()) { 
	echo "</span>"; 
} else { 
	echo "</h1>";
} 
if ( is_single() & of_get_option('blog_title_text','single') == "single") { 
	$description = "<a href=\"" . home_url() . "\">" . get_bloginfo('name') . "</a>"; }
else {	
	$description = get_bloginfo('description');
}
if (!empty ($description)) { ?>
	<span class="description"><?php echo $description; ?></span>
<?php
} ?>
</div><!--end headerimg-->
</div><!--end headerimgwrap-->


</div><!--end header-->

<?php if(of_get_option('nav_location','below') == 'below') {
    get_template_part('nav','wp3'); 
}?>

<?php if (of_get_option('search_box','1') == '1' && !is_active_sidebar( 'right_header' )) { ?>
	<div id="search">
	<?php get_search_form(); ?>
	</div>
<?php } ?>