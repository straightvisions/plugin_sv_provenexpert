<?php
namespace sv_provenexpert;

class rating extends modules {
	public function init() {
		$this->load_settings()
			 ->register_scripts()
			 ->create_widget();
		
		// Shortcodes
		add_shortcode( $this->get_root()->get_prefix( $this->get_module_name() ), array( $this, 'shortcode' ) );
	}
	
	protected function load_settings(): rating {
		$this->get_setting( 'template' )
			 ->set_title( __( 'Select what you wanna display.', 'sv_provenexpert' ) )
			 ->set_options( array(
			 	'default' 			=> __( 'Stars (Default)', 'sv_provenexpert' ),
				'seal' 				=> __( 'Seal', 'sv_provenexpert' ),
				'seal_slider' 		=> __( 'Seal Slider', 'sv_provenexpert' ),
				'seal_seperator'	=> __( 'Seal Seperator', 'sv_provenexpert' ),
				'evaluation' 		=> __( 'Evaluation', 'sv_provenexpert' ),
				'evaluation_large' 	=> __( 'Evaluation Large', 'sv_provenexpert' )
			 ) )
			 ->set_default_value( 'default' )
			 ->load_type( 'select' );
		
		return $this;
	}
	
	protected function register_scripts(): rating {
		$this->get_script( 'default' )
			 ->set_path( 'lib/frontend/css/default.css' );
		
		$this->get_script( 'seal' )
			 ->set_path( 'lib/frontend/css/seal.css' );
		
		$this->get_script( 'seal_slider' )
			 ->set_path( 'lib/frontend/css/seal_slider.css' );
		
		$this->get_script( 'seal_seperator' )
			 ->set_path( 'lib/frontend/css/seal_seperator.css' );
		
		$this->get_script( 'evaluation' )
			 ->set_path( 'lib/frontend/css/evaluation.css' );
		
		$this->get_script( 'evaluation_large' )
			 ->set_path( 'lib/frontend/css/evaluation_large.css' );
		
		$this->get_script( 'evaluation_large_js' )
			 ->set_path( 'lib/frontend/js/evaluation_large.js' )
			->set_deps( array( 'jquery' ) )
			 ->set_type( 'js' );
		
		return $this;
	}
	
	public function create_widget(): rating {
		$widget = static::$widgets
			->create( $this )
			->set_title( 'SV ProvenExpert' )
			->set_ID( $this->get_root()->get_prefix( $this->get_module_name() ) )
			->set_description( __( 'Show Review Stars in Google SERPs.', 'sv_posts' ) )
			->set_template_path( 'lib/frontend/tpl/widget.php' )
			->set_widget_settings( $this->get_settings() );
		
		$widget->set_widget_class_name( get_class( new class( $widget ) extends \sv_core\sv_widget{ protected static $sv; } ) )->load();

		return $this;
	}
	
	public function shortcode( $settings ): string {
		$settings = shortcode_atts(
			array(
				'inline' 	=> true,
				'template'	=> 'default',
				'is_widget' => false,
			),
			$settings,
			$this->get_root()->get_prefix()
		);
		
		return $this->router( $settings );
	}
	
	protected function router( array $settings ): string {
		if ( ! file_exists( $this->get_path( 'lib/frontend/tpl/' . $settings['template'] . '.php' ) ) ) {
			$settings['template'] = 'default';
		}
		
		$this->get_script( $settings['template'] )
			 ->set_inline( $settings['inline'] )
			 ->set_is_enqueued();
		
		switch ( $settings['template'] ) {
			case 'evaluation_large':
				$this->get_script( $settings['template'] . '_js' )
					 ->set_is_enqueued();
				break;
		}
		
		$ratings	= $this->get_parent()->api->request_get( 'rating' )->ratings;
		$summary 	= $this->get_parent()->api->request_get( 'rating/summary' );
		$profile 	= $this->get_parent()->api->request_get( 'profile' )->profile;

		ob_start();
		
		require_once( $this->get_path( 'lib/frontend/tpl/' . $settings['template'] . '.php' ) );
		$output = ob_get_contents();
		
		ob_end_clean();
		
		return $output;
	}
}