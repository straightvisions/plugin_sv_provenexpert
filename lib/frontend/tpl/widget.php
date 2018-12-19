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
					/*
					static::$log->create->log( $this, __FILE__ )
					                    ->set_title( 'JSON ERROR' )
					                    ->set_desc( 'Wrong JSON format.' )
					                    ->set_desc( $json, 'admin' )
					                    ->set_state( 'error' );
					*/
				}

				if( $data['status'] == 'success' ) {
					set_transient( 'sv_provenexpert', json_decode( $json,true ), 86400 );
					/*
					static::$log->create->log( $this, __FILE__ )
					                    ->set_title( 'Widget created' )
					                    ->set_desc( 'The widget was successfully created.' )
					                    ->set_desc( 'New cache set.', 'admin' )
					                    ->set_state( 'success' );
					*/
				} elseif( !in_array( 'wrongPlan', $data['errors'] ) ){
					$tmp									= get_transient( 'sv_provenexpert' );

					if( is_array( $tmp ) ) {
						$data								= $tmp;
						/*
						static::$log->create->log( $this, __FILE__ )
						                    ->set_title( 'Outdated cache' )
						                    ->set_desc( 'The version is outdated, please update the plugin.' )
						                    ->set_desc( 'Uses old cached version.', 'admin' )
						                    ->set_state( 'warning' );
						*/
					} else {
						/*
						static::$log->create->log( $this, __FILE__ )
						                    ->set_title( 'Cache Error' )
						                    ->set_desc( 'The version is outdated, please update.' )
						                    ->set_desc( 'No cached version was found.', 'admin' )
						                    ->set_state( 'error' );
						*/
					}
				}
			}

			// print aggregate rating html
			if( isset($data['status']) && $data['status'] == 'success' ) {
				$output										= $data['aggregateRating'];
			} else {
				if( isset( $data['errors'] ) && is_array( $data['errors'] ) ) {
					/*
					static::$log->create->log( $this, __FILE__ )
					                    ->set_title( 'Response Error' )
					                    ->set_desc( 'No response from the ProvenExpert server.' )
					                    ->set_desc( implode( ', ', $data['errors'] ), 'admin' )
					                    ->set_state( 'error' );
					*/
				} else {
					/*
					static::$log->create->log( $this, __FILE__ )
					                    ->set_title( 'Response Error' )
					                    ->set_desc( 'No response from the ProvenExpert server.' )
					                    ->set_desc( ' ', 'admin' )
					                    ->set_state( 'error' );
					*/
				}
			}
		} catch( Exception $e ) {
			/*
			static::$log->create->log( $this, __FILE__ )
			                    ->set_title( 'Exception Error' )
			                    ->set_desc( 'Exception Error' )
			                    ->set_desc( $e->__toString(), 'admin' )
			                    ->set_state( 'error' );
			*/
		}
	} else {
		/*
		static::$log->create->log( $this, __FILE__ )
		                    ->set_title( 'CURL missing' )
		                    ->set_desc( 'The CURL package is not installed, please install CURL to use this plugin.' )
		                    ->set_desc( 'Install CURL: <a href="https://curl.haxx.se/download.html" target="_blank">Download</a>', 'admin' )
		                    ->set_state( 'error' );
		*/
	}

	echo '<div class="sv_provenexpert">' . $output . '</div>';