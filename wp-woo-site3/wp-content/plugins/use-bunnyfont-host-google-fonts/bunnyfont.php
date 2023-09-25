<?php

/**
 * Plugin Name: Replace or Remove Google Fonts
 * Plugin URI: https://wordpress.org/plugins/use-bunnyfont-host-google-fonts/
 * Description: Disable and remove google fonts or simply replace all Google Fonts with BunnyFonts (GDPR friendly)
 * Version: 1.4.2
 * Author: easywpstuff
 * Author URI: https://easywpstuff.com/
 * License: GNU General Public License v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: remove-replace-gf
 * Domain Path: /l10n
**/


// If this file is called directly, abort.
if (!defined("WPINC")){
	die;
}


/**
 * Silent is golden
**/
define("BFH_EXEC",true);


/**
 * Debug
**/
define("BFH_DEBUG",false);


/**
 * Plugin File
**/
define("BFH_FILE",__FILE__);


/**
 * Plugin Path
**/
define("BFH_PATH",dirname(__FILE__));


/**
 * Plugin Base URL
**/
define("BFH_URL",plugins_url("/",__FILE__));


// include option page

require BFH_PATH . "/inc/options.php";

/**
 * Begins execution of the plugin.
**/

// replace google fonts with bunnyfonts
function bfh_run_bunnyfont( $html ) { 
	$html = str_replace('fonts.googleapis.com', 'fonts.bunny.net', $html);
    $html = str_replace('fonts.gstatic.com" crossorigin', 'fonts.bunny.net" crossorigin', $html);
	$html = str_replace("fonts.gstatic.com' crossorigin", "fonts.bunny.net' crossorigin", $html);
	return $html;
}

// function to remove google fonts
function bfh_remove_google_fonts($buffer) {
   
   $buffer = preg_replace('/<link\s+[^>]*?href=["\']?(?<url>(?:https?:)?\/\/fonts\.googleapis\.com\/[^"\'>]+)["\']?[^>]*?>/', '', $buffer);
	
   $buffer = preg_replace('/@font-face\s*\{[^\}]*?src:\s*url\([\'"]?(?<url>(?:https?:)?\/\/fonts\.gstatic\.com\/[^\'"]+)[\'"]?\).*?\}/s', '', $buffer);
	
   $buffer = preg_replace('/@import\s+url\([\'"]?(?<url>(?:https?:)?\/\/fonts\.googleapis\.com\/[^\'"]+)[\'"]?\);/', '', $buffer);
	
	$buffer = preg_replace('/<script[^>]*>([^<]*WebFontConfig[^<]*googleapis\.com[^<]*)<\/script>/', '', $buffer);
	
	$buffer = preg_replace('/<link\s+(?:[^>]*\s+)?href=["\']?(?:https?:)?\/\/fonts\.gstatic\.com[^>]*>/', '', $buffer);
	
	$buffer = preg_replace('/<link\s+(?:[^>]*\s+)?href=["\']?(?:https?:)?\/\/fonts\.googleapis\.com[^>]*>/', '', $buffer);
  
  return $buffer;
}

// run this function to do replace and remove
function bfh_remove_google_add_bunny($output) {
	
	$output = str_replace('fonts.googleapis.com', 'fonts.bunny.net', $output);
    $output = str_replace('fonts.gstatic.com" crossorigin', 'fonts.bunny.net" crossorigin', $output);
	$output = str_replace("fonts.gstatic.com' crossorigin", "fonts.bunny.net' crossorigin", $output);
	
    // Remove Google fonts 
    $output = preg_replace('/<link\s+[^>]*?href=["\']?(?<url>(?:https?:)?\/\/fonts\.googleapis\.com\/[^"\'>]+)["\']?[^>]*?>/', '', $output);
	
    $output = preg_replace('/@font-face\s*\{[^\}]*?src:\s*url\([\'"]?(?<url>(?:https?:)?\/\/fonts\.gstatic\.com\/[^\'"]+)[\'"]?\).*?\}/s', '', $output);
	
    $output = preg_replace('/@import\s+url\([\'"]?(?<url>(?:https?:)?\/\/fonts\.googleapis\.com\/[^\'"]+)[\'"]?\);/', '', $output);
	
	$output = preg_replace('/<script[^>]*>([^<]*WebFontConfig[^<]*googleapis\.com[^<]*)<\/script>/', '', $output);
	
	return $output;
}

// Register the and enqueue the script
function add_remove_gf_script_to_footer() {
	 $options = get_option('bunnyfonts_options');
  if (isset($options['remove_google_fonts_jquery']) && $options['remove_google_fonts_jquery']) {

	  wp_enqueue_script('remove-gf', BFH_URL . 'assets/remove-gf.js', array(), false, true);
  }
}
add_action( 'wp_footer', 'add_remove_gf_script_to_footer' );

// run bunnyfont function
function run_bunnyfont_template_redirect() {
  $options = get_option('bunnyfonts_options');
	// check if the replace font option is enabled
   if (isset($options['replace_google_fonts']) && $options['replace_google_fonts'] && !isset($options['block_google_fonts'])) {
    ob_start('bfh_run_bunnyfont');
  }
	// check if remove font option is enabled
  if (isset($options['block_google_fonts']) && $options['block_google_fonts'] && !isset($options['replace_google_fonts'])) {
    ob_start('bfh_remove_google_fonts');
  }
	// check if both option is enabled
	if (isset($options['block_google_fonts']) && $options['block_google_fonts'] && isset($options['replace_google_fonts']) && $options['replace_google_fonts']) {
    ob_start('bfh_remove_google_add_bunny');
  }
}
add_action('template_redirect', 'run_bunnyfont_template_redirect', 9);


register_activation_hook(__FILE__, 'bfh_font_plugin_activate');
add_action('admin_init', 'bfh_font_plugin_redirect');

function bfh_font_plugin_activate() {
    add_option('bfh_font_do_activation_redirect', true);
}

function bfh_font_plugin_redirect() {
    if (get_option('bfh_font_do_activation_redirect', false)) {
        delete_option('bfh_font_do_activation_redirect');
		if(!isset($_GET['activate-multi']))
        {
        wp_safe_redirect(admin_url('options-general.php?page=remove-replace-gf'));
        exit;
		}
    }
}

// added settings link
function bunnyadd_settings_link($links) {
  $settings_link = '<a href="' . admin_url( 'options-general.php?page=remove-replace-gf' ) . '">' . __( 'Settings' ) . '</a>';
  array_unshift( $links, $settings_link );
  return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'bunnyadd_settings_link' );