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

usort($categories, function($a, $b) {
    return strcmp($a['label'], $b['label']);
});

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


add_filter('manage_edit-item_columns', 'custom_columns');
function custom_columns($columns) {
    return array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Title'),
        'menu' => __('Menu'),
        'date' => __('Date')
    );
}

add_action('manage_posts_custom_column',  'show_custom_columns');
function show_custom_columns($name) {
    global $post, $menus;
    switch ($name) {
        case 'menu':
            $menu_id = get_post_meta($post->ID, 'items_menu', true);
            $key = array_search($menu_id, array_column($menus, 'value'));
            $selected = $menus[$key];
            if(!isset($selected) || !$selected){
                $views = '';
            } else {
                $views = $selected['label'];
            }

            echo $views;
    }
}

usort($menus, function($a, $b) {
    return strcmp($a['label'], $b['label']);
});

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

add_action('add_meta_boxes', 'item_meta_details_box');


// Field Array
$prefix = 'items_';
$item_meta_details_fields = array(
    array(
        'label'=> 'Display as bottle/glass price',
        'desc'  => '',
        'id'    => $prefix.'is_wine',
        'type'  => 'checkbox'
    ),
    array(
        'label'=> 'Description',
        'desc'  => 'Describe the item',
        'className' => 'normal-price',
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
        'className' => 'normal-price',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Bottle Price',
        'desc'  => '',
        'id'    => $prefix.'bottle_price',
        'className' => 'wine-price', 
        'type'  => 'text'
    ),
    array(
        'label'=> 'Glass Price',
        'desc'  => '',
        'id'    => $prefix.'glass_price',
        'className' => 'wine-price',
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

$item_meta_fields = array_merge($item_meta_details_fields);

function show_item_meta_details_box() {
    global $item_meta_details_fields, $post;
    $showWinePrice = get_post_meta($post->ID, 'items_is_wine', true) === 'on' ? 'show-wine' : 'hide-wine';
    // Use nonce for verification
    echo '<input type="hidden" name="item_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    // Begin the field table and loop
    echo '<table class="form-table ' . $showWinePrice . '">';
    foreach ($item_meta_details_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr class="'. $field['className'] .'">
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
                $value = get_post_meta($post->ID, $field['id'], true);
                echo '<select required="true" name="'.$field['id'].'" id="'.$field['id'].'">';
                echo '<option value="">None</option>';
                foreach ($field['options'] as $option) {
                    $selected = false;
                    if($value == $option['value']){
                        $selected = true;
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