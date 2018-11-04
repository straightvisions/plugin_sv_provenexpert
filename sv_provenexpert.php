<?php
/*
Plugin Name: SV ProvenExpert
Plugin URI: https://straightvisions.com/
Description: Show rating stars via ProvenExpert.com in WordPress..
Version: 1.0.5
Author: Matthias Reuter
Author URI: https://straightvisions.com
Text Domain: sv_provenexpert
Domain Path: /languages
*/

namespace sv_provenexpert;

require_once('lib/core/core.php');

class init extends \sv_core\core {
    const version							= 1005;
    const version_core_match				= 1005;

    public function __construct(){
        $this->setup(__NAMESPACE__,__FILE__);

	    /**
	     * @desc			information for the about section
	     * @return	void
	     * @author			Matthias Reuter
	     * @since			1.0
	     */

        $this->set_section_title('SV ProvenExpert');
        $this->set_section_desc('Show rating stars via ProvenExpert.com in WordPress..'); //@todo change before deployment
    }
    public function update_routine() {
		if( $this->get_previous_version() < 1005 ) {
			$settings = $this->modules->common_settings->get_settings();
			$options            = get_option( 'sv_proven_expert' );

			foreach ( $options['basic'] as $key => $option) {
				if( $key == 'API_ID' && isset($option['value'])) {
					$settings['api_id']->run_type()->set_data($option['value'])->save_option();
				} else if( $key == 'API_KEY' && isset($option['value']) ) {
					$settings['api_key']->run_type()->set_data($option['value'])->save_option();
				}
			}
		}

		parent::update_routine();
    }
}

$GLOBALS[__NAMESPACE__]			= new init();