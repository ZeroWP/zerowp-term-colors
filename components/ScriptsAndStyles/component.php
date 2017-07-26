<?php 
/*
-------------------------------------------------------------------------------
Back-end scripts and styles
-------------------------------------------------------------------------------
*/
add_action( 'admin_enqueue_scripts', function(){
	
	zt_colors()->addStyle( ztcolors_config('id') . '-styles-admin', array(
		'src'     =>zt_colors()->assetsURL( 'css/styles-admin.css' ),
		'enqueue' => false,
	));
	
	zt_colors()->addScript( ztcolors_config('id') . '-config-admin', array(
		'src'     => zt_colors()->assetsURL( 'js/config-admin.js' ),
		'deps'    => array( 'jquery' ),
		'enqueue' => false,
	));

});

/*
-------------------------------------------------------------------------------
Front-end scripts and styles
-------------------------------------------------------------------------------
*/
add_action( 'wp_enqueue_scripts', function(){
	
	zt_colors()->addStyle( ztcolors_config('id') . '-styles', array(
		'src'     =>zt_colors()->assetsURL( 'css/styles.css' ),
		'enqueue' => false,
	));
	
	zt_colors()->addScript( ztcolors_config('id') . '-config', array(
		'src'     => zt_colors()->assetsURL( 'js/config.js' ),
		'deps'    => array( 'jquery' ),
		'enqueue' => false,
	));

});