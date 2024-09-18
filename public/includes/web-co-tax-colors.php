<?php

// Function to output custom CSS based on color options
function output_custom_css() {
	$css = array(); // Initialize an array to store CSS rules
	$sections = array('Shortcode', 'Widget', 'Navigation', 'Floating');
	foreach ($sections as $section) {
		$css_class_rules = array(); // Initialize an array for each section
		$css_classes = array(strtolower($section)); // Default value
		// Change 'Shortcode' to 'default'
		if ( 'Shortcode' === $section ) {
			$css_classes[] = 'default';
		}
		// Change 'Navigation' to 'menu'
		if ( 'Navigation' === $section ) {
			$css_classes[] = 'menu';
		}
		$color = get_option("web_co_tax_plugin_{$section}_color", '');
		$color_hover = get_option("web_co_tax_plugin_{$section}_color_hover", '');
		$bg_color = get_option("web_co_tax_plugin_{$section}_background_color", '');
		$bg_color_hover = get_option("web_co_tax_plugin_{$section}_background_color_hover", '');

		foreach ($css_classes as $css_class) {
			if (!empty($color)) {
				$css_class_rules[] = ".{$css_class} .button.toggle-taxes { color: {$color}; }";
			}
			if (!empty($color_hover)) {
				$css_class_rules[] = ".{$css_class} .button.toggle-taxes:hover { color: {$color_hover}; }";
			}
			if (!empty($bg_color)) {
				$css_class_rules[] = ".{$css_class} .button.toggle-taxes { background-color: {$bg_color}; }";
			}
			if (!empty($bg_color_hover)) {
				$css_class_rules[] = ".{$css_class} .button.toggle-taxes:hover { background-color: {$bg_color_hover}; }";
			}
		}
		// Combine the rules for each section
		$combined_rules = implode(' ', $css_class_rules);
		if (!empty($combined_rules)) {
			$css[] = $combined_rules;
		}
	}
	if (!empty($css)) {
		// Output the combined CSS within a single <style> tag
		echo '<style>' . esc_attr(implode(' ', $css)) . '</style>';
	}
}
// Hook to output custom CSS in the head of the document
add_action('wp_head', 'output_custom_css');
