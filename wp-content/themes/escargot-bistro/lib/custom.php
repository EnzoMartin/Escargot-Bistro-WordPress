<?php

function admin(){
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
    wp_enqueue_script('admin', get_template_directory_uri() . '/library/js/admin.js', array('jquery'), null, true);
}

add_action('admin_enqueue_scripts', 'admin');


// [banner title="Mumble Voice Servers" count="1" caption="Prices start at blah" link="http://google.com" image="http://blahlblahlhah.com"]
function makeBanner( $atts ) {
    $values = shortcode_atts( array(
        'title' => '',
        'image' => '',
        'count' => '1',
	    'button' => 'Order your server',
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
            'supports'            => array( 'title', 'revisions', 'post-formats', ),
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