<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.cedcoss.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Wholesale_Market
 * @subpackage Woocommerce_Wholesale_Market/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woocommerce_Wholesale_Market
 * @subpackage Woocommerce_Wholesale_Market/public
 * @author     Abhishek Pandey <Abhishekpandey@cedcoss.com>
 */
class Woocommerce_Wholesale_Market_Public {

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
		 * defined in Woocommerce_Wholesale_Market_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Wholesale_Market_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-wholesale-market-public.css', array(), $this->version, 'all' );

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
		 * defined in Woocommerce_Wholesale_Market_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Wholesale_Market_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woocommerce-wholesale-market-public.js', array( 'jquery' ), $this->version, false );

	}
	public function ced_create_wholoesale_shipping_option() {
		?>
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
		<input  name="register_wholesale_shipping" type="checkbox" id="register_wholesale_shipping" value="login_as_wholesaller" /> <span><?php esc_html_e( 'Shop as Wholeseller (Hey user if you want to shop as a wholeseller so please check this box )', 'woocommerce' ); ?></span>
			</label>
		<?php
	}
	public function ced_save_wholoesale_shipping_option_register( $user_id ) {
		$register_shiping_wholeseller = $_POST['register_wholesale_shipping'];
	    if ( isset( $register_shiping_wholeseller ) ) update_user_meta( $user_id, 'register_wholesale_shipping', esc_attr( $register_shiping_wholeseller ) );
	}



	public function ced_show_wholesale_price_singlepage()
	{ 
		global $post;
		$show_wholesell_setting = get_option('wholesale_market_prices_show_user_setting',1);
		$prefix_for_wholesell = get_option('wholesale_price_prefix',1);
		if($show_wholesell_setting == 'show_all_customer') {
			$wholesale_price = get_post_meta(  $post->ID,'general_wholesale_price_feild',1);
			if($wholesale_price !=='') {
				?>
				<h4>W.S Price = <?php echo $prefix_for_wholesell; ?> <?php echo get_woocommerce_currency_symbol( $args['currency'] ).  $wholesale_price  ;?></h4>
				<?
			}
		} else {
			if(is_user_logged_in()) {
				$id = get_current_user_id();
				$role = new WP_User($id);
				$current_user_role = $role->roles[0];	
				if($current_user_role == 'wholeseller' || $current_user_role == 'administrator') {
					$wholesale_price = get_post_meta(  $post->ID,'general_wholesale_price_feild',1);
					if($wholesale_price !=='') {
						?>
						<h4>W.S Price = <?php echo $prefix_for_wholesell; ?> <?php echo get_woocommerce_currency_symbol( $args['currency'] ).  $wholesale_price  ;?></h4>
						<?
					}
				}
			}
		}
		
	}
function change_product_price( $price, $variation) {
	$variation_id = $variation->id;
	$whole_sale_price_for_variation_content = get_post_meta($variation->id,'wholesale_price_feild',1);
	var_dump($whole_sale_price_for_variation_content);
    $price = $whole_sale_price_for_variation_content;
    return $price;
}


}
?>
