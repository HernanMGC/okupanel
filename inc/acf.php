<?php
if( !function_exists('is_plugin_active') ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}


function okupanel_acf_available() {
	return is_plugin_active( 'events-manager/events-manager.php' )
	&& is_plugin_active( 'advanced-custom-fields/acf.php' );
}

define('ACF_EVENTS_GROUP_EXTENDED_FIELDS', 'group_5ead9a23be333');
define('ACF_EVENTS_FIELD_ENABLE_DIGITAL', 'field_5ead9af64d517');
define('ACF_EVENTS_GROUP_LOCATION_URL', 'field_5ead9b954d518');
if ( okupanel_acf_available() ) {
	function acf_add_events_fields() {
		if( function_exists('acf_add_local_field_group') ) {
			acf_add_local_field_group(array(
				'key' => ACF_EVENTS_GROUP_EXTENDED_FIELDS,
				'title' => __('Extended options - Okupanel', OKUPANEL_TEXTDOMAIN),
				'fields' => array(
					array(
						'key' => ACF_EVENTS_FIELD_ENABLE_DIGITAL,
						'label' => __('Digital location', OKUPANEL_TEXTDOMAIN),
						'name' => 'okupanel_event_location_is_digital',
						'type' => 'true_false',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => __('If this options is checked, all location fields will be ignored when shown on the Okupanel. Link for digital location will be shown instead.', OKUPANEL_TEXTDOMAIN),
						'default_value' => 0,
						'ui' => 0,
						'ui_on_text' => '',
						'ui_off_text' => '',
					),
					array(
						'key' => ACF_EVENTS_GROUP_LOCATION_URL,
						'label' => __('Link for digital location', OKUPANEL_TEXTDOMAIN),
						'name' => 'okupanel_event_location_url',
						'type' => 'url',
						'instructions' => __('Digital location for the event.', OKUPANEL_TEXTDOMAIN),
						'required' => 1,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_5ead9af64d517',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'location',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));
		}
	}
	add_action('init', 'acf_add_events_fields');
}


function acf_event_admin_enqueue_scripts() {
	wp_enqueue_script( 'acf-event-admin-js', OKUPANEL_URL . '/assets/js/acf_admin.js', array(), '1.0.0', true );

	$acf_event_localize_array = array(
		'acf_events_group_extended_fields' => ACF_EVENTS_GROUP_EXTENDED_FIELDS,
		'acf_events_field_enable_digital' => ACF_EVENTS_FIELD_ENABLE_DIGITAL,
		'acf_events_group_location_url' => ACF_EVENTS_GROUP_LOCATION_URL,
	);
	wp_localize_script( 'acf-event-admin-js', 'acf_event_admin_js', $acf_event_localize_array );
}
add_action('acf/input/admin_enqueue_scripts', 'acf_event_admin_enqueue_scripts');