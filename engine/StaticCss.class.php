<?php 
namespace ZTColors;

class StaticCss{

	public $option_id;

	public function __construct(){
		$this->option_id = 'ztcolors_static';
	}

	public function renderCss(){
		$colors = get_option( $this->option_id, false );

		$css = '';
		if( !empty($colors) ){
			foreach ($colors as $term_id => $color) {
				if( $this->color( $color )->isHex() && $this->color( $color )->isLight() ){
					$text_color = 'rgba( 0, 0, 0, 0.75 )';
				}
				else{
					$text_color = 'rgba( 255, 255, 255, 0.85 )';
				}

				$css .= '.ztc-term-label-'. absint( $term_id ) .'{ background-color: '. $color .'; color: '. $text_color .'; }';
			}
		}

		if( !empty( $css ) ){
			echo '<style>'. apply_filters( 'ztcolors_static', $css, $this->option_id, $colors ) .'</style>';
		}
	}

	public function color( $color ){
		return new Color( $color );
	}

}