<?php
	namespace sv_provenexpert;

	class common_settings extends modules {
		public function __construct() {
			$this->set_section_type('settings');
		}
		/**
		 * @desc			initialize actions and filters
		 * @return	void
		 * @author			Matthias Bathke
		 * @since			1.0
		 */
		public function init() {
			$this->get_root()->add_section( $this );
			$this->set_section_title( __('API Settings', $this->get_root()->get_prefix()) );
			$this->set_section_desc( sprintf(__('Fill out the API settings and add the widget or shortcode %s to your site. This will show review stars on your site and in Google search engine result pages.', $this->get_root()->get_prefix()), '<strong>[sv_provenexpert]</strong>') );
			
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'init', array( $this, 'wp_init' ) );
		}
		private function load_settings() {
			$this->s['api_id']	= static::$settings->create($this)
				->set_ID('api_id')
				->set_title( __( 'API ID', $this->get_root()->get_prefix() ) )
				->set_description( __( 'See API Username on', $this->get_root()->get_prefix() ) . ' <a href="https://www.provenexpert.com/de/personalisierte-umfragelinks/" target="_blank">ProvenExpert.com</a>' )
				->set_maxlength( 32 )
				->set_minlength( 32 )
				->set_required( true )
				->load_type( 'text' );

			$this->s['api_key']	= static::$settings->create($this)
				->set_ID('api_key')
				->set_title( __( 'API Key', $this->get_root()->get_prefix() ) )
				->set_description( __( 'See API Key on', $this->get_root()->get_prefix() ) . ' <a href="https://www.provenexpert.com/de/personalisierte-umfragelinks/" target="_blank">ProvenExpert.com</a>' )
				->set_maxlength( 43 )
				->set_minlength( 43 )
				->set_required( true )
				->load_type( 'text' );
		}
		public function admin_init() {
			$this->load_settings();
		}
		public function wp_init() {
			if( !is_admin() ){
				$this->load_settings();
			}
		}
	}