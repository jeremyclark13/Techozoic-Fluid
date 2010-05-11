<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php get_bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta http-equiv="content-language" content="en" />
<?php 
get_tech_options();
global $tech;
$tech_disable_nav = get_post_meta($post->ID, "Nav_value", $single = true);
if($tech['seo'] == On) { 
	if(is_single()) { 
		if ( have_posts() ) { 
			while ( have_posts() ) { 
				the_post(); ?>
				<meta name="description" content="<?php $excerpt = strip_tags(get_the_excerpt()); echo $excerpt; if ( $cpage < 1 ) {} else { echo (' - comment page '); echo ($cpage);} ?>" />
				<meta name="keywords" content="<?php foreach((get_the_category()) as $category) { echo $category->cat_name . ','; } $posttags = get_the_tags();if ($posttags) {foreach($posttags as $tag) {echo $tag->name . ','; } } ?>" />
<?php 			} 
		} 
	} elseif(is_home()) { ?>
		<meta name="description" content="<?php bloginfo('description'); ?>" />
<?php 		} ?>
	<title>
<?php 
		wp_title(' | ','true','right'); 
		if ( $cpage < 1 ) {} 
		else { 
			echo (' - comment page '); 
			echo ($cpage);
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
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<title><?php bloginfo('name'); ?></title>
<?php 
} ?>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
<?php 
	if ($tech['static_css'] == "Dynamic") {
		if ($tech['head_css'] != "no"){ ?>
			<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory') ?>/style.css" />
		<style>
<?php 		include_once (TEMPLATEPATH . '/style.php');
		echo '</style>';
		} else {
?>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('home') ?>/?techozoic_css=css"/>
<?php 	}
	} else {
?>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory') ?>/style.css" />
<?php }
?>
<!--[if IE 6]>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory') ?>/ie6.css" />
<![endif]-->
<!--[if IE]>
	<style type="text/css">
	#headerimg{ filter:alpha(opacity=80);}
	.top img{ filter:alpha(opacity=60);}
	.top img:hover{ filter:alpha(opacity=100);}
	ul.comment-preview li{ filter:alpha(opacity=70);}
	ul.comment-preview li:hover{ filter:alpha(opacity=100);}
	</style>
<![endif]-->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if ($tech['favicon_image']) {?>
	<link rel="icon" href="<?php echo $tech['favicon_image'];?>" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo $tech['favicon_image'];?>" type="image/x-icon" />
<?php } 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<a name="top"></a>
<div id="page">
<div id="pagel">
<div id="pager">
<div id="header">
<div id="headerimgwrap">
<div id="headerimg">
<h1>
<?php 
if ( is_single() & $tech['blog_title_text'] == "Single Post Title") { ?>
	<a><?php wp_title('',true,''); ?></a><?php 
} else { ?>
	<a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a>
<?php 
} ?></h1>
<?php 
if ( is_single() & $tech['blog_title_text'] == "Single Post Title") { 
	$description = "<a href=\"".get_bloginfo('home')."\">".get_bloginfo('name')."</a>"; } 
else {	
	$description = get_bloginfo('description');
}
if (!empty ($description)) { ?>
	<span class="description"><?php echo $description; ?></span>
<?php 
} ?>
</div>
</div>
</div>
<div id="search">
<?php include (TEMPLATEPATH . "/searchform.php"); ?>
</div>
<hr />
<?php 	if ($tech['nav_menu_type'] != "Disable" && $tech_disable_nav != "checked") {
?>
<div id="navmenu">
<?php
		switch ($tech['nav_menu_type']){
			case "Two Tier": 
				include (TEMPLATEPATH . "/nav/twotier.php");
				break;
			case "Standard":
				include (TEMPLATEPATH . "/nav/standard.php");
				break;
			case "Dropdown":
				include (TEMPLATEPATH . "/nav/dropdown.php");
				break;
			/* case "WP 3 Menu":
				include (TEMPLATEPATH . "/nav/wp3.php");
				break; */
		}
	}
if ($tech['nav_menu_type'] != "Disable" && $tech_disable_nav != "checked") {
	if ($tech['dashboard_link'] == "On") {
		if (is_user_logged_in()){ ?>
			<ul id="admin"><li><a href="<?php echo bloginfo('wpurl'); ?>/wp-admin" alt="admin"><?php _e('Dashboard' ,'techozoic')?></a></li>
			<li><a href="<?php if (function_exists(wp_logout_url)) { echo wp_logout_url();} else { bloginfo('siteurl'); ?>/wp-login.php?action=logout&amp;redirect_to=<?php echo "http://".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']; }?>" alt="logout"><?php _e('Log Out' ,'techozoic')?></a></li></ul>
<?php 
		} else { ?>
			<ul id="admin"><li>
<?php 	if ($tech['thickbox'] =="On") { 
?>
			<a href="#TB_inline?height=120&amp;width=120&amp;inlineId=loginthick" class="thickbox" title="Login"><?php _e('Login' ,'techozoic')?></a>
<?php 	} else { 
?>			<a href="<?php echo wp_login_url();?>" title="Login"><?php _e('Login' ,'techozoic')?></a>
<?php 	}
?>
		</li></ul>
		<div id="loginthick" style="display:none">
		<div class="aligncenter">
		<form action="<?php bloginfo('wpurl'); ?>/wp-login.php" method="post" id="loginform">
		<label><?php _e('Username: ' ,'techozoic')?><br /><input type="text" id="user_login" class="text" name="log"/></label><br />
		<label><?php _e('Password: ' ,'techozoic')?><br /><input type="password" id="user_pass" class="text" name="pwd"/></label><br />
		<input type="submit" id="wp-submit" value="<?php _e('Log in' ,'techozoic')?>" />
		<input type="hidden" name="redirect_to" value="<?php echo "http://".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']; ?>" />
		<input type="hidden" name="testcookie" value="1" />
		</form>
		</div>
		</div>
<?php 	}
	}
?>
</div>
<?php }
if ($tech['breadcrumbs'] == "On"){
	tech_breadcrumbs();
}?>
