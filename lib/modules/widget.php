<?php
	namespace sv_provenexpert;

	/**
	 * @author			Matthias Bathke
	 * @package			sv_proven_expert
	 * @copyright		2017 Matthias Bathke
	 * @link			https://straightvisions.com
	 * @since			1.0
	 */
	class widget extends modules {
		protected static $widget_class_name = '';
		/**
		 * @desc			Loads other classes of package
		 * @author			Matthias Bathke
		 * @since			1.0
		 * @ignore
		 */
		public function __construct() {

		}
		/**
		 * @desc			initialize actions and filters
		 * @return	void
		 * @author			Matthias Bathke
		 * @since			1.0
		 */
		public function init() {
			$this->scripts_queue['frontend']		= static::$scripts->create( $this )
										 ->set_ID( 'frontend' )
										 ->set_path( 'lib/frontend/css/widget.css' );
			
			$widget					= static::$widgets->create( $this );
			$widget->set_title( __( 'SV ProvenExpert',$this->get_root()->get_prefix() ) );
			$widget->set_ID($this->get_prefix());
			$widget->set_description( __( 'Show Review Stars in Google SERPs',$this->get_root()->get_prefix() ) );
			$widget->set_template_path( $this, 'lib/frontend/tpl/widget.php' );
			$widget->set_widget_settings($this->get_parent()->common_settings->s );
			
			static::$widget_class_name  = $widget->set_widget_class_name(get_class(new class($widget) extends \sv_core\sv_widget{protected static $sv;}))->load();
			
			add_shortcode( 'sv_provenexpert', array( $this, 'shortcode' ) );
			
			// legacy
			add_shortcode( 'sv_proven_expert', array( $this, 'shortcode' ) );

			$this->clear_cache->init();
		}

		public function shortcode() {
			ob_start();
			the_widget(static::$widget_class_name, array(), array(
				'before_widget'										=> '',
				'after_widget'										=> '',
				'before_title'										=> '',
				'after_title'										=> ''
			) );
			$output													= ob_get_contents();
			ob_end_clean();
			return $output;
		}
	}