<?php
/**
 * Created by PhpStorm.
 * User: straightvisions
 * Date: 07.08.2019
 * Time: 15:43
 */

namespace sv_provenexpert;

class rating extends modules {
	protected $icon_logo = '';
	protected $icon_star = '';
	
	public function init() {
		$this->register_scripts()
			 ->set_icons();
		
		// Shortcodes
		add_shortcode( $this->get_root()->get_prefix( $this->get_module_name() ), array( $this, 'shortcode' ) );
	}
	
	public function shortcode( $settings ) {
		$settings = shortcode_atts(
			array(
				'inline' => true,
			),
			$settings,
			$this->get_root()->get_prefix()
		);
		
		$this->get_script( 'default' )
			 ->set_inline( $settings['inline'] )
			 ->set_is_enqueued();
		
		return $this->output();
	}
	
	protected function register_scripts(): rating {
		$this->get_script( 'default' )
			 ->set_path( 'lib/frontend/css/default.css' );
		
		return $this;
	}
	
	protected function set_icons(): rating {
		ob_start();
		
		require_once( $this->get_path( 'lib/frontend/icon/logo.svg' ) );
		$this->icon_logo = ob_get_contents();
		
		ob_end_clean();
		
		ob_start();
		
		require_once( $this->get_path( 'lib/frontend/icon/star.svg' ) );
		$this->icon_star = ob_get_contents();
		
		ob_end_clean();
		
		return $this;
	}
	
	protected function output(): string {
		$summary 	= $this->get_parent()->api->get( 'rating/summary' );
		$profile 	= $this->get_parent()->api->get( 'profile' )->profile;
		
		ob_start();
		
		require_once( $this->get_path( 'lib/frontend/tpl/rating.php' ) );
		$output = ob_get_contents();
		
		ob_end_clean();
		
		return $output;
	}
}