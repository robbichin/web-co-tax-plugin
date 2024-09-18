<?php
add_filter('wp_nav_menu_items', 'custom_menu_shortcode', 10, 2);
function custom_menu_shortcode($items, $args) {
	if (strpos($items, 'Tax Toggle') !== false) {
		$items = preg_replace('/<a [^>]*>Tax Toggle<\/a>/', do_shortcode('[web_co_tax_toggle location="menu"]'), $items);
	}
	return $items;
}
