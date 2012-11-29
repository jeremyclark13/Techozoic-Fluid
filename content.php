<?php $date_format = get_option( 'date_format' ); ?>
<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <div class="heading clear">                  
        <h2 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( __( 'Permanent Link to %s', 'techozoic' ), get_the_title() ); ?>">
                <?php
                if ( get_the_title() ) {
                    the_title();
                } else {
                    _e( 'Read More &hellip;', 'techozoic' );
                }
                ?></a></h2>	
        <small><?php printf( __( 'Posted %s By %s', 'techozoic' ), get_the_time( $date_format ), get_the_author() ); ?><?php edit_post_link( __( '&nbsp;|&nbsp; Edit.', 'techozoic' ), '', '' ); ?></small>
    </div>
    <?php if ( $post->post_content != "" ) { ?>
        <div class="entry">
            <?php
            if ( function_exists( 'the_post_thumbnail' ) ) {
                the_post_thumbnail( 'thumbnail' );
            }
            ?>
            <?php
            if ( (is_home() && tech_excerpt( 'main' )) || ( is_category() && tech_excerpt( 'cat' ) ) || ( is_year() && tech_excerpt( 'year' ) ) || ( is_month() && tech_excerpt( 'month' ) ) ) {
                the_excerpt();
            } else {
                the_content( __( 'Read the remainder of this entry &raquo;', 'techozoic' ) );
            }
            wp_link_pages();
            if ( comments_open() && empty( $post->post_password ) && (of_get_option( 'comment_preview', '1' ) == "1") ) {
                ?>
                <div class="post_comment_cont">
                    <?php comments_popup_link( __( 'Be the first to comment', 'techozoic' ), __( '1 Comment. Join the Conversation', 'techozoic' ), _n( '% Comment so far. Join the Conversation', '% Comments so far. Join the Conversation', get_comments_number(), 'techozoic' ), 'comments-link', __( 'Comments Closed', 'techozoic' ) ); ?>
                </div>
                <?php tech_comment_preview( $post->ID ); ?>				
                <?php
            }
            ?>
            <div class="post_info">
                <small>
                    <?php printf( __( 'Filed in %s', 'techozoic' ), get_the_category_list( ', ' ) ) ?><?php the_tags( __( ' | Tagged: ' ) ); ?>
                </small>
            </div>
        </div>
        <?php if ( ( is_home() && tech_icons( 'main' ) ) || ( is_category() && tech_icons( 'archive' ) ) || ( is_year() && tech_icons( 'year' ) ) || ( is_month() && tech_icons( 'month' ) ) ) { ?>	
            <div class="top">
                <?php tech_social_icons( $home = true ); ?><a href="#top" title="<?php _e( 'To the top', 'techozoic' ) ?>" class="social toplink"></a>
            </div>
            <?php
        } // End if $post->post-content blank check.
    } //End if post format check
    ?>
</div>