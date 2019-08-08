<?php
namespace sv_provenexpert;

class icon extends modules {
	protected static $icons = array();
	
	public function init() {
		$this->register_icons();
	}
	
	protected function register_icons(): icon {
		$icons = glob( $this->get_path( 'lib/frontend/icon/*' ) );
		
		foreach ( $icons as $icon ) {
			$this->set( basename( $icon, '.svg' ), $icon );
		}
		
		return $this;
	}
	
	public function set( string $name, string $embed ): icon {
		if ( ! empty( $name ) && ! empty( $embed ) ) {
			static::$icons[ $name ] = $embed;
		}
		
		return $this;
	}
	
	public function get( string $name ): string {
		$icon = '';
		
		if ( isset( static::$icons[ $name ] ) && ! empty( static::$icons[ $name ] ) ) {
			ob_start();
			include static::$icons[ $name ];
			
			$icon = ob_get_contents();
			ob_end_clean();
		}
		
		return $icon;
	}
}