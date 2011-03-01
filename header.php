<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php get_bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php 
get_tech_options();
global $tech, $cpage;
if ( is_singular() ){
	$tech_disable_nav = get_post_meta($post->ID, "Nav_value", $single = true);
} else {
	$tech_disable_nav = "unset";
}
if($tech['seo'] == 'On') { 
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
<?php 
	if ($tech['static_css'] == "Static" || (isset($_GET['stylesheet']) && $_GET['stylesheet'] = 'techozoic-fluid') ) { ?>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory') ?>/style.css" />
<?php
	} else { ?>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo home_url(); ?>/?techozoic_css=css"/>
<?php } ?>
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
<!--[if IE 7]>
	<style type="text/css">
	#headerimgwrap{ position:absolute;left:20%}
	.hleft{position:absolute;}
	.hright{position:absolute; right:0;}
	
	</style>
<![endif]-->
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if ($tech['favicon_image']) {?>
	<link rel="icon" href="<?php echo $tech['favicon_image'];?>" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo $tech['favicon_image'];?>" type="image/x-icon" />
<?php } 
if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<a name="top"></a>
<div id="header">
<div id="header_top">
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
<div id="headerimg">
<?php if(is_single() || is_page()) { 
	echo "<span class=\"blog_title\">";
} else { 
	echo "<h1 class=\"blog_title\">";
} 
if ( is_single() & $tech['blog_title_text'] == "Single Post Title") { ?>
	<a><?php wp_title('',true,''); ?></a><?php 
} else { ?>
	<a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a>
<?php 
} 
if(is_single() || is_page()) { 
	echo "</span>"; 
} else { 
	echo "</h1>";
} 
if ( is_single() & $tech['blog_title_text'] == "Single Post Title") { 
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

<div id="headerl">
<div id="headerr">
</div><!--end headerr-->

<?php 	if ($tech['nav_menu_type'] != "Disable" && $tech_disable_nav != "checked") {
?>
<div id="navmenu">
<?php
	get_template_part('nav',tech_nav_select());
}
        if ($tech['nav_menu_type'] != "Disable" && $tech_disable_nav != "checked") {
	if ($tech['dashboard_link'] == "On") {
		if (is_user_logged_in()) { ?>
			<ul id="admin"><li><a href="<?php echo site_url(); ?>/wp-admin" title="<?php _e('Dashboard' ,'techozoic')?>"><?php _e('Dashboard' ,'techozoic')?></a></li>
			<li><a href="<?php echo wp_logout_url(); ?>" title="<?php _e('Log Out' ,'techozoic')?>"><?php _e('Log Out' ,'techozoic')?></a></li></ul>
<?php 
		} else { ?>
			<ul id="admin"><li>
<?php 	if ($tech['thickbox'] =="On") { 
?>
			<a href="#TB_inline?height=120&amp;width=120&amp;inlineId=loginthick" class="thickbox" title="Login"><?php _e('Login' ,'techozoic')?></a>
<?php 	} else { 
?>			<a href="<?php echo wp_login_url();?>" title="<?php _e('Login' ,'techozoic')?>"><?php _e('Login' ,'techozoic')?></a>
<?php 	}
?>
		</li></ul>
		<div id="loginthick" style="display:none">
		<div class="aligncenter">
		<form action="<?php echo site_url(); ?>/wp-login.php" method="post" id="loginform">
		<label><?php _e('Username: ' ,'techozoic')?><br /><input type="text" id="user_login" class="text" name="log"/></label><br />
		<label><?php _e('Password: ' ,'techozoic')?><br /><input type="password" id="user_pass" class="text" name="pwd"/></label><br />
		<input type="submit" id="wp-submit" value="<?php _e('Log in' ,'techozoic')?>" />
		<input type="hidden" name="redirect_to" value="<?php echo "http://".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']; ?>" />
		<input type="hidden" name="testcookie" value="1" />
		</form>
		</div><!--end aligncenter-->
		</div><!--end loginthick-->
<?php 	}
	}
?>
</div><!--end navmenu-->
<?php }
if ($tech['breadcrumbs'] == "On"){
	tech_breadcrumbs();
}?>
</div><!--end headerl-->
</div><!--end header_top-->
</div><!--end header-->


<div id="page">
<div id="pagel">
<div id="pager">
<?php if ($tech['search_box'] == "Yes" && !is_active_sidebar( 'right_header' )) { ?>
	<div id="search">
	<?php get_search_form(); ?>
	</div>
<?php } ?>