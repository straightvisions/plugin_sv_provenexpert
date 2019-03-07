<?php
namespace sv_provenexpert;

class clear_cache extends widget {
	public function __construct() {
		$this->set_section_title( 'Tools' );
		$this->set_section_desc( 'Some helpfull tools, to manage the SV ProvenExpert Plugin.' );
		$this->set_section_type('tools');
	}
	/**
	 * @desc			initialize actions and filters
	 * @return	void
	 * @author			Matthias Bathke
	 * @since			1.0
	 */
	public function init() {
		$this->get_root()->add_section( $this )
			->set_section_template_path($this->get_path('lib/backend/tpl/tools.php'));
	}
}