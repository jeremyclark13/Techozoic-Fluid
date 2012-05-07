<form method="get" id="searchform" action="<?php echo home_url(); ?>">
<input id="s" type="text" onblur="if(this.value == '') {this.value = '<?php _e('Search' ,'techozoic')?>';}" onfocus="if(this.value == '<?php _e('Search' ,'techozoic')?>') {this.value = '';}" value="<?php _e('Search' ,'techozoic')?>" name="s"/>
<!--<input type="text" value="" name="s" id="s"/>-->
<input type="hidden" name="submit" value="<?php _e('Go' ,'techozoic')?>"/>
</form>
