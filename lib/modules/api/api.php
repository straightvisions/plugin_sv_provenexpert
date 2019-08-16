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
	
	// Methods for getting information
	public function get_api_url( $suffix = '' ): string {
		return $this->api_endpoint . $this->api_version . '/' . $suffix;
	}
	
	protected function get_request_url( string $service, string $function ): string {
		return $this->get_api_url( $service . '/' . $function );
	}
	
	public function get_rating_stars( $rating = 0 ): string {
		$stars = array();
		
		for ( $i = 0; $i < $rating; $i++ ) {
			$stars[] = $this->get_parent()->icon->get( 'star' );
		}
		
		return implode( '', $stars );
	}
	
	public function get_rating_percentage( $rating = 0 ): int {
		$max_rating = 5;
		
		return round( ( $rating / $max_rating ) * 100 );
	}
	
	public function get_rating_text( $rating = 0 ): string {
		$text = '';
		
		switch ( round( $rating ) ) {
			case 0:
			case 1:
				$text = __( 'Mangelhaft', 'sv_provenexpert' );
				break;
			case 2:
				$text = __( 'Ausreichend', 'sv_provenexpert' );
				break;
			case 3:
				$text = __( 'Zufriedenstellend', 'sv_provenexpert' );
				break;
			case 4:
				$text = __( 'Gut', 'sv_provenexpert' );
				break;
			case 5:
				$text = __( 'Sehr Gut', 'sv_provenexpert' );
				break;
		}
		
		return $text;
	}
	
	public function get_competences( $max = 3 ): string {
		
		return '';
	}
	
	// Methods for sending requests to the PE API
	protected function send_request( array $args ) {
		$api_id 		= $this->get_setting( 'api_id' )->run_type()->get_data();
		$api_key		= $this->get_setting( 'api_key' )->run_type()->get_data();
		$request_url 	= $this->get_request_url( $args['service'], $args['function'] );
		$request_data	= array(
			'proxyUser' 	=> array(
				'email' 	=> 'billing@straightvisions.com',
			),
			'filter'		=> $args['filter'],
		);
		$request_args 	= array(
			'method' 	=> 'POST',
			'headers' 	=> array(
				'Authorization' => 'Basic ' . base64_encode( $api_id . ':' . $api_key ),
			),
			'body'		=> json_encode( $request_data ),
		);
		
		$remote_get = $this->get_root()::$remote_get->create( $this )
													->set_request_url( $request_url )
													->set_args( $request_args );

		
		return json_decode( $remote_get->get_response_body() );
	}
	
	public function request_get( $service = 'auth/url', $filter = array() ) {
		$args = array(
			'service'	=> $service,
			'function'	=> 'get',
			'filter'	=> $filter,
		);
		
		return $this->send_request( $args );
	}
	
	public function request_create( $service = 'auth/url', $filter = array() ) {
		$args = array(
			'service'	=> $service,
			'function'	=> 'create',
			'filter'	=> $filter,
		);
		
		return $this->send_request( $args );
	}
	
	public function request_update( $service = 'auth/url', $filter = array() ) {
		$args = array(
			'service'	=> $service,
			'function'	=> 'update',
			'filter'	=> $filter,
		);
		
		return $this->send_request( $args );
	}
	
	public function request_children( $service = 'auth/url', $filter = array() ) {
		$args = array(
			'service'	=> $service,
			'function'	=> 'children',
			'filter'	=> $filter,
		);
		
		return $this->send_request( $args );
	}
}