<?php
// Add the options page to the Settings menu
function web_co_tax_plugin_add_options_page() {
	add_options_page(
		'Woo Customer Tax Toggle', // Page title
		'Woo Customer Tax Toggle', // Menu title
		'manage_options', // Capability required to access the page
		'web-co-tax-plugin', // Menu slug (should be the same as your plugin slug)
		'web_co_tax_plugin_options_page' // Callback function to display the page content
	);
}
add_action('admin_menu', 'web_co_tax_plugin_add_options_page');

// Enqueue color picker script and style
function web_co_tax_plugin_enqueue_color_picker() {
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'web_co_tax_plugin_enqueue_color_picker');

// Callback function to display the options page content
function web_co_tax_plugin_options_page() {
	?>
	<div class="wrap">
		<div class="webco-intro">
			<div class="webco-welcome">
				<h1>Woo Customer Tax Toggle Options</h1>
				<p>Welcome to the Woo Customer Tax Toggle settings page. This is where you can manage display options for your toggle display. <strong>If you require support</strong> for the plugin's current functionality, please contact <a href="mailto:support@thewebco.uk">support@thewebco.uk</a>. I aim to resolve your issue within two working days.</p>
				<p>If you require <strong>bespoke customisation</strong>, visit <span class="dashicons dashicons-coffee"></span> <a href="https://thewebco.uk/contact/" target="_blank">The Web Co</a>.</p>
			</div>
			<div class="webco-smile">
				<img src="<?php echo esc_url(plugins_url('../../assets/Robert-Chin.png', __FILE__)); ?>" alt="Robert Chin" />
			</div>
		</div>

		<form method="post" action="" class="webco-tax-form">
			<?php
			// Include the nonce field for security
			wp_nonce_field('web_co_tax_plugin_options', 'web_co_tax_plugin_options_nonce');

			// Shortcode Metabox
			web_co_tax_plugin_render_metabox('Shortcode', 'Replace text?');

			// Widget Metabox
			web_co_tax_plugin_render_metabox('Widget', 'Replace text?');

			// Navigation Metabox
			web_co_tax_plugin_render_metabox('Navigation', 'Replace text?');

			// Floating Cart Metabox
			web_co_tax_plugin_render_metabox('Floating', 'Replace text?');

			// Other Settings Metabox
			web_co_tax_plugin_render_other_settings_metabox();
			?>

			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary button-hero" value="Save Settings">
			</p>
		</form>
		<script>
			jQuery(document).ready(function($){
				// Add color picker to elements with class 'color-field'
				$('.color-field').wpColorPicker();
			});
		</script>
		<?php include( plugin_dir_path( __FILE__ ) . 'web-co-tax-howto.php'); ?>        
		<div class="webco-footer">
			<p>Find more of my occasional freelance work at</p>
			<p><a href="<?php echo esc_url('https://thewebco.uk/'); ?>" target="_blank"><img src="<?php echo esc_url(plugins_url('../../assets/The-Web-Co.svg', __FILE__)); ?>" alt="The Web Co." /></a></p>
		</div>
	</div>
	<?php
}

// Function to render a metabox
function web_co_tax_plugin_render_metabox($name, $label) {
	?>
	<div id="<?php echo esc_attr("web_co_tax_plugin_{$name}_metabox"); ?>" class="postbox">
		<h2><span><?php echo esc_html("{$name} Settings"); ?></span></h2>
		<div class="inside">
			<?php
			// Add the dropdown field for 'Floating'
			if ('Floating' == $name) {
				$dropdown_options = array(
					'top-left' => 'Top Left',
					'top-center' => 'Top Center',
					'top-right' => 'Top Right',
					'center-left' => 'Center Left',
					'center-right' => 'Center Right',
					'bottom-left' => 'Bottom Left',
					'bottom-center' => 'Bottom Center',
					'bottom-right' => 'Bottom Right',
				);
				web_co_tax_plugin_render_dropdown_field('Floating Position', "{$name}_position", $dropdown_options, 'bottom-right');
			}
			web_co_tax_plugin_render_field($label, "{$name}_label");
			web_co_tax_plugin_render_color_field('Color', "{$name}_color", '');
			web_co_tax_plugin_render_color_field('Color Hover', "{$name}_color_hover", '');
			web_co_tax_plugin_render_color_field('Background', "{$name}_background_color", '');
			web_co_tax_plugin_render_color_field('Background Hover', "{$name}_background_color_hover", '');
			?>
		</div>
	</div>
	<?php
}

// Function to render a generic text field
function web_co_tax_plugin_render_field($label, $id) {
	$value = get_option("web_co_tax_plugin_{$id}", '');
	?>
	<p>
		<label for="web_co_tax_plugin_<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
		<input type="text" id="web_co_tax_plugin_<?php echo esc_attr($id); ?>" name="web_co_tax_plugin_<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($value); ?>">
	</p>

<?php
}
// Function to render a color field
function web_co_tax_plugin_render_color_field($label, $id, $default) {
	$value = get_option("web_co_tax_plugin_{$id}", $default);
	?>
	<p>
		<label for="web_co_tax_plugin_<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
		<input type="text" id="web_co_tax_plugin_<?php echo esc_attr($id); ?>" name="web_co_tax_plugin_<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($value); ?>" class="color-field">
	</p>
	<?php
}

// Function to render a checkbox field
function web_co_tax_plugin_render_checkbox_field($label, $id) {
	$value = get_option("web_co_tax_plugin_{$id}", false); // Default value set to false
	?>
	<p>
		<label for="web_co_tax_plugin_<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
		<input type="checkbox" id="web_co_tax_plugin_<?php echo esc_attr($id); ?>" name="web_co_tax_plugin_<?php echo esc_attr($id); ?>" <?php checked($value, true); ?>>
	</p>
	<?php
}

// Function to render a dropdown field
function web_co_tax_plugin_render_dropdown_field($label, $id, $options) {
	$value = get_option("web_co_tax_plugin_{$id}", '');
	?>
	<p>
		<label for="web_co_tax_plugin_<?php echo esc_attr($id); ?>"><?php echo esc_attr($label); ?></label>
		<select id="web_co_tax_plugin_<?php echo esc_attr($id); ?>" name="web_co_tax_plugin_<?php echo esc_attr($id); ?>">
			<?php
			foreach ($options as $option_value => $option_label) {
				echo '<option value="' . esc_attr($option_value) . '" ' . selected($value, $option_value, false) . '>' . esc_html($option_label) . '</option>';
			}
			?>
		</select>
	</p>
	<?php
}

// Function to render the "Other Settings" metabox
function web_co_tax_plugin_render_other_settings_metabox() {
	?>
	<div id="web_co_tax_plugin_other_settings_metabox" class="postbox">
		<h2><span>Other Settings</span></h2>
		<div class="inside">
			<?php
			web_co_tax_plugin_render_checkbox_field('Enable floating?', 'other_settings_enable_floating');
			web_co_tax_plugin_render_field('Ex. VAT Suffix', 'other_settings_ex_vat_suffix');
			web_co_tax_plugin_render_field('Inc. VAT Suffix', 'other_settings_inc_vat_suffix');
			?>
		</div>
	</div>
	<?php
}

// Save the options when the form is submitted

function web_co_tax_plugin_save_options() {
	// Verify nonce for security
	$nonce = isset($_POST['web_co_tax_plugin_options_nonce']) ? sanitize_text_field($_POST['web_co_tax_plugin_options_nonce']) : '';
	if (isset($_POST['submit']) && wp_verify_nonce($nonce, 'web_co_tax_plugin_options')) {
		$metaboxes = array('Shortcode', 'Widget', 'Navigation', 'Floating');
		foreach ($metaboxes as $metabox) {
			$fields = array('label', 'color', 'color_hover', 'background_color', 'background_color_hover');
			foreach ($fields as $field) {
				$id = "{$metabox}_{$field}";
				$option_name = "web_co_tax_plugin_{$id}";
				// Allow empty color value
				$value = isset($_POST[$option_name]) ? sanitize_text_field($_POST[$option_name]) : '';
				if (strpos($field, 'color') !== false) {
					$value = sanitize_hex_color($value);
				}
				update_option($option_name, $value);
			}
			// Check if it's the 'Floating' metabox and save the dropdown value
			if ('Floating' === $metabox) {
				$dropdown_id = "{$metabox}_position";
				$dropdown_option_name = "web_co_tax_plugin_{$dropdown_id}";
				$dropdown_value = isset($_POST[$dropdown_option_name]) ? sanitize_text_field($_POST[$dropdown_option_name]) : 'bottom-right';
				update_option($dropdown_option_name, $dropdown_value);
			}
		}
		// Save Other Settings
		$other_settings_fields = array('ex_vat_suffix', 'inc_vat_suffix');
		foreach ($other_settings_fields as $field) {
			$id = "other_settings_{$field}";
			$option_name = "web_co_tax_plugin_{$id}";
			$value = isset($_POST[$option_name]) ? sanitize_text_field($_POST[$option_name]) : '';
			update_option($option_name, $value);
		}
		// Adjust the way checkbox value is handled
		$other_settings_floating = array('enable_floating');
		foreach ($other_settings_floating as $floating) {
			$id = "other_settings_{$floating}";
			$option_name = "web_co_tax_plugin_{$id}";
			$value = isset($_POST[$option_name]) && 'on' === $_POST[$option_name] ? true : false;
			update_option($option_name, $value);
		}
	}
}
add_action('admin_init', 'web_co_tax_plugin_save_options');
