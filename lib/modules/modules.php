<?php
namespace sv_provenexpert;

class modules extends init {
	/**
	 * @desc			Loads other classes of package
	 * @author			Matthias Reuter
	 * @since			1.0
	 * @ignore
	 */
	public function __construct() {
		$this->set_section_title( 'Common Settings' );
		$this->set_section_desc( 'General Basic Settings' );
	}
	/**
	 * @desc			initialize actions and filters
	 * @return	void
	 * @author			Matthias Reuter
	 * @since			1.0
	 */
	public function init() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'init', array( $this, 'wp_init' ) );
	}
	private function load_settings() {
		$this->get_root()->add_section( $this, 'settings' );

		$api_id             = '1twp2Nmpj8TpmqGB1xGZ3pQZ3RQBj5zA';
		$api_key            = 'BQOuA2VlLGt3BGZ2LJLlMJAuL2ZmMQSxLzLjMGDmA2H';

		$this->s['api_id']	= static::$settings->create($this)
			->set_ID('api_id')
			->set_title( __( 'API ID', $this->get_module_name() ) )
			->set_description( __( 'See API Username on', $this->get_module_name() ) . ' <a href="https://www.provenexpert.com/de/personalisierte-umfragelinks/" target="_blank">ProvenExpert.com</a>' )
			->load_type('text');

		$this->s['api_key']	= static::$settings->create($this)
			->set_ID('api_key')
			->set_title( __( 'API Key', $this->get_module_name() ) )
			->set_description( __( 'See API Key on', $this->get_module_name() ) . ' <a href="https://www.provenexpert.com/de/personalisierte-umfragelinks/" target="_blank">ProvenExpert.com</a>' )
			->load_type('text');
	}
	public function admin_init() {
		$this->load_settings();
	}
	public function wp_init() {
		if( !is_admin() ){
			$this->load_settings();
			add_action( 'wp_head', array( $this, 'wp_head' ), 1000 );
		}
	}
}