<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
    <head profile="http://gmpg.org/xfn/11">
        <meta http-equiv="Content-Type" content="<?php get_bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
        <?php
        if ( of_get_option( 'mobile_css', '0' ) == 1 ) {
            echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
        }
        global $cpage, $tech_nav, $post_type;
        if ( is_singular() ) {
            $tech_nav = get_post_meta( $post->ID, "Nav_value", $single = true );
            if ( empty( $tech_nav ) ) {
                $tech_nav = "on";
            }
        } else {
            $tech_nav = "on";
        }
        ?>
        <title><?php wp_title() ?></title>
        <meta name="generator" content="WordPress <?php bloginfo( 'version' ); ?>" /> <!-- leave this for stats -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_uri(); ?>" />
        <!--[if IE]>
                <style type="text/css">
                #headerimg{ filter:alpha(opacity=80);}
                .top img{ filter:alpha(opacity=60);}
                .top img:hover{ filter:alpha(opacity=100);}
                ul.comment-preview li{ filter:alpha(opacity=70);}
                ul.comment-preview li:hover{ filter:alpha(opacity=100);}
                #commentform input[type="text"],#commentform .comment-form-author .required, 
                #commentform .comment-form-email .required{padding-left: 65px !important;}
                .top a {position: relative;top: 2px;}
                </style>
        <![endif]-->
        <!--[if IE 7]>
                <style type="text/css">
                #headerimgwrap{ position:absolute;left:20%}
                .hleft{position:absolute;}
                .hright{position:absolute; right:0;}
                .top:hover {bottom: -30px;}
                </style>
        <![endif]-->
        <!--[if IE 8 ]>
                <style type="text/css">
                .top:hover {bottom: -30px;}
                </style>
        <![endif]-->
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if ( of_get_option( 'favicon_image' ) ) { ?>
            <link rel="icon" href="<?php echo of_get_option( 'favicon_image' ); ?>" type="image/x-icon" />
            <link rel="shortcut icon" href="<?php echo of_get_option( 'favicon_image' ); ?>" type="image/x-icon" />
            <?php
        }
        wp_head();
        ?>
    </head>
    <body <?php body_class(); ?>>
        <a name="top"></a>
        <div id="page">
            <?php
            if ( of_get_option( 'nav_location', 'below' ) == 'above' ) {
                get_template_part( 'nav' );
            }
            ?>    
            <div id="header">
                <?php
                if ( function_exists( 'dynamic_sidebar' ) && is_active_sidebar( 'left_header' ) ) {
                    echo '<div class="hleft">' . "\n";
                    dynamic_sidebar( 'left_header' );
                    echo '</div>' . "\n";
                }
                if ( function_exists( 'dynamic_sidebar' ) && is_active_sidebar( 'right_header' ) ) {
                    echo '<div class="hright">' . "\n";
                    dynamic_sidebar( 'right_header' );
                    echo '</div>' . "\n";
                }
                ?>

                <div id="headerimgwrap">
                    <?php if ( of_get_option( 'header_logo', '' ) != '' ) { ?>
                        <div id="header-logo">
                            <a class="header-logo-link" href="<?php echo home_url() ?>"><img src="<?php echo of_get_option( 'header_logo' ); ?>" /></a>
                        </div>
                    <?php } ?>  
                    <div id="headerimg">
                        <?php
                        if ( is_single() || is_page() || ($post_type == 'forum' || $post_type == 'topic' || $post_type == 'reply') ) {
                            echo "<span class=\"blog_title\">";
                        } else {
                            echo "<h1 class=\"blog_title\">";
                        }
                        if ( is_single() & of_get_option( 'blog_title_text', 'single' ) == "single" ) {
                            ?>
                            <a><?php
                        if ( get_the_title() != "" ) {
                            the_title();
                        } else {
                            the_date();
                            echo ' ';
                            the_time();
                        }
                            ?>
                            </a><?php } else {
                            ?>
                            <a href="<?php echo home_url(); ?>/"><?php bloginfo( 'name' ); ?></a>
                            <?php
                        }
                        if ( is_single() || is_page() || ($post_type == 'forum' || $post_type == 'topic' || $post_type == 'reply') ) {
                            echo "</span>";
                        } else {
                            echo "</h1>";
                        }
                        if ( is_single() & of_get_option( 'blog_title_text', 'single' ) == "single" ) {
                            $description = "<a href=\"" . home_url() . "\">" . get_bloginfo( 'name' ) . "</a>";
                        } else {
                            $description = get_bloginfo( 'description' );
                        }
                        if ( !empty( $description ) ) {
                            ?>
                            <span class="description"><?php echo $description; ?></span>
                        <?php }
                        ?>
                    </div><!--end headerimg-->
                </div><!--end headerimgwrap-->


            </div><!--end header-->

            <?php
            if ( of_get_option( 'nav_location', 'below' ) == 'below' ) {
                get_template_part( 'nav' );
            }
            ?>