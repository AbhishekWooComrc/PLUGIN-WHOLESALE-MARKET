(function( $ ) {
	'use strict';

	// *
	// * All of the code for your admin-facing JavaScript source
	// * should reside in this file.
	// *
	// * Note: It has been assumed you will write jQuery code here, so the
	// * $ function reference has been prepared for usage within the scope
	// * of this function.
	// *
	// * This enables you to define handlers, for when the DOM is ready:
	// *
	// * $(function() {
	// *
	// * });
	// *
	// * When the window is loaded:
	// *
	// * $( window ).load(function() {
	// *
	// * });
	// *
	// * ...and/or other possibilities.
	// *
	// * Ideally, it is not considered best practise to attach more than a
	// * single DOM-ready or window-load handler for a particular page.
	// * Although scripts in the WordPress core, Plugins and Themes may be
	// * practising this, we should strive to set a better example in our own work.
	$( document ).ready(
		function(){
			// for general subsection
			$( "#woocommerce_enable_disable__setting" ).on(
				'change',
				function() {
					if ($( "#woocommerce_enable_disable__setting" ).is( ':checked' )) {
						$( '.titledesc' ).show( 1000 );
						$( '.forminp-radio' ).show();
						$( '.forminp-text' ).show();
					} else {
						$( '.titledesc' ).hide( 100 );
						$( '.forminp-radio' ).hide();
						$( '.forminp-text' ).hide();
					}
				}
			);
			// for inventory sub section
			$( '#enable_minmimum_qunatity_wholesale_settings' ).click(
				function(){
					if ($( "#enable_minmimum_qunatity_wholesale_settings" ).is( ':checked' )) {
						$( '.titledesc' ).show( 1000 );
						$( '.forminp-radio' ).show();
						$( 'input:radio[name="wholesale_market_set_min_qty"]' ).change(
							function(){
								if ($( this ).val() == 'set_common_min_qty_all_product') {
									$( '#wholesale_minimum_quantity' ).show();
								} else {
									$( '#wholesale_minimum_quantity' ).hide();
								}
							}
						);
					} else {
						$( '.titledesc' ).hide( 100 );
						$( '.forminp-radio' ).hide();
						$( '#wholesale_minimum_quantity' ).hide();
					}
				}
			);
			// wholesale price validation for general products
			if ($( '#general_wholesale_price_feild' ).length > 0 && $( '#general_wholesale_price_feild' ).val() != '') {
				$( '#publish' ).click(
					function(e){
						// alert('heklllooo');
						e.preventDefault();
						let reg_price      = parseInt( $( '#_regular_price' ).val() );
						let sale_price     = parseInt( $( '#_sale_price' ).val() );
						let wholsale_price = parseInt( $( '#general_wholesale_price_feild' ).val() );
						if (sale_price > 0) {
							if (wholsale_price >= sale_price ) {
								alert( 'wholesale price should lesser than sale price' );
								$( '#general_wholesale_price_feild' ).focus();
							} else if (wholsale_price >= reg_price ) {
								alert( 'wholesale price should lesser than regular price' );
								$( '#general_wholesale_price_feild' ).focus();
							}
							$( '#post' ).submit();

						}
					}
				);
			}

			// ajax for change the normal user to wholeseller user
			$( '.normal_to_wholeseller' ).click(
				function(){
					let action  = 'ced_ajax_for_usernormal_to_wholeseller';
					let clicked = 'yes_ready_to_approved';
					let user_id = $( this ).data( "id" );
					$.ajax(
						{
							url: ced_admin_ajax_object.ajaxurl,
							type : 'post',
							data : {action:action,data:clicked, id:user_id} ,
							success : function (response) {
								alert( response );
								location.reload();

							}
						}
					);
				}
			);
		}
	);
})( jQuery );
