<?php
add_action( 'admin_menu', 'hours_menu' );

function hours_menu() {
    add_menu_page( 'Edit Hours of Operation', 'Hours', 'manage_options', 'hours-operation', 'hours_menu_options', 'dashicons-clock', 25 );
}

function hours_menu_options() {
    $options = array('wpautop' => true, 'media_buttons' => false);
    $message = '';

    if(isset($_POST['hours_of_operation'])){
        update_option('hours_of_operation',addslashes($_POST['hours_of_operation']));

        $message = '<div id="message" class="updated notice notice-success is-dismissible"><p>Hours of operation updated.</p></div>';
    }

    ?>
    <div class="wrap">
        <h1>Hours of Operation</h1>
        <?= $message; ?>
        <form method="post">
            <?php wp_nonce_field('update-options') ?>
            <?php wp_editor( get_option( 'hours_of_operation', '' ), 'hours_of_operation', $options ); ?>
            <p>
                <input type="submit" class="button button-primary button-large" name="Submit" value="Save" />
            </p>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="hours_of_operation" />
        </form>
    </div>
<?php }
