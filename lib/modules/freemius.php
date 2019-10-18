<?php
namespace sv_provenexpert;

class freemius extends init {
	public function __construct() {

	}

	public function init() {
		// Init Freemius.
		$this->load_sdk();
	}
	public function load_sdk() {
		global $sv_provenexpert_freemius;

		$sv_provenexpert_freemius = fs_dynamic_init( array(
			'id'                  => '4152',
			'slug'                => 'sv-provenexpert',
			'type'                => 'plugin',
			'public_key'          => 'pk_be2dc70708b2b697d780812ca1e2c',
			'is_premium'          => false,
			'has_paid_plans'      => false,
			/*'parent'              => array(
				'id'         => '4082',
				'slug'       => 'sv100-companion',
				'public_key' => 'pk_bb203616096bc726f69ca51a0bbe3',
				'name'       => 'SV100 Companion',
			),*/
			'menu'                => array(
				'slug'           => 'sv_provenexpert',
				'account'        => false,
				'parent'         => array(
					'slug' => 'straightvisions',
				),
			),
		) );
		
		do_action( 'sv_provenexpert_freemius_loaded' );

		return $sv_provenexpert_freemius;
	}
	function is_parent_active_and_loaded() {
		// Check if the parent's init SDK method exists.
		return $this->is_instance_active('sv100_companion');
	}

	function is_parent_active() {
		$active_plugins = get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$network_active_plugins = get_site_option( 'active_sitewide_plugins', array() );
			$active_plugins         = array_merge( $active_plugins, array_keys( $network_active_plugins ) );
		}

		foreach ( $active_plugins as $basename ) {
			if ( 0 === strpos( $basename, 'sv100-companion/' ) ||
				0 === strpos( $basename, 'sv100-companion-premium/' )
			) {
				return true;
			}
		}

		return false;
	}
}