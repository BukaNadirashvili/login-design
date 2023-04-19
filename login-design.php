<?php

/*
Plugin Name: Login Design
Description: Custom login page design.
Author: Bondo Nadirashvili
Text Domain: login-design
Version: 1
*/

define('LOGIN_DESIGN_DIR_PATH', plugin_dir_path( __FILE__ ));
define('LOGIN_DESIGN_DIR_URL', plugin_dir_url( __FILE__ ));

require_once 'classes/login-design.php';

add_action('plugins_loaded', function(){

  // Load plugin textdomain.
  load_plugin_textdomain('login-design', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');

});