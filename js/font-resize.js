jQuery(document).ready(function () {

	//min font size
	var min=9; 	

	//max font size
	var max=18;	
	
	//grab the default font size
	var reset = jQuery('body').css('fontSize'); 
	
	//font resize these elements
	var elm = jQuery('body');  
	
	//set the default font size and remove px from the value
	var size = str_replace(reset, 'px', ''); 
	
	//Increase font size
	jQuery('a.fontsizeplus').click(function() {
		
		//if the font size is lower or equal than the max value
		if (size<=max) {
			
			//increase the size
			size++;
			
			//set the font size
			elm.css({'fontSize' : size});
		}
		
		//cancel a click event
		return false;	
		
	});

	jQuery('a.fontsizeminus').click(function() {

		//if the font size is greater or equal than min value
		if (size>=min) {
			
			//decrease the size
			size--;
			
			//set the font size
			elm.css({'fontSize' : size});
		}
		
		//cancel a click event
		return false;	
		
	});
	
	//Reset the font size
	jQuery('a.fontreset').click(function () {
		
		//set the default font size	
		 elm.css({'fontSize' : reset});		
	});
		
});

//A string replace function
function str_replace(haystack, needle, replacement) {
	var temp = haystack.split(needle);
	return temp.join(replacement);
}