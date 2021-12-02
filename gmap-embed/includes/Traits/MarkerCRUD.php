<?php

namespace WGMSRM\Traits;
if (!defined('ABSPATH')) exit;

/**
 * Trait MarkerCRUD: Map CRUD operation doing here
 */
trait MarkerCRUD
{

    /**
     * Get Marker default values
     * @return array
     */
    public function get_marker_default_values()
    {
        return [
            'map_id' => 0,
            'marker_name' => null,
            'marker_desc' => null,
            'icon' => null,
            'address' => null,
            'lat_lng' => null,
            'have_marker_link' => 0,
            'marker_link' => null,
            'marker_link_new_tab' => 0,
            'show_desc_by_default' => 0,
            'created_at' => current_time('mysql'),
            'created_by' => get_current_user_id(),
            'updated_at' => current_time('mysql'),
            'updated_by' => get_current_user_id()
        ];
    }

    /**
     * To save new map marker
     */
    public function save_map_marker()
    {
        global $wpdb;
        $marker_data = $_POST['map_markers_data'];
        $map_id = sanitize_text_field(esc_html($marker_data['wpgmap_map_id']));
        $error = '';
        // Getting ajax fields value
        $map_marker_data = array(
            'map_id' => $map_id,
            'marker_name' => strlen(sanitize_text_field(esc_html($marker_data['wpgmap_marker_name']))) == 0 ? null : sanitize_text_field(esc_html($marker_data['wpgmap_marker_name'])),
            'marker_desc' => sanitize_text_field(htmlentities($marker_data['wpgmap_marker_desc'])),
            'icon' => sanitize_text_field(esc_html($marker_data['wpgmap_marker_icon'])),
            'address' => sanitize_text_field(esc_html($marker_data['wpgmap_marker_address'])),
            'lat_lng' => sanitize_text_field(esc_html($marker_data['wpgmap_marker_lat_lng'])),
            'have_marker_link' => sanitize_text_field(esc_html($marker_data['wpgmap_have_marker_link'])),
            'marker_link' => sanitize_text_field(esc_html($marker_data['wpgmap_marker_link'])),
            'marker_link_new_tab' => sanitize_text_field(esc_html($marker_data['wpgmap_marker_link_new_tab'])),
            'show_desc_by_default' => sanitize_text_field(esc_html($marker_data['wpgmap_marker_infowindow_show'])),
        );
        if ($map_marker_data['lat_lng'] == '') {
            $error = __("Please input Latitude and Longitude", 'gmap-embed');
        }
        if (strlen($error) > 0) {
            echo json_encode(array(
                'responseCode' => 0,
                'message' => $error
            ));
            wp_die();
        }

        if (!_wgm_is_premium()) {
            $no_of_marker_already_have = $this->get_no_of_markers_by_map_id($map_id);
            if ($no_of_marker_already_have > 0) {
                echo json_encode(array(
                    'responseCode' => 0,
                    'message' => __("Please upgrade to premium version to create unlimited markers", 'gmap-embed')
                ));
                wp_die();
            }
        }

        $defaults = $this->get_marker_default_values();
        $wp_gmap_marker_data = wp_parse_args($map_marker_data, $defaults);
        $wpdb->insert(
            $wpdb->prefix . 'wgm_markers',
            $wp_gmap_marker_data,
            array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%d'
            ));

        $returnArray = array(
            'responseCode' => 1,
            'marker_id' => $wpdb->insert_id
        );
        $returnArray['message'] = 'Marker Saved Successfully.';
        echo json_encode($returnArray);
        wp_die();
    }

    /**
     * To update existing marker information
     */

    public function update_map_marker()
    {
        global $wpdb;
        $error = '';
        $marker_data = $_POST['map_markers_data'];
        $marker_id = sanitize_text_field(esc_html($marker_data['wpgmap_marker_id']));
        $map_id = sanitize_text_field(esc_html($marker_data['wpgmap_map_id']));
        // Getting ajax fields value
        $map_marker_data = array(
            'map_id' => $map_id,
            'marker_name' => strlen(sanitize_text_field(esc_html($marker_data['wpgmap_marker_name']))) == 0 ? null : sanitize_text_field(esc_html($marker_data['wpgmap_marker_name'])),
            'marker_desc' => sanitize_text_field(htmlentities($marker_data['wpgmap_marker_desc'])),
            'icon' => sanitize_text_field(esc_html($marker_data['wpgmap_marker_icon'])),
            'address' => sanitize_text_field(esc_html($marker_data['wpgmap_marker_address'])),
            'lat_lng' => sanitize_text_field(esc_html($marker_data['wpgmap_marker_lat_lng'])),
            'have_marker_link' => sanitize_text_field(esc_html($marker_data['wpgmap_have_marker_link'])),
            'marker_link' => sanitize_text_field(esc_html($marker_data['wpgmap_marker_link'])),
            'marker_link_new_tab' => sanitize_text_field(esc_html($marker_data['wpgmap_marker_link_new_tab'])),
            'show_desc_by_default' => sanitize_text_field(esc_html($marker_data['wpgmap_marker_infowindow_show'])),
        );
        if ($map_marker_data['lat_lng'] == '') {
            $error = __("Please input Latitude and Longitude", 'gmap-embed');
        }
        if (strlen($error) > 0) {
            echo json_encode(array(
                'responseCode' => 0,
                'message' => $error
            ));
            wp_die();
        }

        $defaults = $this->get_marker_default_values();
        $wp_gmap_marker_data = wp_parse_args($map_marker_data, $defaults);

        $wpdb->update(
            $wpdb->prefix . 'wgm_markers',
            $wp_gmap_marker_data,
            array('id' => $marker_id),
            [
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%d'
            ],
            array('%d')
        );

        $returnArray = array(
            'responseCode' => 1,
            'marker_id' => $marker_id
        );
        $returnArray['message'] = 'Updated Successfully.';
        echo json_encode($returnArray);
        wp_die();
    }

    /**
     * Get all marker icons/pins
     */
    public function get_marker_icons()
    {
        ob_start();
        require_once WGM_PLUGIN_PATH . 'admin/includes/markers-icons.php';
        echo ob_get_clean();
        wp_die();
    }

    /**
     * Save Marker Icon
     */
    public function save_marker_icon()
    {
        global $wpdb;
        $error = '';
        $icon_url = $_POST['data']['icon_url'];
        // Getting ajax fields value
        $map_icon_data = array(
            'type' => 'uploaded_marker_icon',
            'title' => '',
            'desc' => '',
            'file_name' => $icon_url
        );

        $is_marker_icon_already_exist = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}wgm_icons WHERE file_name='{$icon_url}'");
        if ($is_marker_icon_already_exist == 0) {
            $defaults = array(
                'file_name' => ''
            );
            $wp_gmap_marker_icon = wp_parse_args($map_icon_data, $defaults);
            $wpdb->insert(
                $wpdb->prefix . 'wgm_icons',
                $wp_gmap_marker_icon,
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                )
            );
        }

        $returnArray = array(
            'responseCode' => 1,
            'icon_url' => $icon_url
        );
        $returnArray['message'] = 'Updated Successfully.';
        echo json_encode($returnArray);
        wp_die();
    }

    /**
     * Get no of markers by map id
     * @param $map_id int
     * @retun int
     */
    public function get_no_of_markers_by_map_id($map_id = 0)
    {
        global $wpdb;
        $map_id = sanitize_text_field(esc_html($map_id));
        return $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}wgm_markers WHERE map_id='{$map_id}'");
    }

    /**
     * Get all markers by map id
     */
    public function get_markers_by_map_id()
    {
        if (!wp_verify_nonce($_POST['data']['ajax_nonce'], 'ajax_nonce')) {
            die ('Busted!');
        }

        global $wpdb;
        $map_id = sanitize_text_field(esc_html($_POST['data']['map_id']));
        $filtered_map_markers = [];
        $map_markers = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wgm_markers WHERE map_id='{$map_id}'");
        if(count($map_markers)>0){
            foreach($map_markers as $key=>$map_marker){
                $map_marker->marker_desc=wp_unslash(html_entity_decode($map_marker->marker_desc));
                $filtered_map_markers[$key] = $map_marker;
            }

        }
        $returnArray = array(
            'responseCode' => 1,
            'markers' => $filtered_map_markers
        );
        $returnArray['message'] = 'Markers fetched successfully.';
        echo json_encode($returnArray);
        wp_die();
    }

    /**
     * Get markers by map id for datatable
     */
    public function wgm_get_markers_by_map_id_for_dt()
    {
        $return_json = array();
        global $wpdb;
        $map_id = $_GET['map_id'];
        $wpgmap_markers = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wgm_markers WHERE map_id='{$map_id}'");
        if (count($wpgmap_markers) > 0) {
            foreach ($wpgmap_markers as $marker_key => $wpgmap_marker) {
                $action = '<a href="" class="wpgmap_marker_edit button button-small"
                           map_marker_id="' . $wpgmap_marker->id . '"><i class="fas fa-edit"></i></a>
                        <a href="" class="wpgmap_marker_view button button-small"
                           map_marker_id="' . $wpgmap_marker->id . '"><i class="fas fa-eye"></i></a>
                        <a href="" class="wpgmap_marker_trash button button-small"
                           map_marker_id="' . $wpgmap_marker->id . '"><i class="fas fa-trash"></i></a>';
                $row = array(
                    'id' => $wpgmap_marker->id,
                    'marker_name' => $wpgmap_marker->marker_name,
                    'icon' => '<img src="' . $wpgmap_marker->icon . '" width="20">',
                    'action' => $action
                );
                $return_json[] = $row;
            }
        }
        //return the result to the ajax request and die
        echo json_encode(array('data' => $return_json));
        wp_die();
    }

    /**
     * Delete single marker
     */
    public function delete_marker()
    {
        $marker_id = esc_attr($_POST['data']['marker_id']);
        global $wpdb;
        $wpdb->delete(
            $wpdb->prefix . 'wgm_markers',
            array(
                'id' => $marker_id,
            ),
            array(
                '%d'
            )
        );
    }

    /**
     * Get marker single data by marker ID
     */
    public function get_marker_data_by_marker_id()
    {
        global $wpdb;
        $marker_id = esc_attr($_POST['data']['marker_id']);
        $result = $wpdb->get_row(" SELECT * FROM {$wpdb->prefix}wgm_markers WHERE id='$marker_id'", OBJECT);
        $result->marker_desc=wp_unslash(html_entity_decode($result->marker_desc));
        echo json_encode($result);
        wp_die();
    }
}