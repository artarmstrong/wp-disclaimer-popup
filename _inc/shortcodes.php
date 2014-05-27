<?php

/*-------------------------------------------
	Shortcodes
---------------------------------------------*/

// [wp-disclaimer id="12"]
function wpd_single_shortcode_func( $atts ) {
	extract( shortcode_atts( array(
		'id' => ''
	), $atts ) );
	
	// Add and call action
	add_action('wpd_footer', 'wpd_disclaimer', 10, 2);
	do_action('wpd_footer', $atts, $id);

}
add_shortcode( 'wp-disclaimer', 'wpd_single_shortcode_func' );

// Function to output disclaimer
function wpd_disclaimer($atts, $post_id=NULL) {
  
  // Get default settings
	$settings = unserialize(get_option('wpd_settings'));
	
	// Check that disclaimer post exists
	if ( 'publish' == get_post_status ( $post_id ) ) {
	
	  // Setup variables
	  unset($hold, $accept, $decline, $redirect);
	  $hold = get_post_meta($post_id, 'wpd_hold', true);
	  $accept = get_post_meta($post_id, 'wpd_accept', true);
	  $decline = get_post_meta($post_id, 'wpd_decline', true);
	  $redirect = get_post_meta($post_id, 'wpd_redirect', true);
	  
	  // Check empty variables
	  $hold = !empty($hold) ? $hold : $settings['hold'];
	  $accept = !empty($accept) ? $accept : $settings['accept'];
	  $decline = !empty($decline) ? $decline : $settings['decline'];
	  $redirect = !empty($redirect) ? $redirect : $settings['redirect'];
  
  	// Setup jQuery vars div
  	echo '<div id="wpd-vars">';
  	echo '<div id="wpd-expire">'.$hold.'</div>';
  	echo '<div id="wpd-id">'.$post_id.'</div>';
  	echo '</div>';
  
    // Setup main fancybox
  	echo '<div id="wpd-disclaimer" style="display:none;">';
  	$text = get_post($post_id);
  	//echo "<h2>".apply_filters('the_title', $text->post_title)."</h2>";
  	echo apply_filters('the_content', $text->post_content);
  	echo '<p class="linkwraps"><a class="fancybox agree" href="#">'.$accept.'</a> <a class="fancybox disagree" href="'.$redirect.'">'.$decline.'</a></p>';
  	echo '</div>';
  	
  }
}