=== GM HTML Carousel ===
Contributors: gabrielmioni
Plugin URI: http://gabrielmioni.com/gm-html-carousel/
Tags: testimonials, slider, carousel, html, JavaScript, jQuery, shortcodes
Requires at least: 3.0.1
Tested up to: 4.8.1
Requires PHP: 5.2.4
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple and flexible HTML / text carousel with easy to use shortcodes.

== Description ==

GM HTML Carousel creates a text or HTML carousel with infinite scrolling directly from your WordPress page. No messing with admin settings or entering content into a databse.

The carousel is implemented using simple shortcodes.

== Features ==
1. Super simple.
2. Infinite carousel loop.
3. Carousel items are navigable. Desktop uses click navigation. Mobile uses left/right swipe navigation.
4. Simple shortcode attributes let you modify height, width and the delay between cycling the next carousel item.

== Installation ==

For manual installation:

1. Upload the gm-html-carousel folder and its contents to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Using the carousel shortcodes ===

The carousel is displayed by using the [gm_carousel][/gm_carousel] shortcode.

the You can add as many 'carousel items' within that shortcode as you like. These are just text or HTML blocks wrapped with
[gm_carousel_item][/gm_carousel_item] shortcode.

You can include images, text styling and links. Pretty much anything you can put on a WordPress page.

The [gm_carousel] shortcode accepts 3 attributes:
1. height: Sets the height in pixels for the carousel.
2. width: Sets the width in pixels for the carousel.
3. delay: Sets the time in seconds that the carousel will wait before displaying rotating in the next carousel item.

Here's a complete example:

[gm_carousel height=175 width=600 delay=6]
    [gm_carousel_item]Hi, I'm the first <b>carousel</b> item.[/gm_carousel_item]
    [gm_carousel_item]And this is the second carousel item.[/gm_carousel_item]
    [gm_carousel_item]Well, two out of three ain't bad.[/gm_carousel_item]
[/gm_carousel]

So this carousel will be 175px tall, 600px wide and each carousel item will be displayed for 6 seconds before the next carousel item is displayed. The first carousel item has the word 'carousel' wrapped in a <b> tag and will show up bold.

== Changelog ==

= 1.0 =
* Initial release!

== Upgrade Notice ==

= 1.0 =
* https://giphy.com/gifs/luD6nKBLMolt6/html5
