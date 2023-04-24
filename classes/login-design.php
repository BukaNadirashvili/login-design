<?php

if(!class_exists('LoginDesign')) :

    /**
	 * Main Login Design Class.
	 *
	 */
    class LoginDesign {

        private static $instance;

        function __construct() {

            $this->define_constants();
            $this->require_files();
        }

        /**
		 * LoginDesign Instance.
		 *
		 * Insures that only one instance of LoginDesign exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 * 
		 * @static
		 * @return object|LoginDesign
		 */
        static function instance(){

            if(!isset( self::$instance ) && !( self::$instance instanceof LoginDesign )) {
                self::$instance = new LoginDesign();
            }
        }

        /**
		 * Define constants for plugin
		 *
		 * @return void
		 */
        function define_constants() {
            define( 'LOGIN_DESIGN_GROUP', 'login_design' );
            define( 'LOGIN_DESIGN_PAGE', 'login-design-admin' );
            define( 'LOGIN_DESIGN_SECTION', 'login-design-section' );
            define( 'LOGIN_DESIGN_OPTIONS', 'login_design_options' );
            define( 'LOGIN_DESIGN_TEXT_DOMAIN', 'login-design' );
        }

        /**
		 * Require plugin files
		 *
		 * @return void
		 */
        function require_files() {
            require_once 'helper.php';
            require_once 'login-design-admin.php';
        }


        function wpdocs_enqueue_custom_admin_style() {
            wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
            wp_enqueue_style( 'custom_wp_admin_css' );
        }

    }
endif;

LoginDesign::instance();