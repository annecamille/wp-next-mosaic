<?php
/*
Plugin Name: wp-next-mosaic
Plugin URI: https://github.com/annecamille/wp-next-mosaic.git
Description: Plugin to add effects to images
Version: 0.1.0
Author: Anne Camille e Alberto Souza 
Author URI: em breve
*/

/**
 * Load BP functions safely
 */
function wp_next_mosaic_loader() {
	include( dirname(__FILE__) . '/wp-next-mosaic-widgets.php' );

	$meuPluginURL = WP_CONTENT_URL.'/plugins/'.plugin_basename( dirname(__FILE__)).'/';
	
	$urlMosaic = $meuPluginURL . 'js/mosaic.1.0.1.js';
	
	wp_register_script( 'mosaic' , $urlMosaic, $deps = array('jquery'), '1.0', true);
}
add_action( 'bp_include', 'wp_next_mosaic_loader' );

function wp_next_mosaic_load_scripts() {
	wp_enqueue_script('mosaic');
}

add_action('init', 'wp_next_mosaic_load_scripts');


function wp_next_mosaic_footer(){
	$script = "
	<script type='text/javascript'>
		jQuery(function($){
		$('.cover').mosaic({
			animation	:	'slide',	//fade or slide
			hover_x		:	'400px'		//Horizontal position on hover
			});
		});
	</script>
	";
    print $script;	
} 

add_action('wp_footer', 'wp_next_mosaic_footer');


?>
