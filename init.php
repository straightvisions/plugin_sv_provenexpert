<?php
namespace sv_provenexpert;

if ( ! class_exists( '\sv_core\core_plugin' ) ) {
	require_once( dirname( __FILE__ ) . '/lib/core_plugin/core_plugin.php' );
}

class init extends \sv_core\core_plugin {
	const version 				= 2001;
	const version_core_match 	= 4017;
	
	public function load() {
		if ( ! $this->setup( __NAMESPACE__, __FILE__ ) ) {
			return false;
		}
		
		$section_privacy_text =
			'<p>'
			. $this->get_section_title() . ' does not collect or share any data from clients or visitors.<br />'
			. $this->get_section_title() . ' connects to the server of <a href="https://www.provenexpert.com/de/pa281/" target="_blank">ProvenExpert</a> and only sends the given API ID and API Key, to receive the rating for that account.
			</p>';
		
		$this->set_section_title( __( 'SV ProvenExpert', 'sv_provenexpert' ) )
			 ->set_section_desc( __( 'This plugin is build to show review stars retrieved via ProvenExpert on your site – additionally this enables review stars of your website’s entries in Google’s search engine result pages.', 'sv_provenexpert' ) )
			 ->set_section_privacy( $section_privacy_text );
		
		return $this;
	}
}

$GLOBALS[ __NAMESPACE__ ] = new init();
$GLOBALS[ __NAMESPACE__ ]->load();