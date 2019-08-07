<?php
namespace sv_provenexpert;

class modules extends init {
	public function __construct() {
	
	}
	
	public function init() {
		//$this->playground->init();
		$this->api->init();
		$this->rating->init();
	}
}