<?php

/*
Plugin Name: WordPress Plugin Base
Description: Base plugin for WordPress
Version: 1.0
Author: Susumu Seino
Author URI: https://susu.mu
*/




function wppb_add_stylesheet() {

	if ( is_admin() or ! is_super_admin() ) {
		return;
	}

	$wp_version = get_bloginfo( 'version' );

	if ( $wp_version >= '3.8' ) {
		$is_older_than_3_8 = '';
	} else {
		$is_older_than_3_8 = '-old';
	}

	$stylesheet_path = plugins_url( 'css/main' . $is_older_than_3_8 . '.css', __FILE__ );
	wp_register_style( 'current-template-style', $stylesheet_path );
	wp_enqueue_style( 'current-template-style' );
	wp_enqueue_script( 'wppb', plugins_url( '/js/app.js', __FILE__ ), array( 'jquery' ) );
}


add_action( 'wp_enqueue_scripts', "wppb_add_stylesheet", 9999 );


function add_swiper_sets() {
	$swiper_css_path = plugins_url( 'css/swiper' . '.css', __FILE__ );
	wp_enqueue_style( 'swiper-css', $swiper_css_path );
	wp_enqueue_script( 'wppb', plugins_url( '/js/swiper.min.js', __FILE__ ), array( 'jquery' ) );
}

add_action( 'wp_enqueue_scripts', 'add_swiper_sets' );

/*********************************/
/*
/* 基本機能
/*
/*********************************/
function wppb_functions( $post_id) {
	echo "It's " . $post_id ;
}

add_shortcode( 'wppb', 'wppb_functions' );


/*********************************/
/*
/* 管理画面
/*
/*********************************/

function wppb_init() {
	$wppb_options                  = array();
	$wppb_options['wppb_radio']    = "TEXT";
	$wppb_options['wppb_check']    = 1;
	$wppb_options['wppb_dropdown'] = "WordPress";
	$wppb_options['wppb_text']     = 10;
	$wppb_options['wppb_code']     = "<p>add code</p>";

	add_option( 'wppb_options', $wppb_options );
}

add_action( 'activate_pv-count-swiper/pv-count-swiper.php', 'wppb_init' );

function wppb_get_options() {
	return get_option( 'wppb_options' );
}

function wppb_config() {
	include( 'wppb-admin.php' );
}

function wppb_config_page() {
	if ( function_exists( 'add_submenu_page' ) ) {
		add_options_page( __( 'WordPress Plugin Base' ), __( 'WordPress Plugin Base' ), 'manage_options', 'pv-count-swiper', 'wppb_config' );
	}
}

add_action( 'admin_menu', 'wppb_config_page' );

