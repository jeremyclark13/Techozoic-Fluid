<?php
/**
 * Techozoic Custom CSS
 *
 * Outputs customized CSS to header
 * 
 *
 * @access    private
 * @since     2.0
 */
if ( !is_admin() ) {
    add_action( 'wp_head', 'tech_head_css' );
}

function tech_google_font_family( $font ) {
    $tech_google1 = of_get_option( 'google_font_family', '' );
    $tech_google2 = of_get_option( 'google_font_family_2', '' );
    if ( stripos( $tech_google1, ':' ) !== false ) {
        $tech_google1 = explode( ':', $tech_google1 );
        $tech_google1 = $tech_google1[0];
    }
    if ( stripos( $tech_google2, ':' ) !== false ) {
        $tech_google2 = explode( ':', $tech_google2 );
        $tech_google2 = $tech_google2[0];
    }
    $font['face'] = ($font['face'] == 'google1') ? $tech_google1 : $font['face'];
    $font['face'] = ($font['face'] == 'google2') ? $tech_google2 : $font['face'];
    return $font;
}

function tech_head_css() {
    $tech_blog_title_display = '';
    $tech_blog_title_cursor = '';
    $tech_header_font = tech_google_font_family( of_get_option( 'post_heading', array( 'size' => "20px", 'face' => 'verdana', 'style' => 'bold', 'color' => '#2C4353' ) ) );
    $tech_main_heading_font = tech_google_font_family( of_get_option( 'main_heading_font', array( 'size' => "30px", 'face' => 'verdana', 'style' => 'bold', 'color' => '#A0B3C2' ) ) );
    $tech_sidebar_font = tech_google_font_family( of_get_option( 'side_heading_font', array( 'size' => "16px", 'face' => 'verdana', 'style' => 'bold', 'color' => '#2C4353' ) ) );
    $tech_body_font = tech_google_font_family( of_get_option( 'body_font', array( 'size' => "10px", 'face' => 'arial', 'style' => '', 'color' => '#2C4353' ) ) );
    $tech_post_font = tech_google_font_family( of_get_option( 'post_text_font', array( 'size' => "10px", 'face' => 'arial', 'style' => '', 'color' => '#2C4353' ) ) );
    $tech_small_font = tech_google_font_family( of_get_option( 'small_font', array( 'size' => "10px", 'face' => 'arial', 'style' => '', 'color' => '#777777' ) ) );
    $tech_nav_font = tech_google_font_family( of_get_option( 'nav_font', array( 'size' => "13px", 'face' => 'verdana', 'style' => 'bold', 'color' => '#A0B3C2' ) ) );
    $tech_header_align = strtolower( of_get_option( 'header_align', 'center' ) );
    $tech_header_v_align = strtolower( of_get_option( 'header_v_align', 'center' ) );
    $tech_bg_image = of_get_option( 'bg_image', array( 'color' => '', 'image' => '', 'repeat' => 'repeat', 'position' => 'top center', 'attachment' => 'scroll' ) );
    $tech_page_width = of_get_option( 'page_width', '90' );
    $tech_main_column_width = of_get_option( 'main_column_width', '50' );
    $tech_l_sidebar_width = of_get_option( 'l_sidebar_width', '25' );
    $tech_r_sidebar_width = of_get_option( 'r_sidebar_width', '25' );
    $tech_header_height = of_get_option( 'header_height', '200' );
    $tech_sidebar_pos = of_get_option( 'sidebar_pos', '3-col' );
    $tech_content_bg_image = of_get_option( 'content_bg_image', array( 'color' => '', 'image' => '', 'repeat' => 'repeat', 'position' => 'top center', 'attachment' => 'scroll' ) );
    $tech_nav_margin = of_get_option( 'nav_button_margin', '3' );
    $tech_menu_width = of_get_option( 'nav_menu_width', '250' );
    if ( of_get_option( 'page_type', 'fluid' ) == 'fixed' ) {
        $tech_sign = 'px';
    } else {
        $tech_sign = '%';
    }
    if ( of_get_option( 'page_type', 'fluid' ) == 'fluid' && $tech_page_width > 101 )
        $tech_page_width = '100';
    if ( of_get_option( 'page_type', 'fluid' ) == 'fluid' && ($tech_page_width > 100 || $tech_page_width < 0) ) {
        $tech_page_width = '95';
        $tech_sign = '%';
    }
    if ( of_get_option( 'blog_title', '1' ) == '0' || of_get_option( 'header_logo', '' ) != '' )
        $tech_blog_title_display = 'display:none';
    if ( of_get_option( 'blog_title_text', 'single' ) == 'single' )
        $tech_blog_title_cursor = 'cursor:default;';
    $tech_page_overflow = (of_get_option( 'nav_type', 'square' ) != 'ribbon') ? 'overflow:hidden' : '';
    $tech_logo_top = of_get_option( 'header_logo_top', '0' );
    $tech_logo_left = of_get_option( 'header_logo_left', '0' );
    $tech_blog_title_align_check = "";
    $tech_nav_align_check = "";
    switch ( of_get_option( 'blog_title_align', 'left' ) ) {
        case "left":
            $tech_blog_title_align = 'float:left;margin-left:10px';
            break;
        case "right":
            $tech_blog_title_align = 'float:right;margin-right:10px';
            break;
        case "center":
            $tech_blog_title_align = 'float:left;position:relative;left:-50%';
            $tech_blog_title_align_check = "Center";
            break;
    }
    switch ( of_get_option( 'nav_align', 'left' ) ) {
        case "center":
            $tech_nav_align = 'float:left;position:relative;left:-50%';
            $tech_nav_align_check = "center";
            break;
        case "left":
            $tech_nav_align = '';
            break;
    }

    $tech_bg_color = of_get_option( 'cust_bg_color1', '#A0B3C2' );
    $tech_bg_trans = of_get_option( 'cust_bg_trans1', '0' );
    $tech_acc_color = of_get_option( 'cust_acc_color1', '#A0B3C2' );
    $tech_link_color = of_get_option( 'cust_link_color1', '#597EAA' );
    $tech_link_hov_color = of_get_option( 'cust_link_hov_color1', '#114477' );
    $tech_visit_link_color = of_get_option( 'cust_link_visit_color1', '#2C4353' );
    $tech_nav_bg_color = of_get_option( 'cust_nav_bg_color1', '#E3E3E3' );
    $tech_nav_bg_trans = of_get_option( 'cust_nav_bg_trans1', '0' );
    $tech_post_bg_color = of_get_option( 'cust_post_bg_color1', '#E3E3E3' );
    $tech_post_bg_trans = of_get_option( 'cust_post_bg_trans1', '0' );
    $tech_content_bg_color = of_get_option( 'cust_content_bg_color1', '#F7F7F7' );
    $tech_content_bg_trans = of_get_option( 'cust_content_bg_trans1', '0' );
    $tech_nav_hov_bg_color = of_get_option( 'cust_nav_hov_bg_color1', '#EFEFEF' );
    $tech_nav_hov_text_color = of_get_option( 'cust_nav_hov_text_color1', '#A0B3C2' );
    $tech_nav_active_bg_color = of_get_option( 'cust_nav_active_bg_color1', '#A0B3C2' );
    $tech_nav_active_text_color = of_get_option( 'cust_nav_active_text_color1', '#F7F7F7' );
    $tech_nav_bg_gradient_top = of_get_option( 'cust_nav_bg_gradient_top', '#E3E3E3' );
    $tech_nav_bg_gradient_bot = of_get_option( 'cust_nav_bg_gradient_bot', '#CCCCCC' );
    $tech_nav_ul_bg_color = $tech_nav_bg_color;
    if ( $tech_bg_trans == '1' )
        $tech_bg_color = 'transparent';
    if ( $tech_nav_bg_trans == '1' )
        $tech_nav_bg_color = 'transparent';
    if ( $tech_post_bg_trans == '1' )
        $tech_post_bg_color = 'transparent';
    if ( $tech_content_bg_trans == '1' )
        $tech_content_bg_color = 'transparent';
    $tech_drop_shadow_classes = ".noclass";
    $tech_drop_shadow = of_get_option( 'drop_shadow', '' );
    $tech_drop_shadow_class_map = array(
        "header" => "#headerimg",
        "post" => ".home .narrowcolumn .entry, .home .widecolumn .entry, .top, .archive .entry",
        "image" => ".entry img, .entrytext img",
        "page" => "#page"
    );
    if ( is_array( $tech_drop_shadow ) ) {
        foreach ( $tech_drop_shadow as $key => $value ) {
            if ( $value == '1' ) {
                $tech_drop_shadow_classes .= "," . $tech_drop_shadow_class_map[$key];
            }
        }
    }
    $tech_post_bg_color_classes = ".noclass";
    $tech_post_bg_color_loc = of_get_option( 'post_background_location', array( "main" => "1", 'archive' => '1' ) );
    $tech_post_bg_color_class_map = array(
        "main" => '.home .narrowcolumn .entry, home .widecolumn .entry, .top',
        "single" => '.post .singlepost',
        "archive" => '.archive .narrowcolumn .entry, .archive .widecolumn .entry, .top'
    );
    if ( is_array( $tech_post_bg_color_loc ) ) {
        foreach ( $tech_post_bg_color_loc as $key => $value ) {
            if ( $value == '1' ) {
                $tech_post_bg_color_classes .= "," . $tech_post_bg_color_class_map[$key];
            }
        }
    }
    $css_var = '<style type="text/css">';
    $css_var .= <<<CSS
/*Variable Styles*/
#page{ 
background:{$tech_content_bg_color} url({$tech_content_bg_image['image']}) {$tech_content_bg_image['repeat']} {$tech_content_bg_image['position']} {$tech_content_bg_image['attachment']};
{$tech_page_overflow};
}
body{
font:{$tech_body_font['style']} {$tech_body_font['size']} {$tech_body_font['face']}, Sans-Serif;
background:{$tech_bg_color} url({$tech_bg_image['image']}) {$tech_bg_image['repeat']} {$tech_bg_image['position']} {$tech_bg_image['attachment']};
}
.techozoic_font_size{
font-size: {$tech_body_font['size']};
}
.narrowcolumn .entry,.widecolumn .entry, .top {
font:{$tech_post_font['style']} {$tech_post_font['size']} {$tech_post_font['face']}, Sans-Serif;
color: {$tech_post_font['color']};
}
{$tech_post_bg_color_classes}{
background-color:{$tech_post_bg_color};
border-top:1px {$tech_acc_color} solid;
}
.top{
border:none;
}
.blog_title, .blog_title a, .blog_title a:hover, .blog_title a:visited{
font:{$tech_main_heading_font['style']} {$tech_main_heading_font['size']} {$tech_main_heading_font['face']}, Sans-Serif;
color: {$tech_main_heading_font['color']};
}
h1.post_title{
font:{$tech_header_font['style']} {$tech_header_font['size']} {$tech_header_font['face']}, Sans-Serif;
color:{$tech_header_font['color']} !important;
}
.post_title a{
font:{$tech_header_font['style']} {$tech_header_font['size']} {$tech_header_font['face']}, Sans-Serif;
color:{$tech_header_font['color']} !important;
}
.entry h1{
font:{$tech_header_font['style']} 3em {$tech_header_font['face']}, Sans-Serif;
color: {$tech_header_font['color']} !important;
}
.entry h2{
font:{$tech_header_font['style']} 2em {$tech_header_font['face']}, Sans-Serif;
color: {$tech_header_font['color']} !important;
}
.entry h3{
font:{$tech_header_font['style']} 1.4em {$tech_header_font['face']}, Sans-Serif;
color: {$tech_header_font['color']} !important;
}
.entry h4{
font:{$tech_header_font['style']} 1.3em {$tech_header_font['face']}, Sans-Serif;
color: {$tech_header_font['color']} !important;
}
.entry h5{
font:{$tech_header_font['style']} 1.2em {$tech_header_font['face']}, Sans-Serif;
color: {$tech_header_font['color']} !important;
}
.sidebar h2, .sidebar h3, #footer h2{
font: {$tech_sidebar_font['style']} {$tech_sidebar_font['size']} {$tech_sidebar_font['face']}, Sans-Serif;
color:{$tech_sidebar_font['color']};
}
.widgettitle {
font-size: {$tech_sidebar_font['size']};
margin: 1px 0;
}
#content {
font-size: {$tech_post_font['size']};
}
acronym,abbr,span.caps,small,.trackback li,.sidebar, .postmetadata {
font-size: {$tech_small_font['size']};
}
.postmetadata{
font: {$tech_small_font['style']} {$tech_small_font['size']} {$tech_small_font['face']}, Sans-Serif;
color: {$tech_small_font['color']};
}
ul#nav a, ul#admin a, #dropdown li.current_page_item a:hover, .top-menu li.current-menu-item a:hover, #dropdown li.current_page_item ul a, .top-menu li.current-menu-item ul a, ul#nav li.current_page_item a:hover, {
color: {$tech_nav_font['color']};
}
.commenlist .author,#searchform #s, #searchsubmit:hover,#catsubmit:hover,#wp-submit:hover,#TB_ajaxContent {
background-color: {$tech_acc_color} ;
}
ul#admin li, ul#dropdown li, #navmenu .top-menu li{
/*background-color: {$tech_nav_bg_color};*/
}
ul#admin li a, ul#dropdown li a, #navmenu .top-menu li a{
font-style: {$tech_nav_font['style']}; 
font-size:{$tech_nav_font['size']};
font-family: {$tech_nav_font['face']}, Sans-Serif;
color:{$tech_nav_font['color']};
}
ul#admin li a:hover, ul#dropdown li a:hover, #navmenu .top-menu li a:hover{
color: {$tech_nav_hov_text_color};
}
ul#dropdown > li, ul.top-menu > li{
margin: 0 {$tech_nav_margin}px;
}
.ribbon ul.top-menu > li, .square ul.top-menu > li{
margin: 0;
padding: 0 {$tech_nav_margin}px;
}
.ribbon ul.top-menu > li.has_children:hover:after, .square ul.top-menu > li.has_children:hover:after {
border-bottom: 5px solid {$tech_nav_ul_bg_color};
}
#dropdown ul, .top-menu ul{
background-color: {$tech_nav_bg_gradient_top};
}
.ribbon, .square{
background-color: {$tech_nav_bg_gradient_top};
background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from({$tech_nav_bg_gradient_top}), to({$tech_nav_bg_gradient_bot}));
background-image: -webkit-linear-gradient(top, {$tech_nav_bg_gradient_top}, {$tech_nav_bg_gradient_bot});
background-image:    -moz-linear-gradient(top, {$tech_nav_bg_gradient_top}, {$tech_nav_bg_gradient_bot});
background-image:     -ms-linear-gradient(top, {$tech_nav_bg_gradient_top}, {$tech_nav_bg_gradient_bot});
background-image:      -o-linear-gradient(top, {$tech_nav_bg_gradient_top}, {$tech_nav_bg_gradient_bot});
background-image:         linear-gradient(top, {$tech_nav_bg_gradient_top}, {$tech_nav_bg_gradient_bot});
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='{$tech_nav_bg_gradient_top}', endColorstr='{$tech_nav_bg_gradient_bot}');
}
.ribbon ul.top-menu:before{
border-right: 10px solid {$tech_nav_bg_gradient_bot};
}
.ribbon ul.top-menu:after{
border-left: 10px solid {$tech_nav_bg_gradient_bot};
}
CSS;
    if ( of_get_option( 'search_box', '1' ) == '1' ) {
        $css_var .= <<<CSS
.ribbon ul.top-menu > li:last-child, .square ul.top-menu > li:last-child{
margin-right: 100px;
}
CSS;
    }
    if ( $tech_nav_bg_trans != '1' ) {
        $css_var .= <<<CSS
#navmenu .top-menu li, #navmenu .top-menu ul.sub-menu, ul#admin li{
background-color: {$tech_nav_ul_bg_color};
}       
#dropdown li.current_page_item, #navmenu .top-menu li.current-menu-item, #navmenu .top-menu ul.sub-menu li.current-menu-item {
background-color: {$tech_nav_active_bg_color} ;
}
#dropdown li:hover, #navmenu .top-menu li:hover, #navmenu .top-menu ul.sub-menu > li:hover {
background-color:{$tech_nav_hov_bg_color};
}
#dropdown li.current_page_item > a:hover, #navmenu .top-menu li.current-menu-item > a:hover, #navmenu .top-menu li.current-menu-item:hover > a, #navmenu .top-menu li:hover > a {
color:{$tech_nav_hov_text_color};
}
#dropdown li.current_page_item > a, #navmenu .top-menu li.current-menu-item > a{
color:{$tech_nav_active_text_color};
}
ul#admin li:hover{
background:{$tech_nav_hov_bg_color};
box-shadow:2px 1px 3px rgba(0, 0, 0, 0.3);
-moz-box-shadow:2px 1px 3px rgba(0, 0, 0, 0.3);
-webkit-box-shadow:2px 1px 3px rgba(0, 0, 0, 0.3);
}
CSS;
    } else {
        $css_var .= <<<CSS
#navmenu .top-menu li{
background-color: transparent;
} 
#navmenu .top-menu ul.sub-menu{
background-color: {$tech_nav_ul_bg_color}
}
#dropdown li.current_page_item, #navmenu .top-menu li.current-menu-item {
background-color: transparent ;
}
#dropdown li:hover, #navmenu .top-menu li:hover {
background-color:transparent;
box-shadow:none;
-moz-box-shadow:none;
-webkit-box-shadow:none;
}
#dropdown li.current_page_item > a, #navmenu .top-menu li.current-menu-item > a{
color:{$tech_nav_active_text_color};
}
#dropdown li.current_page_item > a:hover, #navmenu .top-menu li.current-menu-item > a:hover, #navmenu .top-menu li.current-menu-item:hover > a, #navmenu .top-menu li:hover > a{
color:{$tech_nav_hov_text_color};
}
ul#admin li:hover, ul#admin li{
background-color:transparent;
box-shadow:none;
-moz-box-shadow:none;
-webkit-box-shadow:none;
}
CSS;
    }
    $css_var .= <<<CSS
#dropdown li ul li, .top-menu li ul li, #dropdown li ul , .top-menu li ul{
width: {$tech_menu_width}px !important;
}
#dropdown li ul ul, .top-menu li ul ul{
left:{$tech_menu_width}px ; 
}
.post_date {
background-color:{$tech_acc_color};
}
.tags {
border-bottom:1px {$tech_acc_color} solid;
border-top:1px {$tech_acc_color} solid;
}
a,h2 a:hover,h3 a:hover,.commentdiv a, .commentdiv a:visited,#user_login,#user_pass, .commentdiv span, #sidenav a:visited {
color:{$tech_link_color}; 
text-decoration:none;
}
.date_post,#searchform #s {
color:{$tech_post_bg_color}; 
text-decoration:none;
}
a:hover {
color:{$tech_link_hov_color}; 
text-decoration:underline;
}
a:visited{
color:{$tech_visit_link_color};
}
.description {
color:{$tech_acc_color};
}
#headerimg {
{$tech_blog_title_display};
{$tech_blog_title_align};
}
#header-logo{
{$tech_blog_title_align};
padding-top:{$tech_logo_top}px;
padding-left:{$tech_logo_left}px;
}
.single .blog_title a:hover {
{$tech_blog_title_cursor}
text-decoration:none;
}
{$tech_drop_shadow_classes}{
-moz-box-shadow:none !important;
box-shadow:none !important;
-webkit-box-shadow: none !important;
opacity:1 !important;
border: none !important;
}
CSS;
    if ( of_get_option( 'header_logo', '' ) == '' ) {
        $css_var .= <<<CSS
#headerimgwrap{
top:20%;
}  
CSS;
    }
    if ( $tech_blog_title_align_check == "Center" && is_active_sidebar( 'left_header' ) ) {
        $css_var .= <<<CSS
#headerimgwrap {
float:left;
position:absolute;
left:15%;
}
CSS;
    } else if ( $tech_blog_title_align_check == "Center" && !is_active_sidebar( 'left_header' ) ) {
        $css_var .= <<<CSS
#headerimgwrap {
float:left;
position:absolute;
left:50%;
}
CSS;
    }
    if ( $tech_sidebar_pos == '1-col' ) {
        if ( $tech_main_column_width == 0 )
            $tech_main_column_width = 100;
        $tech_main_column_width = $tech_main_column_width - 6;
        $css_var .= <<<CSS
#page {
width: {$tech_page_width}{$tech_sign};
}
.narrowcolumn, .home .widecolumn {
float:left;
margin:0;
padding:0 2% 20px 3%;
width:{$tech_main_column_width}%;
}
CSS;
    } elseif ( $tech_sidebar_pos == '2-col-right' ) {
        if ( $tech_main_column_width == 0 && $tech_r_sidebar_width != 0 ) {
            $tech_main_column_width = 97 - $tech_r_sidebar_width;
        } elseif ( $tech_main_column_width == 0 ) {
            $tech_main_column_width = 70;
        }
        if ( $tech_r_sidebar_width == 0 && $tech_main_column_width != 70 ) {
            $tech_r_sidebar_width = 96 - $tech_main_column_width;
        } elseif ( $tech_r_sidebar_width == 0 ) {
            $tech_r_sidebar_width = 23;
        }
        $tech_main_column_width = $tech_main_column_width - 5;
        $tech_r_sidebar_width = $tech_r_sidebar_width - 3;
        $css_var .= <<<CSS
#page {
width: {$tech_page_width}{$tech_sign};
}
.narrowcolumn {
float:left;
margin:0;
padding:25px 2% 20px 3%;
width:{$tech_main_column_width}%;
}
#r_sidebar {
float:right;
padding:25px 2% 0 1%;
width:{$tech_r_sidebar_width}%
}
CSS;
    } elseif ( $tech_sidebar_pos == '2-col-left' ) {
        if ( $tech_main_column_width == 0 && $tech_l_sidebar_width != 0 ) {
            $tech_main_column_width = 97 - $tech_l_sidebar_width;
        } elseif ( $tech_main_column_width == 0 ) {
            $tech_main_column_width = 70;
        }
        if ( $tech_l_sidebar_width == 0 && $tech_main_column_width != 70 ) {
            $tech_l_sidebar_width = 96 - $tech_main_column_width;
        } elseif ( $tech_l_sidebar_width == 0 ) {
            $tech_l_sidebar_width = 23;
        }
        $tech_main_column_width = $tech_main_column_width - 5;
        $tech_l_sidebar_width = $tech_l_sidebar_width - 3;
        $css_var .= <<<CSS
#page {
width: {$tech_page_width}{$tech_sign};
}
.narrowcolumn {
float:left;
margin:0;
padding:25px 3% 20px 2%;
width:{$tech_main_column_width}%;
}
#l_sidebar {
float:left;
padding:25px 1% 0 2%;
width:{$tech_l_sidebar_width}%
}
CSS;
    } else {
        if ( $tech_main_column_width == 0 && $tech_l_sidebar_width != 0 && $tech_r_sidebar_width != 0 ) {
            $tech_main_column_width = 96 - ($tech_l_sidebar_width + $tech_r_sidebar_width);
        } elseif ( $tech_main_column_width == 0 ) {
            $tech_main_column_width = 55;
        }
        if ( $tech_l_sidebar_width == 0 && $tech_r_sidebar_width == 0 && $tech_main_column_width != 55 ) {
            $tech_l_sidebar_width = (98 - $tech_main_column_width) / 2;
            $tech_r_sidebar_width = (98 - $tech_main_column_width) / 2;
        } elseif ( $tech_l_sidebar_width == 0 && $tech_r_sidebar_width == 0 ) {
            $tech_l_sidebar_width = 22;
            $tech_r_sidebar_width = 22;
        }
        $tech_main_column_width = $tech_main_column_width - 2;
        $tech_l_sidebar_width = $tech_l_sidebar_width - 2;
        $tech_r_sidebar_width = $tech_r_sidebar_width - 2;
        if ( $tech_sidebar_pos == '3-col_right' ) {
            $css_var .= <<<CSS
#page {
width: {$tech_page_width}{$tech_sign}
}
.narrowcolumn {
float:left;
margin:0 0 0 2%;
padding:25px 0 20px 0;
width:{$tech_main_column_width}%;
}
#l_sidebar {
float:right;
padding:25px 0 0 2%;
width:{$tech_l_sidebar_width}%
}
#r_sidebar {
float:right;
clear:right;
padding:25px 2% 0 0;
width:{$tech_r_sidebar_width}%
}
CSS;
        } elseif ( $tech_sidebar_pos == '3-col' ) {
            $css_var .= <<<CSS
#page {
width: {$tech_page_width}{$tech_sign}
}
.narrowcolumn {
float:left;
margin:0 1%;
padding:25px 0 20px 0;
width:{$tech_main_column_width}%;
}
#r_sidebar {
float:right;
padding:25px 2% 0 0;
width:{$tech_r_sidebar_width}%
}
CSS;
            $tech_l_sidebar_width = $tech_l_sidebar_width - 2;
            $css_var .= <<<CSS
#l_sidebar {
float:left;
padding:25px 0 0 2%;
width:{$tech_l_sidebar_width}%
}
CSS;
        } else {
            $css_var .= <<<CSS
#page {
width: {$tech_page_width}{$tech_sign}
}
.narrowcolumn {
float:left;
margin:0 1%;
padding:25px 0 20px 0;
width:{$tech_main_column_width}%;
}
#r_sidebar {
float:left;
padding:25px 2% 0 0;
width:{$tech_r_sidebar_width}%
}
CSS;
            $tech_l_sidebar_width = $tech_l_sidebar_width - 2;
            $css_var .= <<<CSS
#l_sidebar {
float:left;
padding:25px 0 0 2%;
width:{$tech_l_sidebar_width}%
}
CSS;
        }
    }
    $css_var .= <<<CSS
#header ul#nav,#header ul#nav2,#header ul#dropdown,#header ul.top-menu{
{$tech_nav_align};
}
CSS;
    if ( of_get_option( 'nav_button_width', '0' ) != '0' ) {
        $tech_nav_button_width = of_get_option( 'nav_button_width', '0' );
        $css_var .= <<<CSS
#navmenu ul#admin li, #nav2 li,#dropdown li, #navmenu .top-menu li{
width: {$tech_nav_button_width}px;
} 
CSS;
    }
    if ( $tech_nav_align_check == "center" ) {
        $css_var .= <<<CSS
#navwrap {
float:left;
position:relative;
left:50%;
}
ul#admin{
margin-top:30px !important;
}
#dropdown, .top-menu{
position:relative;
clear:both;
left:-50%;
}
CSS;
    }
    $tech_hwidget_height = of_get_option( 'header_height', '200' ) - 40;
    $css_var .= <<<CSS
#header {
background-repeat: no-repeat;  
background-position: {$tech_header_v_align} {$tech_header_align};
height: {$tech_header_height}px;
}
.hleft, .hright {
height: {$tech_hwidget_height}px;
}
CSS;


    if ( of_get_option( 'blog_title_box', '1' ) == "0" ) {
        $css_var .= <<<CSS
#headerimg {
background-color:transparent;
-moz-opacity:1;
-khtml-opacity:1;
opacity:1;
box-shadow:none;
-moz-box-shadow:none;
-webkit-box-shadow:none;
}
.description {
border-top:1px solid #444444;
}
CSS;
    }
    $css_var .= of_get_option( 'custom_styles', '' );
    $css_var .= '</style>';
    if ( of_get_option( 'minify', '1' ) == 1 ) {
        echo str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css_var );
    } else {
        echo $css_var;
    }
}

?>