<?php
function help_menu() {
    global $wp_admin_bar;
    $wp_admin_bar->add_menu(array(
        'id' => 'help-page-top',
        'title' => '<span class="ab-icon"></span><span class="ab-label">'.__('Help & Guides').'</span></span>',
        'href' => '/wp-admin/admin.php?page=help-page'
    ));
}

function help_page() {
    add_menu_page( 'Help & Guides', 'Help', 'manage_options', 'help-page', 'help_page_content', 'dashicons-editor-help', -1 );
}

function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('new-content');
    $wp_admin_bar->remove_menu('comments');
}

function help_page_content() {
    ?>
    <div id="admin-help-guide" class="wrap">
        <h1>Help Guides</h1>
        <form name="post" id="post">
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="postbox-container-2" class="postbox-container">
                        <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                            <div class="postbox ">
                                <h2 class="hndle ui-sortable-handle"><span>Notice / Alert</span></h2>
                                <div class="inside">
                                    <table class="form-table">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <p>To display a notice on the site, click on the "Notices" menu in the sidebar, enter a message into the box, and select the "Display message" checkbox</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/notices.png"/>
                                                <p><strong>If the message text field is empty OR the display message checkbox is not checked, no message will be displayed</strong></p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="postbox ">
                                <h2 class="hndle ui-sortable-handle"><span>Homepage Banners</span></h2>
                                <div class="inside">
                                    <table class="form-table">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <p>To access the Homepage Banners, click on the "Banners" link in the sidebar:</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/side_banners.png"/>
                                                <h3>Create a Banner</h3>
                                                <p>To add a new Banner click on the "Add new" button:</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/add_new.png"/>
                                                <h3>Edit a Banner</h3>
                                                <p>To edit a Banner, click on the name of the Banner you wish to edit</p>
                                                <h3>Upload a new image</h3>
                                                <p>You can upload a new image by clicking on "Select Files" and then selecting the image you wish to upload</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/banner_upload.png"/>
                                                <p>After it's uploaded, scroll down and click on "Homepage Banner Image" under the "Size" options, and then click the "Insert into Post" button</p>
                                                <p><strong>If the "Homepage Banner Image" is greyed out, then select "Full Size"</strong></p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/banner_insert.png"/>
                                                <h3>Select an existing image</h3>
                                                <p>You can select an already uploaded image by clicking on the "Media Library" tab at the top, and then clicking "Show" on the desired image</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/banner_media.png"/>
                                                <p>A box with various options will open, scroll down and click on "Homepage Banner Image" under the "Size" options, and then click the "Insert into Post" button</p>
                                                <p><strong>If the "Homepage Banner Image" is greyed out, then select "Full Size"</strong></p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/banner_insert.png"/
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="postbox ">
                                <h2 class="hndle ui-sortable-handle"><span>Hours of Operation</span></h2>
                                <div class="inside">
                                    <table class="form-table">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <p>To modify the Hours of Operation, click on the "Hours" link in the sidebar:</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/side_hours.png"/>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="postbox ">
                                <h2 class="hndle ui-sortable-handle"><span>Menus</span></h2>
                                <div class="inside">
                                    <table class="form-table">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <p>To access the Menus, click on the "Menus" link in the sidebar:</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/side_menu.png"/>
                                                <h3>Create a Menu</h3>
                                                <p>To add a new Menu click on the "Add new" button:</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/add_new.png"/>
                                                <h3>Edit a Menu</h3>
                                                <p>To edit a Menu, click on the name of the Menu you wish to edit</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="postbox ">
                                <h2 class="hndle ui-sortable-handle"><span>"Fixed Price Menu" section</span></h2>
                                <div class="inside">
                                    <table class="form-table">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <p>The "Fixed Price Menu" section for a Menu can be found at the bottom of the Menu Edit/Create page:</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/fixed_price.png"/>
                                                <br/><br/>
                                                <ol>
                                                    <li>To add items, first create a Category by clicking on "Add category"</li>
                                                    <li>Then click "Add item" to add a new item row</li>
                                                </ol>
                                                <p>Each item can have a name and description, wherein the description will show up as smaller text than the name</p>
                                                <p>You can re-arrange the order of items and categories by clicking on the "Up" or "Down" buttons</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/fixed_price_category_items.png"/>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="postbox ">
                                <h2 class="hndle ui-sortable-handle"><span>Menu Categories</span></h2>
                                <div class="inside">
                                    <table class="form-table">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <p>Menu Categories are used to group items together on the Menu page</p>
                                                <p>To access the Menu Categories, click on the "Menu Categories" link in the sidebar:</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/side_categories.png"/>
                                                <h3>Create a Category</h3>
                                                <p>To add a new Menu Category click on the "Add new" button:</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/add_new.png"/>
                                                <h3>Edit a Category</h3>
                                                <p>To edit a Category Menu, click on the name of the Menu you wish to edit</p>
                                                <h3>Options</h3>
                                                <p>Categories can be sorted for each Menu you have, they are sorted based off of the number you input into the sort box, a bigger number will mean it will be displayed below categories with a lower number</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/categories_order.png"/>
                                                <p><strong>Categories that have no items in them will <em>not display</em> unless you select them to display for a given Menu:</strong></p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/categories_options.png"/>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="postbox ">
                                <h2 class="hndle ui-sortable-handle"><span>Menu Items</span></h2>
                                <div class="inside">
                                    <table class="form-table">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <p>To access Menu Items, click on the "Menu Items" link in the sidebar:</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/side_items.png"/>
                                                <h3>Create a Menu Item</h3>
                                                <p>To add a new Menu Item click on the "Add new" button:</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/add_new.png"/>
                                                <h3>Edit a Menu Item</h3>
                                                <p>To edit a Menu Item, click on the name of the Menu you wish to edit</p>
                                                <h3>Options</h3>
                                                <p>Menu Items can optionally be displayed with 2 price fields by clicking the "Display as bottle/glass price" option:</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/items_wine.png"/>
                                                <p>Menu Items have the ability to display several different icons:</p>
                                                <img src="<?= get_template_directory_uri(); ?>/library/images/items_options.png"/>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div>
                    </div>
                </div>
                <br class="clear">
            </div>
        </form>
    </div>
    <?php
}


add_action('admin_bar_menu', 'help_menu',500);
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );
add_action( 'admin_menu', 'help_page' );
