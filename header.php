<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php get_bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php 
global $cpage;
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
if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<a name="top"></a>
<div id="page">
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
<?php if(of_get_option('header_logo','') != ''){ ?>
    <div id="header-logo">
        <a class="header-logo-link" href="<?php echo home_url() ?>"><img src="<?php echo of_get_option('header_logo'); ?>" /></a>
    </div>
<?php }?>    
<div id="headerimgwrap">
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

<?php if (($tech_nav == "on") && (of_get_option('nav_menu','1') == '1')) {
?>
<div id="navmenu">
<?php
	get_template_part('nav','wp3');
        
        if ($tech_nav == "on") {
	if (of_get_option('dashboard_link','1') == "1") {
		if (is_user_logged_in()) { ?>
			<ul id="admin"><li><a href="<?php echo site_url(); ?>/wp-admin" title="<?php _e('Dashboard' ,'techozoic')?>"><?php _e('Dashboard' ,'techozoic')?></a></li>
			<li><a href="<?php echo wp_logout_url(); ?>" title="<?php _e('Log Out' ,'techozoic')?>"><?php _e('Log Out' ,'techozoic')?></a></li></ul>
<?php 
		} else { ?>
			<ul id="admin"><li>
<?php 	if (of_get_option('thickbox','0') == '1') { 
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
}
if (of_get_option('breadcrumbs','0') == '1'){
	tech_breadcrumbs();
}?>

<?php if (of_get_option('search_box','1') == '1' && !is_active_sidebar( 'right_header' )) { ?>
	<div id="search">
	<?php get_search_form(); ?>
	</div>
<?php } ?>