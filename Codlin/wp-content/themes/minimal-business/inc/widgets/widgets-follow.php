<?php

/**
 * Follow Us
 *
 * @package Minimal_Business
 */

add_action( 'widgets_init', 'minimal_business_register_recent_posts_widget' );
function minimal_business_register_recent_posts_widget() {
    register_widget( 'minimal_business_follow_widget' );
}
class minimal_business_follow_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		parent::__construct(
	 		'minimal_business_follow_widget',
			esc_html__('Minimal Business : Follow Us','minimal-business'),
			array(
				'description'	=> esc_html__( 'A widget To Display Recent Posts', 'minimal-business' )
			)
		);
		
	}

	/**
	 * Helper function that holds widget fields
	 * Array is used in update and form functions
	 */
	 private function widget_fields() {

		$fields = array(
            'follow_title' => array(
            'minimal_business_widgets_name' => 'follow_title',
            'minimal_business_widgets_title' => esc_html__('Title','minimal-business'),
            'minimal_business_widgets_field_type' => 'text',
            ),
		);
		
		return $fields;
	 }


	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		extract($args);
		echo $before_widget;
		$title_widget = apply_filters( 'widget_title', empty( $instance['follow_title'] ) ? '' : $instance['follow_title'], $instance, $this->id_base );

		if (!empty($title_widget)):
		echo $args['before_title'] . esc_html($title_widget) . $args['after_title'];
		endif;  ?>

				<?php if ( has_nav_menu( 'social-media' ) ) : 
					 wp_nav_menu( array(
						'theme_location'  => 'social-media',
						'container_class' => 'inline-social-icon social-links',
					) ); 
				endif; ?>

		<?php echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param	array	$new_instance	Values just sent to be saved.
	 * @param	array	$old_instance	Previously saved values from database.
	 *
	 * @uses	minimal_business_widgets_updated_field_value()		defined in widget-fields.php
	 *
	 * @return	array Updated safe values to be saved.
	 */
	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$widget_fields = $this->widget_fields();

		// Loop through fields
		foreach( $widget_fields as $widget_field ) {

			extract( $widget_field );
	
			// Use helper function to get updated field values
			$instance[$minimal_business_widgets_name] = minimal_business_widgets_updated_field_value( $widget_field, $new_instance[$minimal_business_widgets_name] );
			
		}
				
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param	array $instance Previously saved values from database.
	 *
	 * @uses	minimal_business_widgets_show_widget_field()		defined in widget-fields.php
	 */
	public function form( $instance ) {

		$widget_fields = $this->widget_fields();

		// Loop through fields
		foreach( $widget_fields as $widget_field ) {
			// Make array elements available as variables 
			extract( $widget_field );
			$minimal_business_widgets_field_value = isset( $instance[$minimal_business_widgets_name] ) ? esc_attr( $instance[$minimal_business_widgets_name] ) : '';
			minimal_business_widgets_show_widget_field( $this, $widget_field, $minimal_business_widgets_field_value );
		}
		?>
		 <?php if ( !has_nav_menu( 'social-media' ) ) : ?>
			<p><?php esc_html_e( 'Please set footer menu from menu section', 'minimal-business' );?></p>
		<?php endif;?>	
	<?php }
}