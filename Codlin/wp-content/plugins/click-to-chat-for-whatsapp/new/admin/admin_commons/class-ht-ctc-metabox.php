<?php
/**
 * Meta box
 * change values at page level
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_MetaBox' ) ) :

class HT_CTC_MetaBox {

	/**
	 * add meta box
	 */
	function meta_box() {
		
		add_meta_box(
			'ht_ctc_settings_meta_box',             // Id.
			'Click to Chat',                        // Title.
			array( $this, 'display_meta_box' ),     // Callback.
			'',                                  	// Post_type.
			'side',                                 // Context.
			'default'                               // Priority.
		);
	}

	/**
	 * render meta box content
	 */
	function display_meta_box( $current_post ) {

		wp_nonce_field( 'ht_ctc_page_meta_box', 'ht_ctc_page_meta_box_nonce' );
		$options = get_option( 'ht_ctc_main_options' );

		?>
			<div class="row">
				<p class="description">Change values at <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/change-values-at-page-level">Page level</a></p>
			</div>
		<?php

		// if chat enabled
		if ( isset( $options['enable_chat'] ) ) {
			?>

			<!-- number -->
			<div class="row">
				<label for="number">Chat - WhatsApp Number</label><br>
				<input name="ht_ctc_page_number" value="<?php echo esc_attr( get_post_meta( $current_post->ID, 'ht_ctc_page_number', true ) ); ?>" id="number" type="text">
				<p class="description"><a style="text-decoration: none" target="_blank" href="https://holithemes.com/plugins/click-to-chat/whatsapp-number/">WhatsApp Number</a> with country code</p>
			</div>

			<!-- call to action -->
			<div class="row">
				<label for="call_to_action">Chat - Call to Action</label><br>
				<input name="ht_ctc_page_call_to_action" value="<?php echo esc_attr( get_post_meta( $current_post->ID, 'ht_ctc_page_call_to_action', true ) ); ?>" id="call_to_action" type="text">
			</div>


			<?php
		}
		


		// if group enabled
		if ( isset( $options['enable_group'] ) ) {
			?>

			<!-- group id -->
			<div class="row">
				<label for="group_id">Group - Group ID</label><br>
				<input name="ht_ctc_page_group_id" value="<?php echo esc_attr( get_post_meta( $current_post->ID, 'ht_ctc_page_group_id', true ) ); ?>" id="group_id" type="text">
				<!-- <p class="description"><a style="text-decoration: none" target="_blank" href="https://holithemes.com/plugins/click-to-chat/whatsapp-number/">WhatsApp Number</a> with country code</p> -->
			</div>

			<?php
		}


	}


	/**
	 * save meta box
	 */
	function save_meta_box( $post_id ) {


		// Check if our nonce is set.
		if ( ! isset( $_POST['ht_ctc_page_meta_box_nonce'] ) ) {
			return;
		}

		$nonce = $_POST['ht_ctc_page_meta_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'ht_ctc_page_meta_box' ) ) {
			return;
		}

		// If this is an autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}


		
		// // if ( isset( $_POST['ht_ctc_page_number'] ) && $_POST['ht_ctc_page_number'] != '' ) {
		// if ( isset( $_POST['ht_ctc_page_number'] ) ) {
		// 	update_post_meta( $post_id, 'ht_ctc_page_number', sanitize_text_field( $_POST['ht_ctc_page_number'] ) );
		// }

		// if ( isset( $_POST['ht_ctc_page_call_to_action'] ) ) {
		// 	update_post_meta( $post_id, 'ht_ctc_page_call_to_action', sanitize_text_field( $_POST['ht_ctc_page_call_to_action'] ) );
		// }

		// if ( isset( $_POST['ht_ctc_page_group_id'] ) ) {
		// 	update_post_meta( $post_id, 'ht_ctc_page_group_id', sanitize_text_field( $_POST['ht_ctc_page_group_id'] ) );
		// }


		// number
		if ( isset( $_POST['ht_ctc_page_number'] ) && '' == $_POST['ht_ctc_page_number'] ) {
			// if empty delete
			delete_post_meta($post_id, 'ht_ctc_page_number', '' );
		} elseif ( isset( $_POST['ht_ctc_page_number'] ) ) {
			update_post_meta( $post_id, 'ht_ctc_page_number', sanitize_text_field( $_POST['ht_ctc_page_number'] ) );
		}

		// call to action
		if ( isset( $_POST['ht_ctc_page_call_to_action'] ) && '' == $_POST['ht_ctc_page_call_to_action'] ) {
			// if empty delete
			delete_post_meta($post_id, 'ht_ctc_page_call_to_action', '' );
		} elseif ( isset( $_POST['ht_ctc_page_call_to_action'] ) ) {
			update_post_meta( $post_id, 'ht_ctc_page_call_to_action', sanitize_text_field( $_POST['ht_ctc_page_call_to_action'] ) );
		}

		// group id
		if ( isset( $_POST['ht_ctc_page_group_id'] ) && '' == $_POST['ht_ctc_page_group_id'] ) {
			// if empty delete
			delete_post_meta($post_id, 'ht_ctc_page_group_id', '' );
		} elseif ( isset( $_POST['ht_ctc_page_group_id'] ) ) {
			update_post_meta( $post_id, 'ht_ctc_page_group_id', sanitize_text_field( $_POST['ht_ctc_page_group_id'] ) );
		}

	}





}

$ht_ctc_metabox = new HT_CTC_MetaBox();


add_action( 'add_meta_boxes', array($ht_ctc_metabox, 'meta_box') );
add_action( 'save_post', array($ht_ctc_metabox, 'save_meta_box') );


endif; // END class_exists check