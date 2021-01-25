<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.cedcoss.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Wholesale_Market
 * @subpackage Woocommerce_Wholesale_Market/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woocommerce_Wholesale_Market
 * @subpackage Woocommerce_Wholesale_Market/includes
 * author     Abhishek Pandey <Abhishekpandey@cedcoss.com>
 */
class Woocommerce_Wholesale_Market {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * access   protected
	 * @var      Woocommerce_Wholesale_Market_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOOCOMMERCE_WHOLESALE_MARKET_VERSION' ) ) {
			$this->version = WOOCOMMERCE_WHOLESALE_MARKET_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'woocommerce-wholesale-market';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woocommerce_Wholesale_Market_Loader. Orchestrates the hooks of the plugin.
	 * - Woocommerce_Wholesale_Market_i18n. Defines internationalization functionality.
	 * - Woocommerce_Wholesale_Market_Admin. Defines all hooks for the admin area.
	 * - Woocommerce_Wholesale_Market_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-wholesale-market-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-wholesale-market-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-wholesale-market-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-wholesale-market-public.php';

		$this->loader = new Woocommerce_Wholesale_Market_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woocommerce_Wholesale_Market_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woocommerce_Wholesale_Market_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woocommerce_Wholesale_Market_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		// add custom setting  tab 
		$this->loader->add_filter( 'woocommerce_settings_tabs_array', $plugin_admin, 'add_settings_tab' );
		// add custom sub setting with name of general and inventory
		$this->loader->add_filter( 'woocommerce_sections_wholesalemarket', $plugin_admin, 'ced_create_subsection' );
		// show the contnent within sub section
		$this->loader->add_action( 'woocommerce_settings_wholesalemarket', $plugin_admin, 'output' );
		// save the content of sub section
		$this->loader->add_action( 'woocommerce_settings_save_wholesalemarket', $plugin_admin, 'save' );
		// create a custom feild for whole sale price and quantityfor general page
		$this->loader->add_action( 'woocommerce_product_options_pricing', $plugin_admin, 'ced_wholesale_price_quantity_feild' );
		// create custom feild for variation page
		$this->loader->add_action( 'woocommerce_variation_options_pricing', $plugin_admin, 'ced_wholesale_price_quantity_feild_for_varition', 10, 3  );
		// added fro save the data of variation content 
		$this->loader->add_action( 'woocommerce_save_product_variation', $plugin_admin, 'ced_save_variation_wholesale_data', 10, 3  );
		// added for save the data fo general feilds
		$this->loader->add_action( 'woocommerce_process_product_meta', $plugin_admin, 'ced_save_general_wholesale_data', 10, 1  );
		// add for create a custom columns in user 'Wholesale Market'
		$this->loader->add_action( 'manage_users_columns', $plugin_admin, 'ced_add_user_custom_column');
		// add for content of custom column 'Wholesale market'
		$this->loader->add_action( 'manage_users_custom_column', $plugin_admin, 'ced_content_for_user_custom_column', 1, 3 );
		// add for create a setting for change the user to wholesale user in edit-user.php
		$this->loader->add_action( 'edit_user_profile', $plugin_admin, 'ced_create_setting_user_to_wholesale_user');
		$this->loader->add_action( 'show_user_profile', $plugin_admin, 'ced_create_setting_user_to_wholesale_user');
		$this->loader->add_action( 'edit_user_profile_update', $plugin_admin, 'ced_save_setting_user_to_wholesale_user_data');
		// add for call the ajax in admin end
		$this->loader->add_action( 'wp_ajax_ced_ajax_for_usernormal_to_wholeseller', $plugin_admin, 'ced_normaluser_to_wholeseller_approval', 1, 1);
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'sample_admin_notice__error', 1, 1);
		// add_action( 'admin_notices', 'sample_admin_notice__error' );



	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woocommerce_Wholesale_Market_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		// add for create a shipping option(a checkbox) in register page
		$this->loader->add_action( 'woocommerce_register_form', $plugin_public, 'ced_create_wholoesale_shipping_option');
		// add for save the shipping option (a checkbox) of register page 
		$this->loader->add_action( 'woocommerce_created_customer', $plugin_public, 'ced_save_wholesale_shipping_option_register');	
		// add for show the wholesale price on single page
		$this->loader->add_action( 'woocommerce_before_add_to_cart_form', $plugin_public, 'ced_show_wholesale_price_singlepage', 1, 1);
		//  add for show the wholesale price on shop page
		$this->loader->add_action( 'woocommerce_after_shop_loop_item', $plugin_public, 'ced_show_wholesale_price_singlepage');
		//  add for show the wholesale price on shop page and single page, for variable products
		$this->loader->add_filter('woocommerce_available_variation', $plugin_public, 'ced_show_wholesell_price_variation_product', 10, 3 );
		//  add for calculate  the price according to the quantity value (setted by admin) specially for general products
		$this->loader->add_filter('woocommerce_before_calculate_totals', $plugin_public, 'ced_setting_of_minimum_qunatity_for_wholesale_applied_for_simple_product', 10, 1);
		//  add for calculate the price according to the quantity value (setted by admin) specially for varaible products
		$this->loader->add_filter('woocommerce_before_calculate_totals', $plugin_public, 'ced_setting_of_minimum_qunatity_for_wholesale_applied_for_variable_product', 10, 1);		

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woocommerce_Wholesale_Market_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
