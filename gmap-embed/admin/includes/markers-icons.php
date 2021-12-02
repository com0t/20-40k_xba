<ul class="wgm_gmap_embed_marker_icons">
	<?php
	global $wpdb;
	$wpgmap_marker_icons = $wpdb->get_results( "SELECT type, file_name FROM {$wpdb->prefix}wgm_icons", OBJECT );
	foreach ( $wpgmap_marker_icons as $key => $marker_icon ) {

//		$map_icon_data = array(
//			'type'                => 'pre_uploaded_icon',
//			'title'=>basename( $marker_icon->file_name ),
//			'desc'=>basename( $marker_icon->file_name ),
//			'file_name'=>$marker_icon->file_name
//		);
//		$defaults            = [];
//		$wp_gmap_marker_icon = wp_parse_args( $map_icon_data, $defaults );
//		$wpdb->insert(
//			$wpdb->prefix . 'wgm_icons',
//			$wp_gmap_marker_icon,
//			[
//				'%s',
//				'%s',
//				'%s',
//				'%s'
//			]
//		);

		$image_path = $marker_icon->file_name;
		if ( $marker_icon->type == 'pre_uploaded_icon' ) {
			$image_path = plugin_dir_url( __FILE__ ) . "../assets/images/markers/" . basename( $marker_icon->file_name );
		}
		?>
        <li>
            <img width="32" src="<?php echo $image_path; ?>" onclick="wpgmapChangeCurrentMarkerIcon(this);"/>
        </li>
		<?php
	}
	?>
</ul>