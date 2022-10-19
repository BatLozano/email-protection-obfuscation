<?php
/**
 * Plugin Name:       Email protection by obfuscation
 * Description:       Obfuscate all "mailto:" links to prevent email-harvesting from spammers.
 * Version:           1.1
 * Requires at least: 5.0
 * Requires PHP:      5.6
 * Author:            Baptiste Lozano
 * Author URI:        https://www.inospin.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       email-protection-obfuscation
 * Domain Path:       languages/
 */

defined('ABSPATH') or die('No script kiddies please!');

define('EMPBO_DIR'  , dirname(__FILE__));
define('EMPBO_URL'  , plugins_url('/', __FILE__) );



// ===================== Initialisation du plugin =====================
function empbo_init() {

    require_once(EMPBO_DIR . "/includes/constants.php");
    require_once(EMPBO_DIR . "/includes/functions.php");

}
add_action('init', 'empbo_init');


function empbo_plugins_loaded() {

    if (!is_admin()){
        require_once EMPBO_DIR."/includes/class/filters.class.php";
        \empbo\filters::obfuscate();
    }
 
}
add_action('wp_loaded', 'empbo_plugins_loaded');



function empbo_scripts(){
    wp_enqueue_script('empbo-js', EMPBO_URL.'/assets/js/script.js', array ("jquery"), '1.0', true);
    wp_localize_script( 'empbo-js', 'empbo_special_number', array( EMPBO_SPECIAL_NUMBER ) );
}
add_action( 'wp_enqueue_scripts', 'empbo_scripts' );








