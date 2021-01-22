(function( $ ) {
	'use strict';

// 	*
// 	 * All of the code for your admin-facing JavaScript source
// 	 * should reside in this file.
// 	 *
// 	 * Note: It has been assumed you will write jQuery code here, so the
// 	 * $ function reference has been prepared for usage within the scope
// 	 * of this function.
// 	 *
// 	 * This enables you to define handlers, for when the DOM is ready:
// 	 *
// 	 * $(function() {
// 	 *
// 	 * });
// 	 *
// 	 * When the window is loaded:
// 	 *
// 	 * $( window ).load(function() {
// 	 *
// 	 * });
// 	 *
// 	 * ...and/or other possibilities.
// 	 *
// 	 * Ideally, it is not considered best practise to attach more than a
// 	 * single DOM-ready or window-load handler for a particular page.
// 	 * Although scripts in the WordPress core, Plugins and Themes may be
// 	 * practising this, we should strive to set a better example in our own work. 
$(document).ready(function(){

// 	$("#woocommerce_enable_disable_setting").on('change', function() {
// 	  if ($("#woocommerce_enable_disable_setting").is(':checked')) {
// 	  	$("input[name='wholesale_market_prices_show_user']").show();
// 	  	$("input[name='woocommerce_wholesale_settings']").show();
// 	  }
// 	  else {
// 	    	$("input[name='wholesale_market_prices_show_user']").hide();
// 	    	$("input[name='woocommerce_wholesale_settings']").hide();
// 	  }
// });
	$('.normal_to_wholeseller').click(function(){
		let action = 'ced_ajax_for_usernormal_to_wholeseller';
		let clicked = 'yes_ready_to_approved';
		let user_id = $(this).data("id");
		$.ajax({
			url: ced_admin_ajax_object.ajaxurl,
			type : 'post',
			data : {action:action,data:clicked, id:user_id} ,
			success : function (response) {
				alert(response);
				    location.reload();
				    
			}
		});
	});

	

})
})( jQuery );
