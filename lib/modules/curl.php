<?php
	/**
	 * @author			Matthias Reuter
	 * @package			sv_proven_expert
	 * @copyright		2017 Matthias Reuter
	 * @link			https://straightvisions.com
	 * @since			1.0
	 */
	class sv_proven_expert_curl extends sv_proven_expert{
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
		public function output(){
			$errorMessage											= false;
			$output													= '';
			if(function_exists('curl_init')){
				try{
					$settings										= $this->core->settings->get_settings();
					// check if a cache file exists and its age inside the caching time range
					if(get_transient('sv_proven_expert')){
						$data										= get_transient('sv_proven_expert');
					}elseif(strlen($settings['basic']['API_ID']['value']) > 0 && strlen($settings['basic']['API_KEY']['value']) > 0){
						// init curl handler
						$curlHandler								= curl_init();

						// set curl options
						curl_setopt($curlHandler, CURLOPT_TIMEOUT, 3);
						curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($curlHandler, CURLOPT_URL, 'https://www.provenexpert.com/api_rating_v2.json?v=' . $this->core->version);
						curl_setopt($curlHandler, CURLOPT_USERPWD, trim($settings['basic']['API_ID']['value']) . ':' . trim($settings['basic']['API_KEY']['value']));
						if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')){
							curl_setopt($curlHandler, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
						}

						// send call to api
						$json										= curl_exec($curlHandler);

						if($json === false){
							// curl error
							$errorMessage							= 'curl error (' . date('c') . ')';
							if(file_exists($cachePath)){
								$errorMessage						.= PHP_EOL . PHP_EOL . 'last call: ' . date('c', filemtime($cachePath));
							}
							$errorMessage							.= PHP_EOL . PHP_EOL . curl_error($curlHandler);
							$errorMessage							.= PHP_EOL . PHP_EOL . print_r(curl_version(), true);
							@file_put_contents(dirname($cachePath) . $errorFile, $errorMessage);
							$json									= json_encode(array('status' => 'error', 'errors' => array('curl error')));
						}
						curl_close($curlHandler);

						// convert json to array
						$data										= json_decode($json, true);

						if(!is_array($data)){
							// json format is wrong
							$errorMessage							= 'json error (' . date('c') . ')' . PHP_EOL . PHP_EOL . $json;
							if(file_exists($cachePath)){
								$errorMessage						.= PHP_EOL . PHP_EOL . 'last call: ' . date('c', filemtime($cachePath));
							}
							@file_put_contents(dirname($cachePath) . $errorFile, $errorMessage);
							$data									= array('status' => 'error', 'errors' => array('json error'));
							$json									= json_encode($data);
						}

						if($data['status'] == 'success'){
							// save data in cache file
							set_transient('sv_proven_expert', json_decode($json,true), 86400);
						} elseif(!in_array('wrongPlan', $data['errors'])){
							// it used the old data
							$tmp									= get_transient('sv_proven_expert');
							if(is_array($tmp)){
								$data								= $tmp;
								$output								= ('<!-- from cache because errors [v' . $this->core->version . '] -->');
							}else{
								$output								= ('<!-- no caching -->');
							}
						}
					}

					// print aggregate rating html
					if($data['status'] == 'success'){
						$output										= $data['aggregateRating'];
					}else{
						$errorMessage								= 'response error';
						if (isset($data['errors']) && is_array($data['errors'])) {
							$errorMessage							.= ' (' . implode(', ', $data['errors']) . ')';
						}
						$errorMessage								.= ' [v' . $this->core->version . ']';
					}
				}catch(Exception $e){
					$errorMessage									= 'exception' . PHP_EOL . PHP_EOL . $e->__toString();
					@file_put_contents(dirname($cachePath) . $errorFile, $errorMessage);
					$errorMessage									= ('<!-- exception error [v' . $this->core->version . '] -->');
				}
			}else{
				$errorMessage										= ('<!-- no curl package installed [v' . $this->core->version . '] -->');
			}

			return $errorMessage ? $errorMessage : $output;
		}
	}
?>