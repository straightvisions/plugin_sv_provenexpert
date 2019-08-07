<?php
namespace sv_provenexpert;

class api extends modules {
	protected $api_endpoint = 'https://www.provenexpert.com/api/';
	protected $api_version	= 'v1';
	
	public function init() {
		// Section Info
		$this->set_section_title( __( 'API', 'sv_provenexpert' ) )
			 ->set_section_desc( __( 'API Settings', 'sv_provenexpert' ) )
			 ->set_section_type( 'settings' )
			 ->set_section_template_path( $this->get_path( 'lib/backend/tpl/settings.php' ) );
		
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
	
	public function get_api_url( $suffix = '' ): string {
		return $this->api_endpoint . $this->api_version . '/' . $suffix;
	}
	
	protected function get_request_url( string $service, string $function ): string {
		return $this->get_api_url( $service . '/' . $function );
	}
	
	protected function send_request( string $service, string $function ) {
		$api_id 		= $this->get_setting( 'api_id' )->run_type()->get_data();
		$api_key		= $this->get_setting( 'api_key' )->run_type()->get_data();
		$request_url 	= $this->get_request_url( $service, $function );
		$request_args 	= array(
			'method' 	=> 'POST',
			'headers' 	=> array(
				'Authorization' => 'Basic ' . base64_encode( $api_id . ':' . $api_key ),
			),
		);
		
		$remote_get = $this->get_root()::$remote_get->create( $this )
													->set_request_url( $request_url )
													->set_args( $request_args );

		
		return json_decode( $remote_get->get_response_body() );
	}
	
	public function get( $service = 'auth/url' ) {
		return $this->send_request( $service, 'get' );
	}
	
	public function create( $service = 'auth/url' ) {
		return $this->send_request( $service, 'create' );
	}
	
	public function update( $service = 'auth/url' ) {
		return $this->send_request( $service, 'update' );
	}
}