<?php
namespace sv_provenexpert;

class rating extends modules {
	public function init() {
		$this->load_settings()
			 ->register_scripts()
			 ->create_widget();
		
		// Shortcodes
		add_shortcode( 'sv_provenexpert', array( $this, 'shortcode' ) );
		// Legacy
		add_shortcode( 'sv_proven_expert', array( $this, 'shortcode' ) );
	}
	
	protected function load_settings(): rating {
		$this->get_setting( 'template' )
			 ->set_title( __( 'Select what you wanna display.', 'sv_provenexpert' ) )
			 ->set_options( array(
			 	'default' 			=> __( 'Stars (Default)', 'sv_provenexpert' ),
				'seal' 				=> __( 'Seal', 'sv_provenexpert' ),
				'seal_slider' 		=> __( 'Seal Slider', 'sv_provenexpert' ),
				'seal_seperator'	=> __( 'Seal Seperator', 'sv_provenexpert' ),
				'evaluation' 		=> __( 'Evaluation', 'sv_provenexpert' ),
				'evaluation_large' 	=> __( 'Evaluation Large', 'sv_provenexpert' )
			 ) )
			 ->set_default_value( 'default' )
			 ->load_type( 'select' );
		
		return $this;
	}
	
	protected function register_scripts(): rating {
		$this->get_script( 'default' )
			 ->set_path( 'lib/frontend/css/default.css' );
		
		$this->get_script( 'seal' )
			 ->set_path( 'lib/frontend/css/seal.css' );
		
		$this->get_script( 'seal_slider' )
			 ->set_path( 'lib/frontend/css/seal_slider.css' );
		
		$this->get_script( 'seal_seperator' )
			 ->set_path( 'lib/frontend/css/seal_seperator.css' );
		
		$this->get_script( 'evaluation' )
			 ->set_path( 'lib/frontend/css/evaluation.css' );
		
		$this->get_script( 'evaluation_large' )
			 ->set_path( 'lib/frontend/css/evaluation_large.css' );
		
		$this->get_script( 'evaluation_large_js' )
			 ->set_path( 'lib/frontend/js/evaluation_large.js' )
			->set_deps( array( 'jquery' ) )
			 ->set_type( 'js' );
		
		return $this;
	}
	
	public function create_widget(): rating {
		$widget = static::$widgets
			->create( $this )
			->set_title( 'SV ProvenExpert' )
			->set_ID( $this->get_root()->get_prefix( $this->get_module_name() ) )
			->set_description( __( 'Show Review Stars in Google SERPs.', 'sv_posts' ) )
			->set_template_path( 'lib/frontend/tpl/widget.php' )
			->set_widget_settings( $this->get_settings() );
		
		$widget->set_widget_class_name( get_class( new class( $widget ) extends \sv_core\sv_widget{ protected static $sv; } ) )->load();

		return $this;
	}
	
	public function shortcode( $settings ): string {
		$settings = shortcode_atts(
			array(
				'inline' 	=> true,
				'template'	=> 'default',
				'is_widget' => false,
			),
			$settings,
			$this->get_root()->get_prefix()
		);
		
		return $this->router( $settings );
	}
	
	protected function router( array $settings ): string {
		if ( ! file_exists( $this->get_path( 'lib/frontend/tpl/' . $settings['template'] . '.php' ) ) ) {
			$settings['template'] = 'default';
		}
		
		$this->get_script( $settings['template'] )
			 ->set_inline( $settings['inline'] )
			 ->set_is_enqueued();
		
		switch ( $settings['template'] ) {
			case 'evaluation_large':
				$this->get_script( $settings['template'] . '_js' )
					 ->set_is_enqueued();
				break;
		}
		
		$summary 	= $this->get_parent()->api->request_get( 'rating/summary' );
		
		//@todo Below is original
		//$profile 	= $this->get_parent()->api->request_get( 'profile' )->profile;
		//$ratings	= $this->get_parent()->api->request_get( 'rating' )->ratings;
		
		//@todo Below is temporary for Jesko
		$profile				= (object)array();
		$profile->profileUrl	= 'https://www.provenexpert.com/de-de/strafverteidigung-fachanwalt-fuer-strafrecht-dr-baumhoefener/';
		$profile->company		= 'Strafverteidigung: Fachanwalt für Strafrecht Dr. Baumhöfener';
		$profile->avatarUrl		= 'https://images.provenexpert.com/7b/47/de646a924444909709d813eced38/strafverteidigung-fachanwalt-fuer-strafrecht-dr-baumhoefener_full_1565256763.jpg';
		
		$ratings = (object)array(
			'random_id_1' => (object)array(
				'created' => 1560423852,
				'ratingValue' => 5,
				'ratings' => (object)array(
					'category_0' => 5,
					'category_1' => 5,
					'category_2' => 5,
					'category_3' => 5,
					'category_4' => 5,
					'category_5' => 5,
					'category_6' => 4.80,
				),
				'feedback' => 'Ich möchte mich auf diesem Wege bei Herrn Dr. Baumhöfener bedanken. Er hat mich nach einem Urteil, welches mich aus der Bahn geworfen hat, sowohl in fachlicher Hinsicht als auch auf menschlicher Ebene mehr als nur gut betreut und ist den großen Weg der Revision gemeinsam mit mir gegangen. Er war stets erreichbar und konnte mir jedes noch so kleine und wichtige Detail erläutern, dass auch ich als Laie immer auf dem aktuellen Stand war.
Er ist mit Abstand der kompetenteste und professionellste Anwalt den ich bislang kennenlernen durfte und meine Entscheidung Herrn Dr. Baumhöfener für mein Revisionsverfahren zu verpflichten, war die beste Entscheidung die ich hätte treffen können. Ich kann nur Danke sagen.',
			),
			'random_id_2' => (object)array(
				'created' => 1559646461,
				'ratingValue' => 5,
				'ratings' => (object)array(
					'category_0' => 5,
					'category_1' => 5,
					'category_2' => 5,
					'category_3' => 5,
					'category_4' => 5,
					'category_5' => 5,
					'category_6' => 4.80,
				),
				'feedback' => 'Herr Dr. Baumhöfener hat mir durch seinen Riesen Einsatz ermöglicht, dass ich weiterhin eine Zukunft auf meiner Arbeit und mein Ansehen in der Öffentlichkeit nicht verloren habe.
Durch seine ruhige und sachliche Art hat er einem die Angst genommen vor dem was vor einem steht.
Er war immer ansprechbar bei fragen in der Strafsachen.
Wenn man das erste mal in so eine Situation kommt hat man viele schlaflose Nächte und sieht sich schon mit einem Bein im Gefängnis.
Durch eine geringe Geldstrafe bin ich nicht einmal vorbestraft und kann wieder in die Zukunft blicken.
Vielen Dank!!!!',
			),
			'random_id_3' => (object)array(
				'created' => 1555153661,
				'ratingValue' => 5,
				'ratings' => (object)array(
					'category_0' => 5,
					'category_1' => 5,
					'category_2' => 5,
					'category_3' => 5,
					'category_4' => 5,
					'category_5' => 5,
					'category_6' => 4.80,
				),
				'feedback' => 'Herr Dr. Baumhöfener hat mich sehr kompetent beraten und die Revision juristisch zum Erfolg geführt.

Er war für mich jederzeit erreichbar und auch kurzfristige Termine oder Absprachen waren problemlos möglich.

Ebenso zwischenmenschlich fühlte ich mich gut aufgehoben, ehrlich beraten und verstanden.

Persönlich kann ich jeden Herrn Dr. Baumhöfener empfehlen, wenn es um Revisionen geht!',
			),
		);

		ob_start();
		
		require_once( $this->get_path( 'lib/frontend/tpl/' . $settings['template'] . '.php' ) );
		$output = ob_get_contents();
		
		ob_end_clean();
		
		return $output;
	}
}