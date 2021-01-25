<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.cedcoss.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Wholesale_Market
 * @subpackage Woocommerce_Wholesale_Market/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Wholesale_Market
 * @subpackage Woocommerce_Wholesale_Market/admin
 * author     Abhishek Pandey <Abhishekpandey@cedcoss.com>
 */
class Woocommerce_Wholesale_Market_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;




	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-wholesale-market-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script( 'admin_ced_js', plugin_dir_url( __FILE__ ) . 'js/woocommerce-wholesale-market-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'admin_ced_js', 'ced_admin_ajax_object',
		array( 
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		)
		);
	}

		
	/**
	 * Add_settings_tab
	 * Descriptoin : create a tab with name of 'wholesale market' in woo commerce setting tab
	 *
	 * @since 1.0.0
	 * @param  mixed $settings_tabs
	 * @return void
	 */
	public  function add_settings_tab( $settings_tabs ) {
		$settings_tabs['wholesalemarket'] = __( 'Wholesale Market', 'woocommerce-settings-tab-wholesale' );
		return $settings_tabs;
	}


	
	/**
	 * Ced_create_subsection
	 * Description : create a subsection tabs for 'Wholesale market' setting tab with name of GENERAL and INVENTORY
	 *
	 * @since 1.0.0 
	 * @return void
	 */
	public function ced_create_subsection() {
		global $current_section;

		$sections = array(
			'' => 'GENERAL',
			'inventory_setting' => 'INVENTORY'
		);


		if ( empty( $sections ) || 1 === count( $sections ) ) {
			return;
		}

		echo '<ul class="subsubsub">';
		$array_keys = array_keys( $sections );

		foreach ( $sections as $id => $label ) {
			echo '<li><a href="' . esc_url(admin_url( 'admin.php?page=wc-settings&tab=wholesalemarket&section=' . sanitize_title( $id ) ) ) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . esc_attr($label) . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';
		}

		echo '</ul><br class="clear" />';
	}




	
	/**
	 * Get_settings
	 * Description : create settings form for Inventory and GENRAL setting under Wholesale Market TAb
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function get_settings() {

		global $current_section;

		$settings = array();

		if ( '' == $current_section ) {

			$settings = array(
				array(
						'title' => __( 'General Setting for wholesale Markeet', 'woocommerce' ),
						'desc'  => __( 'These pages need to be set so that WooCommerce knows where to send users to inventory_wholesale_options.', 'woocommerce' ),
						'type'  => 'title',
						'id'    => 'advanced_wholesale_options',
					),
				 array(
						'title'           => __( 'Enable/Disble', 'woocommerce' ),
						'desc'            => __( 'Enable/disable setting', 'woocommerce' ),
						'id'              => 'woocommerce_enable_disable__setting',
						'default'         => 'no',
						'type'            => 'checkbox',
						'checkboxgroup'   => 'start',
						'show_if_checked' => 'option',
						'desc_tip'        => __( 'Enable/Disable wholesale pricing setting.', 'woocommerce' ),
					),
				array(
					'title'    => __('Show Wholesale Price', 'wholesale-market'),
					'id'       => 'wholesale_market_prices_show_user_setting',
					'default'  => 'show_all_user',	
					'type'     => 'radio',
					'desc_tip' => __('This option is important as it will affect how you Show Wholesale price to user.', 'wholesale-market'),
					'options'  => array(
						'show_all_customer' => __('Show Wholesale Price to All Customers ', 'wholesale-market'),
						'only_wholesale_customer'  => __('Show Wholesale Price to Only WholeSale Customers', 'wholesale-market'),
					),
					'desc_tip'        => __( 'Enable/Disable wholesale pricing setting.' ),
				),
				array(
					'title' => __( 'Wholesale Prefix', 'text-domain' ),
					'type' => 'text',
					'desc' =>  __( 'Text Field to store what text should be shown with Wholesale Price.', 'text-domain' ),
					'id' => 'wholesale_price_prefix',
					'desc_tip'        => __( 'Enable/Disable wholesale pricing setting.' )
				),
				array(
					'type' => 'sectionend',
					'id' => 'woocommerce_redirects_license_settings'
				),

			);
		
		} else if ( 'inventory_setting' === $current_section ) {
				$settings = array(
				array(
						'title' => __( 'Inventory Setting for wholesale Markeet', 'woocommerce' ),
						'desc'  => __( 'These pages need to be set so that WooCommerce knows where to send users to checkout.', 'woocommerce' ),
						'type'  => 'title',
						'id'    => 'inventory_wholesale_options',
					),

				array(
					'title' => __( 'Enable Minimum Quantity', 'text-domain' ),
					'type' => 'checkbox',
					'desc' =>  __( ' Enable min. qty setting for applying wholesale price.', 'text-domain' ),
					'id' => 'enable_minmimum_qunatity_wholesale_settings',

				),
				array(
					'title'    => __('Set Min qty', 'wholesale-market'),
					'id'       => 'wholesale_market_set_min_qty',
					'default'  => 'all_customer',
					'type'     => 'radio',
					'desc_tip' => __('This option is important as it will affect how you Show Wholesale price to user.', 'wholesale-market'),
					'options'  => array(
						'set_min_qty_product_level' => __('Set Min qty on product level ', 'wholesale-market'),
						'set_common_min_qty_all_product'  => __('Set common min qty for all products.', 'wholesale-market'),
					),
				),
				array(
					'title' => __( 'Minimum Quantity', 'text-domain' ),
					'type' => 'number',
					'desc' =>  __( 'Text Field to store what text should be shown with Minimum quantity.', 'text-domain' ),
					'id' => 'wholesale_minimum_quantity',
					'desc_tip'        => __( 'Set the minimum quantity for applying wholesale price .' ),
					'custom_attributes' => array(
						'min' => 1,
						'required' => 'required'
					)
					
				),
				array(
					'type' => 'sectionend',
					'id' => 'woocommerce_redirects_license_settings'
				),
			);
		}
		return apply_filters( 'woocommerce_get_settings_wholesale', $settings );
	}


	/**
	 * Output the settings.
	 */
	public function output() {

		$settings = $this->get_settings();

		WC_Admin_Settings::output_fields( $settings );
	}



	/**
	 * Save settings.
	 */
	public function save() {

		global $current_section;

		$settings = $this->get_settings();

		WC_Admin_Settings::save_fields( $settings );

		if ( $current_section ) {
			do_action( 'woocommerce_update_options_whole_sale' . $current_section );
		}
	}

		
	/**
	 * Ced_wholesale_price_quntity_feild
	 * Discription : create a custom feild for Wholesale price and Wholesale quantity
	 *
	 * @since 1.0.0
	 * @param  mixed $post_id
	 * @return void
	 */
	public function ced_wholesale_price_quantity_feild($post_id ) { 
		if ('yes' ==get_option( 'woocommerce_enable_disable__setting', true )) {
			global $woocommerce, $post;
			woocommerce_wp_text_input(
				array(
					'id'          => 'general_wholesale_price_feild',
					'data_type'   => 'price',
					'value' => get_post_meta( $post->ID, 'general_wholesale_price_feild', true ),
					'label'       => __( 'Whole Sale Price!', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
					'description'       => __( 'Let your customers know when the product wholesale price., unless you define stock at variation level.', 'woocommerce' ),
					'desc_tip'          => true,
				)
			);
			woocommerce_wp_text_input(
				array(
					'id'          => 'general_wholesale_quantity_feild',
					'data_type'   => 'price',
					'value' => get_post_meta( $post->ID, 'general_wholesale_quantity_feild', true ),
					'label'       => __( 'Product Quantity', 'woocommerce' ) ,
					'description'       => __( 'Let your customers know when the product wholesale price., unless you define stock at variation level.', 'woocommerce' ),
					'desc_tip'          => true,
					
				)
			);
			woocommerce_wp_text_input(
				array(
				'id' => 'wholesale_general_product_nonce',
				'label' => '',
				'placeholder' => '',
				'type' => 'hidden',
				'value' => wp_create_nonce('create_nonce_for_general_product')
				)
			);	

		}
		
	}

		
	/**
	 * Ced_save_general_wholesale_data
	 * Description : for save the data of general- Wholesale Price and General Wholesale Quanity in post_meta table
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function ced_save_general_wholesale_data( $post_id ) { 
		// if (isset( $_POST['wholesale_price_nonce']) && wp_verify_nonce(sanitize_text_field($_POST['wholesale_price_nonce'], 'wholesale_price_nonce'))) {
		global $post;
		if (isset($_POST['general_wholesale_quantity_feild']) && wp_verify_nonce(sanitize_text_field($_POST['wholesale_price_nonce']), $action = -1 )) {
			$gen_wholesale_quantity = sanitize_text_field($_POST['wholesale_general_product_nonce']);
			if ($gen_wholesale_quantity <= 0) {
				$this->sample_admin_notice__error('Quantity Should greater than 0');
			} else {
				update_post_meta($post_id, 'general_wholesale_quantity_feild', esc_attr( $gen_wholesale_quantity ));
			}
		}
		if (isset($_POST['general_wholesale_price_feild'])) {
			$gen_wholesale_price = sanitize_text_field($_POST['general_wholesale_price_feild']); 
			if ($gen_wholesale_price <= 0 ) {
				$this->sample_admin_notice__error('Quantity Should greater than 0');
			} else {
				update_post_meta($post_id, 'general_wholesale_price_feild', esc_attr( $gen_wholesale_price ));
			}

		}

	   

	   // echo($gen_wholesale_quantity);
	   
	  
	   //  echo($gen_wholesale_price); 
	  

	   // var_dump($gen_wholesale_price);
	   // if ( isset( $gen_wholesale_quantity) && ($gen_wholesale_quantity > 0))
	   //  update_post_meta($post_id, 'general_wholesale_quantity_feild', esc_attr( $gen_wholesale_quantity ) );
	   // if ( isset( $gen_wholesale_price ) && ($gen_wholesale_price > 0 )) update_post_meta($post_id, 'general_wholesale_price_feild', esc_attr( $gen_wholesale_price ) );
	}

	
	/**
	 * Ced_wholesale_price_quantity_feild_for_varition
	 * Description : create a customm feild for the variation products with the name of wholesale price and wholesale quantity
	 *
	 * @since 1.0.0
	 * @param  mixed $loop
	 * @param  mixed $variation_data
	 * @param  mixed $variation
	 * @return void
	 */
	public function ced_wholesale_price_quantity_feild_for_varition( $loop, $variation_data, $variation ) {
		if ('yes' ==get_option( 'woocommerce_enable_disable__setting', true )) {
			woocommerce_wp_text_input( array(
			'id' => 'variation_wholesale_quantity[' . $loop . ']',
			'label' => __( 'Wholesale Quantity ', 'woocommerce' ),
			'value' => get_post_meta( $variation->ID, 'variation_wholesale_quantity', true ),
			'wrapper_class' => 'form-row form-row-first',
			'description'       => __( 'Let your customers know when the product wholesale quantity., unless you define stock at variation level.', 'woocommerce' ),
			'desc_tip'          => true,
			'type' => 'number',
			'custom_attributes' => array(
				'min' => 1,
				'required' => 'required'
			)
			   ) 
		);
			woocommerce_wp_text_input( array(
			'id' => 'variation_wholesale_price[' . $loop . ']',
			'label' => __( 'Wholesale Price ', 'woocommerce' ),
			'wrapper_class' => 'form-row form-row-last',
			'value' => get_post_meta( $variation->ID, 'variation_wholesale_price', true ),
			'description'       => __( 'Let your customers know when the product wholesale price., unless you define stock at variation level.', 'woocommerce' ),
			'desc_tip'          => true,
				s) 
			);
			woocommerce_wp_text_input(
				array(
				'id' => 'wholesale_variation_product_nonce',
				'label' => '',
				'placeholder' => '',
				'type' => 'hidden',
				'value' => wp_create_nonce('create_nonce_for_variation_product')
				)
			);	
		}
	}
 

		
	/**
	 * Ced_save_variation_wholesale_data
	 * Description : save the data of variation produt's wholesale price and wholesale quantity
	 *
	 * @since 1.0.0 
	 * @param  mixed $variation_id
	 * @param  mixed $i
	 * @return void
	 */
	public function ced_save_variation_wholesale_data( $variation_id, $i ) { 
		global $post;
		if (isset($_POST['variation_wholesale_quantity'][$i]) && (wp_verify_nonce(sanitize_text_field($_POST['wholesale_variation_product_nonce']), $action = -1 )))) { 
			$variation_wholesale_quantity = sanitize_text_field($_POST['variation_wholesale_quantity'][$i]);
			if ($variation_wholesale_quantity <= 0 ) {
				$this->sample_admin_notice__error('variation wholesale should greater then 0');
			} else {
				update_post_meta( $variation_id, 'variation_wholesale_quantity', esc_attr( $variation_wholesale_quantity ));
			}
		}
		if (isset($_POST['variation_wholesale_price'][$i])) { 
			$variation_wholesale_price = sanitize_text_field($_POST['variation_wholesale_price'][$i]);
			if ($variation_wholesale_price <= 0 ) { 
				$this->sample_admin_notice__error('variation should greater then 0');
			} else {
				update_post_meta( $variation_id, 'variation_wholesale_price', esc_attr( $variation_wholesale_price ));
			}

		}
	   
	   // if ( isset( $variation_wholesale_quantity ) ) update_post_meta( $variation_id, 'variation_wholesale_quantity', esc_attr( $variation_wholesale_quantity ) );
	   // if ( isset( $variation_wholesale_price ) ) update_post_meta( $variation_id, 'variation_wholesale_price', esc_attr( $variation_wholesale_price ) );
	}

	
	/**
	 * Ced_add_user_custom_column
	 * Description : create a custom column with name of 'wholesale market'  in user settings
	 *
	 * @since 1.0.0
	 * @param  mixed $columns
	 * @return void
	 */
	public function ced_add_user_custom_column($columns) {  
		$columns['wholesale_user'] = 'Wholesale_User';
		return $columns;
	}

		
	/**
	 * Ced_content_for_user_custom_column
	 * Description : content for  created a custom column with name of 'wholesale market' in user settings
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	public function ced_content_for_user_custom_column ($value, $column_name, $user_id) {  
		// var_dump($user_id);
		if ('wholesale_user' == $column_name) {
			$value = '';
			if ('login_as_wholesaller' == get_user_meta( $user_id, 'register_wholesale_shipping' , 1)) {

				$value = "<input type='button' class='normal_to_wholeseller' value = 'Approved Pending' data-id='" . $user_id . "'>";

			} else {
				$value =  '_____';
			}
		}	
		return $value;	
	}
	

	/**
	 * Ced_create_setting_user_to_wholesale_user
	 * Discription: create a custom feild for change the normal user to wholesale user
	 *
	 * @since 1.0.0 
	 * @param  mixed $user
	 * @return void
	 */
	public function ced_create_setting_user_to_wholesale_user ( $user ) {
		echo '<h3 class="heading">Wholesale User</h3>';   
		?>   
		<table class='form-table'>
		<tr>
			<th><label for="wholesale user">Whole Sale User</label></th>
			<td><input type="checkbox" value ="user_to_wholesale" class="input-text form-control" name="whole_sale_user_checkbox" id="whole_sale_user_checkbox" /> Check for change the User to Wholesale User if you have find a specific situation to change it
			</td>
		</tr>
		</table>  
		<?php
	}


	/**
	 * Ced_save_setting_user_to_wholesale_user_data
	 * Discription : save the user setting of wholesale user 
	 *
	 * @since 1.0.0
	 * @param  mixed $user_id
	 * @return void
	 */
	public function ced_save_setting_user_to_wholesale_user_data( $user_id ) { 
		if (isset($_POST['whole_sale_user_checkbox'])) {
			$seting_user_to_wholesale = sanitize_text_field($_POST['whole_sale_user_checkbox']);
			update_user_meta( $user_id, 'whole_sale_user_checkbox', esc_attr( $seting_user_to_wholesale ) ); 
		}	
	}
	
	/**
	 * Ced_normaluser_to_wholeseller_approval
	 * Description : function for change the role of a user, normal user to wholesale user
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function ced_normaluser_to_wholeseller_approval() { 
		global $post;
		if (isset($_POST['id'])) {
			$data_id = $_POST['id'];
			$detail_data = new WP_User($data_id);
			// Wp-User will show thwn current whole detail of user
			$detail_data->remove_role($detail_data->roles[0]);
			$detail_data->add_role('wholeseller');
			update_user_meta($data_id, 'register_wholesale_shipping', 'Approved');
			echo 'Approved Successfully';
		}
		
	}
	public function sample_admin_notice__error($data) { 
		$class = 'notice notice-error is-dismissible';
		$content = $data;
		$message = __( $content, 'sample-text-domain' );
		if ( '' != $content) 
		{
			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
		}
		// printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );     
	}

	






}
