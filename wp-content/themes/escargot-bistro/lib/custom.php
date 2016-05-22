<?php

function admin(){
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
    wp_enqueue_script('admin', get_template_directory_uri() . '/library/js/admin.js', array('jquery'), null, true);
}

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

function admin_menu_separator() {
	add_admin_menu_separator(12);
	add_admin_menu_separator(15);
}

add_action('admin_init','admin_menu_separator');
add_action('admin_enqueue_scripts', 'admin');


// [banner title="A title" count="1" caption="My caption" link="http://google.com" image="http://imgur.com"]
function makeBanner( $atts ) {
    $values = shortcode_atts( array(
        'title' => '',
        'image' => '',
        'count' => '1',
	    'button' => '',
        'caption' => '',
        'link' => ''
    ), $atts );

    $banner = '<div class="banner" style="background-image: url(' . $values['image'] . ')">
        <a href="' . $values['link'] . '" class="bg-link"></a>
        <div class="bottom">
            <a href="' . $values['link'] . '">
	            <div class="heading pull-left">
	                <h2>' . $values['title'] . '</h2>
	            </div>
            </a>
            <div class="subheading">
                <a href="' . $values['link'] . '">
                    <h3 class="pull-left hidden-xs">' .  $values['caption'] . '</h3>
                </a>';

    $out = '</div>
        </div>
    </div>';

    if($values['count'] == '1'){
        $button = '<a href="' . $values['link'] . '" class="btn btn-order pull-right">' . $values['button'] . '</a>';
        $html = '<div class="col-xs-12">' . $banner . $button . $out . '</div>';
    } else {
        $button = '<a href="' . $values['link'] . '" class="btn btn-order btn-half pull-right"><i class="fa fa-mail-forward"></i></a>';
        $html = '<div class="col-xs-12 col-sm-6">' . $banner . $button . $out . '</div>';
    }

    return $html;
}
add_shortcode( 'banner', 'makeBanner' );


// [image url=""]
function makeInternalBanner( $atts ) {
    $values = shortcode_atts( array(
        'url' => ''
    ), $atts );

    return '<div class="banner" style="background-image: url(' . $values['url'] . ')"></div>';
}
add_shortcode( 'image', 'makeInternalBanner' );

//add_filter('widget_text', 'do_shortcode');

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
            'menu_position'       => 5,
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
            'menu_position'       => 12,
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
            'supports'            => array( 'title', 'revisions', 'thumbnail', ),
            'taxonomies'          => array( 'item' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'menu_position'       => 14,
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
            'menu_position'       => 13,
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