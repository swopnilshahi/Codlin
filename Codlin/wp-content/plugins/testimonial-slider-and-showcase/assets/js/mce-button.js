(function() {
    tinymce.PluginManager.add('rt_tss', function( editor, url ) {
        var tlpsc_tag = 'rt-testimonial';

        //add popup
        editor.addCommand('rt_tss_popup', function(ui, v) {
            //setup defaults

            editor.windowManager.open( {
                title: 'Testimonial Slider And Showcase ShortCode',
                width: jQuery( window ).width() * 0.3,
                height: (jQuery( window ).height() - 36 - 50) * 0.1,
                id: 'tlpportfolio-insert-dialog',
                body: [
                    {
                        type   : 'container',
                        html   : '<span class="tlp_loading">Loading...</span>'
                    },
                ],
                onsubmit: function( e ) {

                    var shortcode_str;
                    var id = jQuery("#scid").val();
                    var title = jQuery( "#scid option:selected" ).text();
                    if(id && id != 'undefined'){
                        shortcode_str = '[' + tlpsc_tag;
                        shortcode_str += ' id="'+id+'" title="'+ title +'"';
                        shortcode_str += ']';
                    }
                    if(shortcode_str) {
                        editor.insertContent(shortcode_str);
                    }else{
                        alert('No short code selected');
                    }
                }
            });

            putScList();
        });

        //add button
        editor.addButton('rt_tss', {
            icon: 'rt_tss',
            tooltip: 'Testimonial Shortcode',
            cmd: 'rt_tss_popup'
        });

        function putScList(){
            var dialogBody = jQuery( '#tlpportfolio-insert-dialog-body' );
            jQuery.post( ajaxurl, {
                action: 'shortCodeList'
            }, function( response ) {

                dialogBody.html(response);
                //template = response;
                //
                //dialogBody.children( '.loading' ).remove();
                //dialogBody.append( template );
                //jQuery( '.spinner' ).hide();
                console.log(response);
            });

        }

    });
})();