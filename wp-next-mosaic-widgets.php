<?php

// -------------- Parte de selects dos widgets para determinar 
// quando vai mostrar o widget logica retirada do pb-extended-widget ----

/*
 * The main loader
*/
add_action('bp_init', 'wp_next_mosaic_ew_load');
function wp_next_mosaic_ew_load(){
	// Load languages if any
	//if ( file_exists( dirname(__File__) . '/langs/' . get_locale() . '.mo' ) )
	//	load_textdomain( 'bpew', dirname(__File__) . '/langs/' . get_locale() . '.mo' );

	// display our own fields
	add_action('in_widget_form', 'wp_next_mosaic_ew_extend_form', 10, 3);

	// save our new things
	add_filter('widget_update_callback', 'wp_next_mosaic_ew_extend_update', 10, 4);

	// display content if needed
	add_filter('widget_display_callback', 'wp_next_mosaic_ew_extend_display', 10, 3);
}


/*
 * Handlers
*/
function wp_next_mosaic_ew_extend_form($class, $return, $instance){
	echo '<hr /><p>'.__('Display the widget if it satisfies BuddyPress-specific options below:','bpew').'</p>';

	if(!isset($instance['wp_component_type']))
		$instance['wp_component_type'] = '';
	if(!isset($instance['wp_component_ids']))
		$instance['wp_component_ids'] = '';

	echo '<p>
	<label id="'.$class->get_field_id('wp_next_component_type').'">'. 'Please select for what to apply' .':</label><br />
	<input '.checked($instance['wp_next_component_type'], '', false).' type="radio" name="'.$class->get_field_name('wp_next_component_type').'" value=""/> '. 'Do not apply' .'<br />
	<input '.checked($instance['wp_next_component_type'], 'group_home', false).' type="radio" name="'.$class->get_field_name('wp_next_component_type').'" value="group_home"/> '. 'Apenas na home dos grupos' .'<br />
	</p>';


	add_action('wp_next_mosaic_ew_extend_form', $class, $return, $instance);

	return $return;
}

function wp_next_mosaic_ew_extend_update($instance, $new_instance, $old_instance, $this){
	$new_instance = apply_filters('wp_next_mosaic_ew_extend_update', $new_instance, $old_instance, $instance, $this);

	return $new_instance;
}

function wp_next_mosaic_ew_extend_display($instance, $this, $args){
	if(empty($instance['wp_next_component_type']))
		return $instance;
	
	global $bp;

	// display on groups home pages only
	$group_id = $bp->groups->current_group->id;
	if($instance['wp_next_component_type'] == 'group_home' && !empty($group_id)
			&& wp_is_group_home() ){
		
		return $instance;
	}
	
	return false;
}


?>