<?php
/**
* options page
* content of this page load / continue at admin_page.php
*
* @package ccw
* @subpackage Administration
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="wrap">

    <?php settings_errors(); ?>
    
    <div class="row">

        <div class="col s12 m12 xl6 options">
            <form action="options.php" method="post" class="col s12">
                <?php settings_fields( 'ccw_settings_group' ); ?>
                <?php do_settings_sections( 'ccw_options_settings' ) ?>
                <?php submit_button() ?>
            </form>
        </div>
        
        <div class="col s12 m12 xl6 admin_sidebar">
          <div class="wca_card" style="display: none;">
            <!-- sidebar content -->
          </div>
        </div>    

    </div>
        
    <hr> <br> <br>

    
    <div class="row">
      <div class="col s12 m12 l12 xl9">
        <div class="row">
        
            <div class="col s12 m6">
              <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                  <span class="card-title">Plugin Review</span>
                  <br>
                  <p>If you like the plugin, please Support the Developers</p>
                  <br>
                  <p>By giving 5 Star rating</p>
                </div>
                <div class="card-action">
                  <a target="_blank" href="https://wordpress.org/support/plugin/click-to-chat-for-whatsapp/reviews/#new-post"><?php _e( '' , 'click-to-chat-for-whatsapp' ) ?>Plugin Review</a>
                </div>
              </div>
            </div>

            <div class="collection with-header">
              <div class="collection-header"><bold>HoliThemes On</bold></div>
              <a target="_blank" href="https://www.facebook.com/holithemes/" class="collection-item">Facebook</a>
              <a target="_blank" href="https://twitter.com/holithemes" class="collection-item">Twitter</a>
              <a target="_blank" href="https://www.instagram.com/holithemes/" class="collection-item">Instagram</a>
              <a target="_blank" href="https://www.youtube.com/channel/UC2Tf_WB9PWffO2B3tswWCGw" class="collection-item">YouTube</a>
              <a target="_blank" href="https://www.linkedin.com/company/holithemes" class="collection-item">LinkedIn</a>
            </div>
            
        </div>
      </div>
    </div>

</div>