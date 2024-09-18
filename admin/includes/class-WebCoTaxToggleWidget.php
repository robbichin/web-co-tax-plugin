<?php
class WebCoTaxToggleWidget extends WP_Widget {
	// Constructor
	public function __construct() {
		parent::__construct(
			'webco_tax_widget', // Widget ID
			'Toggle Tax', // Widget name
			array( 'description' => 'A widget to toggle tax' ) // Widget description
		);
	}

	// Widget Form
	public function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr($instance['title'] ) : '';
		$text = isset( $instance['text']) ? esc_textarea($instance['text'] ) : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>">Text:</label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $text ); ?></textarea>
		</p>

<?php
	}
	// Widget Update
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = ( isset( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['text'] = ( isset( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
		return $instance;
	}
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$text = esc_textarea( $instance['text'] );

		$widget_html = '';

		if (!empty($title)) {
			$widget_html .= $args['before_title'] . esc_html($title) . $args['after_title'];
		}

		if (!empty($text)) {
			$widget_html .= '<p>' . esc_html($text) . '</p>';
		}

		$widget_html .= do_shortcode( '[web_co_tax_toggle location="widgetarea"]' );

		if (!empty($shortcode_output)) {
			$widget_html .= wp_kses_post($shortcode_output);
		}

		echo wp_kses_post($args['before_widget'] . $widget_html . $args['after_widget']);
	}
}

// Register the widget
function register_webco_tax_widget() {
	register_widget('WebCoTaxToggleWidget');
}
add_action('widgets_init', 'register_webco_tax_widget');