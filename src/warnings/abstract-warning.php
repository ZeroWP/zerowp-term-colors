<?php 
abstract class ZTCOLORS_Astract_Warning{

	protected $page_slug = 'ztcolors-fail-notice';

	public function __construct( $data = false ){
		$this->data = $data;
		$this->plugin_title = ztcolors_config( 'plugin_name' );

		add_action( 'admin_menu', array( $this, 'register' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'style' ) );
	}

	abstract public function notice();
	
	public function renderNotice(){
		echo '<div class="'. $this->page_slug .'">'. 
			
			'<h1>' . ztcolors_config( 'plugin_name' ) .'</h1>' .
			$this->notice() 

		.'</div>';
	}

	public function register(){
		add_menu_page( 
			$this->plugin_title,
			$this->plugin_title,
			'manage_options',
			$this->page_slug,
			array( $this, 'renderNotice' ),
			'dashicons-warning',
			60
		); 
	}

		
	public function style(){
		if( is_admin() && isset( $_GET['page'] ) && ($this->page_slug === $_GET['page']) ){
			wp_enqueue_style( 'ztcolors-fail-notice', ZTCOLORS_URL . 'warnings/style.css', false, ZTCOLORS_VERSION );
		}
	}

}