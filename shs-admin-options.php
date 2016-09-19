<?php

//Enqueue the color pickers
add_action( 'admin_enqueue_scripts', 'sth_enqueue_color_picker' );
function sth_enqueue_color_picker() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'selection-sharer-hish', plugins_url('js/hish.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

//Create the new fields on the Reading page
new add_background_color_setting();
new add_text_color_setting();

//Create the class for the background color setting
class add_background_color_setting {

    function __construct() {
        add_filter( 'admin_init' , array( $this , 'register_fields' ) );
    }

    function register_fields() {
        $colors = get_option( 'highlight_plugin_colors' );
        register_setting( 'reading', $colors['background'], 'esc_attr' );
        add_settings_field( $colors['background'],
        '<label for="bg_color_choice">' . __( 'Background selection color (Medium-style Highlight)' , 'bg_color_choice' ) . '</label>',
        array( $this, 'fields_html' ) , 'reading' );
    }

    function fields_html() {
        $colors = get_option( 'highlight_plugin_colors' );
        echo '<input type="text" id="bg_color_choice" name="bg_color_choice" value="' . $colors['background'] . '" />';
    }
}

//Create the class for the text color setting
class add_text_color_setting {

    function __construct() {
        add_filter( 'admin_init' , array( $this , 'register_fields' ) );
    }

    function register_fields() {
        $colors = get_option( 'highlight_plugin_colors' );
        register_setting( 'reading', $colors['text'], 'esc_attr' );
        add_settings_field( $colors['text'],
        '<label for="text_color_choice">' . __( 'Text color (Medium-style Highlight)' , 'text_color_choice' ) . '</label>',
        array( $this, 'fields_html' ) , 'reading' );
    }

    function fields_html() {
        $colors = get_option( 'highlight_plugin_colors' );
        echo '<input type="text" id="text_color_choice" name="text_color_choice" value="' . $colors['text'] . '" />';
    }
}
