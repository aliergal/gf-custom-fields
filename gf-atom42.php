<?php
/**
* Plugin Name: Gravity Forms - UTM Fields
* Description: Adds UTM and referrer fields to the Gravity Form editor
* Version: 1.1.2
* Requires at least: 3.8
* Tested up to: 6.0
* Author URI: https://github.com/aliergal
* Author: Atom42 - Ali Ergal.
* Text Domain: gf-atom42
* Domain Path: /languages/ 
*/
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

$plugin_dir = plugin_dir_path( __DIR__ );
//Enqueue scripts and styles for the plugin
function load_atom42_scripts($hook) {
 
    // create my own version codes
    $js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'js/gf-atom42.min.js' ));
    $css_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'css/gf-atom42.min.css' ));
     
    // 
    wp_enqueue_script( 'atom42_js', plugins_url( 'js/gf-atom42.min.js', __FILE__ ), array(), $js_ver, true );
    wp_register_style( 'atom42_css',    plugins_url( 'css/gf-atom42.min.css',    __FILE__ ), false,   $css_ver );
    wp_enqueue_style ( 'atom42_css' );
 
}
add_action('wp_enqueue_scripts', 'load_atom42_scripts');

//UTM Parameters custom field
require_once('includes/fields/class-gf-field-utm.php');
require_once('includes/fields/class-gf-field-referrer.php');
