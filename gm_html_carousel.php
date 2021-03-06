<?php
/*
Plugin Name: GM HTML Carousel
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

add_action( 'wp_enqueue_scripts', 'gm_html_carousel_register_font_awesome' );
function gm_html_carousel_register_font_awesome() {
    wp_register_style('gm-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', GM_CAROUSEL_VERSION, 'all');
}

add_action( 'wp_enqueue_scripts', 'gm_html_carousel_register_css');
function gm_html_carousel_register_css() {
    wp_register_style( 'gm-carousel-css', plugins_url( '/css/gm-carousel.css', __FILE__ ), array(), GM_CAROUSEL_VERSION, 'all' );
}

add_action( 'wp_enqueue_scripts', 'gm_html_carousel_register_js');
function gm_html_carousel_register_js() {
    wp_register_script( 'gm-carousel-js',  plugins_url( 'js/gm-carousel.js', __FILE__ ), array('jquery'), GM_CAROUSEL_VERSION, true );
}

add_action( 'wp_enqueue_scripts', 'gm_html_carousel_register_tocca');
function gm_html_carousel_register_tocca() {
    wp_register_script( 'gm-tocca-js',  plugins_url( 'js/tocca/Tocca.min.js', __FILE__ ), array('jquery'), GM_CAROUSEL_VERSION, true );
}

add_shortcode('gm_carousel', 'gm_html_carousel');
function gm_html_carousel( $atts, $content = null )
{
    // https://giphy.com/gifs/luD6nKBLMolt6/html5
    $attributes = gm_html_carousel_set_attributes($atts);

    if (isset($attributes['delay'])) {
        $delay = $attributes['delay'];
    } else {
        $delay = 6;
    }

    $is_mobile = wp_is_mobile() === true ? 1 : 0;

    if ($is_mobile === 1) {
        wp_enqueue_script('gm-tocca-js');
    }

    $params = array('delay'=>$delay, 'is_mobile'=>$is_mobile);

    wp_localize_script('gm-carousel-js', 'gm_js', $params);

    wp_enqueue_style('gm-carousel-css');
    wp_enqueue_style('gm-font-awesome');
    wp_enqueue_script('gm-carousel-js');

    require_once('php/build_carousel.php');

    $pattern = get_shortcode_regex(array('gm_carousel_item'));
    $matches = array();
    preg_match_all("/$pattern/s", $content, $matches);

    $text_array = isset( $matches[5] ) ? $matches[5] : array();

    $build_carousel = new \gm_html_carousel\build_carousel($text_array, $attributes);

    echo $build_carousel->return_carousel();
}

function gm_html_carousel_set_attributes($atts)
{
    $default = array();
    $default['width'] = 600;
    $default['height'] = 175;

    if ( ! is_array($atts) ) {
        return array();
    }

    if ( empty($atts) ) {
        return array();
    }

    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $attributes_out = array();

    foreach ($atts as $key=>$value)
    {
        if ($key === 'height' || $key === 'width' || $key === 'delay')
        {
            $attributes_out[$key] = intval($value);
        }
    }

    if (! key_exists('height', $attributes_out)) {
        $attributes_out['height'] = $default['height'];
    }

    if (! key_exists('width', $attributes_out)) {
        $attributes_out['width'] = $default['width'];
    }

    return $attributes_out;
}

