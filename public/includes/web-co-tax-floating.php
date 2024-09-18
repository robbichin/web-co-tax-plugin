<?php
// Add a function to be called in the footer
function web_co_tax_plugin_output_text() {
	$enable_floating = get_option( 'web_co_tax_plugin_other_settings_enable_floating', false );
	if ($enable_floating) {
		echo do_shortcode( '[web_co_tax_toggle location="floating"]' );
	}
}
add_action('wp_footer', 'web_co_tax_plugin_output_text');
