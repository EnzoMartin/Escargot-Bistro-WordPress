<?php
function menu_editor_box() {
    add_meta_box(
        'menu_editor_box', // $id
        'Fixed Price Menu', // $title
        'show_menu_editor_box', // $callback
        'menu', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'menu_editor_box');

function menu_meta_box() {
    add_meta_box(
        'menu_meta_box', // $id
        'Details', // $title
        'show_menu_meta_box', // $callback
        'menu', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'menu_meta_box');


// Field Array
$prefix = 'menus_';
$menu_meta_fields = array(
    array(
        'label'=> 'Hours',
        'default' => '',
        'desc'  => 'Days & hours during which this menu is available',
        'id'    => $prefix.'hours',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Menu Season',
        'default' => '',
        'desc'  => 'Season the menu is from (Winter 2015, Fall 2017, etc.)',
        'id'    => $prefix.'season',
        'type'  => 'text'
    ),
);

// The Callback
function show_menu_meta_box() {
    global $menu_meta_fields, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="menu_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($menu_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
        switch($field['type']) {
            // text
            case 'text':
                echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="160" />
                    <br /><span class="description">'.$field['desc'].'</span>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}


function show_menu_editor_box() {
    echo 'Loading..';
}

// Save the Data
function save_menu_meta($post_id) {
    global $menu_meta_fields;

    // verify nonce
    if (!isset($_POST['menu_meta_box_nonce']) || !wp_verify_nonce($_POST['menu_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // loop through fields and save the data
    foreach ($menu_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if($new == '' && !$old && array_key_exists('default',$field)){
            $new = $field['default'];
        }

        if ($new != '' && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ($new == '' && $old != '') {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'save_menu_meta');