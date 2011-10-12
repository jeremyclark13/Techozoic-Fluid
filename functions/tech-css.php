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
if (!is_admin()){
    add_action('wp_head','tech_head_css');
}

function tech_google_font_family($where) {
    $classes = of_get_option('font_headings','');
    if(is_array($classes)){
        foreach($classes as $key => $value){
            if ($value == '1' && $key == $where){
                    return of_get_option('google_font_family','') . ', ';
            }
        }
    }
}
function tech_head_css(){	
	$tech_blog_title_display = '';
	$tech_blog_title_cursor = '';
        $tech_header_font = of_get_option('post_heading',array('size'=>"20px",'face'=>'verdana','style'=>'bold','color'=>'#2C4353'));
        $tech_main_heading_font = of_get_option('main_heading_font',array('size'=>"30px",'face'=>'verdana','style'=>'bold','color'=>'#A0B3C2'));
	$tech_sidebar_font = of_get_option('side_heading_font',array('size'=>"16px",'face'=>'verdana','style'=>'bold','color'=>'#2C4353'));
        $tech_body_font = of_get_option('body_font',array('size'=>"10px",'face'=>'arial','style'=>'','color'=>'#2C4353'));
        $tech_post_font = of_get_option('post_text_font', array('size'=>"10px",'face'=>'arial','style'=>'','color'=>'#2C4353'));
        $tech_small_font = of_get_option('small_font',array('size'=>"9px",'face'=>'arial','style'=>'','color'=>'#777777'));
        $tech_nav_font = of_get_option('nav_font',array('size'=>"13px",'face'=>'verdana','style'=>'bold','color'=>'#A0B3C2'));
        $tech_header_align = strtolower(of_get_option('header_align','center'));
        $tech_header_v_align = strtolower(of_get_option('header_v_align','center'));
	$tech_bg_image = of_get_option('bg_image',array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll'));
        $tech_page_width = of_get_option('page_width','90');
        $tech_main_column_width = of_get_option('main_column_width','50');
        $tech_l_sidebar_width = of_get_option('l_sidebar_width','25');
        $tech_r_sidebar_width = of_get_option('l_sidebar_width','25');
        $tech_header_height = of_get_option('header_height','200');
        $tech_column = of_get_option('column','3');
        $tech_sidebar_pos = of_get_option('sidebar_pos','3-col');
	$tech_content_bg_image = of_get_option('content_bg_image',array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll'));
	if (of_get_option('page_type','fluid') == 'fixed'){$tech_sign = 'px';} else {$tech_sign = '%';}
	if ($tech_page_width == 0 ) { $tech_page_width = '95'; $tech_sign = '%';}
	if (of_get_option('page_type','fluid') == 'fluid' && $tech_page_width > 101)  $tech_page_width = '100';
	if (of_get_option('blog_title','1') == '0')  $tech_blog_title_display = 'display:none';
	if (of_get_option('blog_title_text','single') == 'single') $tech_blog_title_cursor = 'cursor:default;';
	$tech_blog_title_align_check ="";
	$tech_nav_align_check ="";
	switch (of_get_option('blog_title_align','left')){
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
	switch (of_get_option('nav_align','left')){
		case "center":
			$tech_nav_align = 'float:left;position:relative;left:-50%';
			$tech_nav_align_check = "Center";
		break;
		case "left":
			$tech_nav_align = '';
		break;
	}
	
	$tech_blog_title_font = tech_google_font_family('main') .  $tech_main_heading_font['face'];
	$tech_h1_font = tech_google_font_family('h1') . $tech_header_font['face'];
	$tech_h2_font = tech_google_font_family('h2') . $tech_header_font['face'];
	$tech_h3_font = tech_google_font_family('h3') . $tech_header_font['face'];
	$tech_h4_font = tech_google_font_family('h4') . $tech_header_font['face'];
	$tech_h5_font = tech_google_font_family('h5') . $tech_header_font['face'];
	$tech_sidebar_font = tech_google_font_family('sidebar') . $tech_sidebar_font['face'];
	$tech_post_title_font = tech_google_font_family('post') . $tech_header_font['face'];

	$tech_color_scheme = of_get_option('color_scheme','custom_1');
	$tech_default_color = array(
		"blue" => 	array ('#A0B3C2','#A0B3C2','#597EAA','#114477','#2C4353','#2C4353','#E3E3E3','#E3E3E3','#F7F7F7'),
		"khaki" => 	array ('#c7c69a','#c7c69a','#6E0405','#B53839','#2C4353','#2C4353','#E3E3E3','#E3E3E3','#F7F7F7'),
		"red" => 	array ('#AB2222','#AB2222','#D33535','#B53839','#2C4353','#2C4353','#E3E3E3','#E3E3E3','#F7F7F7'),
		"grunge" => 	array ('#534E3E','#534E3E','#78BFBF','#78BFBF','#2C4353','#2C4353','#E3E3E3','#E3E3E3','#F7F7F7')
	);
        $tech_color_names = array('blue','khaki','red','grunge');
        if (in_array($tech_color_scheme, $tech_color_names)){
            $tech_bg_color =            $tech_default_color[$tech_color_scheme][0];
            $tech_acc_color =           $tech_default_color[$tech_color_scheme][1];
            $tech_link_color =          $tech_default_color[$tech_color_scheme][2];
            $tech_link_hov_color = 	$tech_default_color[$tech_color_scheme][3];
            $tech_visit_link_color = 	$tech_default_color[$tech_color_scheme][4];
            $tech_text_color =          $tech_default_color[$tech_color_scheme][5];
            $tech_nav_bg_color = 	$tech_default_color[$tech_color_scheme][6];
            $tech_post_bg_color = 	$tech_default_color[$tech_color_scheme][7];
            $tech_content_bg_color =    $tech_default_color[$tech_color_scheme][8];
        } elseif ($tech_color_scheme == 'custom_1'){
            $tech_bg_color =            of_get_option('cust_bg_color1','#A0B3C2');
            $tech_bg_trans =            of_get_option('cust_bg_trans1','0');
            $tech_acc_color =           of_get_option('cust_acc_color1','#A0B3C2');
            $tech_link_color =          of_get_option('cust_link_color1','#597EAA');
            $tech_link_hov_color =      of_get_option('cust_link_hov_color1','#114477');
            $tech_visit_link_color =    of_get_option('cust_link_visit_color1','#2C4353');
            $tech_text_color =          of_get_option('cust_text_color1','#2C4353');
            $tech_nav_bg_color =        of_get_option('cust_nav_bg_color1','#E3E3E3');
            $tech_nav_bg_trans =        of_get_option('cust_nav_bg_trans1','0');
            $tech_post_bg_color =       of_get_option('cust_post_bg_color1','#E3E3E3');
            $tech_post_bg_trans =       of_get_option('cust_post_bg_trans1','0');
            $tech_content_bg_color =    of_get_option('cust_content_bg_color1','#F7F7F7');
            $tech_content_bg_trans =    of_get_option('cust_content_bg_trans1','0');
        } else {
            $tech_bg_color =            of_get_option('cust_bg_color2','#A0B3C2');
            $tech_bg_trans =            of_get_option('cust_bg_trans2','0');
            $tech_acc_color =           of_get_option('cust_acc_color2','#A0B3C2');
            $tech_link_color =          of_get_option('cust_link_color2','#597EAA');
            $tech_link_hov_color = 	of_get_option('cust_link_hov_color2','#114477');
            $tech_visit_link_color = 	of_get_option('cust_link_visit_color2','#2C4353');
            $tech_text_color =          of_get_option('cust_text_color2','#2C4353');
            $tech_nav_bg_color =	of_get_option('cust_nav_bg_color2','#E3E3E3');
            $tech_nav_bg_trans =        of_get_option('cust_nav_bg_trans2','0');
            $tech_post_bg_color = 	of_get_option('cust_post_bg_color2','#E3E3E3');
            $tech_post_bg_trans =       of_get_option('cust_post_bg_trans2','0');
            $tech_content_bg_color =    of_get_option('cust_content_bg_color2','#F7F7F7');
            $tech_content_bg_trans =    of_get_option('cust_content_bg_trans2','0');
        }
        $tech_nav_ul_bg_color = $tech_nav_bg_color;
        if ($tech_bg_trans == '1') $tech_bg_color = 'transparent';
        if ($tech_nav_bg_trans == '1') $tech_nav_bg_color = 'transparent';
        if ($tech_post_bg_trans == '1')  $tech_post_bg_color = 'transparent';
        if ($tech_content_bg_trans == '1') $tech_content_bg_color = 'transparent';
	$tech_sidebar_h3_font = of_get_option('side_heading_font_size',array('size'=>"16px",'face'=>'verdana','style'=>'bold','color'=>'#2C4353'));
	$tech_sidebar_h3_font_size = $tech_sidebar_h3_font['size'];
        $tech_drop_shadow_classes = ".noclass";
        $tech_drop_shadow = of_get_option('drop_shadow','');
        $tech_drop_shadow_class_map = array(
            "header" => "#headerimg",
            "post" => ".home .narrowcolumn .entry, .home .widecolumn .entry, .top, .archive .entry",
            "image" => ".entry img, .entrytext img"
        );
        if(is_array($tech_drop_shadow)){
            foreach ($tech_drop_shadow as $key => $value){
                if($value == '1'){
                    $tech_drop_shadow_classes .= ",". $tech_drop_shadow_class_map[$key];
                }
            }
        }
	$tech_post_bg_color_classes = ".noclass";
        $tech_post_bg_color_loc = of_get_option('post_background_location',array("main" =>"1",'archive'=>'1'));
        $tech_post_bg_color_class_map = array(
            "main" => '.home .narrowcolumn .entry, home .widecolumn .entry, .top', 
            "single" => '.post .singlepost',
            "archive" => '.archive .narrowcolumn .entry, .archive .widecolumn .entry, .top'
        );
        if(is_array($tech_post_bg_color_loc)){
            foreach ($tech_post_bg_color_loc as $key => $value){
                if($value == '1'){
                    $tech_post_bg_color_classes .= ",". $tech_post_bg_color_class_map[$key];
                }
            }
        }
        
$css_var = '<style type="text/css">';
$css_var .=  <<<CSS
/*Variable Styles*/
#page{ 
background:{$tech_content_bg_color} url({$tech_content_bg_image['image']}) {$tech_content_bg_image['repeat']} {$tech_content_bg_image['position']} {$tech_content_bg_image['attachment']};
}
body{
font-family:{$tech_body_font['face']}, Sans-Serif;
font-size: {$tech_body_font['size']};
background:{$tech_bg_color} url({$tech_bg_image['image']}) {$tech_bg_image['repeat']} {$tech_bg_image['position']} {$tech_bg_image['attachment']};
}
.techozoic_font_size{
font-size: {$tech_body_font['size']}px;
}
.narrowcolumn .entry,.widecolumn .entry, .top {
font-family:{$tech_body_font['face']}, Sans-Serif;
}
{$tech_post_bg_color_classes}{
background-color:{$tech_post_bg_color};
border-top:1px {$tech_acc_color} solid;
}
.top{
border:none;
}
h1{
font-family:{$tech_h1_font}, Sans-Serif;
}
h2{
font-family:{$tech_h2_font}, Sans-Serif;
}
h3{
font-family:{$tech_h3_font}, Sans-Serif;
}
h4{
font-family:{$tech_h4_font}, Sans-Serif;
}
h5{
font-family:{$tech_h5_font}, Sans-Serif;
}
.blog_title, .blog_title a, .blog_title a:hover, .blog_title a:visited{
font:{$tech_main_heading_font['style']} {$tech_main_heading_font['size']} {$tech_blog_title_font}, Sans-Serif;
color: {$tech_main_heading_font['color']};
}
.post_title{
font-family:{$tech_post_title_font}, Sans-Serif;
}
.sidebar h2, .sidebar h3, #footer h2{
font-family:{$tech_sidebar_font}, Sans-Serif;
}
.post_title {
font-size: {$tech_header_font['size']};
}
.widgettitle {
font-size: {$tech_sidebar_font['size']};
margin: 1px 0;
}
.sidebar h3 {
font-size: {$tech_sidebar_h3_font_size};
}
#content {
font-size: {$tech_post_font['size']};
}
acronym,abbr,span.caps,small,.trackback li,#commentform input,#commentform textarea,.sidebar {
font-size: {$tech_small_font['size']};
}
.description, ul#nav a, ul#admin a, #dropdown li.current_page_item a:hover, .menu li.current-menu-item a:hover, #dropdown li.current_page_item ul a, .menu li.current-menu-item ul a, ul#nav li.current_page_item a:hover, #nav2 a, #nav2 li.current_page_item a:hover,#subnav a, #subnav a:visited, #dropdown a, #navmenu .menu li a, #navmenu .menu li.current-menu-item a{
color: {$tech_acc_color};
}
.author,#searchform #s, #searchsubmit:hover,#catsubmit:hover,#wp-submit:hover,.postform,#TB_ajaxContent {
background-color: {$tech_acc_color} ;
}
ul#admin li, ul#dropdown li, #navmenu .menu li{
background-color: {$tech_nav_bg_color};
}
ul#admin li, ul#dropdown li a, #navmenu .menu li a{
font-family:{$tech_nav_font['face']}, Sans-Serif;
font-size:{$tech_nav_font['size']};
}
#navmenu .menu ul.sub-menu li{
background-color: {$tech_nav_ul_bg_color};
}
CSS;
if($tech_nav_bg_trans != 'On') {
$css_var .=  <<<CSS
#dropdown li.current_page_item, #navmenu .menu li.current-menu-item {
background-color: {$tech_acc_color} ;
}
#dropdown li:hover, #navmenu .menu li:hover {
background:#efefef;
box-shadow:2px -1px 3px rgba(0, 0, 0, 0.3);
-moz-box-shadow:2px -1px 3px rgba(0, 0, 0, 0.3);
-webkit-box-shadow:2px -1px 3px rgba(0, 0, 0, 0.3);
}
#dropdown li.current_page_item a, #navmenu .menu li.current-menu-item a{
color:#f7f7f7;
}
ul#admin li:hover{
background:#efefef;
box-shadow:2px 1px 3px rgba(0, 0, 0, 0.3);
-moz-box-shadow:2px 1px 3px rgba(0, 0, 0, 0.3);
-webkit-box-shadow:2px 1px 3px rgba(0, 0, 0, 0.3);
}
CSS;
} else {
$css_var .= <<<CSS
#dropdown li.current_page_item, #navmenu .menu li.current-menu-item {
background-color: transparent ;
}
#dropdown li:hover, #navmenu .menu li:hover {
background-color:transparent;
box-shadow:none;
-moz-box-shadow:none;
-webkit-box-shadow:none;
}
#dropdown li.current_page_item a, #navmenu .menu li.current-menu-item a{
color:#f7f7f7;
}
ul#admin li:hover{
background-color:transparent;
box-shadow:none;
-moz-box-shadow:none;
-webkit-box-shadow:none;
}
CSS;
}
$css_var .= <<<CSS
.post_date {
background-color:{$tech_acc_color};
}
.tags {
border-bottom:1px {$tech_acc_color} solid;
}
#content,h2,h2 a,h2 a:visited,h3,h3 a,h3 a:visited,h4,h5{
color:{$tech_text_color};
}
a,h2 a:hover,h3 a:hover,.commentdiv a, .commentdiv a:visited,#user_login,#user_pass,.postform,.commentdiv span, #sidenav a:visited {
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
ul#nav li.current_page_item a:hover, ul#nav2 li.current_page_item a:hover, ul#nav2 li.current_page_parent a:hover {
color:{$tech_acc_color};
}
#headerimg {
{$tech_blog_title_display};
{$tech_blog_title_align};
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
	if ($tech_blog_title_align_check == "Center" && is_active_sidebar( 'left_header' ) ){
$css_var .= <<<CSS
#headerimgwrap {
float:left;
position:absolute;
left:15%;
}
CSS;
	} else if ($tech_blog_title_align_check == "Center" && !is_active_sidebar( 'left_header' ) ){
$css_var .= <<<CSS
#headerimgwrap {
float:left;
position:absolute;
left:50%;
}
CSS;
	}
	if ($tech_column == 1) {
		if ($tech_main_column_width == 0) 
			$tech_main_column_width = 100; 
		$tech_main_column_width = $tech_main_column_width - 6;
$css_var .= <<<CSS
#page {
width: {$tech_page_width}{$tech_sign};
}
.narrowcolumn {
float:left;
margin:0;
padding:0 2% 20px 3%;
width:{$tech_main_column_width}%;
}
CSS;
	} else if ($tech_column == 2) {
		if ($tech_sidebar_pos =='2-col-right') {
			if ($tech_main_column_width == 0 && $tech_r_sidebar_width != 0 ) {
				$tech_main_column_width = 97 - $tech_r_sidebar_width;
			} elseif ($tech_main_column_width == 0 ){
				$tech_main_column_width = 70;
			}
			if ($tech_r_sidebar_width == 0 && $tech_main_column_width != 70) {  
				$tech_r_sidebar_width = 96 - $tech_main_column_width;
			} elseif ($tech_r_sidebar_width == 0){
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
padding:0 2% 20px 3%;
width:{$tech_main_column_width}%;
}
#r_sidebar {
float:right;
padding:10px 2% 0 1%;
width:{$tech_r_sidebar_width}%
}
CSS;
		} else { 
			if ($tech_main_column_width == 0 && $tech_l_sidebar_width != 0 ) {
				$tech_main_column_width = 97 - $tech_l_sidebar_width;
			} elseif ($tech_main_column_width == 0){
				$tech_main_column_width = 70;
			}
			if ($tech_l_sidebar_width == 0 && $tech_main_column_width != 70) {  
				$tech_l_sidebar_width = 96 - $tech_main_column_width;
			} elseif ($tech_l_sidebar_width == 0){
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
padding:0 3% 20px 2%;
width:{$tech_main_column_width}%;
}
#l_sidebar {
float:left;
padding:10px 1% 0 2%;
width:{$tech_l_sidebar_width}%
}
CSS;
		}
	} else {
		if ($tech_main_column_width == 0 && $tech_l_sidebar_width != 0 && $tech_r_sidebar_width != 0) {
			$tech_main_column_width = 96 - ($tech_l_sidebar_width + $tech_r_sidebar_width);
		} elseif ($tech_main_column_width == 0) {
			$tech_main_column_width = 55;
		}
		if ($tech_l_sidebar_width == 0 && $tech_r_sidebar_width == 0 && $tech_main_column_width != 55) {  
			$tech_l_sidebar_width = (98 - $tech_main_column_width) / 2;
			$tech_r_sidebar_width = (98 - $tech_main_column_width) / 2;
		} elseif ($tech_l_sidebar_width == 0 && $tech_r_sidebar_width == 0) {
			$tech_l_sidebar_width = 22;
			$tech_r_sidebar_width = 22;
		} 
		$tech_main_column_width = $tech_main_column_width - 2;
		$tech_l_sidebar_width = $tech_l_sidebar_width - 2;
		$tech_r_sidebar_width = $tech_r_sidebar_width - 2;
		if ($tech_sidebar_pos =='3-col_right') {
$css_var .= <<<CSS
#page {
width: {$tech_page_width}{$tech_sign}
}
.narrowcolumn {
float:left;
margin:0 0 0 2%;
padding:0 0 20px 0;
width:{$tech_main_column_width}%;
}
#l_sidebar {
float:right;
padding:10px 0 0 2%;
width:{$tech_l_sidebar_width}%
}
#r_sidebar {
float:right;
clear:right;
padding:10px 2% 0 0;
width:{$tech_r_sidebar_width}%
}
CSS;
		} elseif ($tech_sidebar_pos =='3-col') { 
$css_var .= <<<CSS
#page {
width: {$tech_page_width}{$tech_sign}
}
.narrowcolumn {
float:left;
margin:0 1%;
padding:0 0 20px 0;
width:{$tech_main_column_width}%;
}
#r_sidebar {
float:right;
padding:10px 2% 0 0;
width:{$tech_r_sidebar_width}%
}
CSS;
$tech_l_sidebar_width = $tech_l_sidebar_width - 2;
$css_var .= <<<CSS
#l_sidebar {
float:left;
padding:10px 0 0 2%;
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
padding:0 0 20px 0;
width:{$tech_main_column_width}%;
}
#r_sidebar {
float:left;
padding:10px 2% 0 0;
width:{$tech_r_sidebar_width}%
}
CSS;
$tech_l_sidebar_width = $tech_l_sidebar_width - 2;
$css_var .= <<<CSS
#l_sidebar {
float:left;
padding:10px 0 0 2%;
width:{$tech_l_sidebar_width}%
}
CSS;
		}
	}
$css_var .= <<<CSS
#header ul#nav,#header ul#nav2,#header ul#dropdown,#header ul.menu{
{$tech_nav_align};
}
CSS;
	if (of_get_option('nav_button_width','0') != '0') { 
$css_var .= <<<CSS
#navmenu ul#nav li, #navmenu ul#admin li, #nav2 li,#dropdown li, #navmenu .menu li{
width: {$tech['nav_button_width']}em;
} 
CSS;
	}
	if ($tech_nav_align_check == "center") {
$css_var .= <<<CSS
#navwrap {
float:left;
position:relative;
left:50%;
}
ul#admin{
margin-top:30px !important;
}
ul#subnav{
position:relative;
clear:both;
left:-50%;
}
CSS;
	}
$tech_hwidget_height = of_get_option('header_height','200') - 40;
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

	
if ($tech['blog_title_box'] == "On") {
$css_var .= <<<CSS
#headerimg {
background-color:#f7f7f7;
-moz-opacity:0.85;
-khtml-opacity:0.85;
opacity:.85;
box-shadow:2px 2px 6px rgba(0, 0, 0, 0.5);
-moz-box-shadow:2px 2px 6px rgba(0, 0, 0, 0.5);
-webkit-box-shadow: 2px 2px 6px rgba(0,0,0,0.5);
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
}
.description {
border-top:1px solid #444444;
}
CSS;
}
$css_var .= of_get_option('custom_styles','');
$css_var .= '</style>';
echo $css_var;
}
?>