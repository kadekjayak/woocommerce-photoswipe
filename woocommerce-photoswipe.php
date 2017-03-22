<?php
/**
 * @package WooCommerce Photoswipe
 * @version 0.1
 */
/*
Plugin Name: WooCommerce Photoswipe
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: Lightbox Replacement plugin for WooCommerce
Author: kadekjayak
Version: 0.1
Author URI: https://kadekjayak.web.id
*/


require 'inc/WooCommercePhotoswipe.php';

define('WC_Photowipe_URL', plugin_dir_url(__FILE__) );

$WooCommercePhotoswipe = new WooCommercePhotoswipe();
$WooCommercePhotoswipe->run();