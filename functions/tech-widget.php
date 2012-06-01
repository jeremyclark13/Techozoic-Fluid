<?php
/******************************************
Widget registration and custom widgets defined here
******************************************/

if (function_exists('wp_get_theme')){
    $theme_data = wp_get_theme('techozoic-fluid');
    $version = $theme_data->Version;
} else {
    $theme_data = get_theme_data(get_template_directory() . '/style.css');
    $version = $theme_data['Version'];
} 

function tech_widgets_init(){
    register_sidebar(array(
            'name'=>__('Right Sidebar','techozoic'),
            'id'=> 'right_sidebar'
            ));
    register_sidebar(array(
            'name'=>__('Left Sidebar','techozoic'),
            'id'=> 'left_sidebar'
            ));
    register_sidebar(array(
            'name'=>__('Footer','techozoic'),
            'description' => __('Limit 3 widgets can be assigned to footer area','techozoic'),
            'id'=> 'tech_footer',
            'before_widget' => '<div class="footercont"><ul><li class="widget %2$s">',
            'after_widget' => '</li></ul></div>',
            'before_title' => '<h2 class="widgettitle">',
            'after_title' => '</h2>'
    ));
    register_sidebar(array(
            'name'=>__('Right Header','techozoic'),
            'description' => __('Area to the right side of the header','techozoic'),
            'id'=> 'right_header',
            'before_widget' => '<div class="hwidget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle">',
            'after_title' => '</h2>'
    ));
    register_sidebar(array(
            'name'=>__('Left Header','techozoic'),
            'description' => __('Area to the left side of the header','techozoic'),
            'id'=> 'left_header',
            'before_widget' => '<div class="hwidget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle">',
            'after_title' => '</h2>'
    ));

    $pages = get_pages();
    $page_option = of_get_option('page_sidebar','');
    foreach ($pages as $page){
        if (empty($page_option)){
            break;
        }elseif($page_option[$page->ID] == '1'){
            register_sidebar(array(
                    'name'=>sprint(__('%s Left Sidebar','techozoic'),$page->post_title),
                    'description' => sprintf(__('Sidebar displayed only on %1$s.  Page ID(%2$s)','techozoic'), $page->post_title, $page->ID),
                    'id'=> "page_sidebar_l_$page->ID",
                    'before_widget' => '<div class="hwidget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h2 class="widgettitle">',
                    'after_title' => '</h2>'
            ));
            register_sidebar(array(
                    'name'=> sprint(__('%s Right Sidebar','techozoic'),$page->post_title),
                    'description' => sprintf(__('Sidebar displayed only on %1$s.  Page ID(%2$s)','techozoic'), $page->post_title, $page->ID),
                    'id'=> "page_sidebar_r_$page->ID",
                    'before_widget' => '<div class="hwidget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h2 class="widgettitle">',
                    'after_title' => '</h2>'
            ));
        }elseif($page_option['forum'] == '1'){
            register_sidebar(array(
                    'name'=>"Forums Left Sidebar",
                    'description' => __('Sidebar displayed only on Forums.','techozoic'),
                    'id'=> "page_sidebar_l_forum",
                    'before_widget' => '<div class="hwidget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h2 class="widgettitle">',
                    'after_title' => '</h2>'
            ));
            register_sidebar(array(
                    'name'=>"Forums Right Sidebar",
                    'description' => __('Sidebar displayed only on Forums.','techozoic'),
                    'id'=> "page_sidebar_r_forum",
                    'before_widget' => '<div class="hwidget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h2 class="widgettitle">',
                    'after_title' => '</h2>'
            ));
        }
    }
}	

add_action( 'widgets_init', 'tech_widgets_init' );
	
    class Techozoic_Font_Size_Widget extends WP_Widget {

		function Techozoic_Font_Size_Widget() {
			$widget_ops = array('classname' => 'techozoic_font_size', 'description' => __( 'Techozoic Font Size Control Widget' , 'techozoic') );
			$this->WP_Widget('techozoic_font_size', __('Techozoic Font Size' , 'techozoic'), $widget_ops);
		}

		function widget( $args, $instance ) {
			extract($args);
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Resize Text'  , 'techozoic') : $instance['title']);
			echo $before_widget;
			echo '<a href="#" class="fontsizeminus">A-</a> |
				<a href="#" class="fontreset">A</a> | 
				<a href="#" class="fontsizeplus">A+</a>';
			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
			$title = esc_attr( $instance['title'] );
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','techozoic'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
<?php
		}
	} //End Class Techozoic_Page_Widget
	
		class Techozoic_Page_Widget extends WP_Widget {

		function Techozoic_Page_Widget() {
			$widget_ops = array('classname' => 'techozoic_page', 'description' => __( 'Techozoic Child Page menu displays child pages below current page.' , 'techozoic') );
			$this->WP_Widget('techozoic_page', __('Techozoic Child Page' , 'techozoic'), $widget_ops);
		}

		function widget( $args, $instance ) {
			extract($args);
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Sub Pages'  , 'techozoic') : $instance['title']);
			echo $before_widget;
			global $post;
			if(is_page()) {
				if(!$post->post_parent){
						$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
					} else {
						if($post->ancestors){
							$ancestors = end($post->ancestors);
							$children = wp_list_pages("title_li=&child_of=".$ancestors."&echo=0");
						}
					}
				if ($children) {
					if ( $title) {
						echo $before_title . $title . $after_title;
						}
					echo "<ul>$children</ul>";
				} 
			}		
			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array('title' => '',) );
			$title = esc_attr( $instance['title'] );
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','techozoic'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
<?php
		}
	} //End Class Techozoic_Page_Widget
	
	class Techozoic_Nav_Widget extends WP_Widget {

		function Techozoic_Nav_Widget() {
			$widget_ops = array('classname' => 'techozoic_nav', 'description' => __( 'Techozoic Sidebar Navigation Menu - option to add categories to navigation' , 'techozoic') );
			$this->WP_Widget('techozoic_nav', __('Techozoic Navigation' , 'techozoic'), $widget_ops);
		}

		function widget( $args, $instance ) {
			extract($args);
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Navigation'  , 'techozoic') : $instance['title']);
			$c = $instance['cats'] ? '1' : '0';
			$p = $instance['pages'] ? '1' : '0';
			$s = $instance['separate'] ? '1' : '0';
                        
			echo $before_widget;
			global $post;
			if ( $title)
			echo $before_title . $title . $after_title;
			if (has_nav_menu( 'sidebar' ) ) {		
				wp_nav_menu( array('container' =>'','theme_location'=>'sidebar','menu_class' => 'sidenav')); 
			} 		
			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['cats'] = !empty($new_instance['cats']) ? 1 : 0;
			$instance['pages'] = !empty($new_instance['pages']) ? 1 : 0;
			$instance['separate'] = !empty($new_instance['separate']) ? 1 : 0;

			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array('title' => '',) );
			$title = esc_attr( $instance['title'] );
			$cats = isset($instance['cats']) ? (bool) $instance['cats'] : false;
			$pages = isset($instance['pages']) ? (bool) $instance['pages'] : true;
			$separate = isset($instance['separate']) ? (bool) $instance['separate'] : false;
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','techozoic'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
			<p>
			<input class="checkbox" type="checkbox" <?php checked($pages); ?> id="<?php echo $this->get_field_id('pages'); ?>" name="<?php echo $this->get_field_name('pages'); ?>" /> <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Include Pages in Menu' ,'techozoic')?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php checked($cats); ?> id="<?php echo $this->get_field_id('cats'); ?>" name="<?php echo $this->get_field_name('cats'); ?>" /> <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Include Categories in Menu' ,'techozoic') ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php checked($separate); ?> id="<?php echo $this->get_field_id('separate'); ?>" name="<?php echo $this->get_field_name('separate'); ?>" /> <label for="<?php echo $this->get_field_id('separate'); ?>"><?php _e('Separate Pages and Categories' ,'techozoic')?></label>
			<br />
			<hr />
			<small>Note if a menu is assigned to Sidebar Navigation Location it is always displayed</small>
			<br />
			</p>
<?php
		}
	} //End Class Techozoic_Nav_Widget

	class Techozoic_About_Widget extends WP_Widget {

		function Techozoic_About_Widget() {
			$widget_ops = array('classname' => 'techozoic_about', 'description' => __( 'Author information Widget - Enter short blurb about yourself' ,'techozoic') );
			$this->WP_Widget('techozoic_about', __('Techozoic About' ,'techozoic'), $widget_ops);
		}

		function widget( $args, $instance ) {
			extract($args);
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('About Author' ,'techozoic') : $instance['title']);
			$gravatar = $instance['gravatar'] ? '1' : '0';
			$facebook = $instance['facebook'] ? '1' : '0';
			$myspace = $instance['myspace'] ? '1' : '0';
                        $google = $instance['google'] ? '1' : '0';
			$twitter = $instance['twitter'] ? '1' : '0';
			$about = $instance['about'];
			if ( !$number = (int) $instance['number'] )
				$number = 50;
			else if ( $number < 25 )
				$number = 25;
			else if ( $number > 100 )
				$number = 100;

			echo $before_widget;
			global $post;
			if ( $title)
			echo $before_title . $title . $after_title;
?>			<span class="alignleft">
<?php			if ($gravatar) { 
				$email = get_bloginfo('admin_email'); 
				echo get_avatar( $email, $number ); 
			}
?>			</span><p>
<?php			echo $about;
?>			<ul class="about_icons">
<?php		tech_about_icons($facebook,$myspace,$twitter,$google);
?>			</ul>
			</p><div style="clear:both"></div>
<?php	  		echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$new_instance = wp_parse_args( (array) $new_instance, array( 'about' => '', 'title' => '', 'number' => 50) );
			$instance['about'] = $new_instance['about'];
			$instance['facebook'] = !empty($new_instance['facebook']) ? 1 : 0;
			$instance['myspace'] = !empty($new_instance['myspace']) ? 1 : 0;
			$instance['twitter'] = !empty($new_instance['twitter']) ? 1 : 0;
                        $instance['google'] = !empty($new_instance['google']) ? 1 : 0;
			$instance['gravatar'] = !empty($new_instance['gravatar']) ? 1 : 0;
			$instance['number'] = (int) $new_instance['number'];
			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array('about' => '', 'title' => '', 'number'=> 50) );
			$title = esc_attr( $instance['title'] );
			$about = $instance['about'] ;
			$facebook = isset($instance['facebook']) ? (bool) $instance['facebook'] : false;
			$myspace = isset($instance['myspace']) ? (bool) $instance['myspace'] : false;
			$twitter = isset($instance['twitter']) ? (bool) $instance['twitter'] : false;
                        $google = isset($instance['google']) ? (bool) $instance['google'] : false;
			$gravatar = isset($instance['gravatar']) ? (bool) $instance['gravatar'] : false;
			$number = isset($instance['number']) ? absint($instance['number']) : 50;
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','techozoic'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
			<p>
			<p><label><?php _e('Write About yourself here' ,'techozoic')?></label>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('about'); ?>" name="<?php echo $this->get_field_name('about'); ?>"><?php echo $about; ?></textarea>
			<br />
			<input class="checkbox" type="checkbox" <?php checked($facebook); ?> id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" /> <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Display link to Facebook Profile' ,'techozoic')?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php checked($myspace); ?> id="<?php echo $this->get_field_id('myspace'); ?>" name="<?php echo $this->get_field_name('myspace'); ?>" /> <label for="<?php echo $this->get_field_id('myspace'); ?>"><?php _e('Display link to MySpace Profile' ,'techozoic') ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php checked($twitter); ?> id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" /> <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Display link to Twitter Profile' ,'techozoic')?></label>
			<br />
                        <input class="checkbox" type="checkbox" <?php checked($google); ?> id="<?php echo $this->get_field_id('google'); ?>" name="<?php echo $this->get_field_name('google'); ?>" /> <label for="<?php echo $this->get_field_id('google'); ?>"><?php _e('Display link to Google+ Profile' ,'techozoic')?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php checked($gravatar); ?> id="<?php echo $this->get_field_id('gravatar'); ?>" name="<?php echo $this->get_field_name('gravatar'); ?>" /> <label for="<?php echo $this->get_field_id('gravatar'); ?>"><?php _e('Enable Gravatar' ,'techozoic') ?></label>
			</p>
			<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Size of Gravatar' ,'techozoic') ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /><br />
			<small><?php _e('Between 25 and 100 Pixels' ,'techozoic') ?></small></p>

<?php
		}
	} //End Class Techozoic_About_Widget

		class Techozoic_Meta_Widget extends WP_Widget {

		function Techozoic_Meta_Widget() {
			$widget_ops = array('classname' => 'techozoic_meta', 'description' => __( 'Meta Information as well as Dashboard and Log In/Out Links' ,'techozoic') );
			$this->WP_Widget('techozoic_meta', __('Techozoic Meta' ,'techozoic'), $widget_ops);
		}

		function widget( $args, $instance ) {
			extract($args);
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? "" : $instance['title']);
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
			else { 
 				echo $before_title . __('Meta','techozoic') . $after_title;		
			}
?>
			<ul><?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional' ,'techozoic') ?>"><?php _e('Valid XHTML' ,'techozoic') ?></a></li>
				<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.' ,'techozoic') ?>">WordPress</a></li>
<?php 			wp_meta(); 
?>
			</ul>
<?php	  		echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array('title' => '') );
			$title = esc_attr( $instance['title'] );
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','techozoic'); ?>:</label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

<?php
		}
	} //End Class Techozoic_Meta_Widget

		class Techozoic_RSS_Widget extends WP_Widget {

		function Techozoic_RSS_Widget() {
			$widget_ops = array('classname' => 'techozoic_rss', 'description' => __( 'Link to RSS feed for blog as well as comment RSS feed' ,'techozoic') );
			$this->WP_Widget('techozoic_rss', __('Techozoic RSS' ,'techozoic'), $widget_ops);
		}

		function widget( $args, $instance ) {
			extract($args);
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? "" : $instance['title']);
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
			else { 
				echo $before_title . __('Syndicate','techozoic') . $after_title;	
			}
?>
			<ul>
				<li><a href="<?php bloginfo('rss2_url'); ?>">RSS 2.0</a></li>
<?php 		if (is_home() ) { ?>	
				<li><a href="<?php bloginfo('comments_rss2_url'); ?>">RSS 2.0 (<?php _e('Comments' ,'techozoic') ?>)</a></li>
<?php 			}
?>			</ul>
<?php	  		echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array('title' => '') );
			$title = esc_attr( $instance['title'] );
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:' ,'techozoic'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

<?php
		}
	} //End Class Techozoic_RSS_Widget
        
	class Techozoic_Status_Widget extends WP_Widget {

		function Techozoic_Status_Widget() {
			$widget_ops = array('classname' => 'techozoic_status', 'description' => __( 'Techozoic Status Widget - Dispaly Post Format Status updates in sidebar' , 'techozoic') );
			$this->WP_Widget('techozoic_status', __('Techozoic Status' , 'techozoic'), $widget_ops);
                }

		function widget( $args, $instance ) {
			extract($args);
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Status Updates'  , 'techozoic') : $instance['title']);
                        if ( !$number = (int) $instance['number'] )
				$number = 3;
                        
			echo $before_widget;
			if ( $title)
			echo $before_title . $title . $after_title;
                        $args = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'post_format',
                                    'field' => 'slug',
                                    'terms' => array('post-format-status')
                                )
                            ),
                            'posts_per_page' => $number
                        );
                        $wp_query = new WP_Query( $args);
                        if ($wp_query->have_posts()) {
                            while ($wp_query->have_posts()) { 
                                $wp_query ->the_post();
                                echo '<div class="status">';
                                echo '<div class="group">';
                                echo '<div class="avatar"><a href="' . add_query_arg('post_format','status',get_author_posts_url( get_the_author_meta( 'ID' ) ) ) .'" title="' . __('View all status updates by this author','techozoic') . '">' . get_avatar( get_the_author_meta( 'ID' ), 32 ) . '</a></div>';
                                echo '<div class="' . join( ' ', get_post_class() ) . '"' . '>';
                                echo '<a href="' . get_permalink() . '">' . get_the_content() . '</a>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="timestamp">' . get_the_date() . ' ' . get_the_time() . '</div>';
                                echo '<div class="clear"></div></div>';
                            }
                        }
                        $wp_query = null; 
                        wp_reset_postdata();
			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'number'=> 3 ) );
			$instance['title'] = strip_tags($new_instance['title']);
                        $instance['number'] = (int) $new_instance['number'];
			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array('title' => '',) );
			$title = esc_attr( $instance['title'] );
                        $number = isset($instance['number']) ? absint($instance['number']) : 3;
                        
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','techozoic'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
                        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of statuses to show' ,'techozoic') ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

<?php
		}
	} //End Class Techozoic_Status_Widget        
	
		//Register Widgets for Sidebars
		register_widget('Techozoic_Nav_Widget');
                register_widget('Techozoic_Status_Widget');
		register_widget('Techozoic_Page_Widget');
		register_widget('Techozoic_Font_Size_Widget');
		register_widget('Techozoic_About_Widget');
		register_widget('Techozoic_Meta_Widget');
		register_widget('Techozoic_RSS_Widget');
?>