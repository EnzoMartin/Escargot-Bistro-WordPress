<?php

function admin(){
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
    //wp_enqueue_script('lodash', get_template_directory_uri() . '/library/js/lodash.js', array(), null, true);
    wp_enqueue_script('admin', get_template_directory_uri() . '/library/js/admin.js', array('jquery'), null, true);
}

function hours($params, $content=null) {
    return apply_filters( 'the_content',get_option('hours_of_operation'));
}
add_shortcode('hours', 'hours');

function bs_row( $params, $content=null ) {
    extract( shortcode_atts( array(
        'class' => 'row'
    ), $params ) );
    $content = preg_replace( '/<br.\/>/', '', $content );
    $result = '<div class="' . $class . '">';
    $result .= do_shortcode( $content );
    $result .= '</div>';
    return force_balance_tags( $result );
}
add_shortcode('row', 'bs_row');

function bs_span( $params, $content=null ) {
    extract( shortcode_atts( array(
        'class' => 'col-xs-12 col-sm-6'
        ), $params ) );

    $result = '<div class="' . $class . '">';
    $result .= do_shortcode( $content );
    $result .= '</div>';
    return force_balance_tags( $result );
}
add_shortcode( 'col', 'bs_span' );

function add_admin_menu_separator( $position ) {
    global $menu;
    $index = 0;
    foreach ( $menu as $offset => $section ) {
        if ( substr( $section[2], 0, 9 ) == 'separator' ) {
            $index ++;
        }
        if ( $offset >= $position ) {
            $menu[$position] = array( '', 'read', "separator{$index}", '', 'wp-menu-separator' );
            break;
        }
    }
    ksort( $menu );
}

/**
 * BEGIN SHORTCODES
 */

/**
 * MENU WRAPPER
 */

function make_menu($params, $content=null){
    $result = '<div class="custom-menu">';
    $result .= do_shortcode( $content );
    $result .= '</div>';
    return force_balance_tags( $result );
}
add_shortcode( 'menu', 'make_menu' );

function make_special_menu($params, $content=null){
    $result = '<div class="row"><div class="col-xs-12"><div class="menu-special-wrapper">';
    $result .= do_shortcode( $content );
    $result .= '</div></div></div>';
    return force_balance_tags( $result );
}
add_shortcode( 'menu_special', 'make_special_menu' );

function make_title($params, $content=null){
    $result = '<div class="row"><div class="col-xs-12"><h2 class="menu-title">';
    $result .= do_shortcode( $content );
    $result .= '</h2></div></div>';
    return force_balance_tags( $result );
}
add_shortcode( 'menu_title', 'make_title' );

/**
 * MENU ITEMS
 */

function make_items($params, $content=null){
    $result = '<div class="menu-items cf">';
    $result .= do_shortcode( $content );
    $result .= '</div>';
    return force_balance_tags( $result );
}
add_shortcode( 'menu_items', 'make_items' );

function make_item($params, $content=null){
    $result = '<div class="menu-row row"><div class="menu-item col-xs-12"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tbody>';
    $result .= do_shortcode( $content );
    $result .= '</tbody></table></div></div>';
    return force_balance_tags( $result );
}
add_shortcode( 'menu_item', 'make_item' );

function make_item_title($params, $content=null){
    $result = '<tr><th class="name"><h4>';
    $result .= do_shortcode( $content );
    $result .= '</h4></th></tr>';
    return force_balance_tags( $result );
}
add_shortcode( 'menu_item_title', 'make_item_title' );

function make_item_description($params, $content=null){
    $result = '<tr><td class="description">';
    $result .= do_shortcode( $content );
    $result .= '</td></tr>';
    return force_balance_tags( $result );
}
add_shortcode( 'menu_item_description', 'make_item_description' );

/**
 * CATEGORIES
 */

function make_item_category($params, $content=null){
    $result = '<div class="menu-category">';
    $result .= do_shortcode( $content );
    $result .= '</div></div>';
    return force_balance_tags( $result );
}
add_shortcode( 'menu_category', 'make_item_category' );

function make_item_category_title($params, $content=null){
    $result = '<h3 class="menu-category-title"><span>';
    $result .= do_shortcode( $content );
    $result .= '</span></h3>';
    return force_balance_tags( $result );
}
add_shortcode( 'menu_category_title', 'make_item_category_title' );

function make_item_category_description($params, $content=null){
    $result = '<div class="menu-category-content center">';
    $result .= do_shortcode( $content );
    $result .= '</div>';
    return force_balance_tags( $result );
}
add_shortcode( 'menu_category_description', 'make_item_category_description' );

/**
 * END SHORTCODES
 */


function admin_menu_separator() {
	add_admin_menu_separator(12);
	add_admin_menu_separator(17);
}

add_action('admin_init','admin_menu_separator');
add_action('admin_enqueue_scripts', 'admin');

// Register Banner Post Type
if ( ! function_exists('custom_banners') ) {
    function custom_banners() {
        $labels = array(
            'name'                => _x( 'Banners', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Banner', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Banners', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All Banners', 'text_domain' ),
            'view_item'           => __( 'View Banner', 'text_domain' ),
            'add_new_item'        => __( 'Add New Banner', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit Banner', 'text_domain' ),
            'update_item'         => __( 'Update Banner', 'text_domain' ),
            'search_items'        => __( 'Search Banners', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'banner', 'text_domain' ),
            'description'         => __( 'A banner', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'revisions', ),
            'taxonomies'          => array( 'banner' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'menu_position'       => 11,
            'menu_icon'           => 'dashicons-images-alt',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'banner', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'custom_banners', 0 );
}

// Register Menu Post Type
if ( ! function_exists('custom_menu') ) {
    function custom_menu() {
        $labels = array(
            'name'                => _x( 'Menus', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Menu', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Menus', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All Menus', 'text_domain' ),
            'view_item'           => __( 'View Menu', 'text_domain' ),
            'add_new_item'        => __( 'Add New Menu', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit Menu', 'text_domain' ),
            'update_item'         => __( 'Update Menu', 'text_domain' ),
            'search_items'        => __( 'Search Menus', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'menu', 'text_domain' ),
            'description'         => __( 'A menu', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'revisions', ),
            'taxonomies'          => array( 'menu' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 13,
            'menu_icon'           => 'dashicons-book-alt',
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        register_post_type( 'menu', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'custom_menu', 0 );
}

// Register Item Post Type
if ( ! function_exists('custom_items') ) {
    function custom_items() {
        $labels = array(
            'name'                => _x( 'Items', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Item', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Menu Items', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All Items', 'text_domain' ),
            'view_item'           => __( 'View Item', 'text_domain' ),
            'add_new_item'        => __( 'Add New Item', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit Item', 'text_domain' ),
            'update_item'         => __( 'Update Item', 'text_domain' ),
            'search_items'        => __( 'Search Items', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'item', 'text_domain' ),
            'description'         => __( 'A item', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'revisions', ),
            'taxonomies'          => array( 'item' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'menu_position'       => 15,
            'menu_icon'           => 'dashicons-store',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'item', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'custom_items', 0 );
}

// Register Category Post Type
if ( ! function_exists('custom_categories') ) {
    function custom_categories() {
        $labels = array(
            'name'                => _x( 'Categories', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Category', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Menu Categories', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All Categories', 'text_domain' ),
            'view_item'           => __( 'View Category', 'text_domain' ),
            'add_new_item'        => __( 'Add New Category', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit Category', 'text_domain' ),
            'update_item'         => __( 'Update Category', 'text_domain' ),
            'search_items'        => __( 'Search Categories', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'category', 'text_domain' ),
            'description'         => __( 'A category', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'revisions', 'editor', ),
            'taxonomies'          => array( 'item' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'menu_position'       => 14,
            'menu_icon'           => 'dashicons-editor-ul',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'category', $args );
    }

    // Hook into the 'init' action
    add_action( 'init', 'custom_categories', 0 );
}
