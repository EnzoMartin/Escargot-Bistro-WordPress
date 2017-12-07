<?php
add_action( 'admin_menu', 'notice_menu' );

function notice_menu() {
    add_menu_page( 'Edit Notices', 'Notices', 'manage_options', 'notices', 'notice_form', 'dashicons-warning', 25 );
}

function notice_form() {
    $message = '';

    if(isset($_POST['_wpnonce'])){
        update_option('notice_message',trim($_POST['notice_message']));
        update_option('notice_active',$_POST['notice_active'] === 'on');

        $message = '<div id="message" class="updated notice notice-success is-dismissible"><p>Notice has been updated.</p></div>';
    }

    ?>
    <div class="wrap">
        <?= $message; ?>
        <form method="post">
            <?php wp_nonce_field('update-options') ?>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="postbox-container-2" class="postbox-container">
                        <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                            <div class="postbox ">
                                <h2 class="hndle ui-sortable-handle">Notice / Alert</h2>
                                <div class="inside">
                                    <table class="form-table">
                                        <tbody>
                                        <tr>
                                            <th><label for="notice_active">Display message</label></th>
                                            <td>
                                                <input type="checkbox" name="notice_active" id="notice_active"  <?= get_option('notice_active', false) ? 'checked' : ''; ?>>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><label for="notice_message">Message text</label></th>
                                            <td>
                                                <input type="text" name="notice_message" id="notice_message" style="display:block;width:100%;" value="<?= get_option( 'notice_message', '' ) ?>">
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
            <p>
                <input type="submit" class="button button-primary button-large" name="Submit" value="Save" />
            </p>
            <input type="hidden" name="action" value="update" />
        </form>
    </div>
<?php }
