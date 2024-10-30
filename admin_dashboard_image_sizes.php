<?php
/*
Plugin Name: Image sizes in admin dashboard
Plugin URI: 
Description: When you define add_image_size in function.php they will be displayed in admin dashboard
Author: Mansoor Munib
Version: 1.0.0
Author URI: http://www.dwinteractive.se/
*/

// Create the function to output the contents of our Dashboard Widget

function dwi_dashboard_widget_function() {

        $image_sizes = get_intermediate_image_sizes();
		foreach ($image_sizes as $size_key => $size_value):
			
			$image_size = get_thumb_image_size( $size_value );
			if ( !empty( $image_size ) ) {
				$width = $image_size['width'];
				$height = $image_size['height'];
			}
			$size_value = str_replace("-", " ", $size_value);
			$size_value = ucwords($size_value);
			
			echo "<p><strong>".$size_value." : </strong> ".$width."x".$height."px <br /> </p>";			
		endforeach;
		
		echo "<p style='color:#f00; text-align:right; width:100%;'>9999px means it can be any size</p>";			
	
}
function dwi_add_dashboard_widgets() {
	wp_add_dashboard_widget('size_dashboard_widget', 'Images Sizes (width x height)px', 'dwi_dashboard_widget_function');	
}
add_action('wp_dashboard_setup', 'dwi_add_dashboard_widgets' ); 
// Hint: For Multisite Network Admin Dashboard use wp_network_dashboard_setup instead of wp_dashboard_setup.

function get_thumb_image_size( $name ) {
	global $_wp_additional_image_sizes;

	if($name == 'thumbnail'){
		$return_dimensions['width'] = get_option( 'thumbnail_size_w');
		$return_dimensions['height'] = get_option( 'thumbnail_size_h');
		return $return_dimensions;
	}
	elseif($name == 'medium'){
		$return_dimensions['width'] = get_option( 'medium_size_w');
		$return_dimensions['height'] = get_option( 'medium_size_h');
		return $return_dimensions;
	}
	elseif($name == 'large'){
		$return_dimensions['width'] = get_option( 'large_size_w');
		$return_dimensions['height'] = get_option( 'large_size_h');
		return $return_dimensions;
	}
	elseif ( isset( $_wp_additional_image_sizes[$name] ) ){
		return $_wp_additional_image_sizes[$name];
	}

	return false;
}