<?php
$prefix = 'category_';
$category_meta_options_fields = [];

$loop = new WP_Query(array('post_type' => 'menu','nopaging' => true));
while($loop->have_posts()): $loop->the_post();
    $value = get_the_ID();
    $name = get_the_title();
    $menu = array(
        'label' => $name,
        'desc'  => 'Always display as part of "' . $name . '"',
        'id'    => $prefix.'menu_'.$value,
        'type'  => 'checkbox'
    );
    array_push($category_meta_options_fields,$menu);
endwhile;
wp_reset_query();

// Add the Meta Box
function category_meta_details_box() {
    add_meta_box(
        'category_meta_details_box', // $id
        'Options', // $title
        'show_category_meta_details_box', // $callback
        'category', // $page
        'normal', // $context
        'high'); // $priority
}

function category_meta_options_box() {
    add_meta_box(
        'category_meta_options_box', // $id
        'Menu(s) to display on', // $title
        'show_category_meta_options_box', // $callback
        'category', // $page
        'normal', // $context
        'high'); // $priority
}

add_action('add_meta_boxes', 'category_meta_details_box');
add_action('add_meta_boxes', 'category_meta_options_box');


// Field Array
$category_meta_details_fields = array(
    array(
        'label'=> 'Order',
        'default' => '0',
        'desc'  => 'Number by which to order by in the menu',
        'id'    => $prefix.'text_order',
        'type'  => 'text'
    ),
);

$category_meta_fields = array_merge($category_meta_details_fields, $category_meta_options_fields);

function show_category_meta_details_box() {
    global $category_meta_details_fields, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="category_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($category_meta_details_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
        switch($field['type']) {
            // text
            case 'text':
                echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="'.(isset($field['size']) ? $field['size'] : 30).'" />
                    <br /><span class="description">'.$field['desc'].'</span>';
                break;
            // checkbox
            case 'checkbox':
                echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
                    <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

function show_category_meta_options_box() {
    global $category_meta_options_fields, $post;

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($category_meta_options_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
        switch($field['type']) {
            // text
            case 'text':
                echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="'.(isset($field['size']) ? $field['size'] : 30).'" />
                    <br /><span class="description">'.$field['desc'].'</span>';
                break;
            // checkbox
            case 'checkbox':
                echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
                    <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}


// Save the Data
function save_category_meta($post_id) {
    global $category_meta_fields;

    // verify nonce
    if (!isset($_POST['category_meta_box_nonce']) || !wp_verify_nonce($_POST['category_meta_box_nonce'], basename(__FILE__)))
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
    foreach ($category_meta_fields as $field) {
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

add_action('save_post', 'save_category_meta');