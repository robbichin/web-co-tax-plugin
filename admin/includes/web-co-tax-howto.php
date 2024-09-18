<?php // How To ?>

<div class="webco-howto">
	<div class="webco-howto-intro">
		<h1>How-To and Further Customisation</h1>
		<p>Individual settings can be found above for each location module rather than a single group of settings for all. This allows for complete customisation.</p>
		<p>Please see a quick how-to on each module.</p>
	</div>
</div>
<div class="webco-tax-howto">
	<div class="postbox">
		<h2><span>Shortcode</span></h2>
		<div class="inside">
			<p>The default shortcode is <code>[web_co_tax_toggle]</code>.</p>
			<p>The shortcode has one <em>optional</em> parameter, <code>location</code>. This can be anything you would like and adds a class to the container: <code>[web_co_tax_toggle location="trackingpage"]</code> will allow you to target <code>.tax-toggle-container.trackingpage</code>.</p>
		</div>
	</div>
	<div class="postbox">
		<h2><span>Widget</span></h2>
		<div class="inside">
			<p>You can add the Woo Customer Tax Toggle widget in your <a href="widgets.php">WP Admin widget area</a>. This supports an (optional) widget title and description.</p>
			<p>The shortcode output for the widget is <code>[web_co_tax_toggle location="widgetarea"]</code>.</p>
			<p>This is also compatible with all tested page builders. If your theme doesn't support widgets, simply add the shortcode to the desired area.</p>
		</div>
	</div>
	<div class="postbox">
		<h2><span>Navigation</span></h2>
		<div class="inside">
			<p>The shortcode used for the menu tax toggle is <code>[web_co_tax_toggle location="menu"]</code>. Add this navigation item in the <a href="nav-menus.php">WP menu editor</a>.</p>
			<p><strong>Note:</strong> do not change the widget title or this will not work. If you have done so acidentally, simply delete the menu item and re-add it.</p>
		</div>
	</div>
	<div class="postbox">
		<h2><span>Floating</span></h2>
		<div class="inside">
			<p>The Floating Toggle box must be enabled under <em>Other Settings</em> on this page. It uses the location "floating".</p>
			<p>After user review, the checkbox was removed to the 'Other' tab to avoid accidental enabling.</p>
			<p>You can also add this to pages of your choice manually with the shortcode <code>[web_co_tax_toggle location="floating"]</code>.</p>
		</div>
	</div>
	<div class="postbox">
		<h2><span>Other</span></h2>
		<div class="inside">
			<p>Here you can enable the site-wide <strong>floating tax toggle</strong>.</p>
			<p>You can also optionally add a <strong>Tax suffix</strong> to prices displaying with and/or without VAT. Leaving these empty will remove the suffixes on the frontend.</p>
			<p>These suffixes have the CSS class <code>.web-co-vat-suffix</code> if you would like to modify their appearance.</p>
		</div>
	</div>
	<div class="postbox">
		<h2><span>CSS Targets</span></h2>
		<div class="inside">
			<p>These buttons will take the default WooCommerce styling (or your theme's if that overrides those). You can override those manutally above. Targetting elements is straightforward. The <code>location</code> parameter adds an extra class to the container. Here are a few examples:</p>
			<p><code>.tax-toggle-container</code> will target all navigation containers, while <code>.tax-toggle.container.default</code> will target <em>all but</em> custom class containers. <code>.tax-toggle-container.widgetarea .toggle-taxes</code> targets the button in the widget area.</p>
		</div>
	</div>
	<div class="postbox">
		<h2><span>Compatability Issues</span></h2>
		<div class="inside">
			<p>Issues under review:</p>
			<ol>
				<li>Ajax checkout in some themes will display prices based on your current WooCommerce setup <strong>at checkout</strong>. The tax breakdown, however, is still visible.</li>
			</ol>
			<p>If you have any issues, please visit request support in the WooCommerce marketplace.</p>
		</div>
	</div>
	<div class="postbox">
		<h2><span>Roadmap</span></h2>
		<div class="inside">
			<p>Future updates we're working on:</p>
			<ol>
				<li>Make the plugin fully translatable</li>
				<li>CSS/Shortcode generator on this page</li>
				<li>&#x2713; <s>Add floating cart positioning</s></li>
			</ol>
		</div>
	</div>
</div>