<?php
namespace sv_provenexpert;

class modules extends init {
	public function __construct() {

	}
	/**
	 * @desc			initialize modules
	 * @return	void
	 * @author			Matthias Reuter
	 * @since			1.0
	 */
	public function init() {
		$this->common_settings->init();
		$this->widget->init();
	}
}