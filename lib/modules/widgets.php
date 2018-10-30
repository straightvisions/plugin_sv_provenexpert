<?php
	namespace sv_provenexpert;

	/**
	 * @author			Matthias Reuter
	 * @package			sv_proven_expert
	 * @copyright		2017 Matthias Reuter
	 * @link			https://straightvisions.com
	 * @since			1.0
	 */
	class sv_proven_expert_widgets extends sv_provenexpert {
		public $core												= NULL;
		
		/**
		 * @desc			Loads other classes of package
		 * @author			Matthias Reuter
		 * @since			1.0
		 * @ignore
		 */
		public function __construct($core){
			$this->core												= isset($core->core) ? $core->core : $core; // loads common classes
		}
		/**
		 * @desc			initialize actions and filters
		 * @return	void
		 * @author			Matthias Reuter
		 * @since			1.0
		 */
		public function init(){

		}
		public function shortcode(){
			ob_start();
			the_widget('sv_proven_expert_widget',array(
				'before_widget'										=> '',
				'after_widget'										=> '',
				'before_title'										=> '',
				'after_title'										=> ''
			));
			$output													= ob_get_contents();
			ob_end_clean();
			return $output;
		}
	}
	class sv_proven_expert_widget extends WP_Widget{

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct(){
			$widget_ops												= array( 
				'classname'											=> 'sv_proven_expert_widget',
				'description'										=> __('Show Review Stars in Google SERPs', 'sv_proven_expert'),
			);
			parent::__construct('sv_proven_expert_widget', 'SV ProvenExpert.com', $widget_ops);
		}

		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget($args, $instance){
			$output													= $GLOBALS['plugin_sv_proven_expert']->curl->output();
			$output													= str_replace(' xmlns:v="http://rdf.data-vocabulary.org/#"', '', $output); // fix W3C error
			echo $output;
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form($instance){
			// outputs the options form on admin
		}

		/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update($new_instance, $old_instance){
			// processes widget options to be saved
		}
	}
?>