<?php
/*
Plugin Name: SV ProvenExpert
Plugin URI: https://straightvisions.com/
Description: Show rating stars via ProvenExpert.com in WordPress.
Version: 1.3.17
Author: straightvisions GmbH
Author URI: https://straightvisions.com
Text Domain: sv_provenexpert
Domain Path: /languages
*/

namespace sv_provenexpert;

$min_php = '7.0.0';
$name = 'SV ProvenExpert';

if(version_compare( phpversion(), $min_php, '>=' )) {
	require_once( 'lib/core/core.php' );
	
	class init extends \sv_core\core {
		const version = 1317;
		const version_core_match = 3132;
		
		public function __construct() {
			if(!$this->setup( __NAMESPACE__, __FILE__ )){
				return false;
			}
			
			/**
			 * @desc            information for the about section
			 * @return    void
			 * @author            Matthias Bathke
			 * @since            1.0
			 */
			
			$this->set_section_title( __( 'SV ProvenExpert', $this->get_root()->get_prefix() ) );
			$this->set_section_desc( __( 'This plugin is build to show review stars retrieved via ProvenExpert on your site – additionally this enables review stars of your website’s entries in Google’s search engine result pages.', $this->get_root()->get_prefix() ) );
			$this->set_section_privacy( '<p>
				' . $this->get_section_title() . ' does not collect or share any data from clients or visitors.<br />
				' . $this->get_section_title() . ' connects to the server of <a href="https://www.provenexpert.com/de/pa281/" target="_blank">ProvenExpert</a> and only sends the given API ID and API Key, to receive the rating for that account.
			</p>' );
		}
		
		public function update_routine() {
			if ( $this->get_previous_version() < 1005 ) {
				$settings = $this->modules->common_settings->get_settings();
				$options  = get_option( 'sv_proven_expert' );
				
				foreach ( $options['basic'] as $key => $option ) {
					if ( $key == 'API_ID' && isset( $option['value'] ) ) {
						$settings['api_id']->run_type()->set_data( $option['value'] )->save_option();
					} else if ( $key == 'API_KEY' && isset( $option['value'] ) ) {
						$settings['api_key']->run_type()->set_data( $option['value'] )->save_option();
					}
				}
				
				// legacy settings
				delete_option( 'sv_proven_expert' );
				delete_option( 'widget_sv_provenexpert_widget' );
			}
			
			parent::update_routine();
		}
	}
	
	$GLOBALS[ __NAMESPACE__ ] = new init();
}else{
	require_once('lib/core/php_version.php');
	add_action('init', function(){
		\deactivate_plugins(plugin_basename( __FILE__ ) );
	});
}