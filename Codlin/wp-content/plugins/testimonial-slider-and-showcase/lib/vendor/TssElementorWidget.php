<?php

class TssElementorWidget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'testimonial-slider-showcase';
	}

	public function get_title() {
		return __( 'Testimonials Slider and Showcase', 'testimonial-slider-showcase' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Testimonials Slider and Showcase', 'testimonial-slider-showcase' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'short_code_id',
			array(
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'id'      => 'style',
				'label'   => __( 'ShortCode', 'testimonial-slider-showcase' ),
				'options' => TSSPro()->get_shortCode_list()
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if(isset($settings['short_code_id']) && !empty($settings['short_code_id']) && $id = absint($settings['short_code_id'])){
			echo do_shortcode( '[rt-testimonial id="' . $id . '"]' );
		}else{
			echo "Please select a post grid";
		}
	}
}