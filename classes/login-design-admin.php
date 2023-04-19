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
            add_action( 'admin_init', array( $this, 'login_design_init' ) );
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
				'ld_background',
				__( 'Background Image Url:', LOGIN_DESIGN_TEXT_DOMAIN ),
				array( $this, 'form_url' ),
				LOGIN_DESIGN_PAGE,
				LOGIN_DESIGN_SECTION,
				array(
					'id' => 'ld_background',
					'value' => $vars,
					'default' => '',
					'description' => __( 'Ideal size is 312 by 600', LOGIN_DESIGN_TEXT_DOMAIN ),
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
							'ld_background' => '',
						)
					);
				}
			}

			return $this->options;

		}

        function login_design_section_validate() {
        }

    }
endif;

LoginDesignAdmin::instance();