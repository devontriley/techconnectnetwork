<?php

if (!function_exists('techconnect_enqueue_styles')) :
    function techconnect_enqueue_styles() {
        wp_enqueue_style( 'techconnect-style', get_stylesheet_uri(), array( 'heretic-style' ), filemtime(get_stylesheet_directory() . '/style.css') );
    }
endif;
add_action( 'wp_enqueue_scripts', 'techconnect_enqueue_styles' );


if (!function_exists('techconnect_scripts')) :
    function techconnect_scripts() {
        wp_enqueue_script( 'techconnect-script', get_stylesheet_directory_uri().'/main.js', array('jquery'), filemtime(get_stylesheet_directory() . '/main.js'), true );
    }
endif;
add_action( 'wp_enqueue_scripts', 'techconnect_scripts' );