<?php
// Shortcode to display the tax toggle link
function web_co_tax_toggle_shortcode($atts) {
	// Define default attributes
	$atts = shortcode_atts(
		array(
			'location' => 'default', // Default value is 'default'
		),
		$atts,
		'web_co_tax_toggle'
	);

	ob_start();

	// Check if a cookie is set, if not, assume taxes are included by default
	$taxesIncluded = isset( $_COOKIE['taxesIncluded'] ) && 'true' === $_COOKIE['taxesIncluded'];

	// Determine the CSS class based on the 'location' attribute
	$cssClass = 'woocommerce tax-toggle-container'; // Default class

	if ($atts['location']) {
		$cssClass .= ' ' . esc_attr( $atts['location'] );
	}

	if ( 'floating' === $atts['location'] ) {
		// Get the selected floating position
		$floating_position = get_option( 'web_co_tax_plugin_Floating_position', 'bottom-right' );
		$cssClass .= ' ' . esc_attr( $floating_position );
	}

	// Display the link based on the current tax display setting
	$shortcode_label = get_option('web_co_tax_plugin_Shortcode_label', '');
	$widget_label = get_option('web_co_tax_plugin_Widget_label', '');
	$navigation_label = get_option('web_co_tax_plugin_Navigation_label', '');
	$floating_label = get_option('web_co_tax_plugin_Floating_label', '');

	if ( !empty( $shortcode_label ) && ( 'default' == $atts['location'] ) ) {
		$linkText = $shortcode_label;
	} elseif ( !empty( $widget_label ) && ( 'widgetarea' == $atts['location'] ) ) {
		$linkText = $widget_label;
	} elseif ( !empty( $navigation_label ) && ( 'menu' == $atts['location'] ) ) {
		$linkText = $navigation_label;
	} elseif ( !empty($floating_label ) && ( 'floating' == $atts['location'] ) ) {
		$linkText = $floating_label;
	} else {
		$linkText = $taxesIncluded ? 'Display tax?' : 'Display tax?';
	}

	$toggleLink = '<a href="#" class="button toggle-taxes" data-taxes-included="' . ( $taxesIncluded ? 'true' : 'false' ) . '"><span>' . $linkText . '</span></a>';

	// Add a class to the container based on the tax display setting and location
	echo '<div class="' . esc_attr( $cssClass ) . '">' . wp_kses_post( $toggleLink ) . '</div>';

	return ob_get_clean();
}

add_shortcode('web_co_tax_toggle', 'web_co_tax_toggle_shortcode');
