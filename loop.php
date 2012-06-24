<?php 	if (have_posts()) {
		while (have_posts()) { 
			the_post();
?>
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<?php                   if ( has_post_format( 'quote' )  || has_post_format( 'aside' ) ) { ?>
                                <div class="entry">
                                <?php the_content();?>
                                </div>               
<?php                   
                        } elseif ( has_post_format( 'status' ) ) { ?>
                                <div class="avatar"><a href="<?php echo add_query_arg('post_format','status',get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>" title="<?php _e('View all status updates by this author','techozoic'); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 64 ); ?></a></div>    
                                <div class="entry">
                                <?php the_content();?>
                                </div>
<?php                   
                        } else {    
?>                            
			<div class="heading clear">
<?php                   if (is_home()){ ?>                            
                            <div class="post_date">
                            <div class="month_post"><?php the_time('M') ?></div>    
                            <div class="date_post"><?php the_time('j') ?></div>
                            </div>
                            <div class="commentdiv"><?php if ( comments_open() && empty($post->post_password) ) {comments_popup_link('0', '1', '%','comment_num',''); }?></div>
<?php                   } ?>                        
			<h2 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','techozoic'), get_the_title()); ?>"><?php if( get_the_title() ) { the_title(); } else{ _e('Read More &hellip;','techozoic'); } ?></a></h2>	
			<small><?php _e('By' , 'techozoic') ?> <?php the_author() ?>&nbsp;|&nbsp;<?php printf(__('Filed in %s' , 'techozoic'), get_the_category_list(', ')) ?><?php edit_post_link(__('&nbsp;|&nbsp; Edit.','techozoic'), '', ''); ?></small>
			</div>
                        <?php if ($post->post_content!=""){ ?>
                            <div class="entry">
<?php                       if(function_exists('the_post_thumbnail')) { the_post_thumbnail('thumbnail'); }?>
<?php        			if ((is_home() &&tech_excerpt('main')) || ( is_category() && tech_excerpt('cat') ) || ( is_year() && tech_excerpt('year') ) || ( is_month() && tech_excerpt('month') ) ){
                                            the_excerpt();
                                    } else {
                                            the_content(__('Read the remainder of this entry &raquo;'  , 'techozoic')); 
                                    }
                                    wp_link_pages();
        			if ( comments_open()  && empty($post->post_password) && (of_get_option('comment_preview','1') == "1")) { ?>
                                    <div class="post_comment_cont">
<?php       			comments_popup_link(__('Be the first to comment' ,'techozoic'), __('1 Comment. Join the Conversation' ,'techozoic'), _n('% Comment so far. Join the Conversation' , '% Comments so far. Join the Conversation',get_comments_number(),'techozoic'), 'comments-link', __('Comments Closed' ,'techozoic')); ?>
                                    </div>
<?php       			tech_comment_preview($post->ID); ?>				
<?php       			} 

                            $posttags = get_the_tags();
                            if (!empty($posttags)) { ?>
                                    <div class="tags"><small><?php the_tags(); ?></small></div><?php 
                            } 
?>
                            </div>
<?php       		if ( ( is_home() && tech_icons('main') ) || ( is_category() && tech_icons('archive') ) || ( is_year() && tech_icons('year') ) || ( is_month() && tech_icons('month') ) ) {	?>	
                                    <div class="top">
                                    <?php tech_social_icons($home=true); ?><a href="#top" title="<?php _e('To the top' , 'techozoic') ?>" class="social toplink"></a>
                                    </div>
<?php       		}
                    } // End if $post->post-content blank check.
                } //End if post format check
?>
		</div>
 <?php		$tech_ad_code = of_get_option('ad_code','');
                if (!empty($tech_ad_code) && $tech_ii <= 3) {
				$tech_i++;
				if($tech_i == of_get_option('ad_int','3')) { ?>
					<div class="aligncenter">
<?php 					$tech_ad_code = stripslashes (of_get_option('ad_code',''));
                                        echo do_shortcode($tech_ad_code); ?>
					</div>
<?php 				$tech_i = 0; 
					$tech_ii++; 
				}
			} //End Ad Loop
		} //End While Loop 
 	} else { ?>
		<h2 class="center"><?php _e('Not Found' , techozoic) ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here' , 'techozoic') ?>.</p>
<?php 	} ?>