// Click to Chat
document.addEventListener('DOMContentLoaded', function() {

    // M.AutoInit();

    var elems = document.querySelectorAll('select');
    M.FormSelect.init(elems, {});

    var elems = document.querySelectorAll('.collapsible');
    M.Collapsible.init(elems, {});

    var elems = document.querySelectorAll('.modal');
    M.Modal.init(elems, {});

    var elems = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(elems, {});

    // var elems = document.querySelectorAll('.tabs');
    // M.Tabs.getInstance(elems, {});

});


jQuery(document).ready(function ($) {

    $('select').formSelect();
    $('.collapsible').collapsible();
    $('.modal').modal();
    $('.tooltipped').tooltip();
    
    $('.ht-ctc-color').wpColorPicker();

    // show/hide settings
    function ht_ctc_show_hide_options () {

        // default display
        var val = $('.select_show_or_hide').find(":selected").val();
        if (val == 'show') {
            $(".showbased").show();
        } else if (val == 'hide') {
            $(".hidebased").show();
        }

        // on change
        $(".select_show_or_hide").on("change", function (e) {
            
            var change_val = e.target.value;
            $(".showbased").hide();
            $(".hidebased").hide();

            if (change_val == 'show') {
                $(".showbased").show(500);
            } else if (change_val == 'hide') {
                $(".hidebased").show(500);
            }
        });

    }
    ht_ctc_show_hide_options();


    // hide nothing or hide only on one device.
    $(document).on('click', '.hidebasedondevice', function() {      
        $('.hidebasedondevice').not(this).prop('checked', false);      
    });


});