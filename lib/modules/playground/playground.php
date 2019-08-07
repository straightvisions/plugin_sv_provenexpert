<?php
namespace sv_provenexpert;

class playground extends modules {
	public function init() {
		// Section Info
		$this->set_section_title( __( 'Playground', 'sv_provenexpert' ) )
			 ->set_section_desc( __( 'Playground for the enterprise API', 'sv_provenexpert' ) )
			 ->set_section_type( 'settings' )
			 ->set_section_template_path( $this->get_path( 'lib/backend/tpl/playground.php' ) );
		
		$this->get_root()->add_section( $this );
		
		// Load settings, register scripts and sidebars
		$this->load_settings();
	}
	
	public function load_settings() {
		$this->get_setting( 'api_id' )
			 ->set_title( __( 'API ID', 'sv_provenexpert' ) )
			 ->set_description( __( 'See API Username on', 'sv_provenexpert' ) . ' <a href="https://www.provenexpert.com/de/personalisierte-umfragelinks/" target="_blank">ProvenExpert.com</a>' )
			 ->set_maxlength( 32 )
			 ->set_minlength( 32 )
			 ->set_required( true )
			 ->load_type( 'text' );
		
		$this->get_setting( 'api_key' )
			 ->set_title( __( 'API Key', 'sv_provenexpert' ) )
			 ->set_description( __( 'See API Key on', 'sv_provenexpert' ) . ' <a href="https://www.provenexpert.com/de/personalisierte-umfragelinks/" target="_blank">ProvenExpert.com</a>' )
			 ->set_maxlength( 43 )
			 ->set_minlength( 43 )
			 ->set_required( true )
			 ->load_type( 'text' );
		
		return $this;
	}
}