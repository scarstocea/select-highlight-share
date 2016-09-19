<?php

add_action( 'admin_enqueue_scripts', 'sth_enqueue_color_picker' );
function sth_enqueue_color_picker() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'selection-sharer-hish', plugins_url('js/hish.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

new add_background_color_setting();
new add_text_color_setting();

class add_background_color_setting {

    function __construct() {
        add_filter( 'admin_init' , array( $this , 'register_fields' ) );
    }

    function register_fields() {
        register_setting( 'reading', 'bg_color_choice', 'esc_attr' );
        add_settings_field( 'bg_color_choice',
        '<label for="bg_color_choice">' . __( 'Background selection color (Medium-style Highlight)' , 'bg_color_choice' ) . '</label>',
        array( $this, 'fields_html' ) , 'reading' );
    }

    function fields_html() {
        $value = get_option( 'bg_color_choice', '' );
        echo '<input type="text" id="bg_color_choice" name="bg_color_choice" value="' . $value . '" data-default-color="#99ffbe" />';
    }
}

class add_text_color_setting {

    function __construct() {
        add_filter( 'admin_init' , array( $this , 'register_fields' ) );
    }

    function register_fields() {
        register_setting( 'reading', 'text_color_choice', 'esc_attr' );
        add_settings_field( 'text_color_choice',
        '<label for="text_color_choice">' . __( 'Text color (Medium-style Highlight)' , 'text_color_choice' ) . '</label>',
        array( $this, 'fields_html' ) , 'reading' );
    }

    function fields_html() {
        $value = get_option( 'text_color_choice', '' );
        echo '<input type="text" id="text_color_choice" name="text_color_choice" value="' . $value . '" data-default-color="#000"/>';
    }
}
