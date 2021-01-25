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
 * package    Woocommerce_Wholesale_Market
 * subpackage Woocommerce_Wholesale_Market/public
 * author     Abhishek Pandey <Abhishekpandey@cedcoss.com>
 */
class Woocommerce_Wholesale_Market_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * access   private
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


/**
 * Ced_create_wholoesale_shipping_option
 * Discription : create a checkbox on register page for shop as a whooleseller
 *
 * @since 1.0.0
 * @return void
 */
public function ced_create_wholoesale_shipping_option() {
	?>
	<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
	<input  name="register_wholesale_shipping" type="checkbox" id="register_wholesale_shipping" value="login_as_wholesaller" /> <span><?php esc_html_e( 'Shop as Wholeseller (Hey user if you want to shop as a wholeseller so please check this box )', 'woocommerce' ); ?></span>
		</label>
	<?php
}

		
/**
 * Ced_save_wholoesale_shipping_option_register
 * Description : save the checkbox value(created for shop as a wholeseller)
 *
 * @since 1.0.0
 * @param  mixed $user_id
 * @return void
 */
public function ced_save_wholoesale_shipping_option_register( $user_id ) {
	global $post;
	if ( isset($_POST['register_wholesale_shipping'])) {
		$register_shiping_wholeseller = sanitize_key($_POST['register_wholesale_shipping']);
		if ( '' !=   $register_shiping_wholeseller  ) {
			update_user_meta( $user_id, 'register_wholesale_shipping', esc_attr( $register_shiping_wholeseller ) );
		}
	}
}


/**
 * Ced_show_wholesale_price_singlepage
 * Description : show the wholesale price on each product (for general products) according to the settings of admin
 *
 * @since 1.0.0
 * @return void
 */
public function ced_show_wholesale_price_singlepage()
{ 
	global $post;
	$show_wholesell_setting = get_option('wholesale_market_prices_show_user_setting', 1);
	$prefix_for_wholesell = get_option('wholesale_price_prefix', 1);
	if ( 'show_all_customer' == $show_wholesell_setting ) {
		$wholesale_price = get_post_meta(  $post->ID, 'general_wholesale_price_feild', 1);
		if ( ''!==$wholesale_price ) {
?>
			<h4>W.S Price = <?php echo esc_attr($prefix_for_wholesell); ?> <?php echo esc_attr(get_woocommerce_currency_symbol( $args['currency'] )) . esc_attr($wholesale_price) ; ?></h4>
<?
		}
	} else {
		if ( is_user_logged_in() ) {
			$id = get_current_user_id();
			$role = new WP_User($id);
			$current_user_role = $role->roles[0];	
			if ($current_user_role == 'wholeseller' || $current_user_role == 'administrator') {
				$wholesale_price = get_post_meta(  $post->ID,'general_wholesale_price_feild', 1);
				if ($wholesale_price !=='') {
 ?>
					<h4>W.S Price = <?php echo esc_attr($prefix_for_wholesell); ?> <?php echo esc_attr(get_woocommerce_currency_symbol( $args['currency'] )) . esc_attr($wholesale_price) ; ?></h4>
<?
				}
			}
		}
	}	
}

/**
 * Ced_show_wholesell_price_variation_product
 * Description : show th ewholesale price on ecah product(for variable product) according to the settings of admin
 * @since 1.0.0
 * @param  mixed $variation_data
 * @param  mixed $product
 * @param  mixed $variation
 * @return void
 */
function ced_show_wholesell_price_variation_product( $variation_data, $product, $variation ) {
	$variationId = $variation_data['variation_id'];
	global $post;
	$show_wholesell_setting = get_option('wholesale_market_prices_show_user_setting',1);
	$prefix_for_wholesell = get_option('wholesale_price_prefix',1);
	if($show_wholesell_setting == 'show_all_customer') {
		$wholsell_price_for_variation = get_post_meta( $variationId, 'variation_wholesale_price' , 1);
		if( $wholsell_price_for_variation != '') {
		$variation_data['price_html'] .= ' <span class="price-suffix"> Wholesell Price = ' . __( $wholsell_price_for_variation, "woocommerce") . ' </span>' ;
	} 
	
	} else {

		if(is_user_logged_in()) {
			$id = get_current_user_id();
			$role = new WP_User($id);
			$current_user_role = $role->roles[0];	
			if($current_user_role == 'wholeseller' || $current_user_role == 'administrator') {
				$wholsell_price_for_variation = get_post_meta( $variationId, 'variation_wholesale_price' , 1);
				if( $wholsell_price_for_variation != '') {
					$variation_data['price_html'] .= ' <span class="price-suffix"> Wholesell Price = ' . __( $wholsell_price_for_variation, "woocommerce") . ' </span>' ;
				} 
			}
		}

	} 
	return $variation_data;
}


/**
 * Ced_setting_of_minimum_qunatity_for_wholesale_applied_for_simple_product
 * Description : for change the cart-page price according to the setting of minimum quantity on each product/same for all product(general products)
 * @since 1.0.0
 * @param  mixed $cart_object
 * @return void
 */
function ced_setting_of_minimum_qunatity_for_wholesale_applied_for_simple_product( $cart_object ) {

	$min_wholesale_qunatity_for_all_products =  get_option( 'wholesale_minimum_quantity', 1);
	$seting_for_min_wholesale_qunatity_for_all_products = get_option( 'wholesale_market_set_min_qty', 1);
	if('set_common_min_qty_all_product'== $seting_for_min_wholesale_qunatity_for_all_products)
	{ 
			$quantity = 0;
			foreach ( $cart_object->get_cart() as $hash => $value ) {	
				$quantity = $value['quantity'];
				$product_id = $value['product_id'];	
				$regular_price = $value['data']->get_regular_price();
				if($quantity > $min_wholesale_qunatity_for_all_products) {
					$wholesale_price = get_post_meta(  $product_id,'general_wholesale_price_feild',1);
					$value['data']->set_price( $wholesale_price );
				} else {
					$value['data']->set_price( $regular_price );
				}													 
				
			}	
		
	} else if('set_min_qty_product_level'== $seting_for_min_wholesale_qunatity_for_all_products)
	{
		$quantity = 0;
		foreach ( $cart_object->get_cart() as $hash => $value ) {
			$quantity = $value['quantity'];
			$product_id = $value['product_id'];
			$min_wholesale_quantity_for_specific_product = get_post_meta($product_id,'general_wholesale_quantity_feild',1);	
			$regular_price = $value['data']->get_regular_price();
			if($quantity > $min_wholesale_quantity_for_specific_product) {
				$wholesale_price = get_post_meta(  $product_id,'general_wholesale_price_feild',1);
				$value['data']->set_price( $wholesale_price );
			} else {
				$value['data']->set_price( $regular_price );
			}									 				
		}
	}
}


	
/**
 * Ced_setting_of_minimum_qunatity_for_wholesale_applied_for_variable_product
 * Description :  for change the cart-page price according to the setting of minimum quantity on each product/same for all product(variable products)
 * @since 1.0.0
 * @param  mixed $cart_object
 * @return EBML_ID_VOID
 */
public function ced_setting_of_minimum_qunatity_for_wholesale_applied_for_variable_product($cart_object) 
{

	foreach ( $cart_object->get_cart() as $hash => $value ) {	
		if('variation' == $value['data']->get_type()) {
			$variation_id =  $value['variation_id'] ;
			if($variation_id !== 0) {
				$min_wholesale_qunatity_for_all_products =  get_option( 'wholesale_minimum_quantity', 1);
				$seting_for_min_wholesale_qunatity_for_all_products = get_option( 'wholesale_market_set_min_qty', 1);


				if('set_common_min_qty_all_product'== $seting_for_min_wholesale_qunatity_for_all_products)
				{ 
					$quantity = 0;
													 
					$quantity = $value['quantity'];
					$product_id = $value['product_id'];	
					$vari_regular_price = $value['data']->get_regular_price();
					if($quantity > $min_wholesale_qunatity_for_all_products) {
						$wholesale_price = get_post_meta(  $variation_id,'variation_wholesale_price',1);
						// echo($hash);
						$value['data']->set_price( $wholesale_price );
					} else {
						$value['data']->set_price( $vari_regular_price );
					}
				}

				 else if('set_min_qty_product_level'== $seting_for_min_wholesale_qunatity_for_all_products)
				
				{
					$quantity = 0;														 
					$quantity = $value['quantity'];
					$product_id = $value['product_id'];
					$min_wholesale_quantity_for_specific_product = get_post_meta($variation_id,'variation_wholesale_quantity',1);
					$vari_regular_price = $value['data']->get_regular_price();
					if($quantity > $min_wholesale_quantity_for_specific_product) {
						$variable_wholesale_price = get_post_meta(  $variation_id,'variation_wholesale_price',1);
						echo $hash."<br>";
						$value['data']->set_price( $variable_wholesale_price );
					} else {
						$value['data']->set_price( $vari_regular_price );
					}
				}
			} 
		}
	}
}
}

