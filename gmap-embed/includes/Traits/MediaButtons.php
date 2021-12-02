<?php

namespace WGMSRM\Traits;
if (!defined('ABSPATH')) exit;

/**
 * Trait MediaButtons: for plugins media buttons including
 */
trait MediaButtons
{
    public function add_wp_google_map_media_button()
    {

        //path to my icon
        $img = WGM_PLUGIN_URL . 'gmap_icon_18.png';

        //the id of the container I want to show in the popup
        $container_id = 'wp_gmap_popup_container';

        //our popup's title
        $title = 'Select your desired map to insert into post';

        //append the icon
        $context = "<a class='button  thickbox' title='{$title}'
    href='#TB_inline?width=700&height=450&inlineId={$container_id}'>
    " . '<span class="wp-media-buttons-icon" style="background: url(' . $img . '); background-repeat: no-repeat; background-position: left bottom;"></span>' . "WP Google Map</a>";

        echo $context;
    }

    public function wp_google_map_media_button_content()
    {
        ?>
        <div id="wp_gmap_popup_container" style="display:none;">
            <!--modal contents-->
            <div id="wgm_all_maps">
                <!---------------------------new map tab-------------->
                <div class="wp-gmap-tab-content active" id="wp-gmap-all">
                                <span class="wpgmap_msg_error" style="width:80%;">

                                </span>
                    <!--all map tab-->
                    <div class="wp-gmap-list">
                        <a href="<?php echo esc_url(admin_url() . 'admin.php?page=wpgmapembed&amp;tag=new'); ?>"
                           data-id="wp-gmap-new" class="media-menu-item" style="float:right;">Create New
                            Map</a>
                        <span class="spinner is-active"
                              style="margin: 0px !important;float:left;"></span>
                        <div id="wpgmapembed_list"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}