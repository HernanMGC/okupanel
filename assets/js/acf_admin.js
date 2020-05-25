(function($) {
	function digital_location_enabled() {
		$('#em-location-where').hide();

		$('#em-location-where #location-address').val('Calle Falsa');
		$('#em-location-where #location-town').val('Ciudad Falsa');
		$('#em-location-where #location-state').val('');
		$('#em-location-where #location-postcode').val('');
		$('#em-location-where #location-region').val('');
		$('#em-location-where #location-country').val('ES');
	}

	function digital_location_disabled(previous_where_values) {
		$('#em-location-where').show();

		$('#em-location-where :input').each(function(i, v) {
			$(this).val(previous_where_values[i]);
		})
	}

	acf.add_action('ready', function( $el ){
		
		var group_extended_fields = acf_event_admin_js.acf_events_group_extended_fields;
		var field_enable_digital = acf_event_admin_js.acf_events_field_enable_digital;
		var group_location_url = acf_event_admin_js.acf_events_group_location_url;
			
		var previous_where_values = [];

		$('#em-location-where :input').each(function() {
			var value = $(this).val();
			previous_where_values.push(value);
		})


		$('#acf-'+field_enable_digital).change(function() {
			if (this.checked) {
				digital_location_enabled();
			} else {
				digital_location_disabled(previous_where_values);
			}
		});

		if ($('#acf-'+field_enable_digital).prop('checked') ) {
			digital_location_enabled();
		} else {
			digital_location_disabled(previous_where_values);
		}
	});
})(jQuery);	