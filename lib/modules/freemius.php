<?php
	namespace sv_provenexpert;
	
	class freemius extends init {
		public function __construct() {
		
		}
		
		public function init() {
			$this->load_sdk();
			do_action( 'sv_provenexpert_freemius_loaded' );
		}
		
		public function load_sdk() {
			global $sv_provenexpert_freemius;
			
			if ( ! isset( $sv_provenexpert_freemius ) ) {
				$sv_provenexpert_freemius = fs_dynamic_init( array(
					'id'                  => '4148',
					'slug'                => 'sv-provenexpert',
					'type'                => 'plugin',
					'public_key'          => 'pk_c679990cc0cb910abc28b69b4913f',
					'is_premium'          => false,
					'has_addons'          => true,
					'has_paid_plans'      => false,
					'menu'                => array(
						'slug'           => 'sv_provenexpert',
						'parent'         => array(
							'slug' => 'straightvisions',
						),
					),
				) );
			}
			
			return $sv_provenexpert_freemius;
		}
	}