<?php
/**
 * Created by PhpStorm.
 * User: straightvisions
 * Date: 07.08.2019
 * Time: 15:43
 */

namespace sv_provenexpert;

class rating extends modules {
	protected $icon_logo = '';
	protected $icon_star = '';
	
	public function init() {
		$this->register_scripts()
			 ->set_icons();
		
		// Shortcodes
		add_shortcode( $this->get_root()->get_prefix( $this->get_module_name() ), array( $this, 'shortcode' ) );
	}
	
	public function shortcode( $settings ) {
		$settings = shortcode_atts(
			array(
				'inline' => true,
			),
			$settings,
			$this->get_root()->get_prefix()
		);
		
		$this->get_script( 'default' )
			 ->set_inline( $settings['inline'] )
			 ->set_is_enqueued();
		
		return $this->output();
	}
	
	protected function register_scripts(): rating {
		$this->get_script( 'default' )
			 ->set_path( 'lib/frontend/css/default.css' );
		
		return $this;
	}
	
	protected function set_icons(): rating {
		ob_start();
		
		require_once( $this->get_path( 'lib/frontend/icon/logo.svg' ) );
		$this->icon_logo = ob_get_contents();
		
		ob_end_clean();
		
		ob_start();
		
		require_once( $this->get_path( 'lib/frontend/icon/star.svg' ) );
		$this->icon_star = ob_get_contents();
		
		ob_end_clean();
		
		return $this;
	}
	
	protected function output(): string {
		$output 	= array();
		$summary 	= $this->get_parent()->api->get( 'rating/summary' );
		$profile 	= $this->get_parent()->api->get( 'profile' )->profile;
		
		// Wrapper
		$output[] = '<div class="' . $this->get_prefix() . '">';
		$output[] = '<div class="' . $this->get_prefix( 'wrapper' ) . '">';
		
		// Header
		$output[] = '<div class="' . $this->get_prefix( 'header' ) . '">';
		
		// Header - Company
		$output[] = '<span class="' . $this->get_prefix( 'company' ) . '">' . $profile->company . '</span>';
		
		// Header - Logo
		$output[] = '<div class="' . $this->get_prefix( 'logo' ) . '">' . $this->icon_logo . '</div>';
		
		// Header - Description
		$output[] = '<span class="' . $this->get_prefix( 'desc' ) . '">Kundenbewertungen</span>';
		
		// Header - End
		$output[] = '</div>';
		
		// Body
		$output[] = '<div class="' . $this->get_prefix( 'body' ) . '">';
		
		// Body - Stars
		$output[] = '<div class="' . $this->get_prefix( 'stars' ) . '">';
		
		for( $i = 0; $i < $summary->ratingValue; $i++ ) {
			$output[] = $this->icon_star;
		}
		
		$output[] = '</div>';
		
		// Body - End
		$output[] = '</div>';
		
		// Footer
		$output[] = '<div class="' . $this->get_prefix( 'footer' ) . '">';
		
		// Footer - Rreviews
		$output[] = '<span class="' . $this->get_prefix( 'reviews' ) . '">' . $summary->reviewCount . ' Kundenbewertungen</span>';
		
		// Footer - Meta
		$output[] = '<div class="' . $this->get_prefix( 'meta' ) . '">';
		$output[] = '<span class="' . $this->get_prefix( 'date' ) . '">' . current_time( 'd.m.Y', true ) . '</span>';
		$output[] = '<span class="' . $this->get_prefix( 'more_info' ) . '"><a href="" target="_blank">Mehr Infos</a></span>';
		$output[] = '</div>';
		
		// Footer - End
		$output[] = '</div>';
		
		// Wrapper - End
		$output[] = '</div></div>';
		
		ob_start();
		
		echo implode( '', $output );
		$output = ob_get_contents();
		
		ob_end_clean();
		
		return $output;
	}
}