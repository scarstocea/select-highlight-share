<?php
/*
Plugin Name: Select, Highlight and Share!
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: A basic Medium-like highlighter plugin for WordPress. Go to the Settings -> Reading page for color options.
Version:     0.0.1
Author:      Stefan Carstocea
Author URI:  https://twitter.com/scarstocea
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: medium-like-highlight
Domain Path: /languages
*/

require __DIR__ . '/shs-admin-options.php';

// Hook into WP actions for the functions created below
add_action( 'wp_enqueue_scripts', 'sth_enqueue_js_css' );
add_action( 'wp_enqueue_scripts', 'sth_set_colors' );
add_action( 'wp_footer', 'sth_execute_script' );
register_activation_hook( __FILE__, 'sth_set_default_colors' );

// Enqueue JS and CSS files
function sth_enqueue_js_css() {
     wp_enqueue_script( 'selection-sharer-hish', plugins_url( 'js/hish.js', __FILE__ ), array( 'jquery' ) );
     wp_enqueue_style( 'highlight-style', plugins_url( 'css/highlight.css', __FILE__ ), $media = 'all' );
}

// Execute jQuery
function sth_execute_script() {
    echo "<script>jQuery('#main').hish();</script>";
}

//Set default colors
/* function sth_set_default_colors() {
    $colors = array(
        'background' => '#99ffbe',
        'text' => '#000'
    );
    if( get_option( 'highlight_plugin_colors' ) == false ) {
        //update_option( 'highlight_plugin_colors', $colors );
    }
}*/

// Get the user-defined color options from the DB and add them to the CSS stylesheet
function sth_set_colors() {
    $colors = get_option ( 'highlight_plugin_colors' );
    $inline_style = "#main ::-moz-selection {
        background-color: " . $colors['background'] . ";" . "
        color: " . $colors['text'] . ";" . "
    }
    #main ::selection {
        background-color: " . $colors['background'] . ";" . "
        color: " . $colors['text'] . ";" . "
    }";
    wp_add_inline_style( 'highlight-style', $inline_style );
}
