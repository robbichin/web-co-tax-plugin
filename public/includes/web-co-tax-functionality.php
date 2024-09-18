<?php
// Function to check if taxes are included or excluded
function is_taxes_included() {
	return isset($_COOKIE['taxesIncluded']) && 'true' === $_COOKIE['taxesIncluded'];
}

// Function to get the price including or excluding taxes based on the tax status
function get_price_based_on_tax_status($price, $product) {
	$taxes_included = is_taxes_included();
	return $taxes_included ? wc_get_price_including_tax($product, array('price' => $price)) : wc_get_price_excluding_tax($product, array('price' => $price));
}

class WebCoTaxFunctionality {
	// Function to modify the text of the displayed prices
	public static function modify_displayed_price_text($price_html, $product) {
		// Check if $product is an array
		if (is_array($product)) {
			$product = wc_get_product($product['product_id']); // Adjust as needed to get the correct product ID
		}

		// Check if the product is a variable product
		if ($product && $product->is_type('variable')) {
			// Get the variation prices
			$min_variation_price = $product->get_variation_price('min');
			$max_variation_price = $product->get_variation_price('max');

			// Get the prices including or excluding taxes based on the tax status
			$min_variation_price_included = get_price_based_on_tax_status($min_variation_price, $product);
			$max_variation_price_included = get_price_based_on_tax_status($max_variation_price, $product);

			// Format the variation price range without trailing zeros
			$formatted_min_variation_price = wc_price($min_variation_price_included, array('trim_zeros' => true));
			$formatted_max_variation_price = wc_price($max_variation_price_included, array('trim_zeros' => true));

			// Preserve the original HTML structure for variation price ranges
			$price_html = '<span class="woocommerce-Price-amount amount"><bdi>' . $formatted_min_variation_price . ' - ' . $formatted_max_variation_price . '</bdi></span>';
		} else {
			// For regular and sale prices
			// Get the prices including or excluding taxes based on the tax status
			$regular_price = get_price_based_on_tax_status($product->get_regular_price(), $product);
			$sale_price = get_price_based_on_tax_status($product->get_sale_price(), $product);

			$is_on_sale = $product->is_on_sale();

			if ($is_on_sale) {
				// Preserve the original HTML structure for sale prices
				$price_html = ' ';
				$price_html .= '<del>' . wc_price($regular_price) . '</del>';
				$price_html .= ' <ins>' . wc_price($sale_price) . '</ins>';
				$price_html .= ' ';
			} else {
				// Preserve the original HTML structure for regular prices
				$display_price = get_price_based_on_tax_status($product->get_price(), $product);
				$price_html = ' ' . wc_price($display_price) . ' ';
			}

			// Additional code to add VAT suffixes
			$ex_vat_suffix = get_option('web_co_tax_plugin_other_settings_ex_vat_suffix', '');
			$inc_vat_suffix = get_option('web_co_tax_plugin_other_settings_inc_vat_suffix', '');

			if (!empty($ex_vat_suffix) && !is_taxes_included()) {
				$price_html .= ' <span class="web-co-vat-suffix">(' . esc_html($ex_vat_suffix) . ')</span>';
			}

			if (!empty($inc_vat_suffix) && is_taxes_included()) {
				$price_html .= '<span class="web-co-vat-suffix"> (' . esc_html($inc_vat_suffix) . ')</span>';
			}
		}

		return $price_html;
	}
}

// Hook the function to the WooCommerce filter for single product pages
add_filter('woocommerce_get_price_html', array('WebCoTaxFunctionality', 'modify_displayed_price_text'), 10, 2);

// Hook the function to the WooCommerce filter for product archives (shop pages)
add_filter('woocommerce_template_loop_price', array('WebCoTaxFunctionality', 'modify_displayed_price_text'), 10, 2);

// Hook the function to the WooCommerce filter for the cart page
add_filter('woocommerce_cart_item_price', array('WebCoTaxFunctionality', 'modify_displayed_price_text'), 10, 3);

// Bad praxtice to enable functionality on checkout - tax breakdown given
// add_filter('woocommerce_checkout_item_price', array('WebCoTaxFunctionality', 'modify_displayed_price_text'), 10, 3);

