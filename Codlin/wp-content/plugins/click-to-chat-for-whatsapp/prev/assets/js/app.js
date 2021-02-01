// jQuery(document).ready(function ($) {
jQuery(document).ready(function () {

    // to solve autop issue, when added shortcode in same line.
    jQuery(".inline_issue").prev("p").css("display", "inline");

    // animations .. 
    jQuery('.ccw-an').hover(add, remove);

    function add() {
        // jQuery(this).addClass('animated bounce infinite');
        jQuery(this).addClass('animated infinite');
    }

    function remove() {
        jQuery(this).removeClass('animated infinite');
    }
});


var url = window.location.href;

var google_analytics = ht_ccw_var.google_analytics;
var fb_analytics = ht_ccw_var.fb_analytics;

var title = ht_ccw_var.page_title;

// Analytics
ht_ccw_clickevent();

function ht_ccw_clickevent() {

    var ccw_plugin = document.querySelector('.ccw_plugin');

    if ( ccw_plugin ) {
        ccw_plugin.addEventListener('click', ht_ccw_clicked);
    }

}

// when cliced on sytle - source ht_ccw_clickevent() click event
function ht_ccw_clicked() {

    if ( 'true' == google_analytics ) {
        google_analytics_event();
    }

    if ( 'true' == fb_analytics ) {
        fb_analytics_event();
    }

}

// google analytics - source - ht_ccw_clicked
function google_analytics_event() {

    var ga_category = ht_ccw_var.ga_category.replace('{{url}}', url).replace('{{title}}', title);
    var ga_action = ht_ccw_var.ga_action.replace('{{url}}', url).replace('{{title}}', title);
    var ga_label = ht_ccw_var.ga_label.replace('{{url}}', url).replace('{{title}}', title);

    // ga('send', 'event', 'Contact', 'Call Now Button', 'Phone');

    if ("ga" in window) {
        tracker = ga.getAll()[0];
        if (tracker) tracker.send("event", ga_category, ga_action, ga_label );
    } else if ("gtag" in window) {
        gtag('event', ga_action, {
            'event_category': ga_category,
            'event_label': ga_label,
        });
    }

}

// fb analytics - source - ht_ccw_clicked
function fb_analytics_event() {
    
    var p1_value = ht_ccw_var.p1_value.replace('{{url}}', url).replace('{{title}}', title);
    var p2_value = ht_ccw_var.p2_value.replace('{{url}}', url).replace('{{title}}', title);
    var p3_value = ht_ccw_var.p3_value.replace('{{url}}', url).replace('{{title}}', title);

    logFb_analyticsEvent(p1_value, p2_value, p3_value)
}


/**
 * fb analytics
 * This function will log custom App Event
 * @param {string} dynamic_name_value
 * @param {string} dynamic_name_value
 * @param {string} dynamic_name_value
 */
function logFb_analyticsEvent(p1_value, p2_value, p3_value) {

    var p1_name = ht_ccw_var.p1_name;
    var p2_name = ht_ccw_var.p2_name;
    var p3_name = ht_ccw_var.p3_name;
    
    var fb_event_name = ht_ccw_var.fb_event_name;

    var params = {};
    params[p1_name] = p1_value;
    params[p2_name] = p2_value;
    params[p3_name] = p3_value;
    // if fb analytics is not installed - uncheck the fb analytics option from plugin settings
    FB.AppEvents.logEvent( fb_event_name, null, params);
}