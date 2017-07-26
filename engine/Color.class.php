<?php 
namespace ZTColors;

class Color{
	
	public $color;

	public function __construct( $color ){
		$this->color = $color;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Determine if a string is a valid HEX color
	 *
	 * @return bool 
	 */
	public function isHex(){
		$check = preg_match("/^#(?:[0-9a-fA-F]{3}){1,2}$/", $this->color);
		return ( $check === 1 );
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Check if a color is light
	 *
	 * @return bool `true` if is light else `false` 
	 */
	public function isLight(){
		return $this->_luminance() > 186;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Check if a color is dark
	 *
	 * @return bool `true` if is dark else `false` 
	 */
	public function isDark(){
		return $this->isLight() === false;
	}

	//------------------------------------//--------------------------------------//
	
	/**
	 * Get the luminance value of a HEX color
	 *
	 * @return int 
	 */
	protected function _luminance(){
		// Get the color
		$color = str_replace('#', '', $this->color);

		// Calculate straight from rbg
		if( 3 === strlen( $color ) ){
			$r = hexdec($color[0].$color[0]);
			$g = hexdec($color[1].$color[1]);
			$b = hexdec($color[2].$color[2]);
		}
		else{
			$r = hexdec($color[0].$color[1]);
			$g = hexdec($color[2].$color[3]);
			$b = hexdec($color[4].$color[5]);
		}

		// Luminance
		return ( $r*299 + $g*587 + $b*114 )/1000;
	}

}