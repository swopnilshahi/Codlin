<?php
/**
 * Define fields for Widgets.
 * 
 * @package Minimal_Business
 */

function minimal_business_widgets_show_widget_field( $instance = '', $widget_field = '', $athm_field_value = '' ) {

	$minimal_business_pagelist[0] = array(
        'value' => 0,
        'label' => esc_html__('--choose--','minimal-business')
    );

    $arg = array('posts_per_page'   => -1);
    $minimal_business_pages = get_pages($arg);
    foreach($minimal_business_pages as $minimal_business_page) :
        $minimal_business_pagelist[$minimal_business_page->ID] = array(
            'value' => $minimal_business_page->ID,
            'label' => $minimal_business_page->post_title
        );
    endforeach;
    
	extract( $widget_field );
	
	switch( $minimal_business_widgets_field_type ) {
	
		// Standard text field
		case 'text' : ?>
			<p>
				<label for="<?php echo esc_attr($instance->get_field_id( $minimal_business_widgets_name )); ?>"><?php echo esc_html($minimal_business_widgets_title); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr($instance->get_field_id( $minimal_business_widgets_name )); ?>" name="<?php echo esc_attr($instance->get_field_name( $minimal_business_widgets_name )); ?>" type="text" value="<?php echo esc_html($athm_field_value); ?>" />
				
				<?php if( isset( $minimal_business_widgets_description ) ) { ?>
				<br />
				<small><?php echo esc_html($minimal_business_widgets_description); ?></small>
				<?php } ?>
			</p>
			<?php
			break;

		// Textarea field
		case 'textarea' : ?>
			<p>
				<label for="<?php echo esc_attr($instance->get_field_id( $minimal_business_widgets_name )); ?>"><?php echo esc_html($minimal_business_widgets_title); ?>:</label>
				<textarea class="widefat" rows="6" id="<?php echo esc_attr($instance->get_field_id( $minimal_business_widgets_name )); ?>" name="<?php echo esc_attr($instance->get_field_name( $minimal_business_widgets_name )); ?>"><?php echo esc_html($athm_field_value); ?></textarea>
			</p>
			<?php
			break;
			 
	}
	
}

function minimal_business_widgets_updated_field_value( $widget_field, $new_field_value ) {
    
	extract( $widget_field );
	
	// Allow only integers in number fields
	if( $minimal_business_widgets_field_type == 'number' ) {
		return absint( $new_field_value );
		
	// Allow some tags in textareas
	} elseif( $minimal_business_widgets_field_type == 'textarea' ) {
		// Check if field array specifed allowed tags
		if( !isset( $minimal_business_widgets_allowed_tags ) ) {
			// If not, fallback to default tags
			$minimal_business_widgets_allowed_tags = '<p><strong><em><a>';
		}
		return strip_tags( $new_field_value, $minimal_business_widgets_allowed_tags );
		
	// No allowed tags for all other fields
	} else {
		return strip_tags( $new_field_value );
	}

}