<?php
	if( function_exists( 'curl_init') ) {
		wp_enqueue_style( $this->core->get_prefix(), $this->core->get_url_lib_section( 'frontend', 'css', 'widget.css' ), false, filemtime( $this->core->get_path_lib_section( 'frontend', 'css', 'widget.css' ) ) );

		$errorMessage										= false;
		$output												= '';

		try {
			$instance_settings								= $this->core->get_parent()->common_settings->get_settings();
			$settings										= $this->get_widget_settings();

			if( get_transient( 'sv_provenexpert' ) ) {
				$data										= get_transient( 'sv_provenexpert' );
			} elseif( strlen( $instance_settings['api_id']->run_type()->get_data() ) > 0 && strlen( $instance_settings['api_key']->run_type()->get_data() ) > 0 ) {
				$curl = $this->core::$curl->create( $this );

				$curl
					->set_url( 'https://www.provenexpert.com/api_rating_v2.json?v=' . $this->get_version_core() )
					->set_timeout( 3 )
					->set_returntransfer( true )
					->set_ssl_verifypeer( false )
					->set_userpwd( trim( $instance_settings['api_id']->run_type()->get_data() ) . ':' . trim( $instance_settings['api_key']->run_type()->get_data() ) );

				if( defined( 'CURLOPT_IPRESOLVE' ) && defined( 'CURL_IPRESOLVE_V4' ) ) {
					$curl->set_ipresolve( CURL_IPRESOLVE_V4 );
				}

				$json										= curl_exec( $curl->get_handler() );

				curl_close( $curl->get_handler() );

				// convert json to array
				$data										= json_decode( $json, true );

				if( !is_array( $data ) ) {
					$this->core::$log->create( $this->core->get_parent() )
						->set_title( 'JSON Error' )
						->set_desc_public( 'undefined' )
						->set_desc_admin( 'undefined' )
						->set_state( 4 );

					// json format is wrong
					/* $errorMessage							= 'json error (' . date( 'c' ) . ')' . PHP_EOL . PHP_EOL . $json;
					$data									= array( 'status' => 'error', 'errors' => array( 'json error' ) );
					$json									= json_encode( $data );
					*/
				}

				if( $data['status'] == 'success' ) {
					// save data in cache file
					set_transient( 'sv_provenexpert', json_decode( $json,true ), 86400 );
				} elseif( !in_array( 'wrongPlan', $data['errors'] ) ){
					// it used the old data
					$tmp									= get_transient( 'sv_provenexpert' );

					if( is_array( $tmp ) ) {
						$data								= $tmp;
						$this->core::$log->create( $this->core->get_parent() )
							->set_title( 'Version Error' )
							->set_desc_public( 'The version is outdated, please update.' )
							->set_desc_admin( 'Used cached version, because version is not up to date.' )
							->set_state( 2 );
						$output								= ( '<!-- from cache because errors [v' . $this->get_version_core() . '] -->' );
					} else {
						$this->core::$log->create( $this->core->get_parent() )
						                 ->set_title( 'Cache Error' )
						                 ->set_desc_public( 'The version is outdated, please update.' )
						                 ->set_desc_admin( 'Version is outdated and found no cached version.' )
						                 ->set_state( 2 );
					}
				}
			}

			// print aggregate rating html
			if( $data['status'] == 'success' ) {
				$output										= $data['aggregateRating'];
			} else {
				$this->core::$log->create( $this->core->get_parent() )
				                 ->set_title( 'Response Error' )
				                 ->set_desc_public( 'No response from the ProvenExpert Server' )
				                 ->set_state( 4 );

				if( isset( $data['errors'] ) && is_array( $data['errors'] ) ) {
					$errorMessage							.= ' (' . implode( ', ', $data['errors'] ) . ')';
				}

				$errorMessage								.= ' [v' . $this->get_version_core() . ']';                                         //@todo Add Error Message to Notices
			}
		} catch( Exception $e ) {
			$errorMessage									= 'exception' . PHP_EOL . PHP_EOL . $e->__toString();                               //@todo Add Error Message to Notices
			$errorMessage									= ( '<!-- exception error [v' . $this->get_version_core() . '] -->' );             //@todo Add Error Message to Notices
		}
	} else {
		$this->core::$log->create( $this->core->get_parent() )
		                 ->set_title( 'No CURL Package installed' )
		                 ->set_desc_public( 'No CURL Package installed.' )
		                 ->set_state( 4 );
	}

	echo '<div class="sv_provenexpert">' . $output . '</div>';