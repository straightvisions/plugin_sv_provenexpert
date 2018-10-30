<?php
	namespace sv_provenexpert;

	/**
	 * @author			Matthias Reuter
	 * @package			sv_proven_expert
	 * @copyright		2017 Matthias Reuter
	 * @link			https://straightvisions.com
	 * @since			1.0
	 */
	class sv_provenexpert_settings extends sv_provenexpert {
		public $core																= NULL;
		public $settings_default													= false;
		public $settings															= false;
		private $forums																= array();
		private $forums_hierarchically												= array();
		private $forums_hierarchically_dropdown										= '';
		
		/**
		 * @desc			Loads other classes of package and defines available settings
		 * @author			Matthias Reuter
		 * @since			1.0
		 * @ignore
		 */
		public function __construct($core){
			$this->core																= isset($core->core) ? $core->core : $core; // loads common classes
			
			$this->settings_default													= array(
				'sv_provenexpert_settings'											=> 0,
				'basic'																=> array(
					'API_ID'														=> array(
						'name'														=> __('API ID', 'sv_provenexpert'),
						'type'														=> 'select',
						'placeholder'												=> '',
						'desc'														=> __('See API Username on', 'sv_provenexpert').' <a href="https://www.provenexpert.com/de/personalisierte-umfragelinks/">ProvenExpert.com</a>',
						'value'														=> '',
					),
					'API_KEY'														=> array(
						'name'														=> __('API Key', 'sv_provenexpert'),
						'type'														=> 'text',
						'placeholder'												=> '',
						'desc'														=> __('See API Key on', 'sv_provenexpert').' <a href="https://www.provenexpert.com/de/personalisierte-umfragelinks/">ProvenExpert.com</a>',
						'value'														=> '',
					)
				)
			);
		}
		/**
		 * @desc			initialize settings and set constants for IPBWI API
		 * @return	void
		 * @author			Matthias Reuter
		 * @since			1.0
		 */
		public function init(){
			// update settings
			$this->set_settings();
			
			// get settings
			$this->get_settings();
		}
		/**
		 * @desc			update settings
		 * @return	void
		 * @author			Matthias Reuter
		 * @since			1.0
		 */
		public function set_settings(){
			if(isset($_POST['sv_provenexpert_settings'])){
				if($_POST['sv_provenexpert_settings'] == 1){
					$options = get_option('sv_provenexpert');
					
					if($options && is_array($options)){
						$data														= array_replace_recursive($this->settings_default,$options,$_POST);
						$data														= $this->remove_inactive_checkbox_fields($data);
						$this->settings												= $data;
					}else{
						$data														= array_replace_recursive($this->settings_default,$_POST);
						$data														= $this->remove_inactive_checkbox_fields($data);
						$this->settings												= $data;
					}
					
					update_option('sv_provenexpert',$this->settings, true);
				}
			}
		}
		/**
		 * @desc			if checkbox fields are unchecked, update value to 0
		 * @param	int		$data settings data
		 * @return	array	updated settings data
		 * @author			Matthias Reuter
		 * @since			1.0
		 */
		private function remove_inactive_checkbox_fields($data){
			foreach($data as $group_name => $group){
				if(is_array($group)){
					foreach($group as $field_name => $field){
						if($field['type'] == 'checkbox'){
							$data[$group_name][$field_name]['value']				= (isset($_POST[$group_name][$field_name]['value']) ? 1 : 0);
						}
					}
				}
			}
			return $data;
		}
		/**
		 * @desc			get settings
		 * @return	array	settings array
		 * @author			Matthias Reuter
		 * @since			1.0
		 */
		public function get_settings(){
			if($this->settings){
				return $this->settings;
			}else{
				$this->settings														= array_replace_recursive($this->settings_default,(array)get_option('sv_provenexpert'));
				return $this->settings;
			}
		}
		/**
		 * @desc			get default settings
		 * @return	array	default settings
		 * @author			Matthias Reuter
		 * @since			1.0
		 */
		public function get_settings_default(){
			return $this->settings_default;
		}
		/**
		 * @desc			output the plugin action links
		 * @param	array	$actions default plugin action links
		 * @param	string	$plugin_file plugin's file name
		 * @return	array	updated plugin action links
		 * @author			Matthias Reuter
		 * @since			1.0
		 */
		public function plugin_action_links($actions, $plugin_file){
			if($this->core->basename == $plugin_file){
				$links																= array(
										'settings'									=> '<a href="admin.php?page=sv_proven_expert">'.__('Settings', 'sv_proven_expert').'</a>',
										'straightvisions'							=> '<a href="https://straightvisions.com">straightvisions.com</a>',
										'proven_expert'								=> '<a href="https://www.provenexpert.com/de/pa281/">ProvenExpert.com</a>',
										//'support'									=> '<a href="https://straightvisions.com/community/" target="_blank">'.__('Support', 'sv_proven_expert').'</a>',
										//'documentation'								=> '<a href="https://straightvisions.com" target="_blank">'.__('Documentation', 'sv_proven_expert').'</a>',
				);
				$actions															= array_merge($links, $actions);
			}
			return $actions;
		}
		/**
		 * @desc			ACP scripts and styles
		 * @param	string	$hook location in WP Admin
		 * @return	void	
		 * @author			Matthias Reuter
		 * @since			1.0
		 */
		public function acp_style($hook){
			if($hook == 'toplevel_page_sv_provenexpert'){
				wp_enqueue_style('sv_provenexpert_backend', $this->core->url.'lib/backend/css/default.css');
			}
		}
	}
?>