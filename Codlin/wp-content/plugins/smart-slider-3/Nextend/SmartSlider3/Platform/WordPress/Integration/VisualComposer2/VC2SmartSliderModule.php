<?php


namespace Nextend\SmartSlider3\Platform\WordPress\Integration\VisualComposer2;


use Nextend\SmartSlider3\Platform\WordPress\Shortcode\Shortcode;
use VisualComposer\Framework\Container;
use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Helpers\Request;
use VisualComposer\Helpers\Traits\EventsFilters;
use VisualComposer\Helpers\Traits\WpFiltersActions;

class VC2SmartSliderModule extends Container implements Module {

    use WpFiltersActions;
    use EventsFilters;

    public function __construct() {
        $this->wpAddAction('plugins_loaded', 'initialize', 16);
    }

    protected function initialize(Request $requestHelper) {
        if ($requestHelper->isAjax()) {
            $this->addFilter('vcv:ajax:elements:ajaxShortcode:adminNonce', 'addFilters', -1);
        }
    }

    protected function addFilters($response) {

        $this->forceShortcodeIframe();

        return $response;
    }

    public function forceShortcodeIframe() {
        Shortcode::forceIframe('VisualComposer2', true);
    }
}