<?php
//This file contains all the non variable styles
//This file can be edited
//DO NOT delete the echo statement below 
$home = get_bloginfo('template_directory');
echo " 
/*Default Sytle*/
#crumbs{
font-size:1.2em;
margin: 0px 20px 5px;
}
#crumbs .current{
text-decoration:underline;
}
sub,sup {
font-size:1.1em;
color:#606e79;
}
strong.search-excerpt { 
background: yellow; 
}
.search-terms{
font-style:italic;
}
.squarebox {
width:450px;
background-color:#a4acb3;
border:1px solid #6f7d88;
padding:8px;
}
.squarebox_bright {
width:450px;
background-color:#bec4c8;
border:1px solid #6f7d88;
padding:8px;
}
body {
color:#333;
text-align:center;
margin:0;
padding:0;
}
#page {
border:none;
text-align:left;
min-width:760px;
margin:auto;
padding:0;
}
#pagel{
background:transparent url({$home}/images/bgl.png) repeat-y left top;
}
#pager {
background:transparent url({$home}/images/bgr.png) repeat-y right top;
}
.narrowcolumn .entry,.widecolumn .entry {
line-height:1.3em;
margin-top:4px;
-moz-border-radius-bottomleft:5px;
-webkit-border-bottom-left-radius:5px;
padding:2px 4px 1px;
}
.home .narrowcolumn .entry,.home .widecolumn .entry{
-moz-box-shadow:2px 2px 6px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 2px 2px 6px rgba(0,0,0,0.4);
}
.widecolumn {
line-height:1.6em;
width:80%;
margin:5px auto 0;
padding:10px 0 20px;
}
.narrowcolumn .postmetadata {
text-align:center;
padding-top:5px;
}
.tagcont {
float:left;
width:30%;
height:150px;
margin:2% 1%;
}
.tags {
background-color:#ccc;
text-align:center;
margin:5px auto;
padding:2px;
}
.alt {
background-color:#eee;
border-top:1px solid #ddd;
border-bottom:1px solid #ddd;
margin:0;
padding:10px;
}
#footer {
border:none;
clear:both;
height:auto;
width:100%;
margin:0 0 0 auto;
padding:10px 0 0;
background: transparent url({$home}/images/navbarbg.png) repeat-x scroll 0 0;
}
#footercont {
background: transparent url({$home}/images/bgbot.png) repeat-x scroll 0 bottom;
}
small {
line-height:1.5em;
padding-left:10px;
}
h1 {
line-height:1.3em;
margin:0;
}
.description {
font-size:1.2em;
text-align:left;
border-top:1px solid #444;
margin:0 15px;
padding:3px;
}
h2 {
letter-spacing:-0.9px;
margin:0;
}
.entry h2 {
line-height: 1.6em
}
h2.pagetitle {
margin-top:30px;
text-align:center;
}
.sidebar h2, #footer h2 {
margin:5px 0 0;
padding:0;
}
h3 {
font-size:1.3em;
padding:0;
}
.entry h3 {
line-height: 1.3em;
}
.entry h4 {
font-size: 1.2em;
line-height: 1.2em;
}
.entry h5 {
font-size: 1.1em;
line-height: 1.1em;
}
.entry p a:visited {
text-decoration:underline;
}
ul.comment-preview li {
font-size:.9em;
opacity:.7;
}
ul.comment-preview li:hover{
opacity:1;
}
.commentdiv {
height:40px;
width:40px;
float:right;
text-align:center;
margin-top:7px;
}
.commentdiv a{
display:block;
padding-top:6px;
width:40px;
height:35px;
font-size:18px;
background:url({$home}/images/comment2.png) no-repeat top center;
}
.commentdiv span {
font-size:9px;
display:block;
padding-top:6px;
width:40px;
height:35px;
background:url({$home}/images/comment2.png) no-repeat top center;
}
.comments-link{
background:transparent url({$home}/images/comment.gif) no-repeat scroll left top;
font-size:1.2em;
padding:0 0 0 18px;
}
.comments-link a{
text-decoration:underline;
}
.commentlist cite,.commentlist cite a {
font-weight:700;
font-style:normal;
font-size:1.1em;
}
.commentlist p {
font-weight:400;
line-height:1.5em;
text-transform:none;
margin:10px 5px 10px 0;
}
.author,.bypostauthor {
border-top:1px #000 dotted;
background-color:#ddd;
}
.commentlist ul.children {
padding-left:10px;
}
.commentmetadata {
font-weight:400;
display:block;
margin:0;
}
#respond {
padding-bottom:25px;
}
small,.sidebar ul ul li,.sidebar ul ol li,.nocomments,.postmetadata,blockquote,strike {
color:#777;
}
code {
font:1.1em 'Courier New', Courier, Fixed;
}
pre {
overflow:scroll;
overflow-y:hidden;
}
dd {
margin-left:5px;
font-style:italic;
}
acronym,abbr,span.caps {
letter-spacing:.07em;
cursor:help;
}
#wp-calendar #prev a {
font-size:.9em;
padding-left:10px;
text-align:left;
}
#wp-calendar a {
text-decoration:none;
display:block;
}
#wp-calendar caption {
font-size:1.3em;
text-align:center;
width:100%;
}
#wp-calendar th {
font-style:normal;
text-transform:capitalize;
}
#header {
width:97%;
margin:0 auto;
padding:0;
}
.navhead h3 {
margin:5px 10px 0;
}
#sidenav .page_item ul, #sidenav ul.children {
display:none;
}
#sidenav .current_page_item ul,#sidenav .current_page_parent ul, #sidenav .current_page_ancestor ul, #sidenav .current-cat ul.children, #sidenav .current-cat-parent ul.children {
display:block !important;
}
#sidenav li.current_page_item a, #sidenav li.current-cat a{
text-decoration: underline;
}
#sidenav li.current_page_item ul a, #sidenav .current-cat ul a{
text-decoration: none;
}
#navmenu {
background:url({$home}/images/navbarbg.png) repeat-x;
height:60px;
margin:0 0 auto;
padding: 0 10px;
}
#dropdown, #dropdown ul {
position:relative; 
z-index:300;
}
#dropdown a {
display:block; 
padding:3px; 
text-decoration:none;
}
#dropdown li {
float:left; 
position:relative;
margin-right:2px
}
#dropdown ul {
position:absolute; 
display:none; 
width:12em; 
top:2em; 
left:-1px;
}
#dropdown li ul { 
width:14.1em;
padding-left:0;
}
#dropdown li ul a {
width:12em; 
height:auto; 
float:left;
border:1px solid #D3D3D3;
}
#dropdown li ul li{
width:16.3em;
}
#dropdown ul ul {
top:auto;
}
#dropdown li ul ul {
left:15.5em; 
margin:0px 0 0 10px;
}
#dropdown li:hover ul ul, #dropdown li:hover ul ul ul, #dropdown li:hover ul ul ul ul {
display:none;
}
#dropdown li:hover ul, #dropdown li li:hover ul, #dropdown li li li:hover ul, #dropdown li li li li:hover ul {
display:block;
} 
#nav2 li {
margin-right:25px;
}
#nav2 li, #subnav li {
float:left;
list-style:none;
}
#subnav {
margin:0;
padding-top:5px;
}
#subnav li {
border-right:1px solid #ddd;
padding:0 5px;
font-size:1.1em;
}	
#subnav a, #subnav a:visited {
text-decoration:none;
font-weight:bold;
}
#subnav a:hover, #subnav a:active,#subnav li.current_page_item a,#subnav li.current_page_item a:visited {
text-decoration:underline;
}
#navwrap{
height: 30px;
}
ul#admin {
list-style-type:none;
list-style-image:none;
float:right;
margin:0;
}
ul#nav,#dropdown,#dropdown ul {
list-style-type:none;
list-style-image:none;
height:30px;
width:100%;
margin:0 auto;
}
ul#nav2{
height:25px;
margin:0 auto;
}
ul#nav, ul#nav2, #dropdown {
padding:5px 0 0;
}
#search {
display:block;
float:right;
border-right:none;
font-size:1.3em;
font-weight:bolder;
margin:-40px 10px 0 0;
}
ul#nav li,ul#admin li, #nav2 li {
display:inline;
float:left;
text-align:center;
margin-right:2px;
overflow:hidden;
height:16px;
padding:3px;
}
ul#nav a,ul#admin a, #nav2 a,#nav2 a:visited,#dropdown a {
text-decoration:none;
font-weight:bolder;
font-size:1.3em;
}
ul#nav li, #nav2 li, #dropdown li {
-moz-border-radius-topright:5px;
-moz-border-radius-topleft:5px;
-webkit-border-top-right-radius:5px;
-webkit-border-top-left-radius:5px;
}
#dropdown li ul li{
-moz-border-radius-topright:0px;
-moz-border-radius-topleft:0px;
-webkit-border-top-right-radius:0px;
-webkit-border-top-left-radius:0px;
}
ul#admin li {
-moz-border-radius-bottomright:5px;
-moz-border-radius-bottomleft:5px;
-webkit-border-bottom-right-radius:5px;
-webkit-border-bottom-left-radius:5px;
}
ul#nav li.current_page_item, #dropdown li.current_page_item {
border-bottom:1px dotted;
}
ul#nav li.current_page_item a ,#nav2 li.current_page_item a,#nav2 li.current_page_parent a, #nav2 li.current_page_ancestor a{
color:#f7f7f7;
}
ul#nav li:hover,#nav2 li:hover, #nav2 li:active {
background:#efefef;
-moz-box-shadow:2px -1px 3px rgba(0, 0, 0, 0.3);
-webkit-box-shadow:2px -1px 3px rgba(0, 0, 0, 0.3);
}
ul#admin li:hover{
background:#efefef;
-moz-box-shadow:2px 1px 3px rgba(0, 0, 0, 0.3);
-webkit-box-shadow:2px 1px 3px rgba(0, 0, 0, 0.3);
}
.post {
text-align:justify;
margin:0 0 40px;
}
.post small {
padding-top: 4px;
display:block;
}
.post_date {
clear:left;
float:left;
width:40px;
height:40px;
margin:5px 5px 0 0;
background-image: url({$home}/images/datebg.png);
}
* html .post_date {
margin:30px 0 0;
}
.date_post {
border-bottom:1px dotted;
clear:left;
float:left;
font-size:16px;
font-weight:800;
text-align:center;
width:40px;
letter-spacing:-1px;
height: 20px;
}
.month_post {
float:left;
clear:left;
width:40px;
font-size:14px;
color:#2C4353;
text-align:center;
padding-bottom:2px;
height: 20px;
}
.heading {
margin-top:20px;
}
.widecolumn .postmetadata {
margin:30px 0;
}
.widecolumn .smallattachment {
text-align:center;
float:left;
width:128px;
margin:5px 5px 5px 0;
}
.widecolumn .attachment {
text-align:center;
margin:5px 0;
}
.postmetadata {
clear:left;
}
p {
margin:5px;
}
#footerdivs {
margin:10px auto 15px;
padding-left:15%;
text-align:left;
}
.footercont {
width:30%;
float:left;
}
.footercont.widgettitle {
margin-top:0;
}
#footer p{
margin:0;
padding:15px 0 20px;
text-align:center;
}
#footer p.credit{
padding:15px 0 20px;
text-align:center;
}
#footer ul,#footer ul li ul li {
list-style-type:none;
list-style-image:none;
padding:0;
margin-left:0;
}
#footer ul ul li:before {
content:\"\\00BB \\0020\";
padding:0;
}
h3.comments {
margin:40px auto 20px;
padding:0;
}
#headerimg h1 {
text-align:left;
}
#headerimg h1 a {
padding:5px;
}
#headerimgwrap {
position: relative;
top: 20%;
}
p img {
max-width:100%;
padding:2px;
}
.wp-caption {
background-color:#f7f7f7;
-moz-border-radius:3px;
-webkit-border-radius:3px;
-moz-box-shadow:2px 2px 6px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 2px 2px 6px rgba(0,0,0,0.4);
border:1px solid #444;
text-align:center;
padding:3px;
}
.wp-caption-text {
text-align:center;
line-height:1.1em;
}
.wp-caption img {
-moz-box-shadow: none;
-webkit-box-shadow:none;
}
.aligncenter {
display:block;
margin-left:auto;
margin-right:auto;
text-align:center;
}
.wp-post-image, .alignleft {
float:left;
margin:0 6px;
}
.alignright {
float:right;
margin:0 6px;
}
.avatar {
-moz-box-shadow:2px 2px 6px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 2px 2px 6px rgba(0,0,0,0.4);
}
.avatar_cont {
float:left;
margin:0 5px 0 0;
}
.entry ol {
margin:0;
padding:0 0 0 35px;
}
.postmetadata ul,.postmetadata li {
display:inline;
list-style-type:none;
list-style-image:none;
}
.sidebar ul li {
list-style-type:none;
list-style-image:none;
margin-bottom:8px;
}
.sidebar ul p,.sidebar ul select {
-moz-border-radius:3px;
-webkit-border-radius:3px;
margin:5px 0 8px;
}
.sidebar ul ul,.sidebar ul ol {
margin:5px 0 0 10px;
}
.sidebar ul ul ul,.sidebar ul ol {
margin:0 0 0 10px;
}
ol li,.sidebar ul ol li {
list-style:decimal outside;
}
.sidebar ul ul li,.sidebar ul ol li {
margin:3px 0 0;
padding:0;
}
.sidebar_icon {
text-align:right;
padding-right:5px;
}
#loginform {
font-size:.9em;
padding:0 3px;
}
#user_login,#user_pass {
width:90px;
background-color: #f7f7f7;
}
input.text {
font-size:1.2em;
}
#searchform {
text-align:left;
-moz-border-radius:3px;
-webkit-border-radius:3px;
margin:5px 5px 0 0;
}
#searchform #s,#user_login,#user_pass {
border:1px #999 solid;
border-left-color:#ccc;
border-top-color:#ccc;
-moz-border-radius:3px;
-webkit-border-radius:3px;
}
#searchform #s {
width:150px;
margin-bottom:6px;
padding:3px;
}
#searchsubmit,#catsubmit,#wp-submit {
display:inline;
background-color:#EEEDED;
border:1px #999 solid;
border-left-color:#ccc;
border-top-color:#ccc;
-moz-border-radius:3px;
-webkit-border-radius:3px;
padding:1px;
}
#searchsubmit:hover,#catsubmit:hover,#wp-submit:hover {
display:inline;
color:#f7f7f7;
border:1px #ccc solid;
border-left-color:#999;
border-top-color:#999;
-moz-border-radius:3px;
-webkit-border-radius:3px;
padding:1px;
}
.postform {
border:1px #999 solid;
border-left-color:#ccc;
border-top-color:#ccc;
}
#commentform input {
width:170px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
margin:5px 5px 1px 0;
padding:2px;
}
#commentform textarea {
width:100%;
-moz-border-radius:5px;
-webkit-border-radius:5px;
padding:2px;
}
#commentform #submit {
float:right;
border:2px #999 solid;
border-left-color:#ccc;
border-top-color:#ccc;
-moz-border-radius:3px;
-webkit-border-radius:3px;
margin:0;
}
#commentform #submit:hover {
float:right;
border:2px #ccc solid;
border-left-color:#999;
border-top-color:#999;
-moz-border-radius:3px;
-webkit-border-radius:3px;
margin:0;
}
.commentlist,.trackback {
text-align:justify;
padding:0;
}
.trackback li {
list-style:none;
border-bottom:1px solid #ddd;
margin:2px 0;
padding:2px 10px;
}
.commentlist li {
list-style:none;
margin:15px 0 3px;
padding:5px 10px 3px;
}
#commentform p {
margin:5px 0;
}
.nocomments {
text-align:center;
margin:0;
padding:0;
}
.techozoic_rss,#rss {
background:url({$home}/images/syndicatebg.png) no-repeat top center;
}
acronym,abbr {
border-bottom:1px dashed #999;
}
blockquote {
padding-left:20px;
border-left:5px solid #ddd;
margin:15px 30px 0 10px;
}
blockquote cite {
display:block;
margin:5px 0 0;
}
a img {
border:none;
}
.navigation {
display:block;
text-align:center;
margin-top:10px;
margin-bottom:30px;
}
.entry_spacer {
width:400px;
height:0;
border-bottom:1px solid #a4acb3;
border-top:1px solid #eaeaea;
margin:auto;
}
.top {
float:right;
-moz-border-radius-bottomright:3px;
-moz-border-radius-bottomleft:3px;
-webkit-border-bottom-left-radius:3px;
-webkit-border-bottom-right-radius:3px;
-moz-box-shadow:2px 2px 4px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 2px 2px 4px rgba(0,0,0,0.4);
padding:2px 4px;
}
.top img{
opacity:.5;
}
.top img:hover{
opacity: 1;
-moz-box-shadow:1px 1px 3px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 1px 1px 3px rgba(0,0,0,0.4);
}
.toppost {
float:right;
margin-top:-15px;
}
#headerimg {
background-color:#f7f7f7;
-moz-opacity:0.85;
-khtml-opacity:0.85;
opacity:.85;
-moz-box-shadow:2px 2px 6px rgba(0, 0, 0, 0.5);
-webkit-box-shadow: 2px 2px 6px rgba(0,0,0,0.5);
-moz-border-radius:3px;
-webkit-border-radius:3px;
}
#wp-calendar {
empty-cells:show;
width:155px;
margin:10px auto 0;
}
#wp-calendar #next a {
padding-right:10px;
text-align:right;
}
#wp-calendar td {
text-align:center;
padding:3px 0;
}
#wp-calendar td.pad:hover {
background-color:#fff;
}
h1,h2,h3,.commentlist li,.trackback li {
font-weight:700;
}
h1,h1 a,h1 a:hover,h1 a:visited,h2,h2 a,h2 a:hover,h2 a:visited,h3,h3 a,h3 a:hover,h3 a:visited,.sidebar h2,#wp-calendar caption,cite {
text-decoration:none;
}
.commentlist li.pingback,hr {
display:none;
}
.sidebar form {
margin:0;
}
.entry img,.entrytext img {
border:1px solid #ccc;
padding:4px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
-moz-box-shadow:2px 2px 6px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 2px 2px 6px rgba(0,0,0,0.4);
}
.entry ol li,.sidebar ul,.sidebar ul ol {
margin:0;
padding:0;
}
.sidebar .about_icons li{
display:inline;
margin:3px;
}
.entry form,.center {
text-align:center;
}
.wp-caption img {
-moz-box-shadow: none;
-webkit-box-shadow:none;
}
select {
width:140px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
}
.singlepost {
background-color:transparent !important;
border-top:none !important;
}
html>body .entry ul {
margin-left:0;
padding:0 0 0 30px;
list-style:none;
padding-left:10px;
}
html>body .entry li {
margin:7px 0 8px 10px;
}
*html .post_date {background-image: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader( sizingMethod='scale', src='{$home}/images/datebg.png');}
*html .commentdiv a{background-image: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader( sizingMethod='scale', src='{$home}/images/comment.png');}
/* ThickBox Styles */
#TB_window {font: 12px Arial, Helvetica, sans-serif;color: #333;}#TB_secondLine {font: 10px Arial, Helvetica, sans-serif;color:#666;}#TB_window a:link {color: #666;}#TB_window a:visited {color: #666;}#TB_window a:hover {color: #000;}#TB_window a:active {color: #666;}#TB_window a:focus{color: #666;}#TB_overlay {position: fixed;z-index:100;top: 0px;left: 0px;height:100%;width:100%;}.TB_overlayMacFFBGHack {background: url(macFFBgHack.png) repeat;}.TB_overlayBG {background-color:#000;filter:alpha(opacity=75);-moz-opacity: 0.75;opacity: 0.75;}* html #TB_overlay { position: absolute; height: expression(document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px');}#TB_window {position: fixed;background: #ffffff;z-index: 102;color:#000000;display:none;border: 4px solid #525252;text-align:left;top:50%;left:50%;}* html #TB_window { position: absolute;margin-top: expression(0 - parseInt(this.offsetHeight / 2) + (TBWindowMargin = document.documentElement && document.documentElement.scrollTop || document.body.scrollTop) + 'px');}#TB_window img#TB_Image {display:block;margin: 15px 0 0 15px;border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;border-top: 1px solid #666;border-left: 1px solid #666;}#TB_caption{height:25px;padding:7px 30px 10px 25px;float:left;}#TB_closeWindow{height:25px;padding:11px 25px 10px 0;float:right;}#TB_closeAjaxWindow{padding:7px 10px 5px 0;margin-bottom:1px;text-align:right;float:right;}#TB_ajaxWindowTitle{float:left;padding:7px 0 5px 10px;margin-bottom:1px;}#TB_title{background-color:#e8e8e8;height:27px;}#TB_ajaxContent{clear:both;padding:2px 15px 15px 15px;overflow:auto;text-align:left;line-height:1.4em;}#TB_ajaxContent.TB_modal{padding:15px;}#TB_ajaxContent p{padding:5px 0px 5px 0px;}#TB_load{position: fixed;display:none;height:13px;width:208px;z-index:103;top: 50%;left: 50%;margin: -6px 0 0 -104px; /* -height/2 0 0 -width/2 */}* html #TB_load {position: absolute;margin-top: expression(0 - parseInt(this.offsetHeight / 2) + (TBWindowMargin = document.documentElement && document.documentElement.scrollTop || document.body.scrollTop) + 'px');}#TB_HideSelect{z-index:99;position:fixed;top: 0;left: 0;background-color:#fff;border:none;filter:alpha(opacity=0);-moz-opacity: 0;opacity: 0;height:100%;width:100%;}* html #TB_HideSelect {position: absolute; height: expression(document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px');}#TB_iframeContent{clear:both;border:none;margin-bottom:-1px;margin-top:1px; _margin-bottom:1px;}
"
//DO NOT DELETE THE ABOVE LINE
?>
