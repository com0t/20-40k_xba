<?php if (!defined('ABSPATH')) exit;
$gmap_data = $this->get_wpgmapembed_data(intval($_GET['id']));
$wpgmap_single = json_decode($gmap_data);
list($wpgmap_center_lat, $wpgmap_center_lng) = explode(',', esc_html($wpgmap_single->wpgmap_center_lat_lng));
?>
<script type="text/javascript">
    var wgp_api_key = '<?php echo esc_html(get_option('wpgmap_api_key'));?>';
</script>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Edit Map', 'gmap-embed'); ?></h1>
    <?php if (_wgm_can_add_new_map()) { ?>
        <a href="<?php echo admin_url('admin.php?page=wpgmapembed-new'); ?>" class="page-title-action">Add New</a>
        <?php
    } else {
        echo '<a href="#" class="page-title-action wgm_enable_premium" style="opacity: .3" data-notice="' . esc_html(sprintf(__('You need to upgrade to the <a target="_blank" href="%s">Premium</a> Version to <b> Create Unlimited Maps</b>.', 'gmap-embed'), esc_url('https://srmilon.info/pricing?utm_source=admin_map_edit&utm_medium=admin_link&utm_campaign=add_new_map'))) . '">Add New</a><sup class="wgm-pro-label">Pro</sup>';
    }
    ?>
    <?php
    if (!_wgm_is_premium()) {
        echo '<a target="_blank" href="' . esc_url('https://srmilon.info/pricing?utm_source=admin_map_edit&utm_medium=admin_link&utm_campaign=header_menu') . '" class="button wgm_btn" style="float:right;width:auto;padding: 5px 7px;font-size: 11px;margin-left:5px;"><i style="line-height: 25px;" class="dashicons dashicons-star-filled"></i> Upgrade ($10 only)</a>';
    }
    echo '<a target="_blank" href="' . esc_url('https://tawk.to/chat/6083e29962662a09efc1acd5/1f41iqarp') . '" class="button wgm_btn" style="float:right;width:auto;padding: 5px 7px;font-size: 11px;margin-right:5px;background-color: #cb5757 !important;color: white !important;"><i style="line-height: 28px;" class="dashicons dashicons-format-chat"></i> ' . __('LIVE Chat', 'gmap-embed') . '</a>';
    echo '<a href="' . esc_url(admin_url('admin.php?page=wpgmapembed-support')) . '" class="button wgm_btn" style="float:right;width:auto;padding: 5px 7px;font-size: 11px;margin-right:5px;"><i style="line-height: 25px;" class="dashicons  dashicons-editor-help"></i> ' . __('Documentation', 'gmap-embed') . '</a>';
//    echo '<a target="_blank" href="' . esc_url('https://srmilon.info/documentation?utm_source=admin_map_edit&utm_medium=admin_link&utm_campaign=header_menu') . '" class="button wgm_btn" style="float:right;width:auto;padding: 5px 7px;font-size: 11px;margin-right: 5px;"><i style="line-height: 25px;" class="dashicons dashicons-book"></i> ' . __('Help Manual', 'gmap-embed') . '</a>';
    ?>
    <span style="float: right;margin: 0px 8px 0 0;">Shortcode <input type="text"
                                                                     value="<?php echo esc_attr('[gmap-embed id=&quot;' . esc_html($_GET['id']) . '&quot;]'); ?>"
                                                                     style="padding: 2px 10px;border: 2px #008dff solid;" onclick="this.select()"></span>
    <hr class="wp-header-end">
    <div id="gmap_container_inner">
        <span class="wpgmap_msg_error" style="width:80%;"></span>
        <div id="wp-gmap-edit" style="padding:5px;">
            <?php require_once WGM_PLUGIN_PATH . 'admin/includes/wgm_messages_viewer.php'; ?>

            <input id="wpgmap_map_id" name="wpgmap_map_id"
                   value="<?php echo isset($_GET['id']) ? intval(esc_html($_GET['id'])) : 0; ?>" type="hidden"/>
            <div class="wp-gmap-properties-outer">
                <div class="wgm_wpgmap_tab">
                    <ul class="wgm_wpgmap_tab">
                        <li class="active" id="wp-gmap-properties">General</li>
                        <li id="wgm_gmap_markers">Markers</li>
                        <li id="wp-gmap-other-properties">Other Settings</li>
                    </ul>
                </div>
                <div class="wp-gmap-tab-contents wp-gmap-properties">
                    <table class="gmap_properties">
                        <tr>
                            <td>
                                <label for="wpgmap_title"><b><?php _e('Map Title', 'gmap-embed'); ?></b></label><br/>
                                <input id="wpgmap_title" name="wpgmap_title"
                                       value="<?php echo esc_attr($wpgmap_single->wpgmap_title); ?>"
                                       type="text"
                                       class="regular-text">
                                <br/>

                                <input type="checkbox" value="1" name="wpgmap_show_heading"
                                       id="wpgmap_show_heading" <?php echo ($wpgmap_single->wpgmap_show_heading == 1) ? 'checked' : ''; ?>>
                                <label for="wpgmap_show_heading"><?php _e('Show as map title', 'gmap-embed'); ?></label>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="wpgmap_latlng"><b><?php _e('Latitude, Longitude(Approx)', 'gmap-embed'); ?></b></label><br/>
                                <input id="wpgmap_latlng" name="wpgmap_latlng"
                                       value="<?php echo esc_attr($wpgmap_single->wpgmap_latlng); ?>"
                                       type="text"
                                       class="regular-text">
                                <input type="hidden" name="wpgmap_center_lat_lng" id="wpgmap_center_lat_lng"
                                       value="<?php echo esc_attr($wpgmap_single->wpgmap_center_lat_lng); ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="wpgmap_map_zoom"><b><?php _e('Zoom', 'gmap-embed'); ?></b></label><br/>
                                <input id="wpgmap_map_zoom" name="wpgmap_map_zoom"
                                       value="<?php echo esc_attr($wpgmap_single->wpgmap_map_zoom); ?>" type="text"
                                       class="regular-text">


                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="wpgmap_map_width"><b><?php _e('Width (%)', 'gmap-embed'); ?></b></label><br/>
                                <input id="wpgmap_map_width" name="wpgmap_map_width"
                                       value="<?php echo esc_attr($wpgmap_single->wpgmap_map_width); ?>"
                                       type="text" class="regular-text">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="wpgmap_map_height"><b><?php _e('Height (px)', 'gmap-embed'); ?></b></label><br/>
                                <input id="wpgmap_map_height" name="wpgmap_map_height"
                                       value="<?php echo esc_attr($wpgmap_single->wpgmap_map_height); ?>"
                                       type="text" class="regular-text">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label><b><?php _e('Map Type', 'gmap-embed'); ?></b></label><br/>
                                <select id="wpgmap_map_type" class="regular-text">
                                    <option <?php echo $wpgmap_single->wpgmap_map_type == 'ROADMAP' ? 'selected' : ''; ?>>
                                        ROADMAP
                                    </option>
                                    <option <?php echo $wpgmap_single->wpgmap_map_type == 'SATELLITE' ? 'selected' : ''; ?>>
                                        SATELLITE
                                    </option>
                                    <option <?php echo $wpgmap_single->wpgmap_map_type == 'HYBRID' ? 'selected' : ''; ?>>
                                        HYBRID
                                    </option>
                                    <option <?php echo $wpgmap_single->wpgmap_map_type == 'TERRAIN' ? 'selected' : ''; ?>>
                                        TERRAIN
                                    </option>
                                </select>
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="wp-gmap-tab-contents wgm_gmap_markers hidden">
                    <?php
                    require_once plugin_dir_path(__FILE__) . 'markers-settings.php'; ?>
                </div>
                <div class="wp-gmap-tab-contents wp-gmap-other-properties hidden">
                    <table class="gmap_properties">
                        <tr>
                            <td>
                                <label for="wpgmap_heading_class"><b><?php _e('Heading Custom Class', 'gmap-embed'); ?></b></label><br/>
                                <input id="wpgmap_heading_class" name="wpgmap_heading_class"
                                       value="<?php echo $wpgmap_single->wpgmap_heading_class; ?>" type="text"
                                       class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="wpgmap_enable_direction" <?php echo !_wgm_is_premium() ? ' class="wgm_enable_premium" " ' : '' ?> data-notice="<?php echo esc_html(sprintf(__('You need to upgrade to the <a target="_blank" href="%s">Premium</a> Version to <b> Enable Direction Option on Map</b>.', 'gmap-embed'), esc_url('https://srmilon.info/pricing?utm_source=admin_map_edit&utm_medium=admin_link&utm_campaign=enable_direction')));?>"><input
                                            type="checkbox"
                                            value="1" <?php echo !_wgm_is_premium() ? 'disabled="disabled" ' : '' ?>
                                            name="wpgmap_enable_direction"
                                            id="wpgmap_enable_direction" <?php echo ($wpgmap_single->wpgmap_enable_direction == 1) ? 'checked' : ''; ?>>
                                    <?php _e('Enable Direction option in Map', 'gmap-embed'); ?>
                                    <?php echo !_wgm_is_premium() ? '<sup class="wgm-pro-label">Pro</sup>' : ''; ?>
                                </label>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <small style="font-size: 9px;font-style: italic">Disable zoom on mouse scroll settings
                                    has been moved under <a
                                            href="<?php echo admin_url('admin.php?page=wpgmapembed-settings#_wgm_disable_zoom_control'); ?>">settings</a>
                                    menu.</small>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="wp-gmap-preview">
                <h1 id="wpgmap_heading_preview"
                    style="padding: 0px;margin: 0px;"><?php echo $wpgmap_single->wpgmap_title; ?></h1>
                <input id="wgm_pac_input" class="wgm_controls" type="text"
                       placeholder="<?php _e('Search by Address, Zip Code, (Latitude,Longitude)', 'gmap-embed'); ?>"/>
                <div id="wgm_map" style="height: 520px;"></div>
                <div class="" style="width: 100%;float:left;text-align: right;margin-bottom: 5px;margin-top: 5px;">
                    <span class="spinner" style="margin: 0 !important;float: none;"></span>
                    <button class="button wgm_btn" style="width: auto;padding: 5px 12px;"
                            id="wp-gmap-embed-update"><?php _e('Update Map', 'gmap-embed'); ?></button>
                </div>
            </div>
            <script type="text/javascript"
                    src="<?php echo esc_url(plugins_url("../assets/js/geo_based_map_edit.js?v=" . filemtime(__DIR__ . '/../assets/js/geo_based_map_edit.js'), __FILE__)); ?>"></script>
            <script type="text/javascript">
                (function ($) {
                    $(function () {
                        google.maps.event.addDomListener(window, 'load',
                            wgm_initAutocomplete('wgm_map', 'wgm_pac_input',<?php echo $wpgmap_center_lat;?>,<?php echo $wpgmap_center_lng;?>, '<?php echo $wpgmap_single->wpgmap_map_type; ?>',<?php echo $wpgmap_single->wpgmap_map_zoom;?>, 'edit')
                        );
                        if (jQuery('#wpgmap_show_infowindow').is(':checked') === true) {
                            wgm_openInfoWindow();
                        }
                    });
                })(jQuery);
            </script>
        </div>
    </div>
</div>