<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.cedcoss.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Wholesale_Market
 * @subpackage Woocommerce_Wholesale_Market/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Wholesale_Market
 * @subpackage Woocommerce_Wholesale_Market/includes
 * @author     Abhishek Pandey <Abhishekpandey@cedcoss.com>
 */
class Woocommerce_Wholesale_Market_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function ced_add_role_wholeseller() {
		add_role(
	    'wholeseller', //  System name of the role.
	    __( 'Wholeseller'  ), // Display name of the role.
	    array(
	        'read'  => true,
	    )
	);

	}

}
