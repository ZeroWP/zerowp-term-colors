<?php 
add_action( 'init', function(){
	
	// Get all public taxonomies
	$taxonomies = get_taxonomies( array(
		'public' => true,
	) ); 
	
	// Add color meta to each taxonomy
	foreach ( $taxonomies as $taxonomy ) {
		new ZTColors\Meta( $taxonomy );
	}
	

}, 999 ); // Late hook. Probably all taxonomies are ready

add_action( 'wp_head', function(){
	$static_css = new ZTColors\StaticCss;
	$static_css->renderCss();
}, 999 );