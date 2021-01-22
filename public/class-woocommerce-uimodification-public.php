<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.cedcoss.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Uimodification
 * @subpackage Woocommerce_Uimodification/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woocommerce_Uimodification
 * @subpackage Woocommerce_Uimodification/public
 * @author     Abhishek Pandey <Abhishekpandey@cedcoss.com>
 */
class Woocommerce_Uimodification_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Uimodification_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Uimodification_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-uimodification-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Uimodification_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Uimodification_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woocommerce-uimodification-public.js', array( 'jquery' ), $this->version, false );

	}

	public function mytheme_add_woocommerce_support() {
		add_theme_support( 'woocommerce', array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,

	        'product_grid'          => array(
	            'default_rows'    => 3,
	            'min_rows'        => 2,
	            'max_rows'        => 8,
	            'default_columns' => 8,
	            'min_columns'     => 2,
	            'max_columns'     => 5,
	        ),
		) );
	}

	/**
	 * ced_show_theColdOut_items_singlepage
	 * Description : function is used for create the custome badge that will show the sold out badges on product page
	 * @since 1.0.0
	 * @return void
	 */
 	public function ced_shows_theSoldOut_items_shoppage() {
		global $product;
		$quantity  = $product->get_stock_quantity();
		if($quantity <= 0) {
			?>
			<div style = "padding:10px;background-color: red;color: white;font-size: 20px; ">
				SOLD OUT !!!!
			</div>
			<?
		} else {
			echo "";
		}
	}	
	/**
	 * ced_show_theColdOut_items_singlepage
	 * Description : function is used for create the custome badge that will show the sold out badges on single product page
	 * @since 1.0.0
	 * @return void
	 */
	public function ced_show_theColdOut_items_singlepage(){
		global $product;
		$quantity  = $product->get_stock_quantity();
		if($quantity <= 0) {
			?>
			<div style = "padding:10px;background-color: red;color: white;font-size: 20px; ">
				SOLD OUT !!!!
			</div>
			<?
		} else {
			echo "";
		}
	}	


	/**
	 * ced_custom_rename_wc_checkout_fields
	 * Discription : This function used for costomize the feilds of chekout pages 
	 * @since 1.0.0
	 * @param  mixed $fields
	 * @return void
	 */
	public function ced_custom_rename_wc_checkout_fields( $fields ) {
		  $fields['billing']['billing_email']['placeholder'] = 'abhi07898@gmail.com';
		  $fields['billing']['billing_phone']['label'] = 'Mobile';
		  $fields['billing']['billing_email']['label'] = 'E-Mail';
		  $fields['billing']['billing_phone']['placeholder'] = 'contact';
		  return $fields;
	}
	
	/**
	 * ced_template_overiding
	 * Discription : This funciton used for override the template 
	 * @since 1.0.0
	 * @param  mixed $template
	 * @param  mixed $template_name
	 * @param  mixed $template_path
	 * @return void
	 */
	public function ced_template_overiding( $template, $template_name, $template_path ) {
	     global $woocommerce;
	     $_template = $template;
	     if ( ! $template_path ) 
	        $template_path = $woocommerce->template_url;
	 
 		$plugin_path  = untrailingslashit( CED_DIRPATH )  . '/template/woocommerce/';
		$template = locate_template(
	    array(
	      $template_path . $template_name,
	      $template_name
	    )
	   );
	 
	   if( ! $template && file_exists( $plugin_path . $template_name ) )
	    $template = $plugin_path . $template_name;
	 
	   if ( ! $template )
	    $template = $_template;

	   return $template;
	}

}
