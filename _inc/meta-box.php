<?php

/*-------------------------------------------
	Custom Meta Box
---------------------------------------------*/
add_action( 'add_meta_boxes', 'wpd_custom_meta_box_add' );
add_action( 'save_post', 'wpd_custom_meta_box_save' );

/* Adds a box to the main column on the Post and Page edit screens */
function wpd_custom_meta_box_add() {

  add_meta_box(
    "wpd_disclaimer_meta",
    __( "Disclaimer Information", "wp-disclaimer" ),
    "wpd_custom_meta_disclaimer",
    "disclaimers",
    "normal",
    "high"
  );

}

/* When the post is saved, saves our custom data */
function wpd_custom_meta_box_save( $post_id ) {

	// Check if its an autosave, if so, do nothing
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	  return;

	// Verify this came from the our screen and with proper authorization,
	if ( isset($_POST['wpd_noncename']) && !wp_verify_nonce( $_POST['wpd_noncename'], basename( __FILE__ ) ) )
	  return;

	// Check permissions
	if ( !current_user_can( 'edit_post', $post_id ) )
    return;

	// Save Information
	$wpd_accept   = (isset($_POST['wpd_accept'])  ? $_POST['wpd_accept'] : "");
	$wpd_decline  = (isset($_POST['wpd_decline']) ? $_POST['wpd_decline'] : "");
	$wpd_redirect = (isset($_POST['wpd_redirect'])? $_POST['wpd_redirect'] : "");
	$wpd_hold     = (isset($_POST['wpd_hold'])    ? $_POST['wpd_hold'] : "");
	update_post_meta($post_id, 'wpd_accept',   $wpd_accept);
	update_post_meta($post_id, 'wpd_decline',  $wpd_decline);
	update_post_meta($post_id, 'wpd_redirect', $wpd_redirect);
	update_post_meta($post_id, 'wpd_hold',     $wpd_hold);

  // Return
	return;

}

/* Prints the social media box content */
function wpd_custom_meta_disclaimer( $post ) {
  
  // Get default settings
	$settings = unserialize(get_option('wpd_settings'));
  
	// Use nonce for verification
	wp_nonce_field( basename( __FILE__ ), 'wpd_noncename' );

	// Fields
	?>
	<div style="float:left;" class="wpd_form">

		<table>
			<tr>
				<td width="150" style="padding: 5px 15px" valign="middle">
					<label>'Accept' button text:</label>
				</td>
				<td>
					<input type="text" id="wpd_accept" name="wpd_accept" style="width:250px;" value="<?= get_post_meta($post->ID, 'wpd_accept', true); ?>" placeholder="<?= $settings['accept']; ?>" />
				</td>
			</tr>
			<tr>
				<td style="padding: 5px 15px" valign="middle">
					<label>'Decline' button text:</label>
				</td>
				<td>
					<input type="text" id="wpd_decline" name="wpd_decline" style="width:250px;" value="<?= get_post_meta($post->ID, 'wpd_decline', true); ?>" placeholder="<?= $settings['decline']; ?>" />
				</td>
			</tr>
			<tr>
				<td style="padding: 5px 15px" valign="middle">
					<label>'Decline' redirection url:</label>
				</td>
				<td>
					<input type="text" id="wpd_redirect" name="wpd_redirect" style="width:350px;" value="<?= get_post_meta($post->ID, 'wpd_redirect', true); ?>" placeholder="<?= $settings['redirect']; ?>" />
				</td>
			</tr>
			<tr>
				<td style="padding: 5px 15px" valign="middle">
					<label>Days to hold cookie:</label>
				</td>
				<td>
					<input type="text" id="wpd_hold" name="wpd_hold" style="width:50px;" value="<?= get_post_meta($post->ID, 'wpd_hold', true); ?>" placeholder="<?= $settings['hold']; ?>" />
				</td>
			</tr>
		</table>

	</div>
	<div style="clear:both;"></div>
	<?php
}