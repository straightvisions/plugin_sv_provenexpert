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
}

$GLOBALS[__NAMESPACE__]			= new init();