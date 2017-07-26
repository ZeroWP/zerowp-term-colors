<?php 
namespace ZTColors;

class Meta{

	public $taxonomy_slug = false;
	public $field_id      = false;

	public function __construct( $taxonomy_slug ){
		$this->taxonomy_slug = $taxonomy_slug;
		$this->field_id      = 'ztcolor';
		$this->option_id     = 'ztcolors_static';

		// Display field in form
		add_action( $taxonomy_slug .'_add_form_fields', array( $this, 'displayFieldForNew' ) );
		add_action( $taxonomy_slug .'_edit_form_fields', array( $this, 'displayFieldForUpdate' ), 10, 2 );
		
		// Save data
		add_action( 'created_'. $taxonomy_slug, array( $this, 'saveTerm' ), 10, 2 );
		add_action( 'edited_'. $taxonomy_slug, array( $this, 'editTerm' ), 10, 2 );
		
		// Show in table
		add_filter('manage_edit-'. $taxonomy_slug .'_columns', array( $this, 'addColumn' ) );
		add_filter('manage_'. $taxonomy_slug .'_custom_column', array( $this, 'addColumnContent' ), 10, 3 );
		
		// Scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueue' ), 10, 2 );
	}

	public function adminEnqueue( $hook_suffix ){
		if( in_array($hook_suffix, array('term.php', 'edit-tags.php') ) ){
			$screen = get_current_screen();

			if( is_object( $screen ) && 'edit-' . $this->taxonomy_slug == $screen->id ){
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker' );

				// Add it inline. No reasons to do another http request, just for this.
				wp_add_inline_script( 'wp-color-picker', '
					jQuery(document).on( "ready", function(){
						jQuery( "#term-field-'. esc_js( $this->field_id ) .'" ).wpColorPicker()
						jQuery( "#addtag #submit" ).click( function () {

						if ( ! jQuery( "#addtag .form-invalid" ).length ) {
							jQuery( "#term-field-'. esc_js( $this->field_id ) .'" ).val("").trigger("change");
						}
						});
					} );
				' );
			}
		}
	}

	public function displayFieldForNew( $taxonomy ){
		echo $this->addField( $taxonomy, '', 'new' );
	}

	public function displayFieldForUpdate( $term, $taxonomy ){
		$value = get_term_meta( $term->term_id, $this->field_id, true );
		echo $this->addField( $taxonomy, $value, 'update' );
	}

	public function addField( $taxonomy, $value, $view ) {
		$tr_tag = ( 'update' == $view ) ? 'tr' : 'div';
		$th_tag = ( 'update' == $view ) ? 'th' : 'div';
		$td_tag = ( 'update' == $view ) ? 'td' : 'div';

		$output = '';
		$output .= '<'. $tr_tag .' class="form-field term-'. $this->field_id .'-wrap">';
			
			$output .= '<'. $th_tag .' scope="row">
				<label for="tag-'. $this->field_id .'">'. __( 'Color', 'zerowp-term-colors' ) .'</label>
			</'. $th_tag .'>';
			
			$output .= '<'. $td_tag .'>';
				$output .= '<input type="text" name="'. $this->field_id .'" id="term-field-'. $this->field_id .'" value="'. $value .'" />';
				$output .= '<p class="description">'. __( 'Set a color for this term. This color may be used on front-end, but it is mainly used to make a difference in the terms list.', 'zerowp-term-colors' ) .'</p>';
			$output .= '</'. $td_tag .'>';
		$output .= '</'. $tr_tag .'>';

		return $output;
	}

	public function saveTerm( $term_id, $tt_id ){
		if( isset( $_POST[ $this->field_id ] ) ){
			$value =  sanitize_hex_color( trim( esc_html( $_POST[ $this->field_id ] ) ) );

			if( $this->color( $value )->isHex() ){
				update_term_meta( $term_id, $this->field_id, $value );
			}
			else{
				delete_term_meta( $term_id, $this->field_id );
			}

			$this->updateColorsArray( $term_id, $value );
		}
	}

	public function editTerm( $term_id, $tt_id ){
		$this->saveTerm( $term_id, $tt_id );
	}

	public function updateColorsArray( $term_id, $value ){
		$colors = get_option( $this->option_id, array() );

		$colors[ $term_id ] = $value;

		update_option( $this->option_id, $colors );
	}

	public function addColumn( $columns ){
		$columns[ $this->field_id ] = __( 'Color', 'zerowp-term-colors' );
		return $columns;
	}

	public function addColumnContent( $content, $column_name, $term_id ){
		if( $column_name !== $this->field_id ){
			return $content;
		}

		$term_id = absint( $term_id );
		$meta    = get_term_meta( $term_id, $this->field_id, true );
		$color   = !empty( $meta ) ? $meta : '#eee';

		$content .= '<div style="width: 24px; height: 24px; border-radius: 3px; background: '. $color .'"></div>';

		return $content;
	}

	public function color( $color ){
		return new Color( $color );
	}

}