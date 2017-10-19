<?php
/*
Plugin Name: GM Text Carousel
Version: 1.0
Plugin URI: http://gabrielmioni.com/
Description: A simple HTML / text carousel with easy to use shortcodes.
Author URI: http://gabrielmioni.com

Copyright 2017 Gabriel Mioni <email : gabriel@gabrielmioni.com>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('GM_CAROUSEL_VERSION', 1);

add_action( 'wp_enqueue_scripts', 'gm_carousel_font_awesome' );
function gm_carousel_font_awesome() {
    wp_register_style('gm-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', GM_CAROUSEL_VERSION, 'all');
}

add_action( 'wp_enqueue_scripts', 'gm_register_carousel_css');
function gm_register_carousel_css() {
    wp_register_style( 'gm-carousel-css', plugins_url( '/css/gm-carousel.css', __FILE__ ), array(), GM_CAROUSEL_VERSION, 'all' );
}

add_action( 'wp_enqueue_scripts', 'gm_carousel_js');
function gm_carousel_js() {
    wp_register_script( 'gm-carousel-js',  plugins_url( 'js/gm-carousel.js', __FILE__ ), array('jquery'), GM_CAROUSEL_VERSION, true );
}

add_shortcode('gm_carousel_text', 'carousel_text');
function carousel_text( ) {
    // I am an empty callback and don't do anything :(
}

add_shortcode('gm_carousel', 'carousel');
function carousel( $atts, $content = null )
{
    wp_enqueue_style('gm-carousel-css');
    wp_enqueue_style('gm-font-awesome');
    wp_enqueue_script('gm-carousel-js');

    require_once('php/build_carousel.php');

    $pattern = get_shortcode_regex();
    $matches = array();
    preg_match_all("/$pattern/s", $content, $matches);

    $text_array = isset( $matches[5] ) ? $matches[5] : array();

    $build_carousel = new \gm_build\build_carousel($text_array);

    echo $build_carousel->return_ul_html();
}


