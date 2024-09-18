<?php

require_once 'class-WebCoTaxToggleWidget.php';

if (!class_exists('WebCo_Nav_Menu_Items')) {
	class WebCo_Nav_Menu_Items {
		public function add_nav_menu_meta_boxes() {
			// Check if the meta box already exists
			$meta_boxes = get_registered_nav_menus();
			$meta_box_exists = false;
			foreach ($meta_boxes as $meta_box) {
				if ('webco-nav-items' == $meta_box) {
					$meta_box_exists = true;
					break;
				}
			}
			// If the meta box doesn't exist, add it
			if (!$meta_box_exists) {
				add_meta_box(
					'webco-nav-items',
					__('The Web Co.'),
					array($this, 'nav_menu_items'),
					'nav-menus',
					'side',
					'low'
				);
			}
		}
		public function nav_menu_items() {
			$menu_items = apply_filters('webco_nav_items_menu', array());
			?>
			<div id="webco-nav-items" class="posttypediv">
				<div id="tabs-panel-webco-nav-items" class="tabs-panel tabs-panel-active">
					<ul id="webco-nav-items-checklist" class="categorychecklist form-no-clear">
						<?php foreach ($menu_items as $item) : ?>
							<li>
								<label class="menu-item-title">
									<input type="checkbox" class="menu-item-checkbox" name="menu-item[-1][menu-item-object-id]" value="-1">
									<?php echo esc_html($item['label']); ?>
								</label>
								<input type="hidden" class="menu-item-type" name="menu-item[-1][menu-item-type]" value="custom">
								<input type="hidden" class="menu-item-title" name="menu-item[-1][menu-item-title]" value="<?php echo esc_attr($item['label']); ?>">
								<input type="hidden" class="menu-item-url" name="menu-item[-1][menu-item-url]" value="<?php echo esc_url($item['url']); ?>">
								<input type="hidden" class="menu-item-classes" name="menu-item[-1][menu-item-classes]" value="<?php echo esc_attr($item['class']); ?>-menu-item">
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<p class="button-controls">
					<span class="list-controls">
						<a href="#" class="select-all">Select All</a>
					</span>
					<span class="add-to-menu">
						<input type="submit" class="button-secondary submit-add-to-menu right" value="Add to Menu" name="add-post-type-menu-item" id="submit-posttype-webco-nav-items">
						<span class="spinner"></span>
					</span>
				</p>
			</div>
			<?php
		}
	}
}
$webco_custom_nav_items = new WebCo_Nav_Menu_Items();

add_action('admin_init', array($webco_custom_nav_items, 'add_nav_menu_meta_boxes'));
add_filter('webco_nav_items_menu', 'add_webco_menu_items_from_plugin');

function add_webco_menu_items_from_plugin($menu_items) {
	$additional_items = array( array( 'label' => 'Tax Toggle', 'class' => 'testing-menu-item', 'url'   => '#', ), );
	// Merge the additional items with the existing menu items
	$menu_items = array_merge($menu_items, $additional_items);
	return $menu_items;
}
