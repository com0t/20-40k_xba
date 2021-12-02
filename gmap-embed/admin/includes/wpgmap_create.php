<?php if (!defined('ABSPATH')) exit; ?>
<script type="text/javascript">
    var wgp_api_key = '<?php echo esc_html(get_option('wpgmap_api_key'));?>';
</script>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Add New Map', 'gmap-embed'); ?></h1>
    <?php
    if (!_wgm_is_premium()) {
        echo '<a target="_blank" href="' . esc_url('https://srmilon.info/pricing?utm_source=admin_map_create&utm_medium=admin_link&utm_campaign=header_menu') . '" class="button wgm_btn" style="float:right;width:auto;padding: 5px 7px;font-size: 11px;margin-left:5px;"><i style="line-height: 25px;" class="dashicons dashicons-star-filled"></i> Upgrade ($10 only)</a>';
    }
    echo '<a target="_blank" href="' . esc_url('https://tawk.to/chat/6083e29962662a09efc1acd5/1f41iqarp') . '" class="button wgm_btn" style="float:right;width:auto;padding: 5px 7px;font-size: 11px;margin-right:5px;background-color: #cb5757 !important;color: white !important;"><i style="line-height: 28px;" class="dashicons dashicons-format-chat"></i> ' . __('LIVE Chat', 'gmap-embed') . '</a>';
    echo '<a href="' . esc_url(admin_url('admin.php?page=wpgmapembed-support')) . '" class="button wgm_btn" style="float:right;width:auto;padding: 5px 7px;font-size: 11px;margin-right:5px;"><i style="line-height: 25px;" class="dashicons  dashicons-editor-help"></i> ' . __('Documentation', 'gmap-embed') . '</a>';
//    echo '<a target="_blank" href="' . esc_url('https://srmilon.info/documentation?utm_source=admin_map_create&utm_medium=admin_link&utm_campaign=header_menu') . '" class="button wgm_btn" style="float:right;width:auto;padding: 5px 7px;font-size: 11px;margin-right: 5px;"><i style="line-height: 25px;" class="dashicons dashicons-book"></i> ' . __('Help Manual', 'gmap-embed') . '</a>';
    ?>
    <hr class="wp-header-end">
    <div id="gmap_container_inner">
            <span class="wpgmap_msg_error" style="width:80%;">
            </span>
        <div id="wp-gmap-new" style="padding:5px;">
            <!-- google map properties -->
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
                                <input id="wpgmap_title" name="wpgmap_title" value="" type="text"
                                       class="regular-text">
                                <br/>

                                <input type="checkbox" value="1" name="wpgmap_show_heading"
                                       id="wpgmap_show_heading">
                                <label for="wpgmap_show_heading"><?php _e('Show as map title', 'gmap-embed'); ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="wpgmap_latlng"><b><?php _e('Latitude, Longitude(Approx)', 'gmap-embed'); ?></b></label><br/>
                                <input id="wpgmap_latlng" name="wpgmap_latlng" value="" type="text"
                                       class="regular-text">
                                <input type="hidden" name="wpgmap_center_lat_lng" id="wpgmap_center_lat_lng">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="wpgmap_map_zoom"><b><?php _e('Zoom', 'gmap-embed'); ?></b></label><br/>
                                <input id="wpgmap_map_zoom" name="wpgmap_map_zoom" value="13" type="text"
                                       class="regular-text">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="wpgmap_map_width"><b><?php _e('Width (%)', 'gmap-embed'); ?></b></label><br/>
                                <input id="wpgmap_map_width" name="wpgmap_map_width" value="100%"
                                       type="text" class="regular-text">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="wpgmap_map_height"><b><?php _e('Height (px)', 'gmap-embed'); ?></b></label><br/>
                                <input id="wpgmap_map_height" name="wpgmap_map_height" value="300px"
                                       type="text" class="regular-text">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="wpgmap_map_type"><b><?php _e('Map Type', 'gmap-embed'); ?></b></label><br/>
                                <select id="wpgmap_map_type" class="regular-text">
                                    <option>ROADMAP</option>
                                    <option>SATELLITE</option>
                                    <option>HYBRID</option>
                                    <option>TERRAIN</option>
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
                                <label for="wpgmap_heading_class"><b><?php _e('Heading Custom Class', 'gmap-embed'); ?>
                                        <span
                                                style="color:gray;">(if any)</span></b></label><br/>
                                <input id="wpgmap_heading_class" name="wpgmap_heading_class" value="" type="text"
                                       class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="wpgmap_enable_direction" <?php echo !_wgm_is_premium() ? ' class="wgm_enable_premium" " ' : '' ?>
                                       data-notice="<?php echo esc_html(sprintf(__('You need to upgrade to the <a target="_blank" href="%s">Premium</a> Version to <b> Enable Direction Option on Map</b>.', 'gmap-embed'), esc_url('https://srmilon.info/pricing?utm_source=admin_map_create&utm_medium=admin_link&utm_campaign=enable_direction'))); ?>">
                                    <input
                                            type="checkbox" value="1"
                                            name="wpgmap_enable_direction"
                                            id="wpgmap_enable_direction" <?php echo !_wgm_is_premium() ? 'disabled="disabled" ' : '' ?>>
                                    <?php _e('Enable Direction in Map', 'gmap-embed'); ?>
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
                                <!--                                </label>-->
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="wp-gmap-preview">
                <h1 id="wpgmap_heading_preview" style="padding: 0;margin: 0;"></h1>
                <input id="wgm_pac_input" class="wgm_controls" type="text" style="visibility: hidden;"
                       placeholder="<?php _e('Search by Address, Zip Code, (Latitude,Longitude)', 'gmap-embed'); ?>"/>
                <div id="wgm_map" style="height: 520px;"></div>
                <div class="" style="width: 100%;float:left;text-align: right;margin-bottom: 5px;margin-top: 5px;">
                    <span class="spinner" style="margin: 0 !important;float: none;"></span>
                    <button class=" button wgm_btn" id="wp-gmap-embed-save"
                            style="width: auto;padding: 5px 12px;"><?php _e('Save Map', 'gmap-embed'); ?></button>
                </div>
            </div>

            <script type="text/javascript"
                    src="<?php echo esc_url(plugins_url("../assets/js/geo_based_map_create.js?v=" . filemtime(__DIR__ . '/../assets/js/geo_based_map_create.js'), __FILE__)); ?>"></script>
        </div>
    </div>
</div>