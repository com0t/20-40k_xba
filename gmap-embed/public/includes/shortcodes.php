<?php
if (!defined('ABSPATH')) exit;
// ************* WP Google Map Shortcode ***************
if (!function_exists('srm_gmap_embed_shortcode')) {

    /**
     * Generate map based on shortcode input
     * @param $atts
     * @param $content
     * @return string
     * @since 1.0.0
     */
    function srm_gmap_embed_shortcode($atts, $content)
    {
        static $count;
        if (!$count) {
            $count = 0;
        }
        $count++;
        $wgm_map_id = intval(esc_html($atts['id']));
        $wpgmap_title = esc_html(get_post_meta($wgm_map_id, 'wpgmap_title', true));
        $wpgmap_show_heading = esc_html(get_post_meta($wgm_map_id, 'wpgmap_show_heading', true));
        $wpgmap_heading_class = esc_html(get_post_meta($wgm_map_id, 'wpgmap_heading_class', true));
        //$wpgmap_latlng = esc_html(get_post_meta($wgm_map_id, 'wpgmap_latlng', true));
        //$wpgmap_disable_zoom_scroll = esc_html(get_post_meta($wgm_map_id, 'wpgmap_disable_zoom_scroll', true));
        $wpgmap_map_zoom = esc_html(get_post_meta($wgm_map_id, 'wpgmap_map_zoom', true));
        $wpgmap_map_width = esc_html(get_post_meta($wgm_map_id, 'wpgmap_map_width', true));
        $wpgmap_map_height = esc_html(get_post_meta($wgm_map_id, 'wpgmap_map_height', true));
        $wpgmap_map_type = esc_html(get_post_meta($wgm_map_id, 'wpgmap_map_type', true));
        //$wpgmap_map_address = esc_html(get_post_meta($wgm_map_id, 'wpgmap_map_address', true));
        //$wpgmap_show_infowindow = get_post_meta($wgm_map_id, 'wpgmap_show_infowindow', true);
        $wpgmap_enable_direction = get_post_meta($wgm_map_id, 'wpgmap_enable_direction', true);
        $wpgmap_center_lat_lng = get_center_lat_lng_by_map_id($wgm_map_id);

        ob_start();
        if ($wpgmap_center_lat_lng != '') {
            if ($wpgmap_show_heading == '1') {
                echo "<h1 class='srm_gmap_heading_$count " . esc_attr($wpgmap_heading_class) . "'>" . esc_html(strip_tags($wpgmap_title)) . "</h1>";
            }
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    var wgm_map = new google.maps.Map(document.getElementById("srm_gmp_embed_<?php echo $count; ?>"), {
                        center: new google.maps.LatLng(<?php echo $wpgmap_center_lat_lng;?>),
                        zoom:<?php echo $wpgmap_map_zoom;?>,
                        mapTypeId: google.maps.MapTypeId.<?php echo $wpgmap_map_type;?>,
                        scrollwheel: <?php echo get_option('_wgm_disable_mouse_wheel_zoom') === 'Y' ? 0 : 1; ?>,
                        zoomControl: <?php echo get_option('_wgm_disable_zoom_control') === 'Y' ? 0 : 1; ?>,
                        mapTypeControl: <?php echo get_option('_wgm_disable_map_type_control') === 'Y' ? 0 : 1; ?>,
                        streetViewControl: <?php echo get_option('_wgm_disable_street_view') === 'Y' ? 0 : 1; ?>,
                        fullscreenControl: <?php echo get_option('_wgm_disable_full_screen_control') === 'Y' ? 0 : 1; ?>,
                        draggable: <?php echo get_option('_wgm_disable_mouse_dragging') === 'Y' ? 0 : 1; ?>,
                        disableDoubleClickZoom: <?php echo get_option('_wgm_disable_mouse_double_click_zooming') === 'Y' ? 1 : 0; ?>,
                        panControl: <?php echo get_option('_wgm_disable_pan_control') === 'Y' ? 0 : 1; ?>

                    });
                    // To view directions form and data
                    <?php if($wpgmap_enable_direction and _wgm_is_premium() ){ ?>
                    var wgm_directionsDisplay_<?php echo $count;?> = new google.maps.DirectionsRenderer();

                    wgm_directionsDisplay_<?php echo $count;?>.setMap(wgm_map);
                    wgm_directionsDisplay_<?php echo $count;?>.setPanel(document.getElementById("wp_gmap_directions_<?php echo $count; ?>"));

                    var wgm_get_direction_btn_<?php echo $count;?> = document.getElementById('wp_gmap_submit_<?php echo $count; ?>');
                    wgm_get_direction_btn_<?php echo $count;?>.addEventListener('click', function () {
                        var wgm_selectedMode_<?php echo $count;?> = document.getElementById("srm_gmap_mode_<?php echo $count; ?>").value,
                            wgm_dirction_start_<?php echo $count;?> = document.getElementById("srm_gmap_from_<?php echo $count; ?>").value,
                            wgm_direction_end_<?php echo $count;?> = document.getElementById("srm_gmap_to_<?php echo $count; ?>").value;
                        if (wgm_dirction_start_<?php echo $count;?> === '' || wgm_direction_end_<?php echo $count;?> === '') {
                            // cannot calculate route
                            document.getElementById("wp_gmap_results_<?php echo $count; ?>").style.display = 'none';
                            return false;
                        } else {


                            document.getElementById('wp_gmap_loading_<?php echo $count; ?>').style.display = 'block';

                            var wgm_direction_request_<?php echo $count;?> = {
                                origin: wgm_dirction_start_<?php echo $count;?>,
                                destination: wgm_direction_end_<?php echo $count;?>,
                                travelMode: google.maps.DirectionsTravelMode[wgm_selectedMode_<?php echo $count;?>]
                            };
                            var wgm_directionsService_<?php echo $count;?> = new google.maps.DirectionsService();
                            wgm_directionsService_<?php echo $count;?>.route(wgm_direction_request_<?php echo $count;?>, function (response, status) {
                                document.getElementById('wp_gmap_loading_<?php echo $count; ?>').style.display = 'none';
                                if (status === google.maps.DirectionsStatus.OK) {
                                    wgm_directionsDisplay_<?php echo $count;?>.setDirections(response);
                                    document.getElementById("wp_gmap_results_<?php echo $count; ?>").style.display = 'block';
                                } else {
                                    document.getElementById("wp_gmap_results_<?php echo $count; ?>").style.display = 'none';
                                }
                            });

                        }
                    });
                    <?php }?>
                    var wgm_data_<?php echo $count;?> = {
                        'action': 'wpgmapembed_get_markers_by_map_id',
                        'data': {
                            map_id: '<?php echo $wgm_map_id;?>',
                            ajax_nonce: '<?php echo wp_create_nonce('ajax_nonce'); ?>'
                        }
                    };
                    var wgm_ajaxurl_<?php echo $count;?> = '<?php echo esc_url(admin_url('admin-ajax.php'));?>'
                    jQuery.post(wgm_ajaxurl_<?php echo $count;?>, wgm_data_<?php echo $count;?>, function (response) {
                        response = JSON.parse(response);
                        if (response.markers.length === 1) {
                            var wgm_marker_to_<?php echo $count;?> = response.markers[0].marker_desc.replace(/&gt;/g, '>').replace(/&lt;/g, '<');
                            jQuery('#srm_gmap_to_<?php echo $count; ?>').val(wgm_marker_to_<?php echo $count;?>.replace(/(<([^>]+)>)/gi, ""));
                        }
                        var wgm_default_marker_icon_<?php echo $count;?> = 'https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png';
                        if (response.markers.length > 0) {
                            response.markers.forEach(function (wgm_marker) {
                                var wgm_marker_lat_lng_<?php echo $count;?> = wgm_marker.lat_lng.split(',');
                                wgm_custom_marker_<?php echo $count;?> = new google.maps.Marker({
                                    position: new google.maps.LatLng(wgm_marker_lat_lng_<?php echo $count;?>[0], wgm_marker_lat_lng_<?php echo $count;?>[1]),
                                    title: wgm_marker.marker_name,
                                    animation: google.maps.Animation.DROP,
                                    icon: (wgm_marker.icon === '') ? wgm_default_marker_icon_<?php echo $count;?> : wgm_marker.icon
                                });
                                wgm_custom_marker_<?php echo $count;?>.setMap(wgm_map);
                                var wgm_marker_name_<?php echo $count;?> = (wgm_marker.marker_name !== null) ? ('<span class="info_content_title" style="font-size:18px;font-weight: bold;font-family: Arial;">'
                                    + wgm_marker.marker_name +
                                    '</span><br/>') : '';
                                wgm_marker.marker_desc = wgm_marker.marker_desc.replace(/&gt;/g, '>').replace(/&lt;/g, '<');
                                custom_marker_infowindow = new google.maps.InfoWindow({
                                    content: wgm_marker_name_<?php echo $count;?> + wgm_marker.marker_desc
                                });
                                if (wgm_marker.show_desc_by_default === '1') {
                                    custom_marker_infowindow.open({
                                        anchor: wgm_custom_marker_<?php echo $count;?>,
                                        shouldFocus: false
                                    });
                                }
                                if (wgm_marker.have_marker_link === '1') {
                                    google.maps.event.addListener(wgm_custom_marker_<?php echo $count;?>, 'click', function () {
                                        var wgm_target = '_self';
                                        if (wgm_marker.marker_link_new_tab === '1') {
                                            wgm_target = '_blank';
                                        }
                                        window.open(wgm_marker.marker_link, wgm_target);
                                    });
                                }
                            });
                        }
                    });
                });

            </script>

            <div id="srm_gmp_embed_<?php echo $count; ?>"
                 style="width:<?php echo esc_attr($wpgmap_map_width) . ' !important'; ?>;height:<?php echo esc_attr($wpgmap_map_height); ?>  !important; ">
            </div>
            <?php

            if ($wpgmap_enable_direction == '1' and _wgm_is_premium()) { ?>
                <style type="text/css">
                    .wp_gmap_direction_box {
                        width: 100%;
                        height: auto;
                    }

                    .fieldcontain {
                        margin: 8px 0;
                    }

                    #wp_gmap_submit {
                        background-color: #333;
                        border: 0;
                        color: #fff;
                        cursor: pointer;
                        font-family: "Noto Sans", sans-serif;
                        font-size: 12px;
                        font-weight: 700;
                        padding: 13px 24px;
                        text-transform: uppercase;
                    }

                    #wp_gmap_directions {
                        border: 1px #ddd solid;
                    }
                </style>
                <div class="wp_gmap_direction_box">
                    <div class="ui-bar-c ui-corner-all ui-shadow">
                        <div data-role="fieldcontain" class="fieldcontain">
                            <label for="srm_gmap_from_<?php echo $count; ?>"><?php _e('From', 'gmap-embed') ?></label>
                            <input type="text" id="srm_gmap_from_<?php echo $count; ?>" value="" style="width: 100%;"/>
                        </div>
                        <div data-role="fieldcontain" class="fieldcontain">
                            <label for="srm_gmap_to_<?php echo $count; ?>"><?php _e('To', 'gmap-embed') ?></label>
                            <input type="text" id="srm_gmap_to_<?php echo $count; ?>"
                                   value=""
                                   style="width: 100%"/>
                        </div>
                        <div data-role="fieldcontain" class="fieldcontain">
                            <label for="srm_gmap_mode_<?php echo $count; ?>"
                                   class="select"><?php _e('Transportation method', 'gmap-embed') ?>:</label>
                            <select name="select_choice_<?php echo $count; ?>" id="srm_gmap_mode_<?php echo $count; ?>"
                                    style="padding: 5px;width: 100%;">
                                <option value="DRIVING"><?php _e('Driving', 'gmap-embed') ?></option>
                                <option value="WALKING"><?php _e('Walking', 'gmap-embed') ?></option>
                                <option value="BICYCLING"><?php _e('Bicycling', 'gmap-embed') ?></option>
                                <option value="TRANSIT"><?php _e('Transit', 'gmap-embed') ?></option>
                            </select>
                        </div>
                        <button type="button" data-icon="search" data-role="button" href="#" style="padding:8px;"
                                id="wp_gmap_submit_<?php echo $count; ?>"><?php _e('Get Directions', 'gmap-embed') ?>
                        </button>
                        <span id="wp_gmap_loading_<?php echo $count; ?>"
                              style="display: none;"><?php _e('Loading', 'gmap-embed') ?>...</span>
                    </div>

                    <!-- Directions will be listed here-->
                    <div id="wp_gmap_results_<?php echo $count; ?>"
                         style="display:none;max-height: 300px;overflow-y: scroll;">
                        <div id="wp_gmap_directions_<?php echo $count; ?>"></div>
                    </div>

                </div>
                <?php
            }
        } else {
            if (is_user_logged_in() and current_user_can('administrator')) {
                echo "<span style='color:darkred;'>Shortcode not defined, please check WP Google Map plugin in wordpress admin panel(sidebar). This message only visible to Administrator</span>";
            }
        }
        ?>
        <?php
        return ob_get_clean();
    }

}

//******* Defining Shortcode for WP Google Map
add_shortcode('gmap-embed', 'srm_gmap_embed_shortcode');
