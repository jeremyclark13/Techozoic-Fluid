function addLoadEvent(func) {
	var oldonload = window.onload;
  	if (typeof window.onload != 'function') {
   		 window.onload = func;
  	} else {
    		window.onload = function() {
      		if (oldonload) {
        		oldonload();
      		}
      		func();
    		};
  	}
}
addLoadEvent(function() {
	if (typeof(document.tech_options) != 'undefined'){
		var page=document.tech_options;
		textsize(page);
		pagewidth(page);
		colorhide(page);
		detectlink();
		document.getElementById('bg_image_preview').style.display = 'none';
		document.getElementById('content_bg_image_preview').style.display = 'none';
	}
});

function selectedHeader(){
	var headers =["Grunge","Landscape","Random_Lines_1","Random_Lines_2","Technology","Rotate","none"];
	var selected = document.tech_options.header[document.tech_options.header.selectedIndex].text;
	if(indexInArray(headers, selected)>-1){
	} else {
		var url = document.tech_options.header_image_url.value;
		var selected_array = url.split("/");
		url = selected_array[selected_array.length -1];
		var selected_no_ext = url.split(".");
		selected = selected_no_ext[0];
	}
	function indexInArray(arr,val) {
		for(var i=0;i<arr.length;i++) 
		if(arr[i]==val) return i;
		return -1;  
	} 
	document.getElementById(selected).innerHTML = "<h3><span>Current Selection</span></h3>";
}

function image_preview(path,id){
    var preview = id+"_preview";
	var preview_image = id+"_preview_image"
	if (id =="bg_image"){
		var image = document.tech_options.bg_image_select[document.tech_options.bg_image_select.selectedIndex].text;
	} else {
		var image = document.tech_options.content_bg_image_select[document.tech_options.content_bg_image_select.selectedIndex].text;
	}
	if (image == "Select Image") {
		document.getElementById(preview).style.display = 'none';
		document.getElementById(preview_image).style.display = 'none';
	} else {
		document.getElementById(preview).style.display = '';
		document.getElementById(preview_image).style.display = 'block';
		document.getElementById(preview_image).style.backgroundImage = "url(" + path + "/techozoic/images/backgrounds/" + image + ")"; 
		}
	}

function verify(){
	msg = "This Will Reset ALL options\nContinue?";
	return confirm(msg);
}

function delverify(){
	msg = "Are you sure you want to delete this file?\nContinue?";
	return confirm(msg);
}

function stylecopy(){
	msg = "This Will Overwrite Your Current Style.css File\n Are you sure you would like to Continue?";
	return confirm(msg);
}

function tabsetup(){
	var tabs=new ddtabcontent("themetabs"); 
	tabs.setpersist(true);
	tabs.setselectedClassTarget("link");
	tabs.init();
}

function tabchange(id){
	var tabs=new ddtabcontent("themetabs");
	tabs.setpersist(true);
	tabs.setselectedClassTarget("link"); 
	tabs.init();
	tabs.expandit(id);
}


function changelog(url) {
	newwindow=window.open(url,'name','height=600,width=600,scrollbars=yes');
	if (window.focus) {newwindow.focus()}
	return false;
}

function resetcolor(num){
	if (typeof(num) == 'undefined'){
		document.tech_options.cust_bg_color1.value = 'A0B3C2';
		document.tech_options.cust_acc_color1.value = 'A0B3C2';
		document.tech_options.cust_link_color1.value = '597EAA';
		document.tech_options.cust_link_hov_color1.value = '114477';
		document.tech_options.cust_text_color1.value = '2C4353';
		document.tech_options.cust_post_bg_color1.value = 'E3E3E3';
		document.tech_options.cust_nav_bg_color1.value = 'E3E3E3';
		document.tech_options.cust_content_bg_color1.value = 'F7F7F7';
	} else {
		document.tech_options.cust_bg_color2.value = 'A0B3C2';
		document.tech_options.cust_acc_color2.value = 'A0B3C2';
		document.tech_options.cust_link_color2.value = '597EAA';
		document.tech_options.cust_link_hov_color2.value = '114477';
		document.tech_options.cust_text_color2.value = '2C4353';
		document.tech_options.cust_post_bg_color2.value = 'E3E3E3';
		document.tech_options.cust_nav_bg_color2.value = 'E3E3E3';
		document.tech_options.cust_content_bg_color2.value = 'F7F7F7';
	}
}

function colorhide() {
	var custColor = document.tech_options.color_scheme[document.tech_options.color_scheme.selectedIndex].text;
	if (custColor == 'Custom 1') {
		document.getElementById('custom_color2').style.display = 'none';
		document.getElementById('loading').style.display = 'block';
		setTimeout("document.getElementById('custom_color').style.display = 'block'",500);
		setTimeout("document.getElementById('loading').style.display = 'none'",500);
	} else if (custColor == 'Custom 2') {
		document.getElementById('custom_color').style.display = 'none';
		document.getElementById('loading').style.display = 'block';
		setTimeout("document.getElementById('custom_color2').style.display = 'block'",500);
		setTimeout("document.getElementById('loading').style.display = 'none'",500);
	} else {
		document.getElementById('custom_color').style.display = 'none';
		document.getElementById('custom_color2').style.display = 'none';
	}
}

function addlink(num) {
	var divid = "nav_link_div_"+num;
	document.getElementById(divid).style.display = 'block';
}

function dellink(num) {
	var divid = "nav_link_div_"+num;
	document.getElementById('nav_link_'+num).value = "";
	document.getElementById(divid).style.display = 'none';
}

function detectlink() {
	var i = 2
	while (i <= 5)
		{
		var link = 'nav_link_' + i;
		var content = document.getElementById('nav_link_'+i).value;
		if (content == ""){
				document.getElementById('nav_link_div_'+i).style.display = 'none';
		}
		i++;
	}
}

function textsize(form){
	var bodyfont = form.body_font_size.value;
	var headingfont = form.header_font[form.header_font.selectedIndex].text;
	var postbodyfont = form.body_font[form.body_font.selectedIndex].text;
	var defaultfont = form.default_font[form.default_font.selectedIndex].text;
	document.getElementById('main_heading_font_size_out').style.fontSize = bodyfont+"px";
	document.getElementById('post_heading_font_size_out').style.fontSize = bodyfont+"px";
	document.getElementById('side_heading_font_size_out').style.fontSize = bodyfont+"px";
	document.getElementById('post_text_font_size_out').style.fontSize = bodyfont+"px";
	document.getElementById('small_font_size_out').style.fontSize = bodyfont+"px";
	document.getElementById('main_heading_font_size').style.fontSize = form.main_heading_font_size.value+"em";
	document.getElementById('main_heading_font_size').style.fontFamily = headingfont;
	document.getElementById('post_heading_font_size').style.fontSize = form.post_heading_font_size.value+"em";
	document.getElementById('post_heading_font_size').style.fontFamily = headingfont;
	document.getElementById('side_heading_font_size').style.fontSize = form.side_heading_font_size.value+"em";
	document.getElementById('side_heading_font_size').style.fontFamily = headingfont;
	document.getElementById('post_text_font_size').style.fontSize = form.post_text_font_size.value+"em";
	document.getElementById('post_text_font_size').style.fontFamily = postbodyfont;
	document.getElementById('small_font_size').style.fontSize = form.small_font_size.value+"em";
	document.getElementById('small_font_size').style.fontFamily = defaultfont;
}

function header(form){
	if (form.techheader.value == 'Defined Here'){
		form.header_image_url.disabled = false;
	} else { 
		form.header_image_url.disabled = true;
	} 
}

function pagewidth(form){
	for (var i=0; i < document.tech_options.column.length; i++){
		if (document.tech_options.column[i].checked){
			var c = document.tech_options.column[i].value;   
		} 
	}
	for (var i2=0; i2 < document.tech_options.page_type.length; i2++){
		if (document.tech_options.page_type[i2].checked){
			var d = document.tech_options.page_type[i2].value;   
		} 
	}
	var a = (form.main_column_width.value != '') ? eval(form.main_column_width.value) : 0;
	var b = (form.sidebar_width.value != '') ? eval(form.sidebar_width.value) : 0;
	var c = c - 1;
	var b = b * c;
	if (c == 2) { 
		document.tech_options.sidebar_pos.disabled = false;
		document.tech_options.sidebar_width.disabled = false;
		document.getElementById('sidebar_s').innerHTML = 's';
	} else if (c == 1) {
		document.tech_options.sidebar_pos.disabled = true;
		document.tech_options.sidebar_width.disabled = false;
		document.getElementById('sidebar_s').innerHTML = '';
	} else {
		document.tech_options.sidebar_pos.disabled = true;
		document.tech_options.sidebar_width.disabled = true;
		document.getElementById('sidebar_s').innerHTML = '';
	}
	form.total.value = a + b ;
	if (form.total.value > 100) { 
		form.total.style.backgroundColor = '#c00';
		form.total.style.color = '#fff';
		document.getElementById('totalerror').innerHTML = 'This must be less than 100% for layout to be correct.  <br />Please adjust above values.';
	} else {
		form.total.style.backgroundColor = '';
		form.total.style.color = ''; 
		document.getElementById('totalerror').innerHTML = '';
	}
	if (d == 'Fluid Width'){
		document.getElementById('page_width_sign').innerHTML = '%';
		if (form.page_width.value > 100) {
			form.page_width.style.backgroundColor = '#c00';
			form.page_width.style.color = '#fff';
			document.getElementById('page_width_error').innerHTML = 'Can not exceed 100% otherwise <br />horizontal scrolling will occur.';
		} else {
			form.page_width.style.backgroundColor = '';
			form.page_width.style.color = ''; 
			document.getElementById('page_width_error').innerHTML = '';
		} 
	} else {
		document.getElementById('page_width_sign').innerHTML = 'px';
		form.page_width.style.backgroundColor = '';
		form.page_width.style.color = ''; 
		document.getElementById('page_width_error').innerHTML = '';
	}
}
