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
			$widget					= static::$widgets->create( $this );
			$widget->set_title( __( 'SV ProvenExpert.com', $this->get_name() ) );
			$widget->set_ID($this->get_prefix());
			$widget->set_description( __( 'Show Review Stars in Google SERPs', $this->get_name() ) );
			$widget->set_template_path( $this->get_path_lib_section( 'frontend','tpl','widget.php' ) );
			$widget->set_widget_settings( array() );
			static::$widget_class_name  = $widget->load();

			add_shortcode( 'sv_provenexpert', array( $this, 'shortcode' ) );

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