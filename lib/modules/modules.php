<?php
namespace sv_provenexpert;

class modules extends init {
	public function init() {
		$this->api->init();
		$this->icon->init();
		$this->rating->init();
	}
}