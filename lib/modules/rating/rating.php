<?php
namespace sv_provenexpert;

class rating extends modules {
	public function init() {
		$this->register_scripts();
		
		// Shortcodes
		add_shortcode( $this->get_root()->get_prefix( $this->get_module_name() ), array( $this, 'shortcode' ) );
	}
	
	protected function register_scripts(): rating {
		$this->get_script( 'default' )
			 ->set_path( 'lib/frontend/css/default.css' );
		
		$this->get_script( 'line' )
			 ->set_path( 'lib/frontend/css/line.css' );
		
		return $this;
	}
	
	public function shortcode( $settings ): string {
		$settings = shortcode_atts(
			array(
				'inline' 	=> true,
				'template'	=> 'default',
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
		
		$summary 	= $this->get_parent()->api->request_get( 'rating/summary' );
		$profile 	= $this->get_parent()->api->request_get( 'profile' )->profile;
		
		ob_start();
		
		require_once( $this->get_path( 'lib/frontend/tpl/' . $settings['template'] . '.php' ) );
		$output = ob_get_contents();
		
		ob_end_clean();
		
		return $output;
	}
}