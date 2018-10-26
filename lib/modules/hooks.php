<?php
	/**
	 * @author			Matthias Reuter
	 * @package			sv_proven_expert
	 * @copyright		2017 Matthias Reuter
	 * @link			https://straightvisions.com
	 * @since			1.0
	 */
	class sv_proven_expert_hooks extends sv_proven_expert{
		public $core					= NULL;
		
		/**
		 * @desc			Loads other classes of package
		 * @author			Matthias Reuter
		 * @since			1.0
		 * @ignore
		 */
		public function __construct($core){
			$this->core					= isset($core->core) ? $core->core : $core; // loads common classes
		}
		/**
		 * @desc			initialize actions and filters
		 * @return	void
		 * @author			Matthias Reuter
		 * @since			1.0
		 */
		public function init(){
			$this->actions();
			$this->filters();
		}
		/**
		 * @desc			initialize actions
		 * @return	void
		 * @author			Matthias Reuter
		 * @since			1.0
		 */
		public function actions(){
			add_action('admin_menu', array($this->core->settings, 'get_settings_menu'));
			add_action('admin_enqueue_scripts', array($this->core->settings, 'acp_style'));
			add_action('widgets_init', function(){register_widget('sv_proven_expert_widget');});
			add_shortcode('sv_proven_expert', array($this->core->widgets, 'shortcode'));
		}
		/**
		 * @desc			initialize filters
		 * @return	void
		 * @author			Matthias Reuter
		 * @since			1.0
		 */
		public function filters(){
			add_filter('plugin_action_links', array($this->core->settings,'plugin_action_links'), 10, 5);
		}
		public function wp_enqueue_scripts(){
			wp_enqueue_style('sv_bb_admin_frontend', $this->core->url.'lib/css/frontend.css');
		}
	}
?>