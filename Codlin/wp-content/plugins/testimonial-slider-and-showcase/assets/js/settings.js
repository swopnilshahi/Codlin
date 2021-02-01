(function ($) {
    'use strict';
    $(function () {
        if ($('.rt-color').length) {
            $('.rt-color').wpColorPicker();
        }
        $(".rt-tab-nav li:first-child a").trigger('click');

    });

    /* Rating */
    $('.rt-rating').on('click', 'span', function () {
        var self = $(this),
            parent = self.parent(),
            star = parseInt(self.data('star'), 10);
        parent.find('.rating-value').val(star);
        parent.addClass('selected');
        parent.find('span').removeClass('active');
        self.addClass('active');

    });

    /* rt tab active navigation */
    $(".rt-tab-nav li").on('click', 'a', function (e) {
        e.preventDefault();
        var container = $(this).parents('.rt-tab-container');
        var nav = container.children('.rt-tab-nav');
        var content = container.children(".rt-tab-content");
        var $this, $id;
        $this = $(this);
        $id = $this.attr('href');
        content.hide();
        nav.find('li').removeClass('active');
        $this.parent().addClass('active');
        container.find($id).show();
    });

    if ($("#sc-item-select").length) {
        $("#sc-item-select").select2({
            placeholder: "Select multiple item",
            allowClear: true
        });
    }
    if ($("select#sc-item-select").length) {
        $("select#sc-item-select").select2({
            placeholder: "Select multiple member",
            allowClear: true,
            width: '100%'
        });
    }
    if ($("select.rt-select2").length) {
        $("select.rt-select2").select2({width: '100px'});
    }
    if ($("select#img-size").length) {
        $("select#img-size").select2({width: '200px'});
    }
    specificMshowHide();
    layoutOptShowHide();
    $("#specific-items-action, #layout").on('change', function () {
        specificMshowHide();
        layoutOptShowHide();
    });

    $("#tss-settings").submit(function (event) {
        event.preventDefault();
        tssSyncCss();
        var arg = $(this).serialize();
        AjaxCall('', 'tssSettingsAction', arg, function (data) {
            if (!data.error) {
                $('.rt-response').removeClass('success');
                $('.rt-response').show('slow').text(data.msg);
            } else {
                $('.rt-response').addClass('error');
                $('.rt-response').show('slow').text(data.msg);
            }
        });
    });

    function AjaxCall(element, action, arg, handle) {
        'use strict';
        var data;
        if (action) data = "action=" + action;
        if (arg) data = arg + "&action=" + action;
        if (arg && !action) data = arg;
        var n = data.search(tss.nonceId);
        if (n < 0) {
            data = data + "&" + tss.nonceId + "=" + tss.nonce;
        }
        jQuery.ajax({
            type: "post",
            url: ajaxurl,
            data: data,
            beforeSend: function () {
                $('body').append($("<div id='tss-loading'><span class='tss-loading'>Updating ...</span></div>"));
            },
            success: function (data) {
                $("#tss-loading").remove();
                handle(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#tss-loading").remove();
                alert(textStatus + ' (' + errorThrown + ')');
            }
        });
    }
})(jQuery);


function specificMshowHide() {
    if (jQuery('#specific-items-action').is(':checked')) {
        jQuery(".sc-meta-field.titem").hide();
        jQuery(".sc-meta-field.sitem").show();
    } else {
        jQuery(".sc-meta-field.titem").show();
        jQuery(".sc-meta-field.sitem").hide();
    }
}

function layoutOptShowHide() {
    var id = jQuery("#layout").val();
    if (id && id == "carousel") {
        jQuery(".sc-meta-field-full.carousel").show();
    } else {
        jQuery(".sc-meta-field-full.carousel").hide();
    }
}


(function (global, $) {
    var editor,
        syncCSS = function () {
            tssSyncCss();
        },
        loadAce = function () {
            $('.rt-custom-css').each(function () {
                var id = $(this).find('.custom-css').attr('id');
                editor = ace.edit(id);
                global.safecss_editor = editor;
                editor.getSession().setUseWrapMode(true);
                editor.setShowPrintMargin(false);
                editor.getSession().setValue($(this).find('.custom_css_textarea').val());
                editor.getSession().setMode("ace/mode/css");
            });

            jQuery.fn.spin && $('.custom_css_container').spin(false);
            $('#post').submit(syncCSS);
        };
    if ($.browser.msie && parseInt($.browser.version, 10) <= 7) {
        $('.custom_css_container').hide();
        $('.custom_css_textarea').show();
        return false;
    } else {
        $(global).load(loadAce);
    }
    global.aceSyncCSS = syncCSS;
})(this, jQuery);

function tssSyncCss() {
    jQuery('.rt-custom-css').each(function () {
        var e = ace.edit(jQuery(this).find('.custom-css').attr('id'));
        jQuery(this).find('.custom_css_textarea').val(e.getSession().getValue());
    });
}