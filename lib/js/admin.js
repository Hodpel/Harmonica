jQuery(document).ready(function($) {
	"use strict";

	$('.collapsed input:checkbox').click(unhideHidden);
	
	function unhideHidden(){
		if ($(this).attr('checked')) {
			$(this).parent().parent().next().removeClass('hidden');
		}
		else {
			$(this).parent().parent().next().addClass('hidden');
		}
	}

	$('#harmonica_theme_settings-content_archive').on('change', function() {
	  	if (this.value != 'full') {
			$('#harmonica_content_limit_setting').removeClass('hidden');
			$('#harmonica_more_link_scroll').addClass('hidden');
		}
		else {
			$('#harmonica_content_limit_setting').addClass('hidden');
			$('#harmonica_more_link_scroll').removeClass('hidden');
		}
	});

});	