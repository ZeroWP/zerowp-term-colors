<?php 
require_once ZTCOLORS_PATH . 'warnings/abstract-warning.php';

class ZTCOLORS_NoPlugin_Warning extends ZTCOLORS_Astract_Warning{

	public function notice(){
		
		$output = '';
		
		if( count( $this->data ) > 1 ){
			$message = __( 'Please install and activate the following plugins:', 'zerowp-term-colors' );
		}
		else{
			$message = __( 'Please install and activate this plugin:', 'zerowp-term-colors' );
		}

		$output .= '<h2>' . $message .'</h2>';


		$output .= '<ul class="ztcolors-required-plugins-list">';
			foreach ($this->data as $plugin_slug => $plugin) {
				$plugin_name = '<div class="ztcolors-plugin-info-title">'. $plugin['plugin_name'] .'</div>';

				if( !empty( $plugin['plugin_uri'] ) ){
					$button = '<a href="'. esc_url_raw( $plugin['plugin_uri'] ) .'" class="ztcolors-plugin-info-button" target="_blank">'. __( 'Get the plugin', 'zerowp-term-colors' ) .'</a>';
				}
				else{
					$button = '<a href="#" onclick="return false;" class="ztcolors-plugin-info-button disabled">'. __( 'Get the plugin', 'zerowp-term-colors' ) .'</a>';
				}

				$output .= '<li>'. $plugin_name . $button .'</li>';
			}
		$output .= '</ul>';

		return $output;
	}

}