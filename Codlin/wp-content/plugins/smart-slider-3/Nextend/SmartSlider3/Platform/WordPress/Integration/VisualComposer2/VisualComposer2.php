<?php


namespace Nextend\SmartSlider3\Platform\WordPress\Integration\VisualComposer2;


use Nextend\SmartSlider3\Platform\WordPress\Shortcode\Shortcode;

class VisualComposer2 {

    public function __construct() {

        add_action('vcv:boot', array(
            $this,
            'init'
        ));
    }

    public function init() {

        new VC2SmartSliderModule();

        add_action('wp_ajax_vcv:admin:ajax', array(
            $this,
            'forceShortcodeIframe'
        ));
    }

    public function forceShortcodeIframe() {
        Shortcode::forceIframe('VisualComposer2', true);
    }
}