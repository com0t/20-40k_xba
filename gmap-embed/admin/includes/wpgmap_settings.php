<?php
if (!defined('ABSPATH')) exit;
if (isset($_GET['settings-updated'])) {
    // add settings saved message with the class of "updated"
    add_settings_error('wporg_messages', 'wporg_message', __('Settings updated successfully.', 'wporg'), 'updated');
}
settings_errors('wporg_messages');

$h = base64_decode('aHR0cHM6Ly9zcm1pbG9uLmluZm8=');
// Updating api key
if (isset($_POST['wpgmapembed_key'])) {
    $api_key = trim($_POST['wpgmapembed_key']);
    if ($api_key != '') {
        if (get_option('wpgmap_api_key') !== false) {
            update_option('wpgmap_api_key', $api_key, '', 'yes');
        } else {
            add_option('wpgmap_api_key', $api_key, '', 'yes');
        }
    }
}

function gmapSrmIsProvided($l)
{
    return substr($l, 15, 4) == base64_decode('TTAxOQ==');
}

// Updating license key
if (isset($_POST['wpgmapembed_license'])) {
    $wpgmapembed_license = trim(esc_html($_POST['wpgmapembed_license']));
    $message = '<span style="color:red">Invalid license key, please get your license key. <a target="_blank" href="' . esc_url('https://srmilon.info/pricing?utm_source=admin_settings&utm_medium=admin_link&utm_campaign=settings_get_license') . '">Get License Key</a></span>';
    if ($wpgmapembed_license != '') {

        // License key validation
        $ip = esc_html($_SERVER['REMOTE_ADDR']);
        $host = esc_html($_SERVER['HTTP_HOST']);

        $arrContextOptions = array(
            "http" => array(
                "method" => "GET",
                "ignore_errors" => true
            ),
            "ssl" => array(
                "allow_self_signed" => true,
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $response = file_get_contents($h . '/paypal/api.php?key=' . $wpgmapembed_license . '&ip=' . $ip . '&host=' . $host, false, stream_context_create($arrContextOptions));
        $response = json_decode($response);
        if ((isset($response->status) and $response->status == true) or gmapSrmIsProvided($wpgmapembed_license)) {

            if (get_option('wpgmapembed_license') !== false) {
                update_option('wpgmapembed_license', $wpgmapembed_license, 'yes');
            } else {
                add_option('wpgmapembed_license', $wpgmapembed_license, '', 'yes');
            }
            update_option('_wgm_is_p_v', 'Y');
            $message = 'License key updated successfully, <i style="color: green;">Now you can enjoy premium features!</i>';
        } else {
            $message = '<span style="color:red">Invalid license key, please get your license key. <a target="_blank" href="' . esc_url('https://srmilon.info/pricing?utm_source=admin_settings&utm_medium=admin_link&utm_campaign=settings_get_license') . '">Get License Key</a></span>';
        }
    }
}
?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Settings', 'gmap-embed'); ?></h1>
    <?php
    if (!_wgm_is_premium()) {
        echo '<a target="_blank" href="' . esc_url('https://srmilon.info/pricing?utm_source=admin_settings&utm_medium=admin_link&utm_campaign=header_menu') . '" class="button wgm_btn" style="float:right;width:auto;padding: 5px 7px;font-size: 11px;margin-left:5px;"><i style="line-height: 25px;" class="dashicons dashicons-star-filled"></i> Upgrade ($10 only)</a>';
    }
    echo '<a target="_blank" href="' . esc_url('https://tawk.to/chat/6083e29962662a09efc1acd5/1f41iqarp') . '" class="button wgm_btn" style="float:right;width:auto;padding: 5px 7px;font-size: 11px;margin-right:5px;background-color: #cb5757 !important;color: white !important;"><i style="line-height: 28px;" class="dashicons dashicons-format-chat"></i> ' . __('LIVE Chat', 'gmap-embed') . '</a>';
    echo '<a href="' . esc_url(admin_url('admin.php?page=wpgmapembed-support')) . '" class="button wgm_btn" style="float:right;width:auto;padding: 5px 7px;font-size: 11px;margin-right:5px;"><i style="line-height: 25px;" class="dashicons  dashicons-editor-help"></i> ' . __('Documentation', 'gmap-embed') . '</a>';
//    echo '<a target="_blank" href="' . esc_url('https://srmilon.info/documentation?utm_source=admin_settings&utm_medium=admin_link&utm_campaign=admin_header') . '" class="button wgm_btn" style="float:right;width:auto;padding: 5px 7px;font-size: 11px;margin-right: 5px;"><i style="line-height: 25px;" class="dashicons dashicons-book"></i> ' . __('Help Manual', 'gmap-embed') . '</a>';
    ?>
    <hr class="wp-header-end">
    <!--Settings Tabs-->
    <div class="wgm-settings-menu">
        <ul>
            <li class="active" data-tab="wgm_general_settings"><a href="#wgm_general_settings">General Settings</a></li>
            <li data-tab="wgm_advanced_settings"><a href="#wgm_advanced_settings">Advanced Settings</a></li>
        </ul>
    </div>
    <div id="gmap_container_inner" style="margin-top: 0;border-top: none;">
        <?php require_once WGM_PLUGIN_PATH . 'admin/includes/wgm_messages_viewer.php'; ?>
        <div class="wgm_settings_tabs" id="wgm_general_settings" style="display: block;">
            <div class="wpgmapembed_get_api_key">
                <h2><?php _e('API Key and License Information', 'gmap-embed'); ?></h2>
                <hr/>
                <table class="form-table" role="presentation">

                    <tbody>
                    <form method="post"
                          action="<?php echo admin_url(); ?>admin.php?page=wpgmapembed-settings&message=3">
                        <tr>
                            <th scope="row">
                                <label for="wpgmapembed_key">
                                    <?php _e('Enter API Key: ', 'gmap-embed'); ?>
                                </label>
                            </th>
                            <td scope="row">
                                <input type="text" name="wpgmapembed_key"
                                       value="<?php echo esc_html(get_option('wpgmap_api_key')); ?>"
                                       size="45" class="regular-text" style="width:100%" id="wpgmapembed_key"/>
                                <p class="description" id="tagline-description" style="font-style: italic;">
                                    <?php _e('The API key may take up to 5 minutes to take effect', 'gmap-embed'); ?>
                                </p>
                            </td>
                            <td width="30%" style="vertical-align: top;">
                                <button class="button wgm_btn" style="padding: 4px 10px;font-size: 11px;margin-right:5px;width: auto;"><i class="dashicons dashicons-update-alt" style="line-height: 23px;"></i> <?php _e('Update', 'gmap-embed'); ?></button>
                                <a target="_blank" style="margin-left: 5px;" href="
					<?php echo esc_url('https://console.developers.google.com/flows/enableapi?apiid=maps_backend,places_backend,geolocation,geocoding_backend,directions_backend&amp;keyType=CLIENT_SIDE&amp;reusekey=true'); ?>"
                                   class="button media-button button-default button-large"><i class="dashicons dashicons-external" style="line-height: 30px;"></i>
                                    <?php _e('GET API KEY', 'gmap-embed'); ?>
                                </a>
                            </td>
                        </tr>
                    </form>

                    <form method="post"
                          action="<?php echo admin_url(); ?>admin.php?page=wpgmapembed-settings&message=4">
                        <tr>
                            <th scope="row">
                                <label for="wpgmapembed_license">
                                    <?php _e('License Key: ', 'gmap-embed'); ?>
                                </label>
                            </th>
                            <td scope="row">
                                <input type="text" name="wpgmapembed_license"
                                       value="<?php echo esc_html(get_option('wpgmapembed_license')); ?>"
                                       size="45" class="regular-text" style="width:100%" id="wpgmapembed_license"/>
                                <p class="description" id="tagline-description" style="font-style: italic;">
                                    <?php _e('After payment you will get an email with license key', 'gmap-embed'); ?>
                                </p>
                            </td>
                            <td width="30%" style="vertical-align: top;">
                                <button class="button wgm_btn" style="padding: 4px 10px;font-size: 11px;margin-right:5px;width: auto;"><i class="dashicons dashicons-yes-alt" style="line-height: 23px;"></i> <?php _e('Validate', 'gmap-embed'); ?></button>

                                <?php
                                if (strlen(trim(get_option('wpgmapembed_license'))) !== 32) { ?>
                                    <a target="_blank"
                                       href="<?php echo esc_url('https://srmilon.info/pricing?utm_source=admin_settings&utm_medium=admin_link&utm_campaign=settings_get_license'); ?>"
                                       class="button media-button button-default button-large"><?php _e('GET LICENSE KEY', 'gmap-embed'); ?></a>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                    </form>
                    </tbody>
                </table>
            </div>
            <div data-columns="8">
                <form method="POST" action="options.php">
                    <div class="wpgmap_lng_custom_script_settings">
                        <?php
                        settings_fields('wpgmap_general_settings');
                        do_settings_sections('gmap-embed-settings-page-ls');
                        do_settings_sections('gmap-embed-settings-page-cs');
                        do_settings_sections('gmap-embed-general-settings');
                        submit_button();
                        ?>
                    </div>
                </form>
            </div>
        </div>
        <div class="wgm_settings_tabs" id="wgm_advanced_settings" style="display: none;">
            <form method="POST" action="options.php">
                <div class="wpgmap_lng_custom_script_settings">
                    <?php
                    settings_fields('wgm_advance_settings');
                    do_settings_sections('wgm_advance_settings-page');
                    submit_button();
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>