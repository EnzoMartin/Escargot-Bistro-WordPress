<?php
$categories = [];
$loop = new WP_Query(array('post_type' => 'category','nopaging' => true));
while($loop->have_posts()): $loop->the_post();
    $value = get_the_ID();
    $category = array (
        'label' => get_the_title(),
        'value' => $value
    );
    $categories[$value] = $category;
endwhile;
wp_reset_query();

$menus = [];
$loop = new WP_Query(array('post_type' => 'menu','nopaging' => true));
while($loop->have_posts()): $loop->the_post();
    $value = get_the_ID();
    $menu = array (
        'label' => get_the_title(),
        'value' => $value
    );
    $menus[$value] = $menu;
endwhile;
wp_reset_query();

// Add the Meta Box
function item_meta_details_box() {
    add_meta_box(
        'item_meta_details_box', // $id
        'Details', // $title
        'show_item_meta_details_box', // $callback
        'item', // $page
        'normal', // $context
        'high'); // $priority
}

function item_meta_options_box() {
    add_meta_box(
        'item_meta_options_box', // $id
        'Options', // $title
        'show_item_meta_options_box', // $callback
        'item', // $page
        'normal', // $context
        'high'); // $priority
}

add_action('add_meta_boxes', 'item_meta_details_box');
add_action('add_meta_boxes', 'item_meta_options_box');


// Field Array
$prefix = 'items_';
$item_meta_details_fields = array(
    array(
        'label'=> 'Description',
        'desc'  => 'Describe the item',
        'id'    => $prefix.'description',
        'size'  => 100,
        'type'  => 'text'
    ),
    array(
        'label'=> 'Menu',
        'desc'  => 'Menu under which to display',
        'id'    => $prefix.'menu',
        'type'  => 'select',
        'options' => $menus
    ),
    array(
        'label'=> 'Category',
        'desc'  => 'Category under which to display',
        'id'    => $prefix.'category',
        'type'  => 'select',
        'options' => $categories
    ),
    array(
        'label'=> 'Price',
        'desc'  => '',
        'id'    => $prefix.'price',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Order',
        'default' => '0',
        'desc'  => 'Number by which to order by in the menu',
        'id'    => $prefix.'text_order',
        'type'  => 'text'
    ),
);

$item_meta_options_fields = array(
    array(
        'label'=> 'Vegetarian',
        'desc'  => 'Mark as vegetarian',
        'id'    => $prefix.'vegetarion',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Vegan',
        'desc'  => 'Mark as vegan',
        'id'    => $prefix.'vegan',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Gluten free',
        'desc'  => 'Mark as gluten free',
        'id'    => $prefix.'glutenfree',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Andrea recipe',
        'desc'  => 'Mark as Andrea\'s recipe',
        'id'    => $prefix.'andrearecipe',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Chef Jacque recipe',
        'desc'  => 'Mark as Chef Jacque\'s recipe',
        'id'    => $prefix.'jacquerecipe',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> '"NEW"',
        'desc'  => 'Mark as a brand new item on the menu',
        'id'    => $prefix.'newitem',
        'type'  => 'checkbox'
    ),
);

$item_meta_fields = array_merge($item_meta_details_fields, $item_meta_options_fields);

function show_item_meta_details_box() {
    global $item_meta_details_fields, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="item_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($item_meta_details_fields as $field) {
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
            // select
            case 'select':
                $item = get_post_meta($post->ID, $field['id'], false);
                $item = count($item) > 0 ? $item[0] : array();
                echo '<select required="true" name="'.$field['id'].'[]" id="'.$field['id'].'">';
                echo '<option value="">None</option>';
                foreach ($field['options'] as $option) {
                    $selected = false;
                    foreach($item as $value){
                        if($value == $option['value']){
                            $selected = true;
                            break;
                        }
                    }
                    echo '<option', $selected ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                }
                echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

function show_item_meta_options_box() {
    global $item_meta_options_fields, $post;

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($item_meta_options_fields as $field) {
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
function save_item_meta($post_id) {
    global $item_meta_fields;

    // verify nonce
    if (!isset($_POST['item_meta_box_nonce']) || !wp_verify_nonce($_POST['item_meta_box_nonce'], basename(__FILE__)))
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
    foreach ($item_meta_fields as $field) {
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

add_action('save_post', 'save_item_meta');