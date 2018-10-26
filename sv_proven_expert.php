<?php
	/*
	Plugin Name: SV ProvenExpert
	Plugin URI: https://straightvisions.com
	Description: Show Review Stars via ProvenExpert.com in WordPress
	Version: 1.0.4
	Text Domain: sv_proven_expert
	Domain Path: /lib/assets/lang
	Author: Matthias Reuter
	License: GPL3
	License URI: https://www.gnu.org/licenses/gpl-3.0.html
	*/

	class sv_proven_expert{
		public $basename							= NULL;
		public $path								= NULL;
		public $url									= NULL;
		public $version								= 1002;
		/**
		 * @desc			Load's requested libraries dynamicly
		 * @param	string	$name library-name
		 * @return			class object of the requested library
		 * @author			Matthias Reuter
		 * @since			1.0
		 * @ignore
		 */
		public function __get($name){
			if(file_exists($this->path.'lib/modules/'.$name.'.php')){
				require_once($this->path.'lib/modules/'.$name.'.php');
				$classname							= 'sv_proven_expert_'.$name;
				$this->$name						= new $classname($this);
				return $this->$name;
			}else{
				throw new Exception('Class '.$name.' could not be loaded (tried to load class-file '.$this->path.'lib/'.$name.'.php'.')');
			}
		}
		/**
		 * @desc			initialize plugin
		 * @author			Matthias Reuter
		 * @since			1.0
		 * @ignore
		 */
		public function __construct(){
			$this->basename							= plugin_basename(__FILE__);
			$this->path								= trailingslashit(WP_PLUGIN_DIR.'/'.dirname($this->basename));
			$this->url								= trailingslashit(plugins_url( '' , __FILE__ ));

			load_plugin_textdomain('sv_proven_expert', false, dirname($this->basename).'/lib/assets/lang/');
			
			$this->hooks->init();					// load hooks
			$this->settings->init();				// load settings
			$this->widgets->init();					// load widgets and shortcodes
		}
	}

	$GLOBALS['plugin_sv_proven_expert']				= new sv_proven_expert();
?>