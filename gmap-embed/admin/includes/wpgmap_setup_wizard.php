<div class="wgm_setup_wizard_container">
    <div class="wgm_setup_wizard_wrap">

        <div class="wgm_setup_wizard_header">
            <img class="wgm_logo"
                 src="<?php echo esc_url(plugins_url("../assets/images/gmap_embed_logo.jpg", __FILE__)); ?>"/>
            <span class="wgm_plugin_name"><?php _e('Quick Setup Wizard', 'gmap-embed'); ?></span>
        </div>

        <ul class="wgm_setup_wizard_steps wgm_four" data-step="0">
            <li class="wgm_step">
                <div class="wgm_icon">
                    <i class="fas fa-key"></i>
                </div>
                <div class="wgm_step_name"><?php _e("CREATE YOUR API KEY", "gmap-embed") ?></div>
            </li>
            <li class="wgm_step">
                <div class="wgm_icon">
                    <i class="fas fa-language"></i>
                </div>
                <div class="wgm_step_name"><?php _e("MAP LANGUAGE & REGION", "gmap-embed") ?></div>
            </li>
        </ul>

        <div class="wgm_setup_body">
            <form class="wgm_setup_wizard_form" method="post" action="#">
                <!--Get API key-->
                <div class="wgm_setup_content wgm_box">
                    <div class="wgm_row">
                        <div class="wgm-col-full">
                            <span class="wgm_heading"><?php _e('Create API Key from Google', 'gmap-embed'); ?></span>
                            <p class="wgm_text_center wgm_mb_40"><?php _e('Let\'s create API key from Google cloud platform, <b>it\'s required by Google to use Google Map</b>', 'gmap-embed'); ?></p>
                        </div>
                        <div class="wgm-col-full wgm_d_flex">
                            <label for="wgm_key"><?php _e('Enter API key', 'gmap-embed'); ?></label>
                            <div class="wgm_w_60">
                                <input type="text" name="wgm_key"
                                       placeholder="Please click on GET API KEY button to get your own API key"
                                       value="<?php echo esc_html(get_option('wpgmap_api_key')); ?>" size="60"
                                       id="wgm_key"/>
                            </div>
                            <a target="_blank"
                               href="<?php echo esc_url('https://console.developers.google.com/flows/enableapi?apiid=maps_backend,places_backend,geolocation,geocoding_backend,directions_backend&amp;keyType=CLIENT_SIDE&amp;reusekey=true'); ?>"
                               class="button media-button button-default button-large wgm_api_btn"> <i
                                        class="fas fa-external-link-alt"></i>
                                <?php _e('GET API KEY', 'gmap-embed'); ?>
                            </a>
                        </div>
                    </div>
                    <div class="wgm-col-full wgm_text_right">
                        <a href="//www.youtube.com/watch?v=m-jAsxG0zuk" target="_blank" class="wgm_info_notice">
                            <i class="dashicons dashicons-youtube"></i> <?php _e('Video Tutorial', 'gmap-embed'); ?>
                        </a>
                        &nbsp;&nbsp;&nbsp;<a
                                href="<?php echo esc_url('https://srmilon.info/documentation/wp-google-map-quick-installation?utm_source=admin_setup_wizard&utm_medium=admin_link&utm_campaign=setup_wizard');?>"
                                target="_blank" class="wgm_info_notice"><i
                                    class="fas fa-external-link-alt"></i> <?php _e('See help manual', 'gmap-embed'); ?>
                        </a>
                    </div>
                </div>
                <!-- Language and Regional Setup-->
                <div id="wpgmap_lang_regional" class="wgm_setup_content wgm_box">
                    <div class="wgm_row">
                        <div class="wgm-col-full">
                            <span class="wgm_heading"><?php _e('Language and Regional Setup', 'gmap-embed'); ?></span>
                            <p class="wgm_text_center wgm_mb_40"><?php _e('You can customize your Google Map title & contents by setting up Language and Regional setup', 'gmap-embed'); ?></p>
                        </div>
                        <div class="wgm-col-full wgm_d_flex wgm_mb_15">
                            <label><?php _e('Map Language:', 'gmap-embed') ?></label>
                            <div class="wgm_w_60">
                                <select id="wgm_gmap_lng" name="srm_gmap_lng" class="regular-text">
                                    <?php
                                    $wpgmap_languages = gmap_embed_get_languages();
                                    if (count($wpgmap_languages) > 0) {
                                        foreach ($wpgmap_languages as $lng_key => $language) {
                                            $selected = '';
                                            if (get_option('srm_gmap_lng', 'en') == $lng_key) {
                                                $selected = 'selected';
                                            }
                                            echo "<option value='$lng_key' $selected>$language</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <p class="description" id="tagline-description" style="font-style: italic;">
                                    <?php _e('Choose your desired map language', 'gmap-embed'); ?>
                                </p>
                            </div>
                        </div>
                        <br>
                        <div class="wgm-col-full wgm_d_flex">
                            <label><?php _e('Regional Area:', 'gmap-embed') ?></label>
                            <div class="wgm_w_60">
                                <select id="wgm_region" name="wgm_region" class="regular-text">
                                    <?php
                                    $wpgmap_regions = gmap_embed_get_regions();
                                    if (count($wpgmap_regions) > 0) {
                                        foreach ($wpgmap_regions as $region_key => $region) {
                                            $selected = '';
                                            if (get_option('srm_gmap_region', 'US') == $region_key) {
                                                $selected = 'selected';
                                            }
                                            echo "<option value='$region_key' $selected>$region</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <p class="description" id="tagline-description" style="font-style: italic;">
                                    <?php _e('Choose your regional area', 'gmap-embed'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="wgm_setup_footer">
            <button id="wgm_prev" class="button wgm_btn" style="display: none;">
                &lt; <?php _e('Previous', 'gmap-embed'); ?></button>
            <button id="wgm_next" class="button wgm_btn"
                    style="display: inline;"><?php _e('Next', 'gmap-embed'); ?> &gt;
            </button>
            <button id="wgm_save" style="display: none"
                    class="button wgm_btn wpgmap-setup-wizard-save"><?php _e('Finish', 'gmap-embed'); ?></button>
            <div class="wgm-col-full wgm_d_flex">
                <a href="<?php echo admin_url(); ?>admin.php?page=wpgmapembed">Skip Setup Wizard</a>
            </div>
        </div>
    </div>
</div>