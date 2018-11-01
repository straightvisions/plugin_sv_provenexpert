<?php
/*
Plugin Name: SV ProvenExpert
Plugin URI: https://straightvisions.com/
Description: Refactored version by A.C.
Version: 1.0.1
Author: Matthias Reuter
Author URI: https://straightvisions.com
Text Domain: sv_provenexpert
Domain Path: /languages
*/

namespace sv_provenexpert;

require_once('lib/core/core.php');

class init extends \sv_core\core {
    const version							= 1002;
    const version_core_match				= 1004;

    public function __construct(){
        $this->setup(__NAMESPACE__,__FILE__);

	    /**
	     * @desc			information for the about section
	     * @return	void
	     * @author			Matthias Reuter
	     * @since			1.0
	     */

        $this->set_section_title('SV ProvenExpert');
        $this->set_section_desc('Refactored version by A.C.'); //@todo change before deployment
    }
}

$GLOBALS[__NAMESPACE__]			= new init();