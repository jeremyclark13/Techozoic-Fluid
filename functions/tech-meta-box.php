<?php

$meta_box = array(
    'id' => 'tech-meta-box',
    'title' => 'Techozoic Options',
    'context' => 'side',
    'priority' => 'low',
    'fields' => array(
        array(
            'name' => 'Sidebar',
            'id' => 'Sidebar_value',
            'type' => 'select',
            'title' => 'Sidebars',
            'description' => 'Show sidebars on this post/page single view.',
            'options' => array(
                'on', 'off'
            )
        ),
	array(
            'name' => 'Nav',
            'id' => 'Nav_value',
            'type' => 'select',
            'title' => 'Navigation Menu',
            'description' => 'Show navigation menu on this post/page single view.',
            'options' => array(
                'on', 'off'
            )
        )
    )
);

if (of_get_option('single_sidebar', '0') == '0'){
    $meta_box['fields'][0]['options'] = array('off','on');
}
/**
 * Techozoic meta boxes
 *
 * Used to output meta box for disabling the navigation menu and sidebars
 * on single pages/posts 
 *
 * @access    private
 * @since     1.8.6
 */

function tech_new_meta_boxes($post) {
    global $meta_box, $post;
    
    // Use nonce for verification
    echo '<input type="hidden" name="techozoic_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    
    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        
        echo '<tr>',
                '<th><label for="', $field['id'], '">', $field['title'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '
', $field['desc'];
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '
', $field['desc'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '" style="width: 50px;">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
        }
        echo	'<td>',
				'<tr><td colspan="3">',$field['description'],'</td></tr>',
				'</tr>';
    }
    
    echo '</table>';

}
 
/**
 * Techozoic create meta boxes
 *
 * Creates the meta boxes setup in tech_new_meta_boxes function
 *    
 *
 * @access    private
 * @since     1.8.6
 */

add_action('add_meta_boxes', 'tech_create_meta_box');  	// Creates custom meta box for disabling sidebar on page by page basis

function tech_create_meta_box() {
	global $meta_box;
	add_meta_box($meta_box['id'], $meta_box['title'], 'tech_new_meta_boxes', 'post', $meta_box['context'], $meta_box['priority']);
	add_meta_box($meta_box['id'], $meta_box['title'], 'tech_new_meta_boxes', 'page', $meta_box['context'], $meta_box['priority']);
}

/**
 * Techozoic save metabox data
 *
 * Verifies the nonce of the meta box form and saves the option to the database using
 * the update_post_meta function.
 * 
 * @param       string  post id of current post being edited
 *
 * @access    private
 * @since     1.8.6
 */

add_action('save_post', 'tech_save_postdata');  // Saves meta box data to postmeta table

function tech_save_postdata( $post_id ) {
    global $meta_box;
    
    // verify nonce
	if (isset($_POST['techozoic_meta_box_nonce'])){
		if (!wp_verify_nonce($_POST['techozoic_meta_box_nonce'], basename(__FILE__))) {
		   return $post_id;
		}

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		// check permissions
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
		
		foreach ($meta_box['fields'] as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
}
?>