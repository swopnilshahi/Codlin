<div class="wrap">
    <h2><?php esc_html_e( 'Testimonial Settings', "testimonial-slider-showcase-pro" ) ?></h2>
    <div class="rt-settings-container">
        <div class="rt-setting-title"><h3><?php esc_html_e( 'General settings', "testimonial-slider-showcase-pro" ) ?></h3></div>
        <div class="rt-setting-content">
            <form id="tss-settings">
                <div id="settings-tabs" class="rt-tabs rt-tab-container">
                    <ul class="tab-nav rt-tab-nav">
                        <li><a href="#general"><i
                                        class="dashicons dashicons-admin-settings"></i><?php esc_html_e( 'General', "testimonial-slider-showcase-pro" ); ?>
                            </a></li>
                        <li>
                            <a href="#custom-css"><?php esc_html_e( 'Custom Css', "testimonial-slider-showcase-pro" ); ?></a>
                        </li>
                    </ul>
                    <div id="general" class="rt-tab-content">
						<?php echo TSSPro()->rtFieldGenerator( TSSPro()->generalSettings() ); ?>
                    </div>
                    <div id="custom-css" class="rt-tab-content">
						<?php echo TSSPro()->rtFieldGenerator( TSSPro()->othersSettings() ); ?>
                    </div>
                </div>
                <p class="submit">
                    <input
                            type="submit"
                            name="submit"
                            id="tlpSaveButton"
                            class="rt-admin-btn button button-primary"
                            value="<?php esc_html_e( 'Save Changes', "testimonial-slider-showcase-pro" ); ?>">
                </p>

				<?php wp_nonce_field( TSSPro()->nonceText(), TSSPro()->nonceId() ); ?>
            </form>
            <div class="rt-response"></div>
        </div>
        <div class="rt-pro-feature-content">
			<?php TSSPro()->rt_plugin_sc_pro_information( 'settings' ); ?>
        </div>
    </div>
</div>
