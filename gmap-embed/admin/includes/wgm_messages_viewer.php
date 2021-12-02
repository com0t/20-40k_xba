<?php
if (isset($_GET['message'])) {
    ?>
    <div class="message">
        <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
            <p>
                <strong>
                    <?php
                    $message_status = $_GET['message'];
                    switch ($message_status) {
                        case 1:
                            echo __( 'Map has been created Successfully. <a href="' . esc_url( 'https://youtu.be/o90H34eacHg?t=231' ) . '" target="_blank"> See How to use >></a>', 'gmap-embed' );
                            break;
                        case 3:
                            echo __('API key updated Successfully, Please click on <a href="'.admin_url('admin.php?page=wpgmapembed-new').'"><i style="color: green;">Add New</i></a> menu to add new map.', 'gmap-embed');
                            break;
                        case 4:
                            echo __($message, 'gmap-embed');
                            break;
                        case -1:
                            echo __('Map Deleted Successfully.', 'gmap-embed');
                            break;
                    }
                    ?>
                </strong>
            </p>
            <button type="button" class="notice-dismiss"><span
                    class="screen-reader-text">Dismiss this notice.</span>
            </button>
        </div>
    </div>
    <?php
}
?>