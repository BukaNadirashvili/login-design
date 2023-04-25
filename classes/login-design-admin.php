<?php

if(!class_exists('LoginDesignAdmin')) :

	/**
	 * Class for user interaction with plugin
	*/
    class LoginDesignAdmin extends Helper {

        private static $instance;
        private $options;

        function __construct() {
            add_action( 'admin_menu', array( $this, 'login_design_page' ) );
			add_filter( 'login_headerurl', array($this, 'login_design_header_url'));
            add_action( 'admin_init', array( $this, 'login_design_init' ) );
			add_action( 'login_head', array( $this, 'login_design_head' ) );
			add_action( 'login_footer', array( $this, 'login_design_title_display' ) );
			add_filter( 'admin_footer_text', array( $this, 'login_design_admin_footer_text' ) );
        }

		/**
		 * LoginDesignAdmin Instance.
		 *
		 * Insures that only one instance of LoginDesignAdmin exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 * 
		 * @static
		 * @return object|LoginDesignAdmin
		 */
        static function instance(){

            if(!isset( self::$instance ) && !( self::$instance instanceof LoginDesignAdmin )) {
                self::$instance = new LoginDesignAdmin();
            }
        }

		/**
		 * Callback function for admin_menu_hook. This function is used to add a custom option page for a plugin.
		 *
		 * @return void
		 */
        function login_design_page() {
            add_options_page( 'Login Design', 'Login Design', 'manage_options', LOGIN_DESIGN_PAGE, array( $this, 'login_design_options' ) );
        }
		
		/**
		 * Callback function for the plugin options page. This function is used to add a form to the options page.
		 *
		 * @return void
		 */
        function login_design_options() {
            ?>

		<div class="wrap">
			<h2><?php esc_html_e( 'Login Design Options', LOGIN_DESIGN_TEXT_DOMAIN ); ?></h2>
			<form action="options.php" method="post">
                <?php
			        settings_fields( LOGIN_DESIGN_GROUP );
			        do_settings_sections( LOGIN_DESIGN_PAGE );
			        submit_button( esc_html__( 'Save Changes', LOGIN_DESIGN_TEXT_DOMAIN ) );
                ?>
			</form>
		</div>

            <?php

        }

		/**
		 * Function for register settings, add section and add settings fields.
		 *
		 * @return void
		 */
        function login_design_init() {

            $vars = $this->login_design_get_options();

            register_setting(
				LOGIN_DESIGN_GROUP,
				LOGIN_DESIGN_OPTIONS,
				array( $this, 'login_design_validate' )
			);

			add_settings_section(
				LOGIN_DESIGN_SECTION,
				__( 'Login Screen Settings', LOGIN_DESIGN_TEXT_DOMAIN ),
				array( $this, 'login_design_section_validate' ),
				LOGIN_DESIGN_PAGE
			);

			add_settings_field(
				'ld_logo',
				__( 'Logo Image Url:', LOGIN_DESIGN_TEXT_DOMAIN ),
				array( $this, 'form_url' ),
				LOGIN_DESIGN_PAGE,
				LOGIN_DESIGN_SECTION,
				array(
					'id' => 'ld_logo',
					'value' => $vars,
					'default' => '',
					'description' => __( 'Ideal size is 312 by 600', LOGIN_DESIGN_TEXT_DOMAIN ),
				)
			);

			
			add_settings_field(
				'ld_header_url',
				__( 'Logo Url:', LOGIN_DESIGN_TEXT_DOMAIN ),
				array( $this, 'form_url' ),
				LOGIN_DESIGN_PAGE,
				LOGIN_DESIGN_SECTION,
				array(
					'id' => 'ld_header_url',
					'value' => $vars,
					'default' => '',
				)
			);

			add_settings_field(
				'ld_background',
				__( 'Background Image Url:', LOGIN_DESIGN_TEXT_DOMAIN ),
				array( $this, 'form_url' ),
				LOGIN_DESIGN_PAGE,
				LOGIN_DESIGN_SECTION,
				array(
					'id' => 'ld_background',
					'value' => $vars,
					'default' => '',
				)
			);

			add_settings_field(
				'ld_powerby',
				__( 'Custom Login Powered by:', LOGIN_DESIGN_TEXT_DOMAIN ),
				array( $this, 'form_text' ),
				LOGIN_DESIGN_PAGE,
				LOGIN_DESIGN_SECTION,
				array(
					'id' => 'ld_powerby',
					'value' => $vars,
					'default' => '',
					'description' => '',
				)
			);

			add_settings_field(
				'ld_footertext',
				__( 'WordPress footer text:', LOGIN_DESIGN_TEXT_DOMAIN ),
				array( $this, 'form_text' ),
				LOGIN_DESIGN_PAGE,
				LOGIN_DESIGN_SECTION,
				array(
					'id' => 'ld_footertext',
					'value' => $vars,
					'default' => '',
					'description' => __( 'Appears at the bottom of the admin pages when logged in.', LOGIN_DESIGN_TEXT_DOMAIN ),
				)
			);

        }

		/**
		 * Get plugin options
		 *
		 * @return array
		 */
        function login_design_get_options() {

			if ( empty( $this->options ) ) {

				$this->options = get_option( LOGIN_DESIGN_OPTIONS );

				if ( empty( $this->options ) ) {
					$saved_options = get_option( LOGIN_DESIGN_OPTIONS );
					$this->options = wp_parse_args(
						$saved_options,
						array(
							'ld_logo' 	  	 	=> '',
							'ld_header_url' 	=> '',
							'ld_background'  	=> '',
							'ld_powerby' 	 	=> '',
							'ld_footer_text' 	=> '',
						)
					);
				}
			}

			return $this->options;

		}

        function login_design_section_validate() {
        }

		/**
		 * Display the custom login info
		 */
		function login_design_head() {

			$options = $this->login_design_get_options();
			
			echo '<link rel="stylesheet" type="text/css" href="' . esc_url( LOGIN_DESIGN_DIR_URL . 'assets/css/style.css' ) . '" />';
			// Output styles.
			echo '<style>';

			if ( ! empty( $options['ld_logo'] ) ) {
?>
			#login > h1 > a {
				background: url(<?php echo esc_url( $options['ld_logo'] ); ?>);
			}				
				
<?php
			}

			if ( ! empty(  $options['ld_background'] ) ) {
?>
			#login {
				background:url(<?php echo esc_url( $options['ld_background'] ); ?>) top center no-repeat;
			}
<?php
			}



			echo '</style>';

		}

		function login_design_header_url($login_header_url) {
			
			$options = $this->login_design_get_options();

			if ( empty( $options['ld_header_url'] ) )
				return;

			$url = $options['ld_header_url'];
			
			return $url;
		}

		function login_design_title_display() {

			$options = $this->login_design_get_options();

			if ( empty( $options['ld_powerby'] ) )
				return;

			$powered_by = $options['ld_powerby'];

			echo '<p class="ld-powered-by" aria-hidden="true">' . esc_html( $powered_by ) . '</p>';
		}

		function login_design_admin_footer_text($old_text) {
			
			$options = $this->login_design_get_options();
			
			return !empty( $options['ld_footertext']) ? esc_html( $options['ld_footertext'] ) : wp_kses_post( $old_text );

		}

		function login_design_validate($fields) {
			
			$fields['ld_logo'] 		  = esc_url_raw( $fields['ld_logo'] );
			$fields['ld_header_url']  = esc_url_raw( $fields['ld_header_url'] );
			$fields['ld_background']  = esc_url_raw( $fields['ld_background'] );
			$fields['ld_powerby'] 	  = wp_strip_all_tags( esc_html( $fields['ld_powerby'] ) );
			$fields['ld_footer_text'] = wp_strip_all_tags( esc_html( $fields['ld_footer_text'] ) );

			return $fields;
		}

    }
endif;

LoginDesignAdmin::instance();