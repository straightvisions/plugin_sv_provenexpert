<?php
	wp_enqueue_style( $this->core->get_prefix(), $this->core->get_url_lib_section( 'frontend', 'css', 'widget.css' ), false, filemtime( $this->core->get_path_lib_section( 'frontend', 'css', 'widget.css' ) ) );

	$errorMessage											= false;
	$output													= '';
	/*
	if( function_exists( 'curl_init') ) {
		try {
			$instance_settings								= $this->core->get_parent()->common_settings->get_settings();
			$settings										= $this->get_widget_settings();

			// check if a cache file exists and its age inside the caching time range
			if( get_transient( 'sv_provenexpert' ) ) {
				$data										= get_transient('sv_provenexpert');
			} elseif( strlen( $instance_settings['api_id']->run_type()->get_data() ) > 0 && strlen( $instance_settings['api_key']->run_type()->get_data() ) > 0) {
				// set curl options


				if( defined( 'CURLOPT_IPRESOLVE' ) && defined( 'CURL_IPRESOLVE_V4' ) ){
					curl_setopt( $curlHandler, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
				}

				// send call to api
				$json										= curl_exec( $curlHandler );

				if( $json === false ) {
					// curl error
					$errorMessage							= 'curl error (' . date( 'c' ) . ')';

					if( file_exists( $cachePath ) ){
						$errorMessage						.= PHP_EOL . PHP_EOL . 'last call: ' . date( 'c', filemtime( $cachePath ) );
					}

					$errorMessage							.= PHP_EOL . PHP_EOL . curl_error( $curlHandler );
					$errorMessage							.= PHP_EOL . PHP_EOL . print_r( curl_version(), true );

					@file_put_contents( dirname( $cachePath ) . $errorFile, $errorMessage );

					$json									= json_encode( array( 'status' => 'error', 'errors' => array( 'curl error' ) ) );
				}

				curl_close( $curlHandler );

				// convert json to array
				$data										= json_decode( $json, true );

				if( !is_array( $data ) ) {
					// json format is wrong
					$errorMessage							= 'json error (' . date( 'c' ) . ')' . PHP_EOL . PHP_EOL . $json;

					if( file_exists( $cachePath ) ) {
						$errorMessage						.= PHP_EOL . PHP_EOL . 'last call: ' . date( 'c', filemtime( $cachePath ) );
					}

					@file_put_contents( dirname( $cachePath ) . $errorFile, $errorMessage );

					$data									= array( 'status' => 'error', 'errors' => array( 'json error' ) );
					$json									= json_encode( $data );
				}

				if( $data['status'] == 'success' ) {
					// save data in cache file
					set_transient( 'sv_provenexpert', json_decode( $json,true ), 86400 );
				} elseif( !in_array( 'wrongPlan', $data['errors'] ) ){
					// it used the old data
					$tmp									= get_transient( 'sv_provenexpert' );

					if( is_array( $tmp ) ) {
						$data								= $tmp;
						$output								= ( '<!-- from cache because errors [v' . $this->core->version . '] -->' );         //@todo Add Error Message to Notices
					} else {
						$output								= ( '<!-- no caching -->' );                                                        //@todo Add Error Message to Notices
					}
				}
			}

			// print aggregate rating html
			if( $data['status'] == 'success' ) {
				$output										= $data['aggregateRating'];
			} else {
				$errorMessage								= 'response error';                                                                 //@todo Add Error Message to Notices

				if( isset( $data['errors'] ) && is_array( $data['errors'] ) ) {
					$errorMessage							.= ' (' . implode( ', ', $data['errors'] ) . ')';
				}

				$errorMessage								.= ' [v' . $this->get_version_core() . ']';                                         //@todo Add Error Message to Notices
			}
		} catch( Exception $e ) {
			$errorMessage									= 'exception' . PHP_EOL . PHP_EOL . $e->__toString();                               //@todo Add Error Message to Notices

			@file_put_contents( dirname( $cachePath ) . $errorFile, $errorMessage );

			$errorMessage									= ( '<!-- exception error [v' . $this->cget_version_core() . '] -->' );             //@todo Add Error Message to Notices
		}
	} else {
		$errorMessage										= ( '<!-- no curl package installed [v' . $this->get_version_core() . '] -->' );    //@todo Add Error Message to Notices
	}*/

	echo '<div class="sv_provenexpert">' . $output . '</div>';
	//var_dump($this->set_curl_handler()->curl_handler);
	var_dump($this->set_curl_timeout(3)->curl_handler);