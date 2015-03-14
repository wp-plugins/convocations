<?php
/*
Plugin Name: Convocations
Plugin URI: http://wordpress.org/extend/plugins/convocations/
Description: Convocations plugin is for sports associations such as football clubs, handball clubs, basket-ball clubs, ... which allows you to manage the notifications of your teams and of your players to matches.
Version: 0.6
Author: JC
Author URI: http://www.breizh-seo.com/
*/

// Define the path of plugin
define( 'CONVOCATIONS_VERSION', '0.6' );
define( 'CONVOCATIONS_FILE', basename(__FILE__) );
define( 'CONVOCATIONS_PATH', plugin_dir_path(__FILE__) );
define( 'CONVOCATIONS_DIR', dirname( plugin_basename( __FILE__ ) ) );
define( 'CONVOCATIONS_APP_PATH', CONVOCATIONS_PATH. 'app/');
define( 'CONVOCATIONS_LIBS_PATH', CONVOCATIONS_PATH. 'libs/' );

// URL
define('CONVOCATIONS_URL', plugin_dir_url( __FILE__ ));
define('CONVOCATIONS_LIBS_URL', CONVOCATIONS_URL .'libs/');

require_once( 'class-convocations.php' );