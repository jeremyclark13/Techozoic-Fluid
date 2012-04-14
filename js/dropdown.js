jQuery(document).ready(function() {
jQuery("#dropmenu ul").css({display: "none"}); // Opera Fix
jQuery("#dropmenu li").hover(function(){
		jQuery(this).find('ul:first').css({visibility: "visible",display: "none"}).show();
		},function(){
		jQuery(this).find('ul:first').css({visibility: "hidden"});
		});
});
