<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.cedcoss.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Uimodification
 * @subpackage Woocommerce_Uimodification/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Uimodification
 * @subpackage Woocommerce_Uimodification/includes
 * @author     Abhishek Pandey <Abhishekpandey@cedcoss.com>
 */
class Woocommerce_Uimodification_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce-uimodification',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
