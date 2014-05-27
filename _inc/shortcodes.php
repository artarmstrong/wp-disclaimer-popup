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

	$settings = unserialize(get_option('wpd_settings'));
	
	// Check that disclaimer post exists
	if ( 'publish' == get_post_status ( $post_id ) ) {
  
  	// Setup jQuery vars div
  	echo '<div id="wpd-vars">';
  	echo '<div id="wpd-expire">'.get_post_meta($post_id, 'wpd_hold', true).'</div>';
  	echo '<div id="wpd-id">'.$post_id.'</div>';
  	echo '</div>';
  
    // Setup main fancybox
  	echo '<div id="wpd-disclaimer" style="display:none;">';
  	$text = get_post($post_id);
  	//echo "<h2>".apply_filters('the_title', $text->post_title)."</h2>";
  	echo apply_filters('the_content', $text->post_content);
  	echo '<p class="linkwraps"><a class="fancybox agree" href="#">'.get_post_meta($post_id, 'wpd_accept', true).'</a> <a class="fancybox disagree" href="'.get_post_meta($post_id, 'wpd_redirect', true).'">'.get_post_meta($post_id, 'wpd_decline', true).'</a></p>';
  	echo '</div>';
  	
  }
}