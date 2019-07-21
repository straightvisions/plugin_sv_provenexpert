<?php
namespace sv_provenexpert;

if(!class_exists('\sv_core\core_plugin')) {
	require_once(dirname(__FILE__) . '/lib/core_plugin/core_plugin.php');
}

class init extends \sv_core\core_plugin {
	const version = 1400;
	const version_core_match = 4005;

	public function load(){
		if(!$this->setup( __NAMESPACE__, __FILE__ )){
			return false;
		}

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
$GLOBALS[ __NAMESPACE__ ]->load();