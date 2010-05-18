<?php 
	global $tech;
	$tech = get_option('techozoic_options');
	if ($tech['head_css'] == "no"){
		if(!headers_sent()) {
			header('Content-type: text/css');   
			header("Cache-Control: must-revalidate"); 
			$offset = 72000 ; 
			$ExpStr = 'Expires: ' . gmdate("D, d M Y H:i:s", time() + $offset) . ' GMT'; 
			header($ExpStr);
		}
	}
	// Setup Custom Function
	function sanitize_text($text) {
		$text = stripslashes($text);
		$text = preg_replace('/<(.|\n)*?>/i', '', $text);
		return $text;
	}
	function sanitize_num($text) {
		$text = stripslashes($text);
		$text = preg_replace('/[^0-9]/', '', $text);
		return $text;
	}
	function tech_font($font) {
		switch ($font){
			case "Trebuchet MS":
				$font = '"Trebuchet MS", Helvetica';
			break;
			case "Tahoma":
				$font = $font . ', Geneva';
			break;
			case "Times New Roman":
				$font = '"Times New Roman", Times';
			break;
			case "Lucida Sans Unicode":
				$font = '"Lucida Sans Unicode" , "Lucida Grande"';
			break;
			case "Impact":
				$font = 'Impact, Charcoal';
			break;
		}
		return $font;
	}
	
	function tech_color_verify($color){
		if ($color){
			if ($color[0] != '#')
				$color = '#'.$color;
			return $color;
		}
	}
	
	$tech['blog_title_display'] = '';
	$tech['blog_title_cursor'] = '';
	$tech['header_align'] = strtolower($tech['header_align']);
	$bg_image_repeat = explode(',', $tech['bg_image_repeat']);
	if (in_array("X" , $bg_image_repeat)) {
		$tech_bg_repeat = "-x";
	}
	if (in_array("Y" , $bg_image_repeat)) {
		if ($tech_bg_repeat == "-x"){
			unset($tech_bg_repeat);
		} else {
			$tech_bg_repeat = "-y";
		}
	}
	$content_bg_image_repeat = explode(',', $tech['content_bg_image_repeat']);
	if (in_array("X" , $content_bg_image_repeat)) {
		$tech_content_bg_repeat = "-x";
	}
	if (in_array("Y" , $content_bg_image_repeat)) {
		if ($tech_content_bg_repeat == "-x"){
			unset($tech_content_bg_repeat);
		} else {
			$tech_content_bg_repeat = "-y";
		}
	}
	if ($tech['test'] != 'set'){
		$tech['column'] = 3;
		$tech['sidebar_pos'] = 'Sidebar - Content - Sidebar';
		$tech['header'] = 'Grunge';
		$tech['header_font'] = 'Verdana';
		$tech['body_font'] = 'Lucida Sans Unicode';
		$tech['default_font'] = 'Lucida Sans Unicode';
		$tech['color_scheme'] = 'Blue';
		$tech['main_column_width'] = 0;
		$tech['sidebar_width'] = 0;
		$tech['page_width'] = 0;
		$tech['body_font_size'] = 10;
		$tech['blog_title_align'] = 'float:left;margin-left:10px';
	}
	
	if ($tech['page_type'] == 'Fixed Width'){$tech['sign'] = 'px';} else {$tech['sign'] = '%';}
	if ($tech['page_width'] == 0 ) { $tech['page_width'] = '95'; $tech['sign'] = '%';}
	if ($tech['page_type'] == 'Fluid Width' && $tech['page_width'] > 101)  $tech['page_width'] = '100';
	if ($tech['blog_title'] == 'No')  $tech['blog_title_display'] = 'display:none';
	if ($tech['blog_title_text'] == 'Single Post Title') $tech['blog_title_cursor'] = 'cursor:default;';
	switch ($tech['blog_title_align']){
		case "Left":
			$tech['blog_title_align'] = 'float:left;margin-left:10px';
		break;
		case "Right":
			$tech['blog_title_align'] = 'float:right;margin-right:10px';
		break;
		case "Center":
			$tech['blog_title_align'] = 'float:left;position:relative;left:-50%';
			$tech_blog_title_align_check = "Center";
		break;
	}
	switch ($tech['nav_align']){
		case "Center":
			$tech['nav_align'] = 'float:left;position:relative;left:-50%';
			$tech_nav_align_check = "Center";
		break;
	}
	$tech['default_font'] = tech_font($tech['default_font']);
	$tech['body_font'] = tech_font($tech['body_font']);
	$tech['header_font'] = tech_font($tech['header_font']);
	$cufon_header_size = $tech['main_heading_font_size'] ;
	$cufon_sidebar_size = "1.6";
	$tech_color_scheme = $tech['color_scheme'];
	$tech_default_color = array(
		"Blue" => 	array ('#A0B3C2','#A0B3C2','#597EAA','#114477','#2C4353','#E3E3E3','#E3E3E3','#F7F7F7'),
		"Khaki" => 	array ('#c7c69a','#c7c69a','#6E0405','#B53839','#2C4353','#E3E3E3','#E3E3E3','#F7F7F7'),
		"Red" => 	array ('#AB2222','#AB2222','#D33535','#B53839','#2C4353','#E3E3E3','#E3E3E3','#F7F7F7'),
		"Grunge" => 	array ('#534E3E','#534E3E','#78BFBF','#78BFBF','#2C4353','#E3E3E3','#E3E3E3','#F7F7F7')
	);
	$tech_color_names = array('Blue','Khaki','Red','Grunge');
	if (in_array($tech['color_scheme'], $tech_color_names)){
		$tech_bg_color = 	$tech_default_color[$tech_color_scheme][0];
		$tech_acc_color = 	$tech_default_color[$tech_color_scheme][1];
		$tech_link_color = 	$tech_default_color[$tech_color_scheme][2];
		$tech_link_hov_color = 	$tech_default_color[$tech_color_scheme][3];
		$tech_text_color = 	$tech_default_color[$tech_color_scheme][4];
		$tech_nav_bg_color = 	$tech_default_color[$tech_color_scheme][5];
		$tech_post_bg_color = 	$tech_default_color[$tech_color_scheme][6];
		$tech_content_bg_color =$tech_default_color[$tech_color_scheme][7];
	} elseif ($tech['color_scheme'] == 'Custom 1'){
		$tech_bg_color = 	tech_color_verify($tech['cust_bg_color1']);
		$tech_acc_color =	tech_color_verify($tech['cust_acc_color1']);
		$tech_link_color = 	tech_color_verify($tech['cust_link_color1']);
		$tech_link_hov_color = 	tech_color_verify($tech['cust_link_hov_color1']);
		$tech_text_color =	tech_color_verify($tech['cust_text_color1']);
		$tech_nav_bg_color =	tech_color_verify($tech['cust_nav_bg_color1']);
		$tech_post_bg_color = 	tech_color_verify($tech['cust_post_bg_color1']);
		$tech_content_bg_color =tech_color_verify($tech['cust_content_bg_color1']);
	} else {
		$tech_bg_color = 	tech_color_verify($tech['cust_bg_color2']);
		$tech_acc_color =	tech_color_verify($tech['cust_acc_color2']);
		$tech_link_color = 	tech_color_verify($tech['cust_link_color2']);
		$tech_link_hov_color = 	tech_color_verify($tech['cust_link_hov_color2']);
		$tech_text_color = 	tech_color_verify($tech['cust_text_color2']);
		$tech_nav_bg_color =	tech_color_verify($tech['cust_nav_bg_color2']);
		$tech_post_bg_color = 	tech_color_verify($tech['cust_post_bg_color2']);
		$tech_content_bg_color =tech_color_verify($tech['cust_content_bg_color2']);
	}
	$tech_sidebar_h3_font_size = $tech['side_heading_font_size'] - .4;
	$tech_wp_content = WP_CONTENT_URL;
	$header_folder = WP_CONTENT_DIR. "/techozoic/images/headers";
	if (!file_exists($header_folder)){
		$home = get_bloginfo('template_directory');
	} else {
		$home = WP_CONTENT_URL ."/techozoic";
	}
echo <<<CSS
/*Techozoic {$tech['ver']}*/

/*Variable Styles*/
#page{ 
background:{$tech_content_bg_color} url({$tech['content_bg_image']}) repeat{$tech_content_bg_repeat} top left;
}
body{
font-family:{$tech['default_font']}, Sans-Serif;
font-size: {$tech['body_font_size']}px;
background:{$tech_bg_color} url({$tech['bg_image']}) repeat{$tech_bg_repeat} top left;
}
.narrowcolumn .entry,.widecolumn .entry,.top {
font-family:{$tech['body_font']}, Sans-Serif;
background-color:{$tech_post_bg_color};
}
h1,h2,h3,h4,h5{
font-family:{$tech['header_font']}, Sans-Serif;
}
h1{
font-size: {$tech['main_heading_font_size']}em;
}
h2 {
font-size: {$tech['post_heading_font_size']}em;
}
.sidebar h2, #footer h2, .widgettitle {
font-size: {$tech['side_heading_font_size']}em;
}
.sidebar h3 {
font-size: {$tech_sidebar_h3_font_size}em;
}
#content {
font-size: {$tech['post_text_font_size']}em;
}
acronym,abbr,span.caps,small,.commentlist li,.trackback li,#commentform input,#commentform textarea,.sidebar {
font-size: {$tech['small_font_size']}em;
}
.description, ul#nav a, ul#admin a, ul#nav li.current_page_item a:hover,#headerimg h1 a, #nav2 a, #nav2 li.current_page_item a:hover,#subnav a, #subnav a:visited, #dropdown a .menu a{
color: {$tech_acc_color};
}
.author,#searchform #s,ul#nav li.current_page_item,#nav2 li.current_page_item,#nav2 li.current_page_parent,ul#nav2 li.current_page_ancestor, #searchsubmit:hover,#catsubmit:hover,#wp-submit:hover,.postform,#TB_ajaxContent {
background-color: {$tech_acc_color} ;
}
#dropdown li.current_page_item, .menu li.current-menu-item  {
border: 1px solid {$tech_acc_color};
}
ul#nav li,ul#admin li, #nav2 li, #dropdown li, .menu li {
font-family:{$tech['body_font']}, Sans-Serif;
background-color: {$tech_nav_bg_color};
}
.post_date {
background-color:{$tech_acc_color};
}
.narrowcolumn .entry,.widecolumn .entry,.tags {
border-top:1px {$tech_acc_color} solid;
}
.tags {
border-bottom:1px {$tech_acc_color} solid;
}
#content,h2,h2 a,h2 a:visited,h3,h3 a,h3 a:visited,a:visited,h4,h5{
color:{$tech_text_color};
}
a,h2 a:hover,h3 a:hover,.commentdiv a,.date_post,#searchform #s,#user_login,#user_pass,.postform,.commentdiv span, #sidenav a:visited {
color:{$tech_link_color}; 
text-decoration:none;
}
a:hover,#headerimg h1 a:hover {
color:{$tech_link_hov_color}; 
text-decoration:underline;
}
ul#nav li.current_page_item a:hover, ul#nav2 li.current_page_item a:hover, ul#nav2 li.current_page_parent a:hover {
color:{$tech_acc_color};
}
#headerimg {
{$tech['blog_title_display']};
{$tech['blog_title_align']};
}
.single #headerimg h1 a:hover {
{$tech['blog_title_cursor']}
text-decoration:none;
}
CSS;
	if ($tech_blog_title_align_check == "Center") {
echo <<<CSS
#headerimgwrap {
float:left;
position:relative;
left:50%;
}
CSS;
	}
	if ($tech['column'] == 1) {
		if ($tech['main_column_width'] == 0) 
			$tech['main_column_width'] = 100; 
		$tech['main_column_width'] = $tech['main_column_width'] - 6;
echo <<<CSS
#page {
width: {$tech['page_width']}{$tech['sign']};
}
.narrowcolumn {
float:left;
margin:0;
padding:0 2% 20px 3%;
width:{$tech['main_column_width']}%;
}
CSS;
	} else if ($tech['column'] == 2) {
		if ($tech['main_column_width'] == 0 && $tech['sidebar_width'] != 0) {
			$tech['main_column_width'] = 97 - $tech['sidebar_width'];
		} elseif ($tech['main_column_width'] == 0){
			$tech['main_column_width'] = 70;
		}
		if ($tech['sidebar_width'] == 0 && $tech['main_column_width'] != 70) {  
			$tech['sidebar_width'] = 96 - $tech['main_column_width'];
		} elseif ($tech['sidebar_width'] == 0){
			$tech['sidebar_width'] = 23;
		}
		$tech['main_column_width'] = $tech['main_column_width'] - 5;
		$tech['sidebar_width'] = $tech['sidebar_width'] - 3;
echo <<<CSS
#page {
width: {$tech['page_width']}{$tech['sign']};
}
.narrowcolumn {
float:left;
margin:0;
padding:0 2% 20px 3%;
width:{$tech['main_column_width']}%;
}
#r_sidebar {
float:right;
padding:10px 2% 0 1%;
width:{$tech['sidebar_width']}%
}
CSS;
	} else {
		if ($tech['main_column_width'] == 0 && $tech['sidebar_width'] != 0) {
			$tech['main_column_width'] = 96 - ($tech['sidebar_width'] * 2);
		} elseif ($tech['main_column_width'] == 0) {
			$tech['main_column_width'] = 55;
		}
		if ($tech['sidebar_width'] == 0 && $tech['main_column_width'] != 55) {  
			$tech['sidebar_width'] = (98 - $tech['main_column_width']) / 2;
		} elseif ($tech['sidebar_width'] == 0) {
			$tech['sidebar_width'] = 22;
		} 
		$tech['main_column_width'] = $tech['main_column_width'] - 2;
		$tech['sidebar_width'] = $tech['sidebar_width'] - 2;
		if ($tech['sidebar_pos'] =='Content - Sidebar - Sidebar') {
echo <<<CSS
#page {
width: {$tech['page_width']}{$tech['sign']}
}
.narrowcolumn {
float:left;
margin:0 0 0 2%;
padding:0 0 20px 0;
width:{$tech['main_column_width']}%;
}
#l_sidebar {
float:right;
padding:10px 0 0 2%;
width:{$tech['sidebar_width']}%
}
#r_sidebar {
float:right;
clear:right;
padding:10px 2% 0 0;
width:{$tech['sidebar_width']}%
}
CSS;
		} else { 
echo <<<CSS
#page {
width: {$tech['page_width']}{$tech['sign']}
}
.narrowcolumn {
float:left;
margin:0 1%;
padding:0 0 20px 0;
width:{$tech['main_column_width']}%;
}
#r_sidebar {
float:right;
padding:10px 2% 0 0;
width:{$tech['sidebar_width']}%
}
CSS;
$tech['sidebar_width'] = $tech['sidebar_width'] - 2;
echo <<<CSS
#l_sidebar {
float:left;
padding:10px 0 0 2%;
width:{$tech['sidebar_width']}%
}
CSS;
		}
	}
echo <<<CSS
ul#nav,ul#nav2,ul#dropdown,ul.menu{
{$tech['nav_align']};
}
CSS;
	if ($tech['nav_button_width'] != 0) { 
echo <<<CSS
ul#nav li, ul#admin li, #nav2 li,#dropdown li,.menu li{
width: {$tech['nav_button_width']}em;
} 
CSS;
	}
	if ($tech_nav_align_check == "Center") {
echo <<<CSS
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
	switch ($tech['header']){ 
		case "Defined Here": 
echo <<<CSS
#header {
background:url({$tech['header_image_url']}) no-repeat bottom {$tech['header_align']};
height: {$tech['header_height']}px;
}
CSS;
		break;
		case "Rotate":
echo <<<CSS
#header {
background:url({$home}/rotate.php) no-repeat bottom {$tech['header_align']};
height: 200px;
}
CSS;
		break;
		case "Landscape":
echo <<<CSS
#header {
background:url({$home}/images/headers/{$tech['header']}.jpg) no-repeat bottom {$tech['header_align']};
height: 170px;
}
CSS;
		break;
		case "none":
echo <<<CSS
#header {
height: {$tech['header_height']}px;
}
CSS;
		break;
		default:
echo <<<CSS
#header {
background:url({$home}/images/headers/{$tech['header']}.jpg) no-repeat bottom {$tech['header_align']};
height: {$tech['header_height']}px;
}
CSS;
		break;
	}
include("default-css.php");
/*Custom Styles Defined In Options*/
echo $tech['custom_styles'];
?>
