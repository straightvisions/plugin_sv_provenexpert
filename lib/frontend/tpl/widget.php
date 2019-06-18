<?php
	if( function_exists( 'curl_init') ) {
		// we have currently no extra styles for stars widget
		//$this->get_parent()->scripts_queue['frontend']->set_is_enqueued();
		
		$errorMessage										= false;
		$output												= '';

		try {
			$settings = $this->get_root()->modules->common_settings->load_settings()->get_settings();
			
			if( get_transient( 'sv_provenexpert' ) ) {
				$data										= get_transient( 'sv_provenexpert' );
			} elseif( strlen( $settings['api_id']->run_type()->get_data() ) > 0 && strlen( $settings['api_key']->run_type()->get_data() ) > 0 ) {
				$curl = $this->get_parent()::$curl->create( $this );

				$curl
					->set_url( 'https://www.provenexpert.com/api_rating_v2.json?v=' . $this->get_version_core() )
					->set_timeout( 3 )
					->set_returntransfer( true )
					->set_ssl_verifypeer( false )
					->set_userpwd( trim( $settings['api_id']->run_type()->get_data() ) . ':' . trim( $settings['api_key']->run_type()->get_data() ) );

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

	// filter

	$output		= str_replace('@font-face{', '@font-face{font-display: swap;',  $output);
	preg_match('/<style(.*)?>(.*)?<\/style>/', $output, $match);
	$output		= str_replace($match[0], '', $output);

	$stars		= '
	<div class="sv_pe_stars" style="width:'.(round(floatval($data['ratingValue']*15),2)).'px;"><img src="'.$this->get_url('lib/assets/img/star.svg').'" /><img src="'.$this->get_url('lib/assets/img/star.svg').'" /><img src="'.$this->get_url('lib/assets/img/star.svg').'" /><img src="'.$this->get_url('lib/assets/img/star.svg').'" /><img src="'.$this->get_url('lib/assets/img/star.svg').'" /></div>
	';

$output		= str_replace('<span id="pe_stars">', '<span id="pe_stars">'.$stars, $output);

	$this->get_root()->modules->widget->scripts_queue['frontend']->set_is_enqueued();
	echo '<div class="sv_provenexpert">' . $output . '</div>';